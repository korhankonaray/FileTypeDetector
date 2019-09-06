<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

//12122012
add_action('admin_head', 'thememakers_app_mail_subscriber_admin');

function thememakers_app_mail_subscriber_admin() {
	wp_enqueue_script('thememakers_app_mail_subscriber_js', THEMEMAKERS_APPLICATION_URI . '/mail_subscriber/js/general.js');
	wp_enqueue_style('thememakers_app_mail_subscriber_css', THEMEMAKERS_APPLICATION_URI . '/mail_subscriber/css/styles.css');
}

add_action('admin_menu', 'thememakers_app_mail_subscriber_admin_menu');

function thememakers_app_mail_subscriber_admin_menu() {
	add_menu_page(__("Mail subscriber", TMM_THEME_FOLDER_NAME), __("Mail subscriber", TMM_THEME_FOLDER_NAME), 'manage_options', 'thememakers_path_mail_subscriber', array('Application_Mail_Subscriber', 'page_index'));
}

//AJAX callback
add_action('wp_ajax_app_mail_subscriber_add_group', array('Application_Mail_Subscriber', 'add_group'));
add_action('wp_ajax_app_mail_subscriber_remove_group', array('Application_Mail_Subscriber', 'remove_group'));
add_action('wp_ajax_app_mail_subscriber_user_set_group', array('Application_Mail_Subscriber', 'user_set_group'));
add_action('wp_ajax_app_mail_subscriber_get_letter_recepients', array('Application_Mail_Subscriber', 'get_letter_recepients'));
add_action('wp_ajax_app_mail_subscriber_send_one_letter', array('Application_Mail_Subscriber', 'send_one_letter'));
add_action('wp_ajax_app_mail_subscriber_get_template_layout', array('Application_Mail_Subscriber', 'get_template_layout'));
add_action('wp_ajax_app_mail_subscriber_save_archive_template', array('Application_Mail_Subscriber', 'save_archive_template'));
add_action('wp_ajax_app_mail_subscriber_save_settings', array('Application_Mail_Subscriber', 'save_settings'));
add_action('wp_ajax_app_mail_subscriber_get_headfoot_data', array('Application_Mail_Subscriber', 'get_headfoot_data'));
//*********
add_action('wp_ajax_app_mail_subscriber_subscribe_user', array('Application_Mail_Subscriber', 'subscribe_user'));
add_action('wp_ajax_nopriv_app_mail_subscriber_subscribe_user', array('Application_Mail_Subscriber', 'subscribe_user'));
//*********
//*********
define('THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX', TMM_THEME_PREFIX . "app_mail_subscriber_");

//add columns to User panel list page
function app_mail_subscriber_add_user_columns($defaults) {
	$defaults['group'] = __('User subscriptions', TMM_THEME_FOLDER_NAME);
	return $defaults;
}

function app_mail_subscriber_add_custom_user_columns($value, $column_name, $id) {
	if ($column_name == 'group') {
		$data = array();
		$data['groups'] = Application_Mail_Subscriber::get_users_groups();
		$data['users_groups'] = Application_Mail_Subscriber::user_get_groups($id);
		$data['user_id'] = $id;

		return ThemeMakersThemeView::draw_free_page(Application_Mail_Subscriber::get_application_path() . '/views/user_groups_form.php', $data);
	}
}

add_action('manage_users_custom_column', 'app_mail_subscriber_add_custom_user_columns', 15, 3);
add_filter('manage_users_columns', 'app_mail_subscriber_add_user_columns', 15, 1);

class Application_Mail_Subscriber {

	public function __construct() {
		
	}

	public static function get_application_path() {
		return THEMEMAKERS_APPLICATION_PATH . '/mail_subscriber';
	}

	public static function get_application_uri() {
		return THEMEMAKERS_APPLICATION_URI . '/mail_subscriber';
	}

	public static function page_index() {
		$data = array();
		$data['groups'] = Application_Mail_Subscriber::get_users_groups();
		echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/index.php', $data);
	}

	public static function page_settings() {
		echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/settings.php', self::get_settings());
	}

	public static function get_users_groups() {
		$groups = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'users_groups');
		@sort($groups);
		return $groups;
	}

	//ajax
	public function add_group() {
		$new_group_name = $_REQUEST['new_group_name'];
		$users_groups = Application_Mail_Subscriber::get_users_groups();

		foreach ($users_groups as $key => $group) {
			if ($new_group_name == $group) {
				echo __("Such group already exists!!", TMM_THEME_FOLDER_NAME);
				exit;
			}
		}

		$users_groups[] = $new_group_name;
		update_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'users_groups', $users_groups);
		exit;
	}

	public function remove_group() {
		$group_name = $_REQUEST['group_name'];
		$users_groups = Application_Mail_Subscriber::get_users_groups();

		foreach ($users_groups as $key => $group) {
			if ($group_name == $group) {
				unset($users_groups[$key]);
			}
		}

		update_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'users_groups', $users_groups);
		exit;
	}

	//ajax
	public function user_set_group() {
		$groups = Application_Mail_Subscriber::user_get_groups($_REQUEST['user_id']);
		$mode = $_REQUEST['mode'];
		$group_name = $_REQUEST['group_name'];

		if ($mode) {
			$groups[] = $group_name;
		} else {
			foreach ($groups as $key => $group) {
				if ($group == $group_name) {
					unset($groups[$key]);
					break;
				}
			}
		}

		update_user_option($_REQUEST['user_id'], THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'user_group', $groups);
		exit;
	}

	//ajax
	public function get_letter_recepients() {
		$subscribe_groups = $_REQUEST['subscribe_groups'];
		if (!empty($subscribe_groups)) {
			global $wpdb;
			$result = array();
			$users_ids = $wpdb->get_results("SELECT ID FROM $wpdb->users", ARRAY_A);
			if (!empty($users_ids)) {
				foreach ($users_ids as $user) {
					$groups = self::user_get_groups($user['ID']);
					if (!empty($groups)) {
						foreach ($groups as $group) {
							if (in_array($group, $subscribe_groups)) {
								$result[] = $user['ID'];
								break;
							}
						}
					}
				}
			}
			echo json_encode($result);
		}
		exit;
	}

	//ajax
	public function send_one_letter() {
		$user_id = $_REQUEST['user_id'];
		$settings = Application_Mail_Subscriber::get_settings();

		$email = get_user_option('user_email', $user_id);
		$content = ThemeMakersHelper::db_quotes_shield(array('content' => $_REQUEST['content']));
		$content = $content['content'];

		//**** add unsubscribe link
		$content.="<br />";
		$subscription_hash = self::crypt($email, false);
		$content.=__("<center>To stop receiving these emails, you may:", TMM_THEME_FOLDER_NAME) . " " . "<a href='" . home_url() . "/?p=" . $settings['user_subscribe_page'] . "&subscription=" . $subscription_hash . "'>" . __('Manage your subscriptions', TMM_THEME_FOLDER_NAME) . "</a></center>";
		//*************************

		$attachments = array();
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'To: <' . $email . '>' . "\r\n";
		$headers .= 'From: ' . get_option("blogname") . ' <' . (!empty($settings['email_sender']) ? $settings['email_sender'] : get_option("admin_email")) . '>' . "\r\n";
		add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

		$result_data = array();
		$result_data['error'] = "";
		//***
		$subject = "Email subscription";
		if (empty($_REQUEST['subject'])) {
			$s = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'default_email_subject');
			if (!empty($s)) {
				$subject = $s;
			}
		} else {
			$subject = $_REQUEST['subject'];
		}


		//***
		if (!wp_mail($email, $subject, $content, $headers, $attachments)) {
			$result_data['error'] = "Email for " . $email . " has not been sent";
		}
		echo json_encode($result_data);
		exit;
	}

	//ajax
	public function get_template_layout() {
		echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/templates/' . $_REQUEST['template'] . '/layout.php');
		exit;
	}

	//ajax
	public function save_archive_template() {
		$name = $_REQUEST['time'];
		$content = ThemeMakersHelper::db_quotes_shield(array('content' => $_REQUEST['content']));
		$content = $content['content'];
		$archive_path = TMM_THEME_PATH . "/cache/mail_subscriber/" . $name . ".html";
		$file_handle = fopen($archive_path, 'w');
		fwrite($file_handle, $content);
		fclose($file_handle);
		echo '<a href="' . home_url() . '/wp-admin/admin.php?page=thememakers_path_mail_subscriber&amp;archive=' . $name . '">' . date("d-m-Y H:i:s", $name) . '</a>';
		exit;
	}

	//ajax
	public function save_settings() {
		$data = array();
		parse_str($_REQUEST['values'], $data);
		$data = ThemeMakersHelper::db_quotes_shield($data);
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				update_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . $key, $value);
			}
		}
		_e('Options have been saved.', TMM_THEME_FOLDER_NAME);
		exit;
	}

	public static function get_archive_template($name) {
		$archive_path = TMM_THEME_PATH . "/cache/mail_subscriber/" . $name . ".html";
		$content = file_get_contents($archive_path);
		return $content;
	}

	public static function get_archive_templates() {
		$results = array();
		$handler = opendir(TMM_THEME_PATH . "/cache/mail_subscriber/");
		while ($file = readdir($handler)) {
			if ($file != "." AND $file != "..") {
				$results[] = $file;
			}
		}
		//****
		foreach ($results as $key => $value) {
			$value = explode(".", $value);
			$results[$key] = $value[0];
		}
		return $results;
	}

	public static function user_get_groups($user_id) {
		return get_user_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'user_group', $user_id);
	}

	public static function get_settings() {
		$settings = array();
		$settings['user_subscribe_page'] = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'user_subscribe_page');
		$settings['email_sender'] = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'email_sender');
		$settings['letters_per_minute'] = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'letters_per_minute');
		if (!$settings['letters_per_minute']) {
			$settings['letters_per_minute'] = 50;
		}
		return $settings;
	}

	//**********************************
	public static function print_registered_user_mail_subscription_page($user_id) {
		$data = array();
		$user = get_userdata($user_id);
		$data['user'] = $user;
		$data['groups'] = Application_Mail_Subscriber::get_users_groups();
		$data['users_groups'] = Application_Mail_Subscriber::user_get_groups($user->data->ID);
		echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/subscription_page_registered.php', $data);
	}

	public static function print_user_mail_subscription_page() {
		if (isset($_GET['subscription'])) {
			$email = self::crypt($_GET['subscription'], true);
			$data = array();
			$user = get_user_by('email', $email);

			if (isset($_POST['subscribe_hash'])) {
				self::update_user_subscription($user->data->ID, @$_POST['subscribe_themes']);
			}

			$data['user'] = $user;
			$data['groups'] = Application_Mail_Subscriber::get_users_groups();
			$data['users_groups'] = Application_Mail_Subscriber::user_get_groups($user->data->ID);
			echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/subscription_page.php', $data);
		}
	}

	public static function update_user_subscription($user_id, $data = array()) {
		update_user_option($user_id, THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'user_group', $data);
	}

	//ajax
	public static function subscribe_user() {
		$user_name = trim($_REQUEST['user_name']);
		$user_email = trim($_REQUEST['user_email']);

		$result = array();
		$result['errors'] = "";
		$result['info'] = "";
		$result['err_name'] = "";
		$result['err_email'] = "";


		if (empty($user_name)) {
			$result['err_email'].= __('Please type correct mail address', TMM_THEME_FOLDER_NAME);
			echo json_encode($result);
			exit;
		}

		if (!is_email($user_email)) {
			$result['err_email'].= __('Wrong email!', TMM_THEME_FOLDER_NAME);
			echo json_encode($result);
			exit;
		}

		if (email_exists($user_email)) {
			$result['err_email'].= __('Such email already exists', TMM_THEME_FOLDER_NAME);
			echo json_encode($result);
			exit;
		}


		$user_id = username_exists($user_name);
		if (!$user_id) {
			$random_password = wp_generate_password();
			$user_id = wp_create_user($user_name, $random_password, $user_email);
			//subscribe user ***********************************************************
			$groups = Application_Mail_Subscriber::get_users_groups();
			update_user_option($user_id, THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'user_group', $groups);
			//**************************************************************************
			$subject = __("User subscription", TMM_THEME_FOLDER_NAME);
			$content = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . "user_registration_text");
			if (empty($content)) {
				$content = __('Hello __USERNAME__! Your password is: __PASSWORD__', TMM_THEME_FOLDER_NAME);
			}

			$content = str_replace("__USERNAME__", $user_name, $content);
			$content = str_replace("__PASSWORD__", $random_password, $content);

			if (self::send_email($user_email, $content, $subject)) {
				$result['info'].= __('Thank you for signing up. Your e-mail address has been successfully added to our subscription list!', TMM_THEME_FOLDER_NAME);
			} else {
				$result['errors'].= __('Oops) Server error. Please try again later');
			}
			echo json_encode($result);
			exit;
		} else {
			$result['err_name'].= __('Please try another username. Such name already exists', TMM_THEME_FOLDER_NAME);
		}

		echo json_encode($result);
		exit;
	}

	public static function send_email($email, $content, $subject) {
		$attachments = array();
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'To: <' . $email . '>' . "\r\n";
		$headers .= 'From: ' . get_option("blogname") . ' <' . $subject . '>' . "\r\n";
		add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
		return wp_mail($email, $subject, $content, $headers, $attachments);
	}

	public static function get_themes() {
		$theme_path = self::get_application_path() . '/templates/';
		$directories = glob($theme_path . '/*', GLOB_ONLYDIR);
		$result = array();
		if (!empty($directories)) {
			foreach ($directories as $dir) {
				$dir = explode('/', $dir);
				$result[] = $dir[count($dir) - 1];
			}
		}
		return $result;
	}

	public static function get_headfoot_data() {
		$data = array();
		$data['header'] = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'mail_header');
		$data['footer'] = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'mail_footer');
		$data['letter_link'] = TMM_THEME_URI . '/cache/mail_subscriber/__LETTER_TIME__.html';
		$data['letter_link_html'] = __('Having trouble viewing this email? View it in your browser', TMM_THEME_FOLDER_NAME) . ': <a href="' . self::get_application_uri() . '/archive.php?archive=__LETTER_TIME__">' . __('View', TMM_THEME_FOLDER_NAME) . '</a>';
		echo json_encode($data);
		exit;
	}

	public static function crypt($input, $decrypt = false) {
		$data = "";

		if ($decrypt) {
			$data = base64_decode($input);
		} else {
			$data = base64_encode($input);
		}

		return $data;
	}

	public static function get_gropups_subscribers_count() {
		$subscribe_groups = self::get_users_groups();
		$result = array();

		if (!empty($subscribe_groups)) {
			global $wpdb;
			foreach ($subscribe_groups as $group) {
				$result[$group] = 0;
			}
			$users_ids = $wpdb->get_results("SELECT ID FROM $wpdb->users", ARRAY_A);
			if (!empty($users_ids)) {
				foreach ($users_ids as $user) {
					$groups = self::user_get_groups($user['ID']);
					if (!empty($groups)) {
						foreach ($groups as $group) {
							@$result[$group]+=1;
						}
					}
				}
			}
			return $result;
		}

		return array();
	}

}

//****************************
include_once Application_Mail_Subscriber::get_application_path() . '/widgets.php';


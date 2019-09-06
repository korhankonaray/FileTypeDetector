<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class Thememakers_Entity_Contact_Form {

	public $types = array(
		'textinput' => 'Textinput',
		'email' => 'Email',
		'subject' => 'Subject',
		'messagebody' => 'Message body',
		'select' => 'Select'
	);
	public $set_name, $options_description = array(), $contacts_form_titles = array(), $forms_count = 1;

	function __construct($set_name) {
		$this->set_name = $set_name;
	}

	public function get_types_select($name, $selected = "text") {
		//field_type

		$html = '<select class="options_type_select" name="' . $name . '">';
		if (!empty($this->types)) {
			foreach ($this->types as $key => $value) {
				$html.='<option ' . ($selected == $key ? "selected" : "") . ' value="' . $key . '">' . $value . '</option>';
			}
		}
		$html.="</select>";
		return $html;
	}

	public function draw_forms_templates() {
		$data = array("form_constructor" => new Thememakers_Entity_Contact_Form('contacts_form'));
		echo ThemeMakersThemeView::draw_html("contact_form/draw_forms_templates", $data);
	}

	public function draw_forms() {
		$form_constructor->options_description = array(
			"form_title" => array(__("Form Title", TMM_THEME_FOLDER_NAME), "input"),
			"field_type" => array(__("Field Type", TMM_THEME_FOLDER_NAME), "select"),
			"form_label" => array(__("Field Label", TMM_THEME_FOLDER_NAME), "input"),
			"enable_captcha" => array(__("Enable Captcha Protection", TMM_THEME_FOLDER_NAME), "checkbox")
		);

		$data['contact_forms'] = get_option(TMM_THEME_PREFIX . 'contact_form');
		$data['form_constructor'] = $this;
		echo ThemeMakersThemeView::draw_html("contact_form/draw_forms", $data);
	}

	public static function save($data) {
		update_option(TMM_THEME_PREFIX . "contact_form", $data);
	}

	public static function get_form($form_name) {
		$contact_forms = get_option(TMM_THEME_PREFIX . 'contact_form');
		if (!empty($contact_forms)) {
			//after import
			if (!empty($contact_forms) AND is_string($contact_forms)) {
				$contact_forms = unserialize($contact_forms);
			}
			foreach ($contact_forms as $form) {
				if ($form['title'] == $form_name) {
					return $form;
				}
			}
		}

		return array();
	}

	public static function get_forms_names() {
		$contact_forms = get_option(TMM_THEME_PREFIX . 'contact_form');
		$result = array();

		if (!empty($contact_forms)) {
			//after import
			if (!empty($contact_forms) AND is_string($contact_forms)) {
				$contact_forms = unserialize($contact_forms);
			}

			foreach ($contact_forms as $form) {
				$result[@$form['title']] = @$form['title'];
			}
		}

		return $result;
	}

	public function contact_form_request() {
		$data = array();
		parse_str($_REQUEST['values'], $data);
		$errors = array();
		$form = self::get_form($data['contact_form_name']);
		$subject = "";
		$messagebody = "";
		$pre_messagebody_info = "";


		if (!empty($form['inputs'])) {
			foreach ($form['inputs'] as $input) {
				$name = strtolower(trim($input['label']));
				$name = str_replace(" ", "_", $name);
				$pattern = "/[^a-zA-Z0-9_]+/i";
				$name = preg_replace($pattern, "", $name);

				if ($input['is_required']) {
					if (empty($data[$name])) {
						$errors[$name] = trim($name);
					}
				}

				if ($input['type'] == 'email') {
					if (!is_email(@$data[$name])) {
						$errors[$name] = trim($name);
					}
				}

				//*****
				if ($input['type'] == 'messagebody') {
					$messagebody = @$data[$name];
				}

				if ($input['type'] == 'subject') {
					$subject = @$data[$name];
				}
				//*****
				if ($input['type'] != 'subject' AND $input['type'] != 'messagebody') {
					$pre_messagebody_info.="<strong>" . $name . "</strong>" . ":" . @$data[$name] . "<br /><br />";
				}
			}
		}


		//capcha	
		if (@$form['has_capture']) {
			if (substr($data['verify_code'], 7, 5) != $data['verify']) {
				$errors["verify"] = "Capcha";
			}
		}


		//*****
		$result = array(
			"is_errors" => 0,
			"info" => ""
		);
		if (!empty($errors)) {
			$result['is_errors'] = 1;
			$result['hash'] = md5(time());
			$result['info'] = $errors;
			echo json_encode($result);
			exit;
		}

		//*****
		if (empty($subject)) {
			$subject = __("Email from contact form", TMM_THEME_FOLDER_NAME);
		}

		//*****
		add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
		add_filter('wp_mail_from_name', 'my_mail_from_name');

		function my_mail_from_name($name) {
			return get_option('blogname');
		}

		//*****
		$after_message = "\r\n<br />--------------------------------------------------------------------------------------------------\r\n<br /> " . __('This mail was sent via', TMM_THEME_FOLDER_NAME) . site_url() . " " . __('contact form', TMM_THEME_FOLDER_NAME);


		//*****
		$recepient_mail = $form['recepient_email'];
		if (empty($form['recepient_email'])) {
			$recepient_mail = get_bloginfo('admin_email');
		}
		//******

		if (wp_mail($recepient_mail, $subject, $pre_messagebody_info . $messagebody . $after_message)) {
			$result["info"] = "succsess";
		} else {
			$result["info"] = "server_fail";
		}

		$result['hash'] = md5(time());

		echo json_encode($result);
		exit;
	}

}


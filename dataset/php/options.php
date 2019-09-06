<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
if (WP_DEBUG) {
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}
//Theme data
define('THEMEMAKERS_THEME_NAME', 'Blessing');
define('TMM_THEME_FOLDER_NAME', basename(dirname(__FILE__)));
define('TMM_THEME_PREFIX', 'thememakers_');
define('THEMEMAKERS_FRAMEWORK_VERSION', '1.0.4M');
define('TMM_THEME_URI', get_template_directory_uri());
define('TMM_THEME_PATH', get_template_directory());
define('THEMEMAKERS_APPLICATION_URI', TMM_THEME_URI . "/admin/applications");
define('THEMEMAKERS_APPLICATION_PATH', TMM_THEME_PATH . "/admin/applications");
define('THEMEMAKERS_THEME_LINK', 'http://blessing.webtemplatemasters.com/help/');
define('THEMEMAKERS_THEME_FORUM_LINK', 'http://forums.webtemplatemasters.com/');


include_once TMM_THEME_PATH . '/admin/classes/view.php';
include_once TMM_THEME_PATH . '/admin/classes/model.php';


//*****
//AJAX callback to save or reset options
add_action('wp_ajax_change_options', array('ThemeMakersThemeModel', 'change_options'));
add_action('wp_ajax_render_gall', array('Thememakers_Entity_Gallery', 'render_gallery'));
add_action('wp_ajax_add_sidebar', array('Thememakers_Entity_Custom_Sidebars', 'add_sidebar'));
add_action('wp_ajax_add_sidebar_page', array('Thememakers_Entity_Custom_Sidebars', 'add_sidebar_page'));
add_action('wp_ajax_add_sidebar_category', array('Thememakers_Entity_Custom_Sidebars', 'add_sidebar_category'));
add_action('wp_ajax_contact_form_request', array('Thememakers_Entity_Contact_Form', 'contact_form_request'));
add_action('wp_ajax_add_comment', array('ThemeMakersHelper', 'add_comment'));
add_action('wp_ajax_get_google_fonts', array('ThemeMakersHelperFonts', 'get_google_fonts_ajax'));
add_action('wp_ajax_get_new_google_fonts', array('ThemeMakersHelperFonts', 'get_new_google_fonts'));
add_action('wp_ajax_save_google_fonts', array('ThemeMakersHelperFonts', 'save_google_fonts'));
add_action('wp_ajax_get_mediagallery', array('ThemeMakersHelper', 'get_mediagallery'));
add_action('wp_ajax_get_audio_mediagallery', array('ThemeMakersHelper', 'get_audio_mediagallery'));
add_action('wp_ajax_get_video_mediagallery', array('ThemeMakersHelper', 'get_video_mediagallery'));
add_action('wp_ajax_add_seo_group', array('Thememakers_Entity_SEO_Group', 'add_seo_group'));
add_action('wp_ajax_add_seo_group_category', array('Thememakers_Entity_SEO_Group', 'add_seo_group_category'));
add_action('wp_ajax_get_unique_ids', array('ThemeMakersHelper', 'get_unique_ids'));

//***
add_action('wp_ajax_nopriv_render_gall', array('Thememakers_Entity_Gallery', 'render_gallery'));
add_action('wp_ajax_nopriv_contact_form_request', array('Thememakers_Entity_Contact_Form', 'contact_form_request'));
add_action('wp_ajax_nopriv_add_comment', array('ThemeMakersHelper', 'add_comment'));
add_action('wp_ajax_nopriv_get_google_fonts', array('ThemeMakersHelperFonts', 'get_google_fonts_ajax'));
add_action('wp_ajax_nopriv_get_new_google_fonts', array('ThemeMakersHelperFonts', 'get_new_google_fonts'));
add_action('wp_ajax_nopriv_get_mediagallery', array('ThemeMakersHelper', 'get_mediagallery'));
add_action('wp_ajax_nopriv_get_audio_mediagallery', array('ThemeMakersHelper', 'get_audio_mediagallery'));
add_action('wp_ajax_nopriv_get_video_mediagallery', array('ThemeMakersHelper', 'get_video_mediagallery'));


//*****

add_action('admin_menu', 'thememakers_theme_add_admin');
add_action('admin_head', 'thememakers_theme_admin_head');
add_action('admin_bar_menu', 'thememakers_theme_admin_bar_menu', 89);

add_action('init', 'tmm_init', 1);
add_action('wp_head', 'thememakers_theme_wp_head', 1);
add_action('wp_footer', 'thememakers_theme_wp_footer');

//*****

function tmm_init() {
	$image_mode = get_option(TMM_THEME_PREFIX . 'image_mode');
	if ($image_mode == 1) {
		$theme_image_sizes = get_theme_image_sizes();
		if (!empty($theme_image_sizes)) {
			foreach ($theme_image_sizes as $key => $value) {
				add_image_size($key, $value['width'], $value['height'], $value['crop']);
			}
		}
	}
}

function get_theme_image_sizes() {
	$data = array();

	$data['50*50'] = array();
	$data['50*50']['name'] = '50*50';
	$data['50*50']['width'] = 50;
	$data['50*50']['height'] = 50;
	$data['50*50']['crop'] = true;

	$data['200*130'] = array();
	$data['200*130']['name'] = '200*130';
	$data['200*130']['width'] = 200;
	$data['200*130']['height'] = 130;
	$data['200*130']['crop'] = true;

	$data['200*200'] = array();
	$data['200*200']['name'] = '200*200';
	$data['200*200']['width'] = 200;
	$data['200*200']['height'] = 200;
	$data['200*200']['crop'] = true;

	$data['204*318'] = array();
	$data['204*318']['name'] = '204*318';
	$data['204*318']['width'] = 204;
	$data['204*318']['height'] = 318;
	$data['204*318']['crop'] = true;


	$data['284*140'] = array();
	$data['284*140']['name'] = '284*140';
	$data['284*140']['width'] = 284;
	$data['284*140']['height'] = 140;
	$data['284*140']['crop'] = true;

	$data['284*224'] = array();
	$data['284*224']['name'] = '284*224';
	$data['284*224']['width'] = 284;
	$data['284*224']['height'] = 224;
	$data['284*224']['crop'] = true;

	$data['400*283'] = array();
	$data['400*283']['name'] = '400*283';
	$data['400*283']['width'] = 400;
	$data['400*283']['height'] = 283;
	$data['400*283']['crop'] = true;

	$data['444*264'] = array();
	$data['444*264']['name'] = '444*264';
	$data['444*264']['width'] = 444;
	$data['444*264']['height'] = 264;
	$data['444*264']['crop'] = true;

	$data['560*326'] = array();
	$data['560*326']['name'] = '560*326';
	$data['560*326']['width'] = 560;
	$data['560*326']['height'] = 326;
	$data['560*326']['crop'] = true;

	$data['570*326'] = array();
	$data['570*326']['name'] = '570*326';
	$data['570*326']['width'] = 570;
	$data['570*326']['height'] = 326;
	$data['570*326']['crop'] = true;

	$data['570*360'] = array();
	$data['570*360']['name'] = '570*360';
	$data['570*360']['width'] = 570;
	$data['570*360']['height'] = 360;
	$data['570*360']['crop'] = true;

	$data['570*380'] = array();
	$data['570*380']['name'] = '570*380';
	$data['570*380']['width'] = 570;
	$data['570*380']['height'] = 380;
	$data['570*380']['crop'] = true;

	$data['574*258'] = array();
	$data['574*258']['name'] = '574*258';
	$data['574*258']['width'] = 574;
	$data['574*258']['height'] = 258;
	$data['574*258']['crop'] = true;

	$data['580*360'] = array();
	$data['580*360']['name'] = '580*360';
	$data['580*360']['width'] = 580;
	$data['580*360']['height'] = 360;
	$data['580*360']['crop'] = true;

	$data['800*600'] = array();
	$data['800*600']['name'] = '800*600';
	$data['800*600']['width'] = 800;
	$data['800*600']['height'] = 600;
	$data['800*600']['crop'] = true;

	$data['1220*415'] = array();
	$data['1220*415']['name'] = '1220*415';
	$data['1220*415']['width'] = 1220;
	$data['1220*415']['height'] = 415;
	$data['1220*415']['crop'] = true;

	return $data;
}

//***

global $pagenow;
if (is_admin() AND 'themes.php' == $pagenow AND isset($_GET['activated'])) {
//***** set default options
	$theme_was_activated = get_option(TMM_THEME_PREFIX . 'theme_was_activated');
	@chmod(TMM_THEME_PATH . "/cache/timthumb_cache", 0777);
	if (!$theme_was_activated) {
		wp_update_nav_menu_object(0, array('menu-name' => 'Primary Menu'));
		update_option(TMM_THEME_PREFIX . 'theme_was_activated', 1);
		thememakers_get_upload_folder();
//*****
		update_option(TMM_THEME_PREFIX . 'show_full_content', 0);
		update_option(TMM_THEME_PREFIX . 'excerpt_symbols_count', 140);
		update_option(TMM_THEME_PREFIX . 'gallery_height', 283);
		update_option(TMM_THEME_PREFIX . 'gallery_width', 400);
		update_option(TMM_THEME_PREFIX . 'portfolio_slider_width', 400);
		update_option(TMM_THEME_PREFIX . 'sidebar_position', 'sbr');
		update_option(TMM_THEME_PREFIX . 'hide_wp_image_sizes', 1);
		update_option(TMM_THEME_PREFIX . 'logo_type', 'text');
		update_option(TMM_THEME_PREFIX . 'logo_text', 'Blessing');
		update_option(TMM_THEME_PREFIX . 'logo_font', 'Over the Rainbow');
		update_option(TMM_THEME_PREFIX . 'disable_content_autoparagraphs', 1);
		update_option(TMM_THEME_PREFIX . 'disable_content_linebreak', 1);
		update_option(TMM_THEME_PREFIX . 'slider_flexslider_enable_caption', 1);
		update_option(TMM_THEME_PREFIX . 'turn_off_wptexturize', 1);
		update_option(TMM_THEME_PREFIX . 'show_author_info', 1);


		update_option(TMM_THEME_PREFIX . 'copyright_text', 'Copyright &copy; 2012. <a target="_blank" href="http://webtemplatemasters.com">ThemeMakers</a>. All rights reserved');
	}
}

//********************
add_action('admin_notices', 'thememakers_print_admin_notice');

function thememakers_print_admin_notice() {
	$notices = "";

	if (!is_writable(TMM_THEME_PATH . "/cache/timthumb_cache")) {
		$notices.=sprintf(__('<div class="error"><p>To make your theme work correctly you need to set the permissions 777 for <b>%s/cache</b> folder. Follow <a href="http://webtemplatemasters.com/tutorials/permissions/" target="_blank">the link</a> to read the instructions how to do it properly.</p></div>'), TMM_THEME_PATH);
	}

	if (!is_writable(TMM_THEME_PATH . "/css/custom1.css")) {
		$notices.=sprintf(__('<div class="error"><p>To make your theme work correctly you need to set the permissions 777 for <b>%s/css/custom1.css</b> folder. Follow <a href="http://webtemplatemasters.com/tutorials/permissions/" target="_blank">the link</a> to read the instructions how to do it properly.</p></div>'), TMM_THEME_PATH);
	}

	if (!is_writable(TMM_THEME_PATH . "/css/custom2.css")) {
		$notices.=sprintf(__('<div class="error"><p>To make your theme work correctly you need to set the permissions 777 for <b>%s/css/custom2.css</b> folder. Follow <a href="http://webtemplatemasters.com/tutorials/permissions/" target="_blank">the link</a> to read the instructions how to do it properly.</p></div>'), TMM_THEME_PATH);
	}

	if (!is_writable(thememakers_get_upload_folder())) {
		$notices.=sprintf(__('<div class="error"><p>To make your theme work correctly you need to set the permissions 777 for <b>%s</b> folder. Follow <a href="http://webtemplatemasters.com/tutorials/permissions/" target="_blank">the link</a> to read the instructions how to do it properly.</p></div>'), thememakers_get_upload_folder());
	}

	echo $notices;
}

/* * ****************** functions *********************** */

function thememakers_theme_admin_bar_menu() {
	global $wp_admin_bar;
	if (!is_super_admin() || !is_admin_bar_showing())
		return;
	$wp_admin_bar->add_menu(array(
		'id' => 'thememakers_link',
		'title' => __("Theme Options", TMM_THEME_FOLDER_NAME),
		'href' => site_url() . '/wp-admin/themes.php?page=thememakers_path_theme_options',
	));
}

function thememakers_theme_add_admin() {
	add_theme_page(__("Theme Options", TMM_THEME_FOLDER_NAME), __("Theme Options", TMM_THEME_FOLDER_NAME), 'edit_themes', 'thememakers_path_theme_options', 'thememakers_theme_admin');
}

function thememakers_theme_admin() {
	echo ThemeMakersThemeView::draw_page('theme_options');
}

//*** sliders
function thememakers_theme_sliders_groups() {
	$slides = Thememakers_Entity_Slider::get_slides();
	echo ThemeMakersThemeView::draw_page('slider/sliders_groups', array('slides' => $slides));
}

function thememakers_theme_admin_head() {
	wp_enqueue_style("thememakers_theme_styles_css", TMM_THEME_URI . '/admin/css/styles.css');

	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery.ui.sortable');


	wp_enqueue_script('media-upload');
	wp_enqueue_script('thememakers_theme_admin_js', TMM_THEME_URI . '/admin/js/general.js');

	wp_enqueue_style('thickbox');
	wp_enqueue_script('thickbox');

//*****
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style("thememakers_theme_fancybox_css", TMM_THEME_URI . '/js/fancybox/jquery.fancybox.css');
	wp_enqueue_style("thememakers_theme_colorpicker_css", TMM_THEME_URI . '/admin/js/colorpicker/colorpicker.css');

	wp_enqueue_script('thememakers_theme_fancybox_js', TMM_THEME_URI . '/js/fancybox/jquery.fancybox.pack.js');
	wp_enqueue_script('thememakers_theme_colorpicker_js', TMM_THEME_URI . '/admin/js/colorpicker/colorpicker.js');
	wp_enqueue_script('thememakers_theme_mediagallery_js', TMM_THEME_URI . '/admin/js/mediagallery.js');
	?>
	<!--[if IE]>
			<script>
								document.createElement('header');
								document.createElement('footer');
								document.createElement('section');
								document.createElement('aside');
								document.createElement('nav');
								document.createElement('article');
			</script>
	<![endif]-->
	<script type="text/javascript">
		var site_url = "<?php echo home_url(); ?>/";
		var template_directory = "<?php echo TMM_THEME_URI; ?>/";
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		//translations
		var lang_edit = "<?php _e('Edit', TMM_THEME_FOLDER_NAME); ?>";
		var lang_update = "<?php _e('Update', TMM_THEME_FOLDER_NAME); ?>";
		var lang_delete = "<?php _e('Delete', TMM_THEME_FOLDER_NAME); ?>";
		var lang_one_moment = "<?php _e("One moment", TMM_THEME_FOLDER_NAME) ?>";
		var lang_one_loading = "<?php _e("Loading ...", TMM_THEME_FOLDER_NAME) ?>";
		var lang_one_updating = "<?php _e("Updating Preview ...", TMM_THEME_FOLDER_NAME) ?>";
		var lang_chooce_groups = "<?php _e("Choose e-mail groups!", TMM_THEME_FOLDER_NAME) ?>";
		var lang_please_confirm = "<?php _e("Please confirm letter sending!", TMM_THEME_FOLDER_NAME) ?>";
		var lang_sure_deleting = "<?php _e("Sure about deleting", TMM_THEME_FOLDER_NAME) ?>";
		var lang_sending_is_paused = "<?php _e("Paused. Please do not reload browser page till letters/messages are sending!", TMM_THEME_FOLDER_NAME) ?>";
		var lang_email_saved = "<?php _e("Email saved to history!", TMM_THEME_FOLDER_NAME) ?>";
		var lang_email_sent = "<?php _e("Your mail was successfully sent to users", TMM_THEME_FOLDER_NAME) ?>";
		var lang_write_name = "<?php _e("Please write your name", TMM_THEME_FOLDER_NAME) ?>";
		var lang_write_email = "<?php _e("Please write your email", TMM_THEME_FOLDER_NAME) ?>";
		//***
		var lang_enter_correctly = "<?php _e('Please enter correct', TMM_THEME_FOLDER_NAME); ?>";
		var lang_sended_succsessfully = "<?php _e('Your message has been sent successfully!', TMM_THEME_FOLDER_NAME); ?>";
		var lang_server_failed = "<?php _e('Server failed. Send later', TMM_THEME_FOLDER_NAME); ?>";
		var lang_server_navigation = "<?php _e('Navigation', TMM_THEME_FOLDER_NAME); ?>";
		var lang_prev = "<?php _e('previous', TMM_THEME_FOLDER_NAME); ?>";
		var lang_next = "<?php _e('next', TMM_THEME_FOLDER_NAME); ?>";
		var drawHeaderColor = "<?php echo get_option(TMM_THEME_PREFIX . "header_bg_color") ?>";
		var drawFooterColor = "<?php echo get_option(TMM_THEME_PREFIX . "footer_bg_color") ?>";
		var drawPattern = "<?php echo get_option(TMM_THEME_PREFIX . "draw_pattern_type") ?>";
		var events_time_format =<?php echo (int) get_option(TMM_THEME_PREFIX . "events_time_format"); ?>
	</script>

	<!--[if (gte IE 9)|!(IE)]><!-->

	<style type="text/css">

		/* -------------------------------------------------- */
		/*	Form Style
		/* -------------------------------------------------- */

		.thememakers_shortcode_template input[type="checkbox"],
		.thememakers_shortcode_template input[type="radio"] { display: none; }

		.thememakers_shortcode_template input[type="checkbox"] + label,
		.thememakers_shortcode_template input[type="radio"] + label { 
			margin-right: 8px;
			cursor: pointer; 
		}

		.thememakers_shortcode_template .label-form {
			display: inline-block;
			margin-top: 4px;
		}

		.thememakers_shortcode_template .radio-holder { margin-bottom: 15px; height: 37px; }

		/* Checkbox */

		.thememakers_shortcode_template input[type="checkbox"] + label span {
			display: inline-block;
			margin-top: 1px;
			margin-right: 5px;
			height: 16px;
			vertical-align: top;
			width: 16px;
			border-width: 1px;
			border-style: solid;
			border-color: #d6d7d7;
			background-color: #fff;
		}

		.thememakers_shortcode_template input[type="checkbox"]:hover + label span { border-color: #ffc223; }

		.thememakers_shortcode_template input[type="checkbox"] + label span,
		.thememakers_shortcode_template input[type="radio"] + label span
		{
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			-webkit-transition: all .25s linear;
			-moz-transition: all .25s linear;
			-ms-transition: all .25s linear;
			-o-transition: all .25s linear;
			transition: all .25s linear;	
		}

		.thememakers_shortcode_template input[type="checkbox"]:checked + label span {
			border-width: 4px;
			border-color: #fff;
			background-color: #ffc223;
		}

		/* Radio */

		.thememakers_shortcode_template input[type="radio"] + label span {
			display: inline-block;
			margin-right: 5px;
			height: 16px;
			vertical-align: text-bottom;
			width: 16px;
			border-width: 1px;
			border-style: solid;
			border-color: #d6d7d7;
			background-color: #fff;
		}

		.thememakers_shortcode_template input[type="radio"] + label span {
			-webkit-border-radius: 50%;
			-moz-border-radius: 50%;
			border-radius: 50%;
		}

		.thememakers_shortcode_template input[type="radio"]:hover + label span { border-color: #ffc223; }

		.thememakers_shortcode_template input[type="radio"]:checked + label span {
			border-width: 4px;
			border-color: #fff;
			background-color: #ffc223;
		}

	</style>

	<!--<![endif]-->

	<?php
	echo ThemeMakersHelperFonts::get_google_fonts_link();
}

function thememakers_theme_wp_head() {
	wp_enqueue_style("thememakers_theme_fancybox_css", TMM_THEME_URI . '/js/fancybox/jquery.fancybox.css');
	wp_enqueue_script('thememakers_theme_fancybox_js', TMM_THEME_URI . '/js/fancybox/jquery.fancybox.pack.js', array('jquery'));
//*****
	wp_enqueue_script('thememakers_theme_jquery_easing_js', TMM_THEME_URI . '/js/jquery.easing.1.3.js', array('jquery'));

	wp_enqueue_script('thememakers_theme_jquery_isotope_js', TMM_THEME_URI . '/js/jquery.isotope.min.js', array('jquery'));
	wp_enqueue_script('thememakers_theme_jquery_cycle_js', TMM_THEME_URI . '/js/jquery.cycle.all.min.js', array('jquery'));
	wp_enqueue_script('thememakers_theme_respond_js', TMM_THEME_URI . '/js/respond.min.js', array('jquery'));
	wp_enqueue_script('thememakers_theme_sudoslider_js', TMM_THEME_URI . '/js/jquery.sudoSlider.min.js', array('jquery'));
	wp_enqueue_style("thememakers_theme_mediaelement_css", TMM_THEME_URI . '/js/mediaelement/mediaelementplayer.css');
	wp_enqueue_script('thememakers_theme_mediaelement_js', TMM_THEME_URI . '/js/mediaelement/mediaelement-and-player.min.js', array('jquery'));
//HTML5 Shiv + detect touch events
	wp_enqueue_script('thememakers_theme_modernizr_js', TMM_THEME_URI . '/js/modernizr.custom.js', array('jquery'));
//*****
	wp_enqueue_script('thememakers_theme_general_js', TMM_THEME_URI . '/js/general.js', array('jquery'));
	?>
	<script type="text/javascript">
		var site_url = "<?php echo home_url(); ?>/";
		var capcha_image_url = "<?php echo TMM_THEME_URI ?>/admin/extensions/capcha/image.php/";
	</script>
	<?php
}

function thememakers_theme_wp_footer() {
	
}

function thememakers_get_upload_folder() {
	$path = wp_upload_dir();
	$path = $path['basedir'];

	if (!file_exists($path)) {
		mkdir($path, 0777);
	}

	$path = $path . '/thememakers/';
	if (!file_exists($path)) {
		mkdir($path, 0777);
	}

	return $path;
}

function thememakers_get_upload_folder_uri() {
	$link = wp_upload_dir();
	return $link['baseurl'] . '/thememakers/';
}

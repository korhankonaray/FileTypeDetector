<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
wp_enqueue_style("thememakers_theme_uniform_css", TMM_THEME_URI . '/admin/css/uniform.default.css');
wp_enqueue_style("thememakers_theme_admin_css", TMM_THEME_URI . '/admin/css/options_styles.css');


//***
wp_enqueue_style("thememakers_theme_jquery_ui_css1", TMM_THEME_URI . '/admin/css/ui-lightness/jquery-ui-1.8.23.custom.css');
wp_enqueue_style("thememakers_theme_jquery_ui_css2", TMM_THEME_URI . '/admin/css/jquery-ui.css');
wp_enqueue_script('thememakers_theme_jquery_ui_js', TMM_THEME_URI . '/admin/js/jquery-ui-1.8.23.custom.min.js');

wp_enqueue_script('thememakers_theme_options_js', TMM_THEME_URI . '/admin/js/options.js');
wp_enqueue_script('thememakers_theme_uniform_js', TMM_THEME_URI . '/admin/js/jquery.uniform.min.js');
wp_enqueue_script('thememakers_theme_selectivizr_js', TMM_THEME_URI . '/admin/js/selectivizr-and-extra-selectors.min.js');

wp_enqueue_script('thememakers_theme_custom_sidebars_js', TMM_THEME_URI . '/admin/js/custom_sidebars.js');
wp_enqueue_script('thememakers_theme_seo_groups_js', TMM_THEME_URI . '/admin/js/seo_groups.js');
wp_enqueue_script('thememakers_theme_sliders_js', TMM_THEME_URI . '/admin/js/sliders.js');
wp_enqueue_script('thememakers_theme_form_constructor_js', TMM_THEME_URI . '/admin/js/form_constructor.js');

//*********---------------------------------------------------------------------------------------------------------------

$form_constructor = new Thememakers_Entity_Contact_Form('contacts_form');
$form_constructor->options_description = array(
	"form_title" => array(__("Form Title", TMM_THEME_FOLDER_NAME), "input"),
	"field_type" => array(__("Field Type", TMM_THEME_FOLDER_NAME), "select"),
	"form_label" => array(__("Field Label", TMM_THEME_FOLDER_NAME), "input"),
	"enable_captcha" => array(__("Enable Captcha Protection", TMM_THEME_FOLDER_NAME), "checkbox")
);
//*****
$google_fonts = ThemeMakersHelperFonts::get_google_fonts();
$content_fonts = ThemeMakersHelperFonts::get_content_fonts();
$fonts = array_merge($content_fonts, $google_fonts);
$fonts = array_merge(array("" => ""), $fonts);
//*****
$slides = Thememakers_Entity_Slider::get_slides();
//*****
$sidebars = get_option(TMM_THEME_PREFIX . "thememakers_sidebars");
//*****
$contact_forms = get_option(TMM_THEME_PREFIX . 'contact_form');
//******
$seo_groups = get_option(TMM_THEME_PREFIX . "thememakers_seo_groups");

//Default colorizing array
function set_theme_options_defaults($option, $value) {

	$theme_options_defaults = array(
		'body_bg_color' => '#efece2',
		'header_bg_color' => '#373533',
		'logo_text_color' => '#E5E1D8',
		'links_color' => '#847460',
		'links_hover_color' => '#63c3d7',
		'main_nav_bg_color_top' => '#f7f5ed',
		'main_nav_bg_color_bottom' => '#ebe9e2',
		'main_nav_def_text_color' => '#36332E',
		'main_nav_curr_text_color' => '#63C3D7',
		'main_nav_hover_text_color' => '#63C3D7',
		'main_nav_curr_item_bg_color' => '#36332e',
		'content_text_color' => '#777777',
		'buttons_text_color' => '#fff',
		'widget_def_title_color' => '#242424',
		'widget_def_text_color' => '#777777',
		'widget_colored_testimonials_text_color' => '#777777',
		'widget_colored_testimonials_author_text_color' => '#777777',
		'image_frame_bg_color' => '#E0DFD8',
		'image_frame_hover_bg_color' => '#E0DFD8',
		'footer_bg_color' => '#e6e3d8',
		'footer_widget_title_color' => '#36332E',
		'footer_color' => '#696868',
		'footer_widget_link_color' => '#777777',
		'footer_widget_link_hover_color' => '#63c3d7'
	);

	//*******

	if (empty($value)) {
		$value = $theme_options_defaults[$option];
	}

	return $value;
}
?>

<form id="theme_options" name="theme_options" method="post" style="display: none;">
    <div id="tm">

        <section class="admin-container clearfix">

            <header id="title-bar" class="clearfix">

                <a href="#" class="admin-logo"></a>
                <span class="fw-version">framework v.<?php echo THEMEMAKERS_FRAMEWORK_VERSION ?></span>

                <div class="clear"></div>

            </header><!--/ #title-bar-->

            <section class="set-holder clearfix">

                <ul class="support-links">
                    <li><a class="support-docs" href="<?php echo THEMEMAKERS_THEME_LINK ?>" target="_blank"><?php _e('View Theme Docs', TMM_THEME_FOLDER_NAME); ?></a></li>
                    <li><a class="support-forum" href="<?php echo THEMEMAKERS_THEME_FORUM_LINK ?>" target="_blank"><?php _e('Visit Forum', TMM_THEME_FOLDER_NAME); ?></a></li>
                </ul><!--/ .support-links-->

                <div class="button-options">
                    <a href="#" class="admin-button button-small button-yellow button_reset_options"><?php _e('Reset All Options', TMM_THEME_FOLDER_NAME); ?></a>
                    <a href="#" class="admin-button button-small button-yellow button_save_options"><?php _e('Save All Changes', TMM_THEME_FOLDER_NAME); ?></a>
                </div><!--/ .button-options-->

            </section><!--/ .set-holder-->

            <aside id="admin-aside">

                <ul class="admin-nav">
                    <li>
                        <a class="shortcut-options" href="#tab1"><?php _e('General', TMM_THEME_FOLDER_NAME); ?></a>
                    </li>
                    <li>
                        <a class="shortcut-styling" href="#tab2-0"><?php _e('Styling', TMM_THEME_FOLDER_NAME); ?></a>
                        <ul>
                            <li><a href="#tab2-0"><?php _e('General', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <li><a href="#tab2-1"><?php _e('Headings', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <li><a href="#tab2-2"><?php _e('Main Navigation', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <li><a href="#tab2-3"><?php _e('Content', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <li><a href="#tab2-4"><?php _e('Buttons', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <li><a href="#tab2-5"><?php _e('Sidebar Widgets', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <li><a href="#tab2-6"><?php _e('Images', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <li><a href="#tab2-7"><?php _e('Footer Area', TMM_THEME_FOLDER_NAME); ?></a></li>
                        </ul>
                    </li>


                    <li><a class="shortcut-slider" href="#tab4-0"><?php _e('Slider Settings', TMM_THEME_FOLDER_NAME); ?></a>
                        <ul>
                            <li><a href="#tab4-0"><?php _e('General', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <!-- <li><a href="#tab4-1">Nivo Slider</a></li> -->
                            <!-- <li><a href="#tab4-2">Circle</a></li> -->
                            <!-- <li><a href="#tab4-3">Elegant Accordion</a></li> -->
                            <!-- <li><a href="#tab4-4">Rama Slider</a></li> -->
                            <li><a href="#tab4-5">Flex Slider</a></li>
                            <!-- <li><a href="#tab4-6">Revolution</a></li> -->
                            <!-- <li><a href="#tab4-7">Mosaic</a></li> -->
                        </ul>
                    </li>


                    <li><a class="shortcut-slider" href="#tab41-0"><?php _e('Sliders Groups', TMM_THEME_FOLDER_NAME); ?></a>
                        <ul class="slider_groups_list">
                            <li><a href="#tab41-0" class="slider_groups_list_nav_link"><?php _e('General', TMM_THEME_FOLDER_NAME); ?></a></li>
							<?php
							if (is_string($slides) AND !empty($slides)) {
								$slides = unserialize($slides);
							}
							?>
							<?php if (!empty($slides) AND is_array($slides)): ?>
								<?php foreach ($slides as $key => $slide) : ?>
									<?php if (isset($slide['name'])): ?>
										<?php if ($slide['name']): ?>
											<li style="display: none;"><a href="#slider_group_<?php echo $key ?>"><?php echo $slide['name'] ?></a></li>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
                        </ul>
                    </li>


                    <li><a class="shortcut-blog" href="#tab5"><?php _e('Blog', TMM_THEME_FOLDER_NAME); ?></a></li>
                    <li><a class="shortcut-portfolio" href="#tab6"><?php _e('Portfolio', TMM_THEME_FOLDER_NAME); ?></a></li>
                    <li><a class="shortcut-gallery" href="#tab7"><?php _e('Gallery', TMM_THEME_FOLDER_NAME); ?></a></li>
                    <li>
                        <a class="shortcut-contact" href="#tab8-0"><?php _e('Contact Forms', TMM_THEME_FOLDER_NAME); ?></a>
                        <ul class="contact_forms_groups_list">
                            <li><a href="#tab8-0" class="contact_page_nav_link"><?php _e('Add Form', TMM_THEME_FOLDER_NAME); ?></a></li>
							<?php
							if (is_string($contact_forms) AND !empty($contact_forms)) {
								$contact_forms = unserialize($contact_forms);
							}
							?>
							<?php if (!empty($contact_forms) AND is_array($contact_forms)): ?>
								<?php $counter = 0; ?>
								<?php foreach ($contact_forms as $contact_form_id => $contact_form) : ?>
									<li style="display: none"><a href="#contact_form_<?php echo $counter; ?>"><?php echo $contact_form['title']; ?></a></li>
									<?php $counter++; ?>
								<?php endforeach; ?>
							<?php endif; ?>
                        </ul>
                    </li>

                    <li><a class="shortcut-sidebar" href="#tab9-0"><?php _e('Custom Sidebars', TMM_THEME_FOLDER_NAME); ?></a>
                        <ul class="custom_sidebars_list">
                            <li><a href="#tab9-0" class="custom_sidebars_list_nav_link"><?php _e('General', TMM_THEME_FOLDER_NAME); ?></a></li>

							<?php
							if (is_string($sidebars) AND !empty($sidebars)) {
								$sidebars = unserialize($sidebars);
							}
							?>
							<?php if (!empty($sidebars) AND is_array($sidebars)): ?>
								<?php foreach ($sidebars as $sidebar_id => $sidebar) : ?>
									<li style="display: none"><a href="#<?php echo $sidebar_id; ?>"><?php echo $sidebar['name']; ?></a></li>
								<?php endforeach; ?>
							<?php endif; ?>


                        </ul>

                    </li>

                    <li><a class="shortcut-seo" href="#tab10">
							<?php _e('SEO Tools', TMM_THEME_FOLDER_NAME); ?></a>
                        <ul class="seo_groups_list">
                            <li><a class="shortcut-footer" href="#tab10"><?php _e('General', TMM_THEME_FOLDER_NAME); ?></a></li>
                            <li><a class="shortcut-footer seo_groups_nav_link" href="#tab10-0"><?php _e('SEO Groups', TMM_THEME_FOLDER_NAME); ?></a></li>


							<?php
							if (is_string($seo_groups) AND !empty($seo_groups)) {
								$seo_groups = unserialize($seo_groups);
							}
							?>

							<?php if (!empty($seo_groups) AND is_array($seo_groups)): ?>
								<?php foreach ($seo_groups as $group_id => $seo_group) : ?>
									<?php if ($group_id): ?>
										<li style="display: none;"><a href="#<?php echo $group_id; ?>"><?php echo $seo_group['name']; ?></a></li>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>


                        </ul>
                    </li>
                    <li><a class="shortcut-footer" href="#events"><?php _e('Events', TMM_THEME_FOLDER_NAME); ?></a></li>
                    <li><a class="shortcut-footer" href="#tab11"><?php _e('Footer', TMM_THEME_FOLDER_NAME); ?></a></li>
                </ul><!--/ .admin-nav-->

            </aside><!--/ #admin-aside-->

            <section id="admin-content" class="clearfix">

                <div class="tab-content" id="tab1">
                    <h1><?php _e('General settings', TMM_THEME_FOLDER_NAME); ?></h1>

                    <h4><?php _e('Custom Favicon', TMM_THEME_FOLDER_NAME); ?></h4>

                    <div class="admin-file clearfix">

						<?php $favicon = get_option(TMM_THEME_PREFIX . "favicon_img") ?>

                        <input type="text" name="favicon_img" value="<?php echo $favicon ?>">

                        <a class="admin-button button-gray button-medium button_upload" href="#"><?php _e('Upload', TMM_THEME_FOLDER_NAME); ?></a><br />

                        <div class="clear"></div>

                        <img id="favicon_preview_image" style="display: <?php if ($favicon): ?>block<?php else: ?>none<?php endif; ?>" src="<?php echo $favicon ?>" alt="favicon" />

                    </div>

                    <hr class="admin-divider" />

                    <h2><?php _e('Site Logo', TMM_THEME_FOLDER_NAME); ?></h2>
                    <ul>
                        <li><input type="radio" name="logo_type" value="1" <?php echo(get_option(TMM_THEME_PREFIX . "logo_type") ? "checked" : "") ?> /><?php _e('Image', TMM_THEME_FOLDER_NAME); ?>&nbsp;&nbsp;<input type="radio" name="logo_type" value="0" <?php echo(!get_option(TMM_THEME_PREFIX . "logo_type") ? "checked" : "") ?> /> <?php _e('Text', TMM_THEME_FOLDER_NAME); ?><br /></li>
                        <li class="logo_img" <?php echo(get_option(TMM_THEME_PREFIX . "logo_type") ? "" : 'style="display:none;"') ?>>
							<?php $logo_img = get_option(TMM_THEME_PREFIX . "logo_img") ?>
                            <input type="text" name="logo_img" value="<?php echo $logo_img ?>">&nbsp;<a title="" class="button_upload admin-button button-gray button-medium" href="#"><?php _e('Upload', TMM_THEME_FOLDER_NAME); ?></a><br />
                            <img id="logo_preview_image" style="display: <?php if ($logo_img): ?>inline<?php else: ?>none<?php endif; ?>; max-width:150px;" src="<?php echo $logo_img ?>" alt="logo" />
                        </li>
                        <li class="logo_text" <?php echo(!get_option(TMM_THEME_PREFIX . "logo_type") ? "" : 'style="display:none;"') ?>>
                            <input type="text" name="logo_text" value="<?php echo get_option(TMM_THEME_PREFIX . "logo_text") ?>"><br />
                        </li>
                    </ul>
                    <h4><?php _e('Logo font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php $logo_font = get_option(TMM_THEME_PREFIX . "logo_font"); ?>
                    <select name="logo_font" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $logo_font ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>

                    <h4><?php _e('Logo Text Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php $logo_text_color = get_option(TMM_THEME_PREFIX . "logo_text_color"); ?>
                            <input type="text" name="logo_text_color" value="<?php echo set_theme_options_defaults('logo_text_color', $logo_text_color) ?>" class="bg_hex_color text">
                            <div style="background-color: <?php echo set_theme_options_defaults('logo_text_color', $logo_text_color) ?>;" class="bgpicker"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <hr class="admin-divider" />

                    <h4><?php _e('Default Sidebar position', TMM_THEME_FOLDER_NAME); ?></h4>

					<?php $sidebar_position_selected = get_option(TMM_THEME_PREFIX . "sidebar_position"); ?>
					<?php $sidebar_position_selected = (!$sidebar_position_selected ? "sbr" : $sidebar_position_selected) ?>
                    <input type="hidden" value="<?php echo $sidebar_position_selected ?>" name="sidebar_position" />
                    <ul class="admin-choice-sidebar clearfix">
                        <li class="lside <?php echo ($sidebar_position_selected == "sbl" ? "current-item" : "") ?>"><a href="#" data-val="sbl"><?php _e('Left Sidebar', TMM_THEME_FOLDER_NAME); ?></a></li>
                        <li class="wside <?php echo ($sidebar_position_selected == "no_sidebar" ? "current-item" : "") ?>"><a href="#" data-val="no_sidebar"><?php _e('Without Sidebar', TMM_THEME_FOLDER_NAME); ?></a></li>
                        <li class="rside <?php echo ($sidebar_position_selected == "sbr" ? "current-item" : "") ?>"><a data-val="sbr" href="#"><?php _e('Right Sidebar', TMM_THEME_FOLDER_NAME); ?></a></li>
                    </ul>

                    <hr class="admin-divider" />


					<div class="clearfix ">
                        <div class="admin-one-half">
							<?php $image_mode = get_option(TMM_THEME_PREFIX . "image_mode"); ?>
							<input type="checkbox" value="true" name="image_mode" class="option_checkbox" <?php echo($image_mode ? "checked" : "") ?> />
							<input type="hidden" value="<?php echo($image_mode ? "1" : "0") ?>" name="image_mode">
							&nbsp;<strong><?php _e('Resize images without timthumb', TMM_THEME_FOLDER_NAME); ?></strong>

                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('After checking this checkbox please regenerate thumbnails', TMM_THEME_FOLDER_NAME); ?>!
                            </p>
                        </div>
                    </div>



                    <hr class="admin-divider" />


					<?php $hide_breadcrumb = get_option(TMM_THEME_PREFIX . "hide_breadcrumb"); ?>
                    <input type="checkbox" value="true" name="hide_breadcrumb" class="option_checkbox" <?php echo($hide_breadcrumb ? "checked" : "") ?> />
                    <input type="hidden" value="<?php echo($hide_breadcrumb ? "1" : "0") ?>" name="hide_breadcrumb">
                    &nbsp;<strong><?php _e('Disable Breadcrumbs', TMM_THEME_FOLDER_NAME); ?></strong>


                    <hr class="admin-divider" />


					<?php $hide_footer = get_option(TMM_THEME_PREFIX . "hide_footer"); ?>
                    <input type="checkbox" value="true" name="hide_footer" class="option_checkbox" <?php echo($hide_footer ? "checked" : "") ?> />
                    <input type="hidden" value="<?php echo($hide_footer ? "1" : "0") ?>" name="hide_footer">
                    &nbsp;<strong><?php _e('Disable Footer Bar', TMM_THEME_FOLDER_NAME); ?></strong>


                    <hr class="admin-divider" />


					<?php $hide_wp_image_sizes = get_option(TMM_THEME_PREFIX . "hide_wp_image_sizes"); ?>
                    <input type="checkbox" value="true" name="hide_wp_image_sizes" class="option_checkbox" <?php echo($hide_wp_image_sizes ? "checked" : "") ?> />
                    <input type="hidden" value="<?php echo($hide_wp_image_sizes ? "1" : "0") ?>" name="hide_wp_image_sizes">
                    &nbsp;<strong><?php _e('Disable Default Image Media Settings', TMM_THEME_FOLDER_NAME); ?></strong>


                    <hr class="admin-divider" />


					<?php $turn_off_wptexturize = get_option(TMM_THEME_PREFIX . "turn_off_wptexturize"); ?>
                    <input type="checkbox" value="true" name="turn_off_wptexturize" class="option_checkbox" <?php echo($turn_off_wptexturize ? "checked" : "") ?> />
                    <input type="hidden" value="<?php echo($turn_off_wptexturize ? "1" : "0") ?>" name="turn_off_wptexturize">
                    &nbsp;<strong><?php _e('Disable wptexturize (recommended)', TMM_THEME_FOLDER_NAME); ?></strong>


                    <hr class="admin-divider" />


					<?php $switcher_pie = get_option(TMM_THEME_PREFIX . 'switcher_pie'); ?>
                    <input type="checkbox" value="true" name="switcher_pie" class="option_checkbox" <?php echo($switcher_pie ? "checked" : "") ?> />
                    <input type="hidden" value="<?php echo($switcher_pie ? "1" : "0") ?>" name="switcher_pie">
                    <strong>
						<?php _e('Enable PIE (better look for IE8)', TMM_THEME_FOLDER_NAME); ?>
                    </strong>


                    <hr class="admin-divider" />


                    <h4><?php _e('Custom CSS', TMM_THEME_FOLDER_NAME); ?></h4>
                    <textarea name="custom_css" class="fullwidth" style="height: 300px !important ;"><?php echo get_option(TMM_THEME_PREFIX . "custom_css") ?></textarea>


                    <hr class="admin-divider" />


                    <h4><?php _e('Tracking Code', TMM_THEME_FOLDER_NAME); ?></h4>

                    <div class="clearfix ">
                        <div class="admin-one-half">
                            <p>
                                <textarea name="tracking_code"><?php echo get_option(TMM_THEME_PREFIX . "tracking_code") ?></textarea>
                            </p>
                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Paste your Google Analytics (or other) tracking code here. It will be inserted before the closing body tag of your theme.', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div><!--/ .admin-one-half-->
                    </div>



                    <hr class="admin-divider" />

                    <h4><?php _e('FeedBurner URL', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
                            <p>
                                <input type="text" name="feedburner" value="<?php echo get_option(TMM_THEME_PREFIX . "feedburner") ?>">
                            </p>
                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Enter your full FeedBurner URL (or any other preferred feed URL) if you wish to use FeedBurner over the standard WordPress Feed', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div><!--/ .admin-one-half-->


						<?php if (wp_count_posts()->publish == 1 AND wp_count_posts('page')->publish == 1): ?>

							<hr />
							<h2><?php _e('One Click Demo Data Install', TMM_THEME_FOLDER_NAME); ?></h2>


							<div class="clearfix">
								<div class="admin-one-half">
									<p>
										<a class="admin-button button-medium button-yellow" id="button_import_demo_data" href="#"><?php _e('Install', TMM_THEME_FOLDER_NAME); ?></a>
										<a style="display: none;" class="admin-button button-medium button-yellow" id="button_create_wp_meta_data" href="#"><?php _e('Create wp meta data', TMM_THEME_FOLDER_NAME); ?></a>
									</p>
								</div>

								<div class="admin-one-half last">
									<p class="admin-info">
										<?php _e('<b>Important Note:</b> Please make sure you have already set the permissions to folder http://yourdomain.com/wp-content/ to "777" before clicking "Install" button and afrer the installation you should change them back to "775"! After the installation you\'ll be redirected to wp-login page. Use the <b>login:</b> demo and <b>password:</b> demo. After logging you should reset your password and email.', TMM_THEME_FOLDER_NAME); ?>
									</p>
								</div>
							</div>

						<?php endif; ?>


                    </div>




                </div><!--/ .tab-content-->


                <div class="tab-content" id="tab2-0">
                    <h1><?php _e('Theme styling', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('General', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Default website font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$content_font = get_option(TMM_THEME_PREFIX . "content_fonts");
					?>
                    <select name="content_fonts" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $content_font ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>

                    <hr class="admin-divider" />


                    <h4><?php _e('Header Background Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php $header_bg_color = get_option(TMM_THEME_PREFIX . "header_bg_color"); ?>
                            <input type="text" class="bg_hex_color text" value="<?php echo get_option(TMM_THEME_PREFIX . "header_bg_color") ?>" name="header_bg_color">
                            <div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('header_bg_color', $header_bg_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <h4><?php _e('Background Separators', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <select name="draw_pattern_type">
							<?php
							$draw_pattern_type = array(
								1 => __("Jaggy", TMM_THEME_FOLDER_NAME),
								2 => __("Wavy", TMM_THEME_FOLDER_NAME),
								3 => __("Lineal", TMM_THEME_FOLDER_NAME),
							);
							$draw_pattern_selected = get_option(TMM_THEME_PREFIX . "draw_pattern_type");
							?>

							<?php foreach ($draw_pattern_type as $key => $value) : ?>
								<option <?php echo($key == $draw_pattern_selected ? "selected" : "") ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>

                    <hr class="admin-divider" />


                    <h4><?php _e('Links Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$links_color = get_option(TMM_THEME_PREFIX . "links_color");
							?>
                            <input type="text" name="links_color" value="<?php echo set_theme_options_defaults('links_color', $links_color) ?>" class="bg_hex_color text">
                            <div style="background-color: <?php echo set_theme_options_defaults('links_color', $links_color) ?>;" class="bgpicker"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <hr class="admin-divider" />

                    <h4><?php _e('Links Hover Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$links_hover_color = get_option(TMM_THEME_PREFIX . "links_hover_color");
							?>
                            <input type="text" name="links_hover_color" value="<?php echo set_theme_options_defaults('links_hover_color', $links_hover_color) ?>" class="bg_hex_color text">
                            <div style="background-color: <?php echo set_theme_options_defaults('links_hover_color', $links_hover_color) ?>;" class="bgpicker"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <hr class="admin-divider" />


                    <h4><?php _e('Theme Color Scheme', TMM_THEME_FOLDER_NAME); ?></h4>

                    <div class="clearfix ">

                        <div class="admin-one-half">
							<?php
							$color_scheme = get_option(TMM_THEME_PREFIX . "color_scheme");

							if (empty($color_scheme)) {
								$color_scheme = 'color-1';
							}
							?>

                            <div class="control_panel">
                                <ul>
                                    <li><a class="<?php if ($color_scheme == 'color-1') echo 'active'; ?>" style="background-color: #63c3d7" href="color-1"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 1</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-2') echo 'active'; ?>" style="background-color: #61b4ba" href="color-2"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 2</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-3') echo 'active'; ?>" style="background-color: #3476A6" href="color-3"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 3</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-4') echo 'active'; ?>" style="background-color: #827b71" href="color-4"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 4</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-5') echo 'active'; ?>" style="background-color: #8ec954" href="color-5"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 5</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-6') echo 'active'; ?>" style="background-color: #bac637" href="color-6"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 6</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-7') echo 'active'; ?>" style="background-color: #bf4423" href="color-7"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 7</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-8') echo 'active'; ?>" style="background-color: #cc6a28" href="color-8"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 8</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-9') echo 'active'; ?>" style="background-color: #7c291c" href="color-9"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 9</a></li>
                                    <li><a class="<?php if ($color_scheme == 'color-10') echo 'active'; ?>" style="background-color: #d8b929" href="color-10"><?php _e('color', TMM_THEME_FOLDER_NAME); ?> 10</a></li>
                                </ul>
                                <input type="hidden" name="color_scheme" />
                            </div><!--/ .control_panel-->

                        </div>

                    </div>


                    <hr class="admin-divider" />

                    <div class="tmk_option select ">
                        <div class="options_custom_body_pattern">
							<?php
							$body_pattern_selected = get_option(TMM_THEME_PREFIX . "body_pattern_selected");
							$body_pattern = get_option(TMM_THEME_PREFIX . "body_pattern");
							?>

                            <h4><?php _e('Default website background', TMM_THEME_FOLDER_NAME); ?></h4>
                            <select name="body_pattern_selected">
                                <option value="0" <?php echo($body_pattern_selected == 0 ? 'selected=""' : "") ?>><?php _e('Patterns', TMM_THEME_FOLDER_NAME); ?></option>
                                <option value="1" <?php echo($body_pattern_selected == 1 ? 'selected=""' : "") ?>><?php _e('Custom background image', TMM_THEME_FOLDER_NAME); ?></option>
                                <option value="2" <?php echo($body_pattern_selected == 2 ? 'selected=""' : "") ?>><?php _e('Background color', TMM_THEME_FOLDER_NAME); ?></option>
                            </select>

                            <ul>
                                <li class="body_pattern_default_image" <?php echo($body_pattern_selected == 0 ? "" : 'style="display:none;"') ?>>


									<?php
									$result = array();
									$patterns_path = TMM_THEME_PATH . "/images/patterns/";
									$dir_handle = opendir($patterns_path); # Open the path
									while ($file = readdir($dir_handle)) {
										if (is_dir($file)) {
											continue;
										}
										$result[] = $file;
									}
									closedir($dir_handle);
									?>
                                    <div class="thumb_pattern">
										<?php if (!empty($result)): ?>
											<?php foreach ($result as $key => $file_name) : ?>
												<?php $img_path = TMM_THEME_URI . "/images/patterns/" . $file_name; ?>
												<a class="thumb_thumb_<?php echo($key + 1) ?> <?php if ($img_path == $body_pattern) echo "current"; ?>" href="<?php echo $img_path ?>">
													<img src="<?php echo $img_path ?>" alt="" width="29" height="29" />
												</a>
											<?php endforeach; ?>
										<?php endif; ?>
                                    </div>
                                    <div class="clear"></div>



                                    <br />

                                    <h4><?php _e('Pattern Background Color', TMM_THEME_FOLDER_NAME); ?></h4>

                                    <div class="clearfix ">
                                        <div class="admin-one-half">
											<?php
											$body_bg_color = get_option(TMM_THEME_PREFIX . "body_bg_color");
											?>
                                            <input type="text" name="body_bg_color" value="<?php echo set_theme_options_defaults('body_bg_color', $body_bg_color) ?>" class="bg_hex_color text">
                                            <div style="background-color: <?php echo set_theme_options_defaults('body_bg_color', $body_bg_color) ?>;" class="bgpicker"></div>
                                        </div>
                                        <div class="admin-one-half last">
                                            <p class="admin-info">
												<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="body_pattern_custom_image"<?php echo($body_pattern_selected == 1 ? "" : 'style="display:none;"') ?>>
                                    <input type="text" id="body_pattern_upload" name="body_pattern" value="<?php
									if ($body_pattern AND $body_pattern_selected == 1) {
										echo $body_pattern;
									}
									?>">&nbsp;<a title="" class="button_upload admin-button button-gray button-medium" href="#"><?php _e('Upload', TMM_THEME_FOLDER_NAME); ?></a><br />
                                    <div id="body_pattern_custom_image_preview" <?php if (!$body_pattern OR $body_pattern_selected == 0): ?>style="display: none;"<?php endif; ?>>
                                        <img src="<?php echo ThemeMakersHelper::resize_image($body_pattern, 100) ?>" alt="" width="100" />
                                    </div>
                                </li>

                                <li class="body_pattern_custom_color"<?php echo($body_pattern_selected == 2 ? "" : 'style="display:none;"') ?>>
                                    <div class="clearfix ">
                                        <div class="admin-one-half">
                                            <input type="text" name="body_pattern_custom_color" value="<?php echo(get_option(TMM_THEME_PREFIX . "body_pattern_custom_color")) ?>" class="bg_hex_color text">
                                            <div style="background-color: <?php echo(get_option(TMM_THEME_PREFIX . "body_pattern_custom_color")) ?>;" class="bgpicker"></div>
                                        </div>
                                        <div class="admin-one-half last">
                                            <p class="admin-info">
												<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>



                        </div>

                    </div>
                    <div class="clear"></div>
                    <br />

					<?php $disable_body_bg = get_option(TMM_THEME_PREFIX . "disable_body_bg"); ?>
                    <input type="checkbox" class="option_checkbox" <?php echo($disable_body_bg ? "checked" : "") ?> />
                    <input type="hidden" name="disable_body_bg" value="<?php echo($disable_body_bg ? 1 : 0) ?>" />
                    <strong><?php _e('Reverse to default website background', TMM_THEME_FOLDER_NAME); ?></strong>


                    <hr class="admin-divider" />

                    <div class="tmk_option select ">
                        <div class="options_custom_page_header_pattern">
							<?php $page_header_custom_image = get_option(TMM_THEME_PREFIX . "page_header_custom_image"); ?>

                            <h4><?php _e('Header background color', TMM_THEME_FOLDER_NAME); ?></h4>
                            <div class="clearfix ">
                                <div class="admin-one-half">
                                    <input type="text" name="page_header_custom_color" value="<?php echo(get_option(TMM_THEME_PREFIX . "page_header_custom_color")) ?>" class="bg_hex_color text">
                                    <div style="background-color: <?php echo(get_option(TMM_THEME_PREFIX . "page_header_custom_color")) ?>;" class="bgpicker"></div>
                                </div>
                                <div class="admin-one-half last">
                                    <p class="admin-info">
										<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                                    </p>
                                </div>
                            </div>

                            <h4><?php _e('Header background image', TMM_THEME_FOLDER_NAME); ?></h4>

                            <div class="clearfix ">
                                <div class="admin-one-half">
                                    <input type="text" id="page_header_upload" name="page_header_custom_image" value="<?php echo $page_header_custom_image ?>">&nbsp;<a title="" class="button_upload admin-button button-gray button-medium" href="#"><?php _e('Upload', TMM_THEME_FOLDER_NAME); ?></a><br />
                                    <div id="page_header_custom_image_preview" <?php if (!$page_header_custom_image): ?>style="display: none;"<?php endif; ?>>
                                        <img src="<?php echo ThemeMakersHelper::resize_image($page_header_custom_image, 100) ?>" alt="" width="100" />
                                    </div>
                                </div>
                                <div class="admin-one-half last">
                                    <p class="admin-info">
										<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                                    </p>
                                </div>
                            </div>





                        </div>

                    </div>
                    <div class="clear"></div>
                    <br />


                </div><!--/ #tab2-->


                <div class="tab-content" id="tab2-1">

                    <h1><?php _e('Theme Styling', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('Headings', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Default Heading Font Family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$heading_font = get_option(TMM_THEME_PREFIX . "heading_font");
					?>
                    <select name="heading_font" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $heading_font ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>


                    <hr class="admin-divider" />



                    <h4><?php _e('H1 heading font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$h1_font_family = get_option(TMM_THEME_PREFIX . "h1_font_family");
					?>
                    <select name="h1_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $h1_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>

                    <h4><?php _e('H1 heading font size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" name="h1_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "h1_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />

                    <hr class="admin-divider" />



                    <h4><?php _e('H2 heading font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$h2_font_family = get_option(TMM_THEME_PREFIX . "h2_font_family");
					?>
                    <select name="h2_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $h2_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>


                    <h4><?php _e('H2 heading font size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" name="h2_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "h2_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />


                    <hr class="admin-divider" />


                    <h4><?php _e('H3 heading font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$h3_font_family = get_option(TMM_THEME_PREFIX . "h3_font_family");
					?>
                    <select name="h3_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $h3_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>


                    <h4><?php _e('H3 heading font size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" name="h3_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "h3_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />


                    <hr class="admin-divider" />


                    <h4><?php _e('H4 heading font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$h4_font_family = get_option(TMM_THEME_PREFIX . "h4_font_family");
					?>
                    <select name="h4_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $h4_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>



                    <h4><?php _e('H4 heading font size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" name="h4_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "h4_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />

                    <hr class="admin-divider" />


                    <h4><?php _e('H5 heading font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$h5_font_family = get_option(TMM_THEME_PREFIX . "h5_font_family");
					?>
                    <select name="h5_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $h5_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>


                    <h4><?php _e('H5 heading font size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" name="h5_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "h5_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />


                    <hr class="admin-divider" />



                    <h4><?php _e('H6 heading font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$h6_font_family = get_option(TMM_THEME_PREFIX . "h6_font_family");
					?>
                    <select name="h6_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $h6_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>


                    <h4><?php _e('H6 heading font size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" name="h6_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "h6_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />


                </div>


                <div class="tab-content" id="tab2-2">

                    <h1><?php _e('Theme styling', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('Main navigation', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Font Family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$main_nav_font = get_option(TMM_THEME_PREFIX . "main_nav_font");
					?>
                    <select name="main_nav_font" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $main_nav_font ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>

					<hr class="admin-divider" />

					<h3><?php _e('Gradient Background Color') ?></h3>

                    <h4><?php _e('Background Color Top', TMM_THEME_FOLDER_NAME); ?></h4>

                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$main_nav_bg_color_top = get_option(TMM_THEME_PREFIX . "main_nav_bg_color_top");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('main_nav_bg_color_top', $main_nav_bg_color_top) ?>" name="main_nav_bg_color_top"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('main_nav_bg_color_top', $main_nav_bg_color_top) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <h4><?php _e('Background Color Bottom', TMM_THEME_FOLDER_NAME); ?></h4>

                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$main_nav_bg_color_bottom = get_option(TMM_THEME_PREFIX . "main_nav_bg_color_bottom");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('main_nav_bg_color_bottom', $main_nav_bg_color_bottom) ?>" name="main_nav_bg_color_bottom"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('main_nav_bg_color_bottom', $main_nav_bg_color_bottom) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <hr class="admin-divider" />

                    <h2><?php _e('Text color', TMM_THEME_FOLDER_NAME); ?></h2>


                    <h4><?php _e('Default', TMM_THEME_FOLDER_NAME); ?></h4>

                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$main_nav_def_text_color = get_option(TMM_THEME_PREFIX . "main_nav_def_text_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('main_nav_def_text_color', $main_nav_def_text_color) ?>" name="main_nav_def_text_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('main_nav_def_text_color', $main_nav_def_text_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>


                    <br />
                    <h4><?php _e('Current', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$main_nav_curr_text_color = get_option(TMM_THEME_PREFIX . "main_nav_curr_text_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('main_nav_curr_text_color', $main_nav_curr_text_color) ?>" name="main_nav_curr_text_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('main_nav_curr_text_color', $main_nav_curr_text_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <br />

                    <h4><?php _e('Hover', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$main_nav_hover_text_color = get_option(TMM_THEME_PREFIX . "main_nav_hover_text_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('main_nav_hover_text_color', $main_nav_hover_text_color) ?>" name="main_nav_hover_text_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('main_nav_hover_text_color', $main_nav_hover_text_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <hr class="admin-divider" />
                    <h2><?php _e('Background colors', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Current', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$main_nav_curr_item_bg_color = get_option(TMM_THEME_PREFIX . "main_nav_curr_item_bg_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('main_nav_curr_item_bg_color', $main_nav_curr_item_bg_color) ?>" name="main_nav_curr_item_bg_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('main_nav_curr_item_bg_color', $main_nav_curr_item_bg_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>



                </div>


                <div class="tab-content" id="tab2-3">

                    <h1><?php _e('Theme styling', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('Content', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$content_font_family = get_option(TMM_THEME_PREFIX . "content_font_family");
					?>
                    <select name="content_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $content_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>


                    <h4><?php _e('Font size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" name="content_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "content_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />

                    <hr class="admin-divider" />

                    <h4><?php _e('Text Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">

                        <div class="admin-one-half">
							<?php
							$content_text_color = get_option(TMM_THEME_PREFIX . "content_text_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('content_text_color', $content_text_color) ?>" name="content_text_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('content_text_color', $content_text_color) ?>;"></div>
                        </div>

                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>

                    </div>

                </div>

                <div class="tab-content" id="tab2-4">

                    <h1><?php _e('Theme Styling', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('Buttons', TMM_THEME_FOLDER_NAME); ?></h2>


                    <h4><?php _e('Font Family', TMM_THEME_FOLDER_NAME); ?></h4>

					<?php $content_font_family = get_option(TMM_THEME_PREFIX . "buttons_font_family"); ?>

                    <select name="buttons_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $content_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>


                    <h4><?php _e('Font Size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" name="buttons_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "buttons_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />


                    <h4><?php _e('Text Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$buttons_text_color = get_option(TMM_THEME_PREFIX . "buttons_text_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('buttons_text_color', $buttons_text_color) ?>" name="buttons_text_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('buttons_text_color', $buttons_text_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                </div>


                <div class="tab-content" id="tab2-5">

                    <h1><?php _e('Theme Styling', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('Sidebar Widgets', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Font family', TMM_THEME_FOLDER_NAME); ?></h4>
					<?php
					$widgets_heading_font_family = get_option(TMM_THEME_PREFIX . "widgets_heading_font_family");
					?>
                    <select name="widgets_heading_font_family" class="google_font_select">
						<?php foreach ($fonts as $font_name) : ?>
							<?php
							$font_clean_name = explode(":", $font_name);
							$font_clean_name = $font_clean_name[0];
							?>
							<option <?php echo ($font_clean_name == $widgets_heading_font_family ? "selected" : "") ?> value="<?php echo $font_clean_name; ?>"><?php echo $font_name; ?></option>
						<?php endforeach; ?>
                    </select>&nbsp;<a title="" class="admin-button button-gray button-medium" href="javascript:add_google_font();"><?php _e('Manage google fonts', TMM_THEME_FOLDER_NAME); ?></a>

                    <h4><?php _e('Heading font size', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
                            <input type="text" name="widgets_heading_font_size" value="<?php echo(get_option(TMM_THEME_PREFIX . "widgets_heading_font_size")) ?>" min-value="12" max-value="42" class="ui_slider_item" />
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Set this field 0 to use default theme styling', TMM_THEME_FOLDER_NAME); ?><br />
                            </p>
                        </div>
                    </div>



                    <hr class="admin-divider" />

                    <h2><?php _e('Text', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Title color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$widget_def_title_color = get_option(TMM_THEME_PREFIX . "widget_def_title_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('widget_def_title_color', $widget_def_title_color) ?>" name="widget_def_title_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('widget_def_title_color', $widget_def_title_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>


                    <br />

                    <h4><?php _e('Text color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$widget_def_text_color = get_option(TMM_THEME_PREFIX . "widget_def_text_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('widget_def_text_color', $widget_def_text_color) ?>" name="widget_def_text_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('widget_def_text_color', $widget_def_text_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <br />

<!--                    <h4><?php _e('Links color active', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
					<?php
					$widget_def_link_color = get_option(TMM_THEME_PREFIX . "widget_def_link_color");
					?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('widget_def_link_color', $widget_def_link_color) ?>" name="widget_def_link_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('widget_def_link_color', $widget_def_link_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
					<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <br />

                    <h4><?php _e('Links color hover', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
					<?php
					$widget_def_link_hover_color = get_option(TMM_THEME_PREFIX . "widget_def_link_hover_color");
					?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('widget_def_link_hover_color', $widget_def_link_hover_color) ?>" name="widget_def_link_hover_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('widget_def_link_hover_color', $widget_def_link_hover_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
					<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>-->


                    <hr class="admin-divider" />


                    <h2><?php _e('Testimonials', TMM_THEME_FOLDER_NAME); ?></h2>
                    <h4><?php _e('Testimonials text color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix">
                        <div class="admin-one-half">
							<?php
							$widget_colored_testimonials_text_color = get_option(TMM_THEME_PREFIX . "widget_colored_testimonials_text_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('widget_colored_testimonials_text_color', $widget_colored_testimonials_text_color) ?>" name="widget_colored_testimonials_text_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('widget_colored_testimonials_text_color', $widget_colored_testimonials_text_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>

                    <h4><?php _e('Testimonials author text color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix">
                        <div class="admin-one-half">
							<?php
							$widget_colored_testimonials_author_text_color = get_option(TMM_THEME_PREFIX . "widget_colored_testimonials_author_text_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('widget_colored_testimonials_author_text_color', $widget_colored_testimonials_author_text_color) ?>" name="widget_colored_testimonials_author_text_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('widget_colored_testimonials_author_text_color', $widget_colored_testimonials_author_text_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>


                </div>


                <div class="tab-content" id="tab2-6">


                    <h1><?php _e('Theme Styling', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('Images', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Image Frame Background Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$image_frame_bg_color = get_option(TMM_THEME_PREFIX . "image_frame_bg_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('image_frame_bg_color', $image_frame_bg_color) ?>" name="image_frame_bg_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('image_frame_bg_color', $image_frame_bg_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>
                    <hr class="admin-divider" />

                    <h4><?php _e('Image Frame Hover Background Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$image_frame_hover_bg_color = get_option(TMM_THEME_PREFIX . "image_frame_hover_bg_color");
							?>
                            <input type="text" class="bg_hex_color text" value="<?php echo set_theme_options_defaults('image_frame_hover_bg_color', $image_frame_hover_bg_color) ?>" name="image_frame_hover_bg_color"><div class="bgpicker" style="background-color: <?php echo set_theme_options_defaults('image_frame_hover_bg_color', $image_frame_hover_bg_color) ?>;"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>
                    <hr class="admin-divider" />

                </div>


                <div class="tab-content" id="tab2-7">

                    <h1><?php _e('Theme Styling', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('Footer Area', TMM_THEME_FOLDER_NAME); ?></h2>

                    <h4><?php _e('Footer Background Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$footer_bg_color = get_option(TMM_THEME_PREFIX . "footer_bg_color");
							?>
                            <input type="text" name="footer_bg_color" value="<?php echo set_theme_options_defaults('footer_bg_color', $footer_bg_color) ?>" class="bg_hex_color text">
                            <div style="background-color: <?php echo set_theme_options_defaults('footer_bg_color', $footer_bg_color) ?>;" class="bgpicker"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>
                    <div class="clear"></div>



                    <hr class="admin-divider" />



                    <h2><?php _e('Footer Widgets', TMM_THEME_FOLDER_NAME); ?></h2>
                    <h4><?php _e('Title Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$footer_widget_title_color = get_option(TMM_THEME_PREFIX . "footer_widget_title_color");
							?>
                            <input type="text" name="footer_widget_title_color" value="<?php echo set_theme_options_defaults('footer_widget_title_color', $footer_widget_title_color) ?>" class="bg_hex_color text">
                            <div style="background-color: <?php echo set_theme_options_defaults('footer_widget_title_color', $footer_widget_title_color) ?>;" class="bgpicker"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <br />

                    <h4><?php _e('Text Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$footer_color = get_option(TMM_THEME_PREFIX . "footer_color");
							?>
                            <input type="text" name="footer_color" value="<?php echo set_theme_options_defaults('footer_color', $footer_color) ?>" class="bg_hex_color text">
                            <div style="background-color: <?php echo set_theme_options_defaults('footer_color', $footer_color) ?>;" class="bgpicker"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <br />

                    <h4><?php _e('Link Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$footer_widget_link_color = get_option(TMM_THEME_PREFIX . "footer_widget_link_color");
							?>
                            <input type="text" name="footer_widget_link_color" value="<?php echo set_theme_options_defaults('footer_widget_link_color', $footer_widget_link_color) ?>" class="bg_hex_color text">
                            <div style="background-color: <?php echo set_theme_options_defaults('footer_widget_link_color', $footer_widget_link_color) ?>;" class="bgpicker"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <br />


                    <h4><?php _e('Link hover Color', TMM_THEME_FOLDER_NAME); ?></h4>
                    <div class="clearfix ">
                        <div class="admin-one-half">
							<?php
							$footer_widget_link_hover_color = get_option(TMM_THEME_PREFIX . "footer_widget_link_hover_color");
							?>
                            <input type="text" name="footer_widget_link_hover_color" value="<?php echo set_theme_options_defaults('footer_widget_link_hover_color', $footer_widget_link_hover_color) ?>" class="bg_hex_color text">
                            <div style="background-color: <?php echo set_theme_options_defaults('footer_widget_link_hover_color', $footer_widget_link_hover_color) ?>;" class="bgpicker"></div>
                        </div>
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e('Leave this field blank to use default theme styling', TMM_THEME_FOLDER_NAME); ?>
                            </p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <br />



                </div>



				<?php $slider = new Thememakers_Entity_Slider(); ?>
                <div class="tab-content" id="tab4-0">

                    <h1><?php _e('Slider Settings', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h2><?php _e('General', TMM_THEME_FOLDER_NAME); ?></h2>

                    <div class="options_slider_settings">
						<?php echo $slider->draw_sliders_options(); ?>
                    </div>
                </div>

                <div class="tab-content" id="tab4-1">1</div>
                <div class="tab-content" id="tab4-2">2</div>
                <div class="tab-content" id="tab4-3">3</div>
                <div class="tab-content" id="tab4-4">4</div>
                <div class="tab-content" id="tab4-5">5</div>
                <div class="tab-content" id="tab4-6">6</div>
                <div class="tab-content" id="tab4-7">7</div>
                <div class="tab-content" id="tab41"></div>
                <div class="tab-content" id="tab41-0">

                    <h1><?php _e('Sliders Groups General', TMM_THEME_FOLDER_NAME); ?></h1>

                    <div class="add-input clearfix">
                        <input type="text" value="" placeholder="<?php _e('type title here', TMM_THEME_FOLDER_NAME); ?>" />
                        <a class="add-input-button create-slider-group" href="#"></a>
                    </div>


                    <hr class="admin-divider" />
                    <h4><?php _e("Sliders Groups", TMM_THEME_FOLDER_NAME); ?></h4>
                    <ul class="groups slider_groups_list">
						<?php if (!empty($slides) AND is_array($slides)): ?>
							<?php foreach ($slides as $key => $slide) : ?>
								<?php if (isset($slide['name'])): ?>
									<?php if ($slide['name']): ?>
										<li>
											<a class="delegate_click" id-data="slider_group_<?php echo $key ?>" href="#"><?php echo $slide['name'] ?></a>
											<input type="hidden" name="sliders[<?php echo $key ?>][name]" value="<?php echo $slide['name'] ?>" />
											<a href="#" title="Delete" class="remove remove-slider-group" group-index="<?php echo $key ?>"></a>
											<a id-data="slider_group_<?php echo $key ?>" href="#" title="Edit" class="edit delegate_click"></a>
										</li>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<li class="js_no_one_item_else"><span><?php _e('You have not created any slider group yet. Please create one using the form above.', TMM_THEME_FOLDER_NAME); ?></span></li>
						<?php endif; ?>
                    </ul>

                </div>

                <div id="slider_groups_content">
					<?php echo ThemeMakersThemeView::draw_page('slider/sliders_groups', array('slides' => $slides)); ?>
                </div>


                <div class="tab-content" id="tab5">

                    <h1><?php _e('Blog', TMM_THEME_FOLDER_NAME); ?></h1>


                    <div class="options_blog_settings">

						<?php
						$enable_related_posts = get_option(TMM_THEME_PREFIX . "enable_related_posts");
						//$show_author_info = get_option(TMM_THEME_PREFIX . "show_author_info");
						$show_full_content = get_option(TMM_THEME_PREFIX . "show_full_content");
						$disable_author = get_option(TMM_THEME_PREFIX . "disable_author");
						$disable_blog_comments = get_option(TMM_THEME_PREFIX . "disable_blog_comments");
						$disable_categories = get_option(TMM_THEME_PREFIX . "disable_categories");
						$disable_tags = get_option(TMM_THEME_PREFIX . "disable_tags");
						$cut_blog_images_without_height = get_option(TMM_THEME_PREFIX . "cut_blog_images_without_height");
						$comment_notes_after = get_option(TMM_THEME_PREFIX . "comment_notes_after");
						?>

                        <input type="checkbox" class="option_checkbox" <?php if ($disable_author): ?>checked=""<?php endif; ?>  /><input type="hidden" value="<?php if ($disable_author): ?>1<?php else: ?>0<?php endif; ?>" name="disable_author" /> <strong><?php _e('Disable Author', TMM_THEME_FOLDER_NAME); ?></strong><br />

                        <hr class="admin-divider" />

                        <input type="checkbox" class="option_checkbox" <?php if ($disable_blog_comments): ?>checked=""<?php endif; ?>  /><input type="hidden" value="<?php if ($disable_blog_comments): ?>1<?php else: ?>0<?php endif; ?>" name="disable_blog_comments" /> <strong><?php _e('Disable Blog Comments', TMM_THEME_FOLDER_NAME); ?></strong><br />

                        <hr class="admin-divider" />

                        <input type="checkbox" class="option_checkbox" <?php if ($disable_categories): ?>checked=""<?php endif; ?>  /><input type="hidden" value="<?php if ($disable_categories): ?>1<?php else: ?>0<?php endif; ?>" name="disable_categories" /> <strong><?php _e('Disable Categories', TMM_THEME_FOLDER_NAME); ?></strong><br />

                        <hr class="admin-divider" />

                        <input type="checkbox" class="option_checkbox" <?php if ($disable_tags): ?>checked=""<?php endif; ?>  /><input type="hidden" value="<?php if ($disable_tags): ?>1<?php else: ?>0<?php endif; ?>" name="disable_tags" /> <strong><?php _e('Disable Tags', TMM_THEME_FOLDER_NAME); ?></strong><br />

                        <hr class="admin-divider" />

                        <input type="checkbox" class="option_checkbox" <?php if ($enable_related_posts): ?>checked=""<?php endif; ?>  /><input type="hidden" value="<?php if ($enable_related_posts): ?>1<?php else: ?>0<?php endif; ?>" name="enable_related_posts" /> <strong><?php _e('Enable related posts', TMM_THEME_FOLDER_NAME); ?></strong><br />

                        <hr class="admin-divider" />

                       <!-- <input type="checkbox" class="option_checkbox" <?php if ($show_author_info): ?>checked=""<?php endif; ?> /><input type="hidden" value="<?php if ($show_author_info): ?>1<?php else: ?>0<?php endif; ?>" name="show_author_info" /> <strong><?php _e('Show author info', TMM_THEME_FOLDER_NAME); ?></strong><br /> -->

                        <!-- <hr class="admin-divider" /> -->

                        <input type="checkbox" class="option_checkbox" <?php if ($show_full_content): ?>checked=""<?php endif; ?> /><input type="hidden" value="<?php if ($show_full_content): ?>1<?php else: ?>0<?php endif; ?>" name="show_full_content" /> <strong><?php _e('Show full content', TMM_THEME_FOLDER_NAME); ?></strong><br />

                        <hr class="admin-divider" />

						<input type="checkbox" class="option_checkbox" <?php if ($comment_notes_after): ?>checked=""<?php endif; ?> /><input type="hidden" value="<?php if ($comment_notes_after): ?>1<?php else: ?>0<?php endif; ?>" name="comment_notes_after" /> <strong><?php _e('Show comment notes after comment form', TMM_THEME_FOLDER_NAME); ?></strong><br />

                        <hr class="admin-divider" />

                        <h4><?php _e('Excerpt: symbols count', TMM_THEME_FOLDER_NAME); ?></h4>
						<?php
						$excerpt_symbols_count = get_option(TMM_THEME_PREFIX . "excerpt_symbols_count");
						if (!$excerpt_symbols_count) {
							$excerpt_symbols_count = 140;
						}
						?>

                        <input type="text" class="ui_slider_item" name="excerpt_symbols_count" value="<?php echo $excerpt_symbols_count ?>" min-value="20" max-value="500" class="ui_slider_item"><br />

						<hr class="admin-divider" />
						<input type="checkbox" class="option_checkbox" <?php if ($cut_blog_images_without_height): ?>checked=""<?php endif; ?>  /><input type="hidden" value="<?php if ($cut_blog_images_without_height): ?>1<?php else: ?>0<?php endif; ?>" name="cut_blog_images_without_height" /> <strong><?php _e('Cut blog images proportionally', TMM_THEME_FOLDER_NAME); ?></strong><br />


                    </div>

                </div>

                <div class="tab-content" id="tab6">

                    <h1><?php _e('Portfolio', TMM_THEME_FOLDER_NAME); ?></h1>
                    <h4><?php _e('Portfolio slider width', TMM_THEME_FOLDER_NAME); ?></h4>

					<?php
					$portfolio_slider_width = get_option(TMM_THEME_PREFIX . "portfolio_slider_width");

					if (!$portfolio_slider_width) {
						$portfolio_slider_width = 400;
					}
					?>

                    <select name="portfolio_slider_width">

						<?php
						$portfolio_slider_width = array(
							340 => __("Small", TMM_THEME_FOLDER_NAME),
							400 => __("Middle", TMM_THEME_FOLDER_NAME),
							460 => __("Large", TMM_THEME_FOLDER_NAME),
							520 => __("Extra Large", TMM_THEME_FOLDER_NAME)
						);

						$portfolio_layout_selected = get_option(TMM_THEME_PREFIX . "portfolio_slider_width");
						?>

						<?php foreach ($portfolio_slider_width as $key => $value) : ?>
							<option <?php echo($key == $portfolio_layout_selected ? "selected" : "") ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
						<?php endforeach; ?>

                    </select>

                    <br />	<br />


					<?php $disable_portfolio_comments = get_option(TMM_THEME_PREFIX . "disable_portfolio_comments"); ?>
                    <input type="checkbox" class="option_checkbox" <?php if ($disable_portfolio_comments): ?>checked=""<?php endif; ?>  /><input type="hidden" value="<?php if ($disable_portfolio_comments): ?>1<?php else: ?>0<?php endif; ?>" name="disable_portfolio_comments" /> <strong><?php _e('Disable Portfolio Comments', TMM_THEME_FOLDER_NAME); ?></strong><br />


                    <br />

                    <ul>
                        <li>
							<?php $portfolio_hide_filter = get_option(TMM_THEME_PREFIX . "portfolio_hide_filter"); ?>
                            <input type="checkbox" <?php echo($portfolio_hide_filter ? 'checked=""' : '') ?> class="option_checkbox"><input type="hidden" value="<?php if ($portfolio_hide_filter): ?>1<?php else: ?>0<?php endif; ?>" name="portfolio_hide_filter" />
                            &nbsp;<strong><?php _e('Disable Portfolio Filter', TMM_THEME_FOLDER_NAME); ?></strong>
                            <hr class="admin-divider" />
                        </li>
                    </ul>


                    <br />
                    <h2><?php _e('Archive layout', TMM_THEME_FOLDER_NAME); ?></h2>
					<?php $folio_archive_layout = get_option(TMM_THEME_PREFIX . "folio_archive_layout"); ?>
                    <select name="folio_archive_layout">
                        <option <?php if ($folio_archive_layout == 1): ?>selected=""<?php endif; ?> value="1"><?php _e('1 Column Template', TMM_THEME_FOLDER_NAME); ?></option>
                        <option <?php if ($folio_archive_layout == 2): ?>selected=""<?php endif; ?> value="2"><?php _e('2 Column Template', TMM_THEME_FOLDER_NAME); ?></option>
                        <option <?php if ($folio_archive_layout == 3): ?>selected=""<?php endif; ?> value="3"><?php _e('3 Column Template', TMM_THEME_FOLDER_NAME); ?></option>
                    </select><br />

                    <br />

                    <h2><?php _e('1 Column Template', TMM_THEME_FOLDER_NAME); ?></h2>
					<?php
					$porfolio_1col_excerpt_symbols_count = get_option(TMM_THEME_PREFIX . "porfolio_1col_excerpt_symbols_count");
					if (!$porfolio_1col_excerpt_symbols_count) {
						$porfolio_1col_excerpt_symbols_count = 120;
					}
					?>

                    <h4><?php _e('Exerpt symbols count', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" class="ui_slider_item" name="porfolio_1col_excerpt_symbols_count" value="<?php echo $porfolio_1col_excerpt_symbols_count ?>" min-value="0" max-value="900" class="ui_slider_item"><br />

                    <br />

					<?php
					$porfolio_1col_posts_per_page = get_option(TMM_THEME_PREFIX . "porfolio_1col_posts_per_page");
					if (!$porfolio_1col_posts_per_page) {
						$porfolio_1col_posts_per_page = 4;
					}
					?>
                    <h4><?php _e('Items to show per page', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" class="ui_slider_item" name="porfolio_1col_posts_per_page" value="<?php echo $porfolio_1col_posts_per_page ?>" min-value="1" max-value="12" class="ui_slider_item"><br />

                    <hr class="admin-divider" />


                    <h2><?php _e('2 Column Template', TMM_THEME_FOLDER_NAME); ?></h2>
					<?php
					$porfolio_2col_excerpt_symbols_count = get_option(TMM_THEME_PREFIX . "porfolio_2col_excerpt_symbols_count");
					if (!$porfolio_2col_excerpt_symbols_count) {
						$porfolio_2col_excerpt_symbols_count = 100;
					}
					?>

                    <h4><?php _e('Exerpt symbols count', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" class="ui_slider_item" name="porfolio_2col_excerpt_symbols_count" value="<?php echo $porfolio_2col_excerpt_symbols_count ?>" min-value="0" max-value="900" class="ui_slider_item"><br />

                    <br />

					<?php
					$porfolio_2col_posts_per_page = get_option(TMM_THEME_PREFIX . "porfolio_2col_posts_per_page");
					if (!$porfolio_2col_posts_per_page) {
						$porfolio_2col_posts_per_page = 6;
					}
					?>
                    <h4><?php _e('Items to show per page', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" class="ui_slider_item" name="porfolio_2col_posts_per_page" value="<?php echo $porfolio_2col_posts_per_page ?>" min-value="1" max-value="12" class="ui_slider_item"><br />

                    <hr class="admin-divider" />


                    <h2><?php _e('3 Column Template', TMM_THEME_FOLDER_NAME); ?></h2>
					<?php
					$porfolio_3col_excerpt_symbols_count = get_option(TMM_THEME_PREFIX . "porfolio_3col_excerpt_symbols_count");
					if (!$porfolio_3col_excerpt_symbols_count) {
						$porfolio_3col_excerpt_symbols_count = 80;
					}
					?>

                    <h4><?php _e('Exerpt symbols count', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" class="ui_slider_item" name="porfolio_3col_excerpt_symbols_count" value="<?php echo $porfolio_3col_excerpt_symbols_count ?>" min-value="0" max-value="900" class="ui_slider_item"><br />

                    <br />

					<?php
					$porfolio_3col_posts_per_page = get_option(TMM_THEME_PREFIX . "porfolio_3col_posts_per_page");
					if (!$porfolio_3col_posts_per_page) {
						$porfolio_3col_posts_per_page = 9;
					}
					?>
                    <h4><?php _e('Items to show per page', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" class="ui_slider_item" name="porfolio_3col_posts_per_page" value="<?php echo $porfolio_3col_posts_per_page ?>" min-value="1" max-value="12" class="ui_slider_item"><br />

                </div>

                <div class="tab-content" id="tab7">

                    <h1><?php _e('Gallery', TMM_THEME_FOLDER_NAME); ?></h1>

                    <ul>
                        <li>

                            <h4><?php _e('Slider gallery width', TMM_THEME_FOLDER_NAME); ?>:</h4>
							<?php
							$gallery_slider_width = get_option(TMM_THEME_PREFIX . "gallery_slider_width");

							if (!$gallery_slider_width) {
								$gallery_slider_width = 400;
							}
							?>

                            <select name="gallery_slider_width">
								<?php
								$gallery_slider_width = array(
									340 => __("Small", TMM_THEME_FOLDER_NAME),
									400 => __("Middle", TMM_THEME_FOLDER_NAME),
									460 => __("Large", TMM_THEME_FOLDER_NAME),
									520 => __("Extra Large", TMM_THEME_FOLDER_NAME)
								);
								$gallery_layout_selected = get_option(TMM_THEME_PREFIX . "gallery_slider_width");
								?>
								<?php foreach ($gallery_slider_width as $key => $value) : ?>
									<option <?php echo($key == $gallery_layout_selected ? "selected" : "") ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php endforeach; ?>
                            </select>

                            <hr class="admin-divider" />
                        </li>

                        <li>
							<?php $gallery_hide_filter = get_option(TMM_THEME_PREFIX . "gallery_hide_filter"); ?>
                            <input type="checkbox" <?php echo($gallery_hide_filter ? 'checked=""' : '') ?> class="option_checkbox"><input type="hidden" value="<?php if ($gallery_hide_filter): ?>1<?php else: ?>0<?php endif; ?>" name="gallery_hide_filter" />
                            &nbsp;<strong><?php _e('Disable gallery filter', TMM_THEME_FOLDER_NAME); ?></strong>
                            <hr class="admin-divider" />
                        </li>
                    </ul>

                </div><!--/ .tab-content-->


                <div class="tab-content" id="tab8"></div>


                <div class="tab-content" id="tab8-0">

                    <h1><?php _e('Contact Forms', TMM_THEME_FOLDER_NAME); ?></h1>

                    <h4><?php _e('Add new Form', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" value="" placeholder="type title here" id="new_contact_form_name" />&nbsp;<div class="add-button add_form"></div><br />

                    <hr class="admin-divider" />

                    <ul class="groups contact_forms_groups_list">
						<?php if (!empty($contact_forms) AND is_array($contact_forms)): ?>
							<?php $counter = 0; ?>
							<?php foreach ($contact_forms as $contact_form_id => $contact_form) : ?>
								<li>
									<a id-data="contact_form_<?php echo $counter ?>" class="delegate_click" href="#"><?php echo @$contact_form['title']; ?></a>
									<a href="#" title="<?php _e("Delete", TMM_THEME_FOLDER_NAME) ?>" class="remove delete_contact_form" form-list-index="<?php echo $counter ?>"></a>
									<a id-data="contact_form_<?php echo $counter ?>" href="#" title="<?php _e("Edit", TMM_THEME_FOLDER_NAME) ?>" class="edit delegate_click"></a>
								</li>
								<?php $counter++; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<li class="js_no_one_item_else"><span><?php _e('You have not created any group yet. Please create one using the form above.', TMM_THEME_FOLDER_NAME); ?></span></li>
						<?php endif; ?>
                    </ul>
                </div>



				<?php
				//print contacts forms
				$form_constructor = new Thememakers_Entity_Contact_Form('contacts_form');
				$form_constructor->draw_forms();
				?>


                <div class="tab-content" id="tab9-0">

                    <h1><?php _e('Custom Sidebars', TMM_THEME_FOLDER_NAME); ?></h1>

                    <h4><?php _e('Add Sidebar', TMM_THEME_FOLDER_NAME); ?></h4>

                    <input type="text" value="" id="sidebar_name" placeholder="<?php _e("type title here", TMM_THEME_FOLDER_NAME) ?>">

                    <div class="add-button add_sidebar"></div>

                    <hr class="admin-divider" />
                    <h4><?php _e("Custom Sidebars", TMM_THEME_FOLDER_NAME); ?></h4>
                    <ul class="groups custom_sidebars_list">
                        <input type="hidden" name="sidebars[]" value="" />
						<?php if (!empty($sidebars) AND is_array($sidebars)): ?>
							<?php foreach ($sidebars as $sidebar_id => $sidebar) : ?>
								<li>
									<a id-data="<?php echo $sidebar_id; ?>" class="delegate_click" href="#"><?php echo $sidebar['name']; ?></a>
									<input type="hidden" name="sidebars[<?php echo $sidebar_id; ?>][name]" value="<?php echo $sidebar['name']; ?>" />
									<a href="#" title="<?php _e('Delete', TMM_THEME_FOLDER_NAME); ?>" class="remove remove_sidebar" sidebar-id="<?php echo $sidebar_id ?>"></a>
									<a id-data="<?php echo $sidebar_id; ?>" href="#" title="<?php _e('Edit', TMM_THEME_FOLDER_NAME); ?>" class="edit delegate_click"></a>
								</li>
							<?php endforeach; ?>
						<?php else: ?>
							<li class="js_no_one_item_else"><span><?php _e('You have not created any sidebar group yet. Please create one using the form above.', TMM_THEME_FOLDER_NAME); ?></span></li>
						<?php endif; ?>

                    </ul>
                </div>
				<?php
				$data['sidebars'] = $sidebars;
				$data['entity_sidebars'] = new Thememakers_Entity_Custom_Sidebars();
				echo Thememakers_Entity_Custom_Sidebars::draw_sidebars_panel();
				?>


                <div class="tab-content" id="tab10">

                    <h1><?php _e('Seo Tools', TMM_THEME_FOLDER_NAME); ?></h1>

					<?php
					$meta_title_home = get_option(TMM_THEME_PREFIX . "meta_title_home");
					$meta_keywords_home = get_option(TMM_THEME_PREFIX . "meta_keywords_home");
					$meta_description_home = get_option(TMM_THEME_PREFIX . "meta_description_home");
					?>

                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta title home page', TMM_THEME_FOLDER_NAME); ?></h4>
                            <input type="text" name="meta_title_home" value="<?php echo $meta_title_home; ?>">

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('SEO title of page. Title – 50-80 characters (usually – 75)', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>

                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta keywords home page', TMM_THEME_FOLDER_NAME); ?></h4>
                            <textarea name="meta_keywords_home"><?php echo $meta_keywords_home; ?></textarea>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('Keywords - up to 250 characters', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>


                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta description home page', TMM_THEME_FOLDER_NAME); ?></h4>
                            <textarea name="meta_description_home"><?php echo $meta_description_home; ?></textarea>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('Description – about 150-200 characters', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>



                    <hr class="admin-divider" />


                    <h2><?php _e('Posts listing/Blog page', TMM_THEME_FOLDER_NAME); ?></h2>

					<?php
					$meta_title_post_listing = get_option(TMM_THEME_PREFIX . "meta_title_post_listing");
					$meta_keywords_post_listing = get_option(TMM_THEME_PREFIX . "meta_keywords_post_listing");
					$meta_description_post_listing = get_option(TMM_THEME_PREFIX . "meta_description_post_listing");
					?>

                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta title', TMM_THEME_FOLDER_NAME); ?></h4>
                            <input type="text" name="meta_title_post_listing" value="<?php echo $meta_title_post_listing; ?>">

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('SEO title of page. Title – 50-80 characters (usually – 75)', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>

                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta keywords', TMM_THEME_FOLDER_NAME); ?></h4>
                            <textarea name="meta_keywords_post_listing"><?php echo $meta_keywords_post_listing; ?></textarea>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('Keywords - up to 250 characters', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>


                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta description', TMM_THEME_FOLDER_NAME); ?></h4>
                            <textarea name="meta_description_post_listing"><?php echo $meta_description_post_listing; ?></textarea>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('Description – about 150-200 characters', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>



                    <hr class="admin-divider" />



                    <h2><?php _e('Portfolio listing', TMM_THEME_FOLDER_NAME); ?></h2>

					<?php
					$meta_title_portfolio_listing = get_option(TMM_THEME_PREFIX . "meta_title_portfolio_listing");
					$meta_keywords_portfolio_listing = get_option(TMM_THEME_PREFIX . "meta_keywords_portfolio_listing");
					$meta_description_portfolio_listing = get_option(TMM_THEME_PREFIX . "meta_description_portfolio_listing");
					?>

                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta title', TMM_THEME_FOLDER_NAME); ?></h4>
                            <input type="text" name="meta_title_portfolio_listing" value="<?php echo $meta_title_portfolio_listing; ?>">

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('SEO title of page. Title – 50-80 characters (usually – 75)', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>

                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta keywords', TMM_THEME_FOLDER_NAME); ?></h4>
                            <textarea name="meta_keywords_portfolio_listing"><?php echo $meta_keywords_portfolio_listing; ?></textarea>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('Keywords - up to 250 characters', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>


                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta description', TMM_THEME_FOLDER_NAME); ?></h4>
                            <textarea name="meta_description_portfolio_listing"><?php echo $meta_description_portfolio_listing; ?></textarea>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('Description – about 150-200 characters', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>



                    <hr class="admin-divider" />




                    <h2><?php _e('Gallery listing', TMM_THEME_FOLDER_NAME); ?></h2>

					<?php
					$meta_title_gallery_listing = get_option(TMM_THEME_PREFIX . "meta_title_gallery_listing");
					$meta_keywords_gallery_listing = get_option(TMM_THEME_PREFIX . "meta_keywords_gallery_listing");
					$meta_description_gallery_listing = get_option(TMM_THEME_PREFIX . "meta_description_gallery_listing");
					?>

                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta title', TMM_THEME_FOLDER_NAME); ?></h4>
                            <input type="text" name="meta_title_gallery_listing" value="<?php echo $meta_title_gallery_listing; ?>">

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('SEO title of page. Title – 50-80 characters (usually – 75)', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->
                    </div>






                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta keywords', TMM_THEME_FOLDER_NAME); ?></h4>
                            <textarea name="meta_keywords_gallery_listing"><?php echo $meta_keywords_gallery_listing; ?></textarea>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('Keywords - up to 250 characters', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>


                    <div class="clearfix ">
                        <div class="admin-one-half">

                            <h4><?php _e('Meta description', TMM_THEME_FOLDER_NAME); ?></h4>
                            <textarea name="meta_description_gallery_listing"><?php echo $meta_description_gallery_listing; ?></textarea>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e('Description – about 150-200 characters', TMM_THEME_FOLDER_NAME); ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>



                </div>


                <div class="tab-content" id="tab10-0">
                    <h4><?php _e('Add SEO Group', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="text" value="" id="seo_group_name" placeholder="<?php _e("type title here", TMM_THEME_FOLDER_NAME) ?>">
                    <div class="add-button add_seo_group"></div>
                    <hr class="admin-divider" />
                    <h4><?php _e('SEO Groups', TMM_THEME_FOLDER_NAME); ?></h4>
                    <input type="hidden" name="seo_group[]" value="" />
                    <ul class="groups seo_groups_list">
						<?php unset($seo_groups[0]); ?>
						<?php if (!empty($seo_groups) AND is_array($seo_groups)): ?>
							<?php foreach ($seo_groups as $group_id => $seo_group) : ?>
								<?php if ($group_id): ?>
									<li>
										<a id-data="<?php echo $group_id; ?>" class="delegate_click" href="#"><?php echo $seo_group['name']; ?></a>
										<a href="#" title="<?php _e('Delete', TMM_THEME_FOLDER_NAME); ?>" class="remove remove_seo_group" seo-group-id="<?php echo $group_id ?>"></a>
										<a id-data="<?php echo $group_id; ?>" href="#" title="<?php _e('Edit', TMM_THEME_FOLDER_NAME); ?>" class="edit delegate_click"></a>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<li class="js_no_one_item_else"><span><?php _e('You have not created any group yet. Please create one using the form above.', TMM_THEME_FOLDER_NAME); ?></span></li>
						<?php endif; ?>

                    </ul>


                </div>





				<?php echo Thememakers_Entity_SEO_Group::draw_seo_groups_panel(); ?>



				<div class="tab-content" id="events">
					<h1><?php _e('Events', TMM_THEME_FOLDER_NAME); ?></h1>

					<?php $events_hide_time_zone = get_option(TMM_THEME_PREFIX . "events_hide_time_zone"); ?>
                    <input type="checkbox" value="true" name="events_hide_time_zone" class="option_checkbox" <?php echo($events_hide_time_zone ? "checked" : "") ?> />
                    <input type="hidden" value="<?php echo($events_hide_time_zone ? "1" : "0") ?>" name="events_hide_time_zone">
                    &nbsp;<strong><?php _e('Hide time zone', TMM_THEME_FOLDER_NAME); ?></strong><br />
					<br />


					<?php $events_time_format = get_option(TMM_THEME_PREFIX . "events_time_format"); ?>
                    <input type="checkbox" value="true" name="events_time_format" class="option_checkbox" <?php echo($events_time_format ? "checked" : "") ?> />
                    <input type="hidden" value="<?php echo($events_time_format ? "1" : "0") ?>" name="events_time_format">
                    &nbsp;<strong><?php _e('Show events with am/pm time format', TMM_THEME_FOLDER_NAME); ?></strong><br />
					<br />


					<?php $events_listing_show_categories = get_option(TMM_THEME_PREFIX . "events_listing_show_categories"); ?>
                    <input type="checkbox" value="true" name="events_listing_show_categories" class="option_checkbox" <?php echo($events_listing_show_categories ? "checked" : "") ?> />
                    <input type="hidden" value="<?php echo($events_listing_show_categories ? "1" : "0") ?>" name="events_listing_show_categories">
                    &nbsp;<strong><?php _e('Show selector of categories on events listing page', TMM_THEME_FOLDER_NAME); ?></strong><br />
					<br />



				</div>

                <div class="tab-content" id="tab11">

                    <h1><?php _e('Footer', TMM_THEME_FOLDER_NAME); ?></h1>

                    <h4><?php _e('Footer text', TMM_THEME_FOLDER_NAME); ?></h4>

                    <div class="options_footer">
						<?php
						$copyright_text = get_option(TMM_THEME_PREFIX . "copyright_text");
						?>
                        <textarea name="copyright_text" class="fullwidth"><?php echo $copyright_text ?></textarea>
                    </div>


                </div>

                <div class="admin-group-button clearfix">
                    <a class="admin-button button-yellow button-medium align-btn-left button_reset_options" href="#"><?php _e('Reset All Options', TMM_THEME_FOLDER_NAME); ?></a>
                    <a class="admin-button button-yellow button-medium align-btn-right button_save_options" href="#"><?php _e('Save All Changes', TMM_THEME_FOLDER_NAME); ?></a>
                </div>

            </section><!--/ #admin-content-->

        </section><!--/ .admin-container-->



    </div><!--/ #tm-->


</form>


<!------------------------ html templates for js ------------------------------------------->

<div style="display: none;">
    <a href="#google_font_set" id="google_font_set_link">fancy</a>
    <div id="google_font_set" style="width: 800px; height: 600px;">
        <a class="admin-button button-small button-yellow button_save_google_fonts" href="#"><?php _e('save', TMM_THEME_FOLDER_NAME); ?></a>
        <ul id="google_font_set_list"></ul><br />
        <a class="admin-button button-small button-yellow button_save_google_fonts" href="#"><?php _e('save', TMM_THEME_FOLDER_NAME); ?></a>
    </div>


    <a href="#fancy_loader" id="fancy_loader_link">fancy loader</a>
    <div id="fancy_loader">
        <img src="<?php echo TMM_THEME_URI . "/images/preloader.gif" ?>" alt="loader" />
    </div>


    <div id="ui_slider_item">

        <div class="clearfix" id="__UI_SLIDER_NAME__">
            <div class="slider-range __UI_SLIDER_NAME__"></div>
            <input type="text" class="range-amount-value" value="__UI_SLIDER_VALUE__" />
            <input type="hidden" value="__UI_SLIDER_VALUE__" name="__UI_SLIDER_NAME__" class="range-amount-value-hidden" />
        </div>

    </div>

</div>




<?php Thememakers_Entity_Contact_Form::draw_forms_templates(); ?>

<div class="clear"></div>


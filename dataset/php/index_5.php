<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php include_once 'header.php'; ?>
<?php
wp_enqueue_style("thememakers_theme_jquery_ui_css", TMM_THEME_URI . '/admin/css/jquery-ui.css');
wp_enqueue_style("thememakers_theme_uniform_css", TMM_THEME_URI . '/admin/css/uniform.default.css');
wp_enqueue_style("thememakers_theme_admin_css", TMM_THEME_URI . '/admin/css/options_styles.css');

//***
wp_enqueue_script('thememakers_theme_options_js', TMM_THEME_URI . '/admin/js/options.js');
wp_enqueue_script('thememakers_theme_uniform-ui_js', TMM_THEME_URI . '/admin/js/jquery-ui-1.8.21.custom.min.js');
wp_enqueue_script('thememakers_theme_uniform_js', TMM_THEME_URI . '/admin/js/jquery.uniform.min.js');
wp_enqueue_script('thememakers_theme_uniform_js', TMM_THEME_URI . '/admin/js/selectivizr-and-extra-selectors.min.js');
wp_enqueue_script('thememakers_app_mail_subscriber_js', Application_Mail_Subscriber::get_application_path() . '/js/general.js');
?>


<div id="top"></div>
<form id="theme_options" name="mail_subscriber_form" method="post" style="display: none;">
    <div id="tm">

        <section class="admin-container clearfix">

            <header id="title-bar" class="clearfix">

                <a href="#" class="admin-logo"></a>
                <span class="fw-version">Mail subscriber v.1.0.2</span>

                <div class="clear"></div>

            </header><!--/ #title-bar-->

            <section class="set-holder clearfix">

                <ul class="support-links">
                    <li><a class="support-docs" href="http://blessing.webtemplatemasters.com/subscriber-help" target="_blank"><?php _e('Mail Subscriber\'s Docs', TMM_THEME_FOLDER_NAME); ?></a></li>
                    <li><a class="support-forum" href="<?php echo THEMEMAKERS_THEME_FORUM_LINK ?>" target="_blank"><?php _e('Visit Forum', TMM_THEME_FOLDER_NAME); ?></a></li>
                </ul><!--/ .support-links-->

                <div class="button-options">
                    <a href="#" class="admin-button button-small button-yellow button_save_mail_subscriber_options"><?php _e('Save All Changes', TMM_THEME_FOLDER_NAME); ?></a>
                </div><!--/ .button-options-->

            </section><!--/ .set-holder-->

            <aside id="admin-aside">

                <ul class="admin-nav">
                    <li><a class="shortcut-contact" href="#tab0"><?php _e("Mail Composer", TMM_THEME_FOLDER_NAME) ?></a></li>
                    <li><a class="shortcut-options" href="#tab1"><?php _e("Settings", TMM_THEME_FOLDER_NAME) ?></a></li>
                    <li><a class="shortcut-slider" href="#tab2"><?php _e("Subscription Groups", TMM_THEME_FOLDER_NAME) ?></a></li>
                    <li><a class="shortcut-blog" href="#tab3"><?php _e("History", TMM_THEME_FOLDER_NAME) ?></a></li>
                </ul><!--/ .admin-nav-->

            </aside><!--/ #admin-aside-->

            <section id="admin-content" class="clearfix">

                <div class="tab-content" id="tab0">


                    <h1><?php _e("Mail Composer", TMM_THEME_FOLDER_NAME) ?></h1>                    
                    <div id="process_bar" style="display: none;">
                        <span></span>
                        <div id="process_progress"><strong></strong></div>
                    </div>

                    <div class="clearfix">

                        <p>
							<?php
							$template_names = array(
								'_default' => 'One column',
								'blue_left-sidebar-4-source' => 'Two column',
								'christmas_mail' => 'Christmas Mail',
							);
							?>
							<?php $themes = Application_Mail_Subscriber::get_themes(); ?>
                            <label class="out"><?php _e("Email Layouts", TMM_THEME_FOLDER_NAME) ?>:</label>
                            <select class="email_layouts">
								<?php if (!empty($themes)): ?>
									<?php foreach ($themes as $value) : ?>
										<option value="<?php echo $value ?>"><?php echo(isset($template_names[$value]) ? $template_names[$value] : $value) ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
                            </select><br />
							<br />
							<label class="out"><?php _e("Email subject", TMM_THEME_FOLDER_NAME) ?>:</label>
							<input type="text" id="subject" value="<?php echo get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'default_email_subject') ?>" />
                        </p>

                    </div><!--/ .clearfix-->

                    <hr class="sep-divider" />

                    <div class="clearfix">

                        <p>
                            <label class="out"><?php _e("Email groups", TMM_THEME_FOLDER_NAME) ?>:</label>
							<?php $gropups_subscribers_count = Application_Mail_Subscriber::get_gropups_subscribers_count(); ?>
                        <ul id="email_groups_check_list">
							<?php if (!empty($groups)) : ?>
								<?php foreach ($groups as $key => $group) : ?>
		                            <li><input type="checkbox" class="option_checkbox"><input class="email_groups_values" name="<?php echo $group ?>" type="hidden" value="0">&nbsp;<?php echo $group ?> (<?php echo @$gropups_subscribers_count[$group] ?>)</li>
								<?php endforeach; ?>
							<?php endif; ?>
                        </ul>
                        </p>

                    </div><!--/ .clearfix-->

                    <hr class="sep-divider" />
					<?php if (isset($_GET['archive'])): ?>

						<h2 class="archive_title"><?php _e("Archive", TMM_THEME_FOLDER_NAME) ?>: <?php echo date("d-m-Y H:i:s", $_GET['archive']) ?></h2>

					<?php endif; ?>

					<?php
					$current_theme = "_default";
					$frame_uri = Application_Mail_Subscriber::get_application_uri() . "/templates/" . $current_theme . "/layout.php";
					if (isset($_GET['archive'])) {
						$frame_uri = Application_Mail_Subscriber::get_application_uri() . "/history.php?archive=" . $_GET['archive'];
					}
					?>

					<ul style="display: none;" id="sent_letters_errors">
						<li><h2><?php _e("ERRORS", TMM_THEME_FOLDER_NAME) ?></h2></li>
					</ul>

                    <iframe src="<?php echo $frame_uri ?>" width="100%" height="800" frameborder="1" id="letter_content_frame"> </iframe>
                    <br />
                    <br />

                    <a href="#" class="admin-button button-medium button-gray align-btn-right js_send_letter"><?php _e("Send letter", TMM_THEME_FOLDER_NAME) ?></a>

                </div>

                <div class="tab-content" id="tab1">

                    <h1><?php _e("Settings", TMM_THEME_FOLDER_NAME) ?></h1>



                    <div class="clearfix">
                        <label class="out"><?php _e("User subscribe page id", TMM_THEME_FOLDER_NAME) ?></label>
                        <div class="admin-one-half">
                            <p>
                                <input type="text" placeholder="<?php _e("Set user subscribe page id", TMM_THEME_FOLDER_NAME) ?>" name="user_subscribe_page" value="<?php echo get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'user_subscribe_page') ?>" />
                            </p>
                        </div><!--/ .admin-one-half-->
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e("Choose the page id where all users will have an ability to subscribe/unsubscribe from their subscriptions.", TMM_THEME_FOLDER_NAME) ?>
                            </p>
                        </div><!--/ .admin-one-half-->
                    </div>
                    <hr class="sep-divider" />


					<div class="clearfix">
                        <label class="out"><?php _e("Default email subject", TMM_THEME_FOLDER_NAME) ?></label>
                        <div class="admin-one-half">
                            <p>
                                <input type="text" placeholder="<?php _e("Email subscription subject", TMM_THEME_FOLDER_NAME) ?>" name="default_email_subject" value="<?php echo get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'default_email_subject') ?>" />
                            </p>
                        </div><!--/ .admin-one-half-->
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e("Default email subject", TMM_THEME_FOLDER_NAME) ?>
                            </p>
                        </div><!--/ .admin-one-half-->
                    </div>
                    <hr class="sep-divider" />



                    <div class="clearfix">
                        <label class="out"><?php _e("Letters per minute", TMM_THEME_FOLDER_NAME) ?></label>
                        <div class="admin-one-half">
                            <p>
								<?php
								$letters_per_minute = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'letters_per_minute');
								if (empty($letters_per_minute)) {
									$letters_per_minute = 50;
								}
								?>
                                <input type="text" placeholder="<?php _e("Set letters per minute", TMM_THEME_FOLDER_NAME) ?>" name="letters_per_minute" value="<?php echo $letters_per_minute ?>" />
                            </p>
                        </div><!--/ .admin-one-half-->
                        <div class="admin-one-half last">
                            <p class="admin-info">
								<?php _e("
On Web Hosting Hub servers, there is a limit to the number of emails that can be sent per hour (50 messages per domain, per hour). 
This is for the protection of servers and to help prevent spam. If your mailing list is greater than 50 email addresses, the first 
50 messages,for example, would be sent, but the remaining messages would not. You would also not be albe to send emails from any email account on that domain for one hour.
If you have a need to send more than 50 emails per hour, you can send request to hoster.                                    
", TMM_THEME_FOLDER_NAME) ?>
                            </p>
                        </div><!--/ .admin-one-half-->
                    </div>
                    <hr class="sep-divider" />





                    <div class="clearfix">

                        <label class="out"><?php _e("Set senders mail address", TMM_THEME_FOLDER_NAME) ?></label>

                        <div class="admin-one-half">

                            <p>
                                <input type="text" placeholder="<?php _e("Set senders mail address", TMM_THEME_FOLDER_NAME) ?>" name="email_sender" value="<?php echo get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'email_sender') ?>" />
                            </p>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e("Set an e-mail address from which mails would come to subscribers. (i.e. for From: field)", TMM_THEME_FOLDER_NAME) ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>

                    <hr class="sep-divider" />

                    <div class="clearfix">

                        <label class="out"><?php _e("Set mail header", TMM_THEME_FOLDER_NAME) ?></label>

                        <div class="admin-one-half">

                            <p>
                                <textarea name="mail_header"><?php echo get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'mail_header') ?></textarea>
                            </p>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e("Set default text for your subscribers which will be shown at the very top, right above your e-mail body", TMM_THEME_FOLDER_NAME) ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>

                    <hr class="sep-divider" />

                    <div class="clearfix">

                        <label class="out"><?php _e("Set mail footer", TMM_THEME_FOLDER_NAME) ?></label>

                        <div class="admin-one-half">

                            <p>
                                <textarea name="mail_footer"><?php echo get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . 'mail_footer') ?></textarea>
                            </p>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e("Set default text for your subscribers which will be shown at the very bottom, right below your e-mail body", TMM_THEME_FOLDER_NAME) ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>

                    <hr class="sep-divider" />

                    <div class="clearfix">

                        <label class="out"><?php _e('New user registration text', TMM_THEME_FOLDER_NAME); ?></label>

                        <div class="admin-one-half">

							<?php
							$user_registration_text = get_option(THEMEMAKERS_APP_MAIL_SUBSCRIBER_PREFIX . "user_registration_text");
							if (empty($user_registration_text)) {
								$user_registration_text = __('Hello __USERNAME__! Your password is: __PASSWORD__');
							}
							?>

                            <p>
                                <textarea name="user_registration_text"><?php echo $user_registration_text ?></textarea>
                            </p>

                        </div><!--/ .admin-one-half-->

                        <div class="admin-one-half last">

                            <p class="admin-info">
								<?php _e("Set default text for your subscribers after subscription", TMM_THEME_FOLDER_NAME) ?>
                            </p>

                        </div><!--/ .admin-one-half-->

                    </div>




                </div>
                <div class="tab-content" id="tab2">


                    <h1><?php _e("Subscription Groups", TMM_THEME_FOLDER_NAME) ?></h1>

                    <h2><?php _e("Create subscription group", TMM_THEME_FOLDER_NAME) ?></h2>

                    <div class="add-input clearfix">
                        <input type="text" placeholder="type title here" class="text" id="new_user_group">
                        <a href="javascript: mail_subscriber_create_new_group();void(0);" class="add-input-button"></a>
                    </div>

                    <hr class="admin-divider" />

                    <ul id="users_groups" class="groups">
						<?php if (!empty($groups)): ?>
							<?php foreach ($groups as $group) : ?>
								<li>
									<a href="#"><?php echo $group; ?></a>
									<a href="javascript:mail_subscriber_remove_user_group('<?php echo $group; ?>')" title="<?php _e("Remove", TMM_THEME_FOLDER_NAME) ?>" class="remove"></a>
								</li>
							<?php endforeach; ?>
						<?php else: ?>
							<li id="mail_subscriber_no_groups">
								<?php _e("There is no any subscription group yet, you can create one above.", TMM_THEME_FOLDER_NAME) ?>
							</li>
						<?php endif; ?>
                    </ul>




                </div>
                <div class="tab-content" id="tab3">
                    <h1><?php _e("History", TMM_THEME_FOLDER_NAME) ?></h1>

                    <ul class="groups js_history">
						<?php
						$templates = Application_Mail_Subscriber::get_archive_templates();
						$templates = array_reverse($templates);
						?>
						<?php if (!empty($templates)): ?>
							<?php foreach ($templates as $key => $name) : ?>
								<li><a href="<?php echo site_url() ?>/wp-admin/admin.php?page=thememakers_path_mail_subscriber&archive=<?php echo $name; ?>"><?php echo date("d-m-Y H:i:s", $name); ?></a></li>
							<?php endforeach; ?>
						<?php endif; ?>
                    </ul>
                </div>


            </section><!--/ #admin-content-->

        </section><!--/ .admin-container-->



    </div><!--/ #tm-->


</form>
<a href="#top" id="move_to_top"></a>
<div class="info_popup" style="display: none;"></div>

<div style="display: none">

    <div id="new_user_group_template">
        <li>
            <a href="#">__GROUP_NAME__</a>
            <a href="javascript:mail_subscriber_remove_user_group('__GROUP_NAME__')" title="<?php _e("Remove", TMM_THEME_FOLDER_NAME) ?>" class="remove"></a>
        </li>

    </div>

</div>

<div class="clear"></div>




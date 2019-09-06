<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<!DOCTYPE html>
<!--[if IE 7]>					<html class="ie7 no-js" <?php language_attributes(); ?>>     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" <?php language_attributes(); ?>>     <![endif]-->
<!--[if IE 9]>					<html class="ie9 no-js" <?php language_attributes(); ?>>     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" <?php language_attributes(); ?>>  <!--<![endif]-->
    <head>

		<?php echo ThemeMakersHelperFonts::get_google_fonts_link() ?>

		<?php if (!isset($content_width)) $content_width = 960; ?>
		<?php include_once TMM_THEME_PATH . '/header_seocode.php'; ?>
		<?php global $post; ?>

        <script type="text/javascript" src="http://www.google.com/jsapi"></script>

		<?php
		//wp_deregister_script('jquery');
		//wp_register_script('jquery', TMM_THEME_URI . '/js/jquery172.js', array(), '1.7.2');
		wp_print_scripts('jquery');
		?>

        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php
		$feedburner = get_option(TMM_THEME_PREFIX . 'feedburner');
		if ($feedburner) {
			echo $feedburner;
		} else {
			bloginfo('rss2_url');
		}
		?>" />

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<link rel='stylesheet' href='<?php echo bloginfo('stylesheet_url') ?>' type='text/css' media='all' />
        <link rel='stylesheet' href='<?php echo TMM_THEME_URI; ?>/css/custom1.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?php echo TMM_THEME_URI; ?>/css/custom2.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?php echo TMM_THEME_URI; ?>/css/skeleton.css' type='text/css' media='all' />

        <!--[if lt IE 9]>
			<script src="<?php echo TMM_THEME_URI; ?>/js/ie8.js"></script>
			<script src="<?php echo TMM_THEME_URI; ?>/js/selectivizr-and-extra-selectors.min.js"></script>
        <![endif]-->

        <style type="text/css" media="print">#wpadminbar { display:none; }</style>

		<?php
		$switcher_pie = get_option(TMM_THEME_PREFIX . 'switcher_pie');
		if ($switcher_pie) {
			include_once TMM_THEME_PATH . '/ie8.php';
		}
		?>

        <script type="text/javascript">

			var template_directory = "<?php echo TMM_THEME_URI; ?>/";
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			//translations
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
		<!-- HTML5 Shiv + detect touch events (PLACE IN HEADER ONLY) -->
		<script type="text/javascript" src="<?php echo TMM_THEME_URI; ?>/js/modernizr.custom.js"></script>
		<?php wp_head(); ?>
    </head>

	<?php echo get_option(TMM_THEME_PREFIX . 'tracking_code'); ?>

	<?php
	$color_scheme = get_option(TMM_THEME_PREFIX . "color_scheme");
	if (empty($color_scheme)) {
		$color_scheme = 'color-1';
	}
	?>


	<?php
	$page_id = 0;
	if (is_single() OR is_page() OR is_front_page()) {
		global $post;
		$page_id = $post->ID;
	}
	?>
    <body <?php body_class($color_scheme); ?> style="<?php echo ThemeMakersHelper::get_page_backround($page_id) ?>">

        <!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->

        <header id="header">

            <div class="container clearfix">

                <div class="eight columns">

                    <!-- - - - - - - - - - - - Logo - - - - - - - - - - - - - -->

                    <div id="logo">

						<?php
						$logo_font = get_option(TMM_THEME_PREFIX . "logo_font");
						$logo_type = get_option(TMM_THEME_PREFIX . 'logo_type');
						$logo_text = get_option(TMM_THEME_PREFIX . 'logo_text');
						$logo_img = get_option(TMM_THEME_PREFIX . 'logo_img');
						$logo_text_color = get_option(TMM_THEME_PREFIX . 'logo_text_color');

						if (!$logo_type AND $logo_text) {
							?>
							<a title="<?php bloginfo('description'); ?>" href="<?php echo home_url(); ?>"><h1 style="<?php if (!empty($logo_font)) : ?>font-family: '<?php echo $logo_font; ?>';<?php endif; ?> color: <?php echo $logo_text_color; ?>"><?php echo $logo_text; ?></h1></a>
						<?php } else if ($logo_type AND $logo_img) { ?>
							<a title="<?php bloginfo('description'); ?>" href="<?php echo home_url(); ?>"><img src="<?php echo $logo_img; ?>" alt="<?php bloginfo('description'); ?>" /></a>
						<?php } else { ?>
							<a title="<?php bloginfo('description'); ?>" href="<?php echo home_url(); ?>"><h1 style="<?php if (!empty($logo_font)) : ?>font-family: '<?php echo $logo_font; ?>'; <?php endif; ?> color: <?php echo $logo_text_color; ?>"><?php bloginfo('name'); ?></h1></a>
						<?php } ?>

                    </div><!--/ #logo-->

                    <!-- - - - - - - - - - - end Logo - - - - - - - - - - - - -->

                </div><!--/ .eight.columns-->

                <div class="eight columns">

                    <!-- - - - - - - - - - - - Social Icons - - - - - - - - - - - - - -->

                    <div class="header-container clearfix">
						<?php if (function_exists('dynamic_sidebar') AND dynamic_sidebar('Header Sidebar')):else: ?><?php endif; ?>
                    </div><!--/ .header-container-->

                    <!-- - - - - - - - - - - end Social Icons - - - - - - - - - - - - -->

                </div><!--/ .eight.columns-->

                <div class="clear"></div>

                <!-- - - - - - - - - - - - - Navigation - - - - - - - - - - - - - - -->

                <nav id="navigation" class="navigation">

					<?php wp_nav_menu(array('theme_location' => 'primary', 'container_class' => 'clearfix')); ?>

					<div class="clear"></div>

                </nav><!--/ #navigation-->

                <!-- - - - - - - - - - - - end Navigation - - - - - - - - - - - - - -->

            </div><!--/ .container-->

        </header><!--/ #header-->

        <!-- - - - - - - - - - - - - - end Header - - - - - - - - - - - - - - - - -->


        <!-- - - - - - - - - - - - - Slider - - - - - - - - - - - - - - - -->

		<?php get_template_part('slider'); ?>

        <!-- - - - - - - - - - - - - end Slider - - - - - - - - - - - - - - -->


        <!-- - - - - - - - - - - - - - Main - - - - - - - - - - - - - - - - -->

		<?php
		$sidebar_position = "sbr";

		$_REQUEST['sidebar_position'] = $sidebar_position;

		if (is_single() AND $post->post_type == 'folio') {
			$_REQUEST['sidebar_position'] = 'no_sidebar';
			$sidebar_position = 'no_sidebar';
		} else {

			$page_sidebar_position = "default";

			if (!is_404()) {
				if (is_single() OR is_page()) {
					$page_sidebar_position = get_post_meta(get_the_ID(), 'page_sidebar_position', TRUE);
				}

				if (!empty($page_sidebar_position) AND $page_sidebar_position != 'default') {
					$sidebar_position = $page_sidebar_position;
				} else {
					$sidebar_position = get_option(TMM_THEME_PREFIX . "sidebar_position");
				}

				if (!$sidebar_position) {
					$sidebar_position = "sbr";
				}

				//*****
			} else {
				$sidebar_position = 'no_sidebar';
			}
		}

		//*****
		/*
		  if (is_front_page() AND !isset($_REQUEST['index_sidebar_position'])) {
		  $sidebar_position = 'no_sidebar';
		  }
		 */

		$_REQUEST['sidebar_position'] = $sidebar_position;
		?>

		<?php
		$hide_breadcrumb = get_option(TMM_THEME_PREFIX . "hide_breadcrumb");
		$page_have_slider = FALSE;
		if (is_object($post) AND (is_single() OR is_page() OR is_front_page()) AND !is_home()) {
			$page_settings = Thememakers_Entity_Page_Constructor::get_page_settings($post->ID);
			if ($page_settings['page_slider_type'] == 'revolution') {
				if ($page_settings['revolution_slide_group']) {
					$page_have_slider = TRUE;
				}
			}

			if ($page_settings['page_slider_type'] != 'revolution') {
				if ($page_settings['page_slider']) {
					$page_have_slider = TRUE;
				}
			}
		}
		?>

		<?php if (!is_front_page() AND is_object($post) AND !$page_have_slider or is_404()): ?>

			<?php if (is_404()): ?>

				<section class="page-header" style="<?php echo ThemeMakersHelper::draw_page_header_bg() ?>">

					<div class="container">
						<h1>404 <?php _e("Error", TMM_THEME_FOLDER_NAME) ?></h1>
					</div><!--/ .container-->

				</section><!--/ .page-header-->

			<?php else: ?>


				<?php if (!isset($_GET['s'])): ?>
					<section class="page-header" style="<?php echo ThemeMakersHelper::draw_page_header_bg() ?>">

						<div class="container">

							<?php $queried_object = get_queried_object(); ?>

							<?php if (is_single() OR is_page()): ?>

								<h1><?php echo $post->post_title ?></h1>

							<?php else: ?>

								<?php if (is_post_type_archive('post')): ?>
									<h1 class="page-title">
										<?php if (is_day()) : ?>
											<?php printf(__('Daily Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date() . '</span>'); ?>
										<?php elseif (is_month()) : ?>
											<?php printf(__('Monthly Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', TMM_THEME_FOLDER_NAME)) . '</span>'); ?>
										<?php elseif (is_year()) : ?>
											<?php printf(__('Yearly Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date(_x('Y', 'yearly archives date format', TMM_THEME_FOLDER_NAME)) . '</span>'); ?>
										<?php else : ?>
											<?php _e('Blog Archives', TMM_THEME_FOLDER_NAME); ?>
										<?php endif; ?>
									</h1>
								<?php elseif (is_post_type_archive('folio')) : ?>

									<?php
									$sidebar_position = 'no_sidebar';
									$_REQUEST['sidebar_position'] = $sidebar_position;
									?>

									<h1 class="page-title">
										<?php if (is_day()) : ?>
											<?php printf(__('Daily Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date() . '</span>'); ?>
										<?php elseif (is_month()) : ?>
											<?php printf(__('Monthly Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', TMM_THEME_FOLDER_NAME)) . '</span>'); ?>
										<?php elseif (is_year()) : ?>
											<?php printf(__('Yearly Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date(_x('Y', 'yearly archives date format', TMM_THEME_FOLDER_NAME)) . '</span>'); ?>
										<?php else : ?>
											<?php _e('Folio Archives', TMM_THEME_FOLDER_NAME); ?>
										<?php endif; ?>
									</h1>


								<?php elseif (is_post_type_archive('event') OR @$queried_object->taxonomy == 'events') : ?>

									<h1 class="page-title events_archive_title"><?php _e('Events', TMM_THEME_FOLDER_NAME); ?></h1>



								<?php elseif (is_category()) : ?>

									<h1 class="page-title events_archive_title"><?php printf(__('Category: %s', TMM_THEME_FOLDER_NAME), '<span>' . single_cat_title('', false) . '</span>'); ?></h1>

								<?php else: ?>

									<?php if (@$queried_object->taxonomy == 'skills'): ?>
										<h1 class="page-title events_archive_title"><?php _e('Skills', TMM_THEME_FOLDER_NAME); ?></h1>

									<?php elseif (@$queried_object->taxonomy == 'clients') : ?>

										<h1 class="page-title events_archive_title"><?php _e('Clients', TMM_THEME_FOLDER_NAME); ?></h1>

									<?php else: ?>

										<?php if (is_archive()): ?>
											<h1 class="page-title">
												<?php if (is_day()) : ?>
													<?php printf(__('Daily Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date() . '</span>'); ?>
												<?php elseif (is_month()) : ?>
													<?php printf(__('Monthly Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', TMM_THEME_FOLDER_NAME)) . '</span>'); ?>
												<?php elseif (is_year()) : ?>
													<?php printf(__('Yearly Archives: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_the_date(_x('Y', 'yearly archives date format', TMM_THEME_FOLDER_NAME)) . '</span>'); ?>
												<?php else : ?>
													<?php _e('Blog Archives', TMM_THEME_FOLDER_NAME); ?>
												<?php endif; ?>
											</h1>
										<?php endif; ?>

									<?php endif; ?>

								<?php endif; ?>



							<?php endif; ?>

						</div><!--/ .container-->

					</section><!--/ .page-header-->
				<?php endif; ?>



			<?php endif; ?>

		<?php endif; ?>



		<?php if ((is_front_page() OR is_home()) AND !$page_have_slider OR isset($_GET['s'])): ?>

			<section class="page-header">
				<div class="container">
					<?php if (is_object($post) AND !is_home()): ?>
						<h1><?php echo $post->post_title ?></h1>
					<?php else: ?>
						<?php if (isset($_GET['s'])): ?>
							<h1><?php printf(__('Search Results for: %s', TMM_THEME_FOLDER_NAME), '<span>' . get_search_query() . '</span>'); ?></h1>
						<?php else: ?>
							<h1><?php bloginfo('description'); ?></h1>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</section>

		<?php endif; ?>



        <section class="main container <?php echo (is_front_page()) ? "front " : " " ?><?php echo $sidebar_position ?> clearfix">

            <!-- - - - - - - - - - - - Breadcrumbs  - - - - - - - - - - - - - - -->

			<?php if (!$hide_breadcrumb AND !is_front_page() AND !$page_have_slider): ?>

				<div class="breadcrumbs">

					<?php ThemeMakersHelper::draw_breadcrumbs() ?>

				</div><!--/ .breadcrumbs-->

			<?php endif; ?>

            <!-- - - - - - - - - - - end Breadcrumbs - - - - - - - - - - - - - -->


            <section id="<?php echo($sidebar_position != 'no_sidebar' ? "content" : "") ?>" class="<?php echo ($sidebar_position != 'no_sidebar' ? "ten columns" : "container") ?>">

				<?php
				$_REQUEST['excerpt_symbols_count'] = get_option(TMM_THEME_PREFIX . "excerpt_symbols_count");
				if (!$_REQUEST['excerpt_symbols_count']) {
					$_REQUEST['excerpt_symbols_count'] = 140;
				}

				$_REQUEST['show_full_content'] = get_option(TMM_THEME_PREFIX . 'show_full_content');
				$_REQUEST['disable_author'] = get_option(TMM_THEME_PREFIX . 'disable_author');
				//$_REQUEST['show_author_info'] = get_option(TMM_THEME_PREFIX . 'show_author_info');
				$_REQUEST['disable_blog_comments'] = get_option(TMM_THEME_PREFIX . 'disable_blog_comments');
				$_REQUEST['disable_categories'] = get_option(TMM_THEME_PREFIX . "disable_categories");
				$_REQUEST['disable_tags'] = get_option(TMM_THEME_PREFIX . "disable_tags");
				?>


                <script type="text/javascript">

					var template_sidebar_position = "<?php echo $_REQUEST['sidebar_position'] ?>";

                </script>
				
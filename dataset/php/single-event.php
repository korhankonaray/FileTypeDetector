<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


		<article id="post-<?php the_ID(); ?>" <?php post_class("entry event"); ?>>


			<?php if (has_post_thumbnail()): ?>
				<div class="bordered">
					<figure class="add-border">
						<img src="<?php echo ThemeMakersHelper::get_post_featured_image($post->ID, 574, true, 258); ?>" alt="<?php the_title(); ?>" />
					</figure>
				</div><!--/ .bordered-->
			<?php endif; ?>



			<div class="entry-meta">
				<?php
				$hide_event_place = get_post_meta($post->ID, 'hide_event_place', true);
				$event_place_address = get_post_meta($post->ID, 'event_place_address', true);
				$ev_mktime = (int) get_post_meta($post->ID, 'ev_mktime', true);
				$ev_end_mktime = get_post_meta($post->ID, 'ev_end_mktime', true);
				$ev_date = Thememakers_Application_Events::get_single_event_date($post->ID);
				?>
				<span class="date"><?php echo date("j", $ev_date) ?></span>
				<span class="month"><?php echo ThemeMakersHelper::get_short_monts_names((int) date("n", $ev_date) - 1) ?> <?php echo date("Y", $ev_date) ?></span>

			</div><!--/ .entry-meta-->

			<div class="entry-body">

				<div class="entry-title">

					<h2 class="title"><?php the_title(); ?></h2>

					<span class="e-date">
						<?php
						$event_duration_sec = get_post_meta($post->ID, 'event_duration_sec', true);
						//*****
						$duration_hh = (int) ($event_duration_sec / 3600);
						$duration_mm = (int) (($event_duration_sec % 3600) / 60);
						?>

						<?php if (date('d', $ev_mktime) == @date('d', $ev_end_mktime)): ?>
							<b><?php echo ThemeMakersHelper::get_days_of_week(date("w", $ev_date)) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_mktime) ?> - <?php if($ev_end_mktime)echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_end_mktime) ?> <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span>, <?php _e('Duration', TMM_THEME_FOLDER_NAME); ?>: <?php echo (($duration_hh >= 10 ? $duration_hh : "0" . $duration_hh) . ":" . ($duration_mm >= 10 ? $duration_mm : "0" . $duration_mm)) ?></strong>
						<?php else: ?>
							<b><?php echo ThemeMakersHelper::get_days_of_week(date("w", $ev_date)) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_mktime) ?></strong> (<?php echo date("d/m/Y", $ev_mktime) ?>) - <strong><?php if($ev_end_mktime)echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_end_mktime) ?></strong> (<?php if($ev_end_mktime)echo date("d/m/Y", $ev_end_mktime) ?>) <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span>, <strong><?php _e('Duration', TMM_THEME_FOLDER_NAME); ?>: <?php echo (($duration_hh >= 10 ? $duration_hh : "0" . $duration_hh) . ":" . ($duration_mm >= 10 ? $duration_mm : "0" . $duration_mm)) ?></strong>
						<?php endif; ?>

					</span>

					<?php $repeats_every = get_post_meta($post->ID, 'event_repeating', true); ?>
					<?php if ($repeats_every != "no_repeat"): ?>
						<span class="e-date">
							<b><?php _e('Repeats every', TMM_THEME_FOLDER_NAME); ?>:</b> <strong><?php echo Thememakers_Application_Events::$event_repeatings[$repeats_every] ?></strong><br />
						</span>
					<?php endif; ?>

					<?php if (!empty($event_place_address)): ?>
						<span class="place"><b><?php _e('Place', TMM_THEME_FOLDER_NAME); ?>: </b><?php echo $event_place_address ?></span><br />
					<?php endif; ?>

					<span class="place"><b><?php _e('Categories', TMM_THEME_FOLDER_NAME); ?>: </b><?php echo get_the_term_list($post->ID, 'events', '', ', ', ''); ?></span>
				</div><!--/ .entry-title-->

			</div><!--/ .entry-body -->

			<?php if (!$hide_event_place): ?>
				<div class="map">
					<?php
					$event_map_longitude = get_post_meta($post->ID, 'event_map_longitude', true);
					$event_map_latitude = get_post_meta($post->ID, 'event_map_latitude', true);
					$event_map_zoom = get_post_meta($post->ID, 'event_map_zoom', true);
					echo do_shortcode('[google_map width="550" height="230" latitude="' . $event_map_latitude . '" longitude="' . $event_map_longitude . '" zoom="' . $event_map_zoom . '" controls="" enable_scrollwheel="0" map_type="ROADMAP" enable_marker="1" enable_popup="0"][/google_map]');
					?>
				</div>
			<?php endif; ?>
			<br />
			<div class="nine columns offset-by-one alpha omega" style="padding-left: 0;">

				<?php the_content(); ?>

			</div><!--/ .nine-columns-->

		</article><!--/ .entry-->

		<div class="border-divider"></div>

		<?php
	endwhile;
endif;
?>

<?php //wp_reset_query();  ?>
<?php if (!$_REQUEST['disable_blog_comments']) : ?>
	<?php comments_template(); ?>
<?php endif; ?>


<?php get_footer(); ?>
<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class("entry event"); ?>>

			<?php if (has_post_thumbnail()): ?>
				<div class="bordered">
					<figure class="add-border">
						<img src="<?php echo ThemeMakersHelper::get_post_featured_image($post->ID, 574, true, 258); ?>" alt="<?php the_title(); ?>" />
					</figure>
				</div><!--/ .bordered-->
			<?php endif; ?>



			<div class="entry-meta">
				<?php
				$ev_mktime = Thememakers_Application_Events::get_single_event_date($post->ID);
				$ev_end_mktime = get_post_meta($post->ID, 'ev_end_mktime', true);
				?>
				<span class="date"><?php echo date("j", $ev_mktime) ?></span>
				<span class="month"><?php echo ThemeMakersHelper::get_short_monts_names((int) date("n", $ev_mktime) - 1) ?> <?php echo date("Y", $ev_mktime) ?></span>

			</div><!--/ .entry-meta-->

			<div class="entry-body">

				<div class="entry-title">

					<h2 class="title"><?php the_title(); ?></h2>

					<span class="e-date">
						<?php
						$hide_event_place = get_post_meta($post->ID, 'hide_event_place', true);
						$event_place_address = get_post_meta($post->ID, 'event_place_address', true);

						$ev_date = Thememakers_Application_Events::get_single_event_date($post->ID);
						$event_duration_sec = get_post_meta($post->ID, 'event_duration_sec', true);
						//*****
						$duration_hh = (int) ($event_duration_sec / 3600);
						$duration_mm = (int) (($event_duration_sec % 3600) / 60);
						?>

						<?php if (date('d', $ev_mktime) == @date('d', $ev_end_mktime)): ?>
						<b><?php echo ThemeMakersHelper::get_days_of_week(date("w", $ev_date)) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("H:i", $ev_mktime) ?> - <?php if($ev_end_mktime)echo date("H:i", $ev_end_mktime) ?> <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span>, <?php _e('Duration', TMM_THEME_FOLDER_NAME); ?>: <?php echo (($duration_hh >= 10 ? $duration_hh : "0" . $duration_hh) . ":" . ($duration_mm >= 10 ? $duration_mm : "0" . $duration_mm)) ?></b>
						<?php else: ?>
							<b><?php echo ThemeMakersHelper::get_days_of_week(date("w", $ev_date)) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo date("H:i", $ev_mktime) ?></strong> (<?php echo date("d/m/Y", $ev_mktime) ?>) - <strong><?php if($ev_end_mktime)echo date("H:i", $ev_end_mktime) ?></strong> (<?php if($ev_end_mktime)echo date("d/m/Y", $ev_end_mktime) ?>) <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span>, <strong><?php _e('Duration', TMM_THEME_FOLDER_NAME); ?>: <?php echo (($duration_hh >= 10 ? $duration_hh : "0" . $duration_hh) . ":" . ($duration_mm >= 10 ? $duration_mm : "0" . $duration_mm)) ?></strong>
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

			<?php if (!$hide_event_place) : ?>
				<div class="map">
					<?php
					$event_map_longitude = get_post_meta($post->ID, 'event_map_longitude', true);
					$event_map_latitude = get_post_meta($post->ID, 'event_map_latitude', true);
					$event_map_zoom = get_post_meta($post->ID, 'event_map_zoom', true);
					echo '<img src="http://maps.googleapis.com/maps/api/staticmap?center=' . $event_map_latitude . ',' . $event_map_longitude . '&zoom=' . $event_map_zoom . '&size=550x250&markers=color:red|label:P|' . $event_map_latitude . ',' . $event_map_longitude . '&sensor=false">';
					?>
				</div>
			<?php endif; ?>

			<div class="nine columns offset-by-one alpha omega" style="padding-left: 0;">

				<?php the_excerpt() ?>


				<div class="clearfix"></div>
				<br />
				<a href="<?php the_permalink(); ?>" class="button default small"><?php _e('Event details', TMM_THEME_FOLDER_NAME); ?></a>

			</div><!--/ .nine-columns-->

		</article><!--/ .entry-->


		<?php
	endwhile;
endif;
?>	
<?php get_template_part('content', 'pagenavi'); ?>
<?php get_footer(); ?>

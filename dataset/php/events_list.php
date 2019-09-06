<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php if (!empty($events)): ?>
	<?php foreach ($events as $event) : ?>

		<article class="entry event">

			<?php
			$hide_event_place = get_post_meta($event['post_id'], 'hide_event_place', true);
			$event_place_address = get_post_meta($event['post_id'], 'event_place_address', true);
			?>

			<?php if (!$hide_event_place) : ?>
				<div class="gmaps">
					<div class="bordered">
						<figure class="add-border">
							<?php
							$event_map_longitude = get_post_meta($event['post_id'], 'event_map_longitude', true);
							$event_map_latitude = get_post_meta($event['post_id'], 'event_map_latitude', true);
							$event_map_zoom = get_post_meta($event['post_id'], 'event_map_zoom', true);
							echo '<img src="http://maps.googleapis.com/maps/api/staticmap?center=' . $event_map_latitude . ',' . $event_map_longitude . '&zoom=' . $event_map_zoom . '&size=570x250&markers=color:red|label:P|' . $event_map_latitude . ',' . $event_map_longitude . '&sensor=false">';
							?>               
						</figure>
					</div><!--/ .bordered-->
				</div>
			<?php endif; ?>


			<div class="entry-meta">
				<span class="date"><?php echo date("d", $event['start_mktime']) ?></span>
				<span class="month"><?php echo ThemeMakersHelper::get_short_monts_names(date("n", $event['start_mktime']) - 1) ?></span>
			</div><!--/ .entry-meta-->

			<div class="entry-body">

				<div class="entry-title">

					<h2 class="title"><a href="<?php echo get_permalink($event['post_id']); ?>"><?php echo get_the_title($event['post_id']); ?></a></h2>

					<span class="e-date">
						<?php
						$event_duration_sec = @$event['event_duration_sec'];
						$ev_mktime = (int) get_post_meta($event['post_id'], 'ev_mktime', true);
						$ev_end_mktime = get_post_meta($event['post_id'], 'ev_end_mktime', true);
						$ev_date = Thememakers_Application_Events::get_single_event_date($event['post_id']);
						//*****
						$duration_hh = (int) ($event_duration_sec / 3600);
						$duration_mm = (int) (($event_duration_sec % 3600) / 60);
						?>

						<?php if (date('d', $ev_mktime) == @date('d', $ev_end_mktime)): ?>
							<b><?php echo ThemeMakersHelper::get_days_of_week(date("w", $ev_date)) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_mktime) ?> - <?php if($ev_end_mktime)echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_end_mktime) ?> <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span>, <?php _e('Duration', TMM_THEME_FOLDER_NAME); ?>: <?php echo (($duration_hh >= 10 ? $duration_hh : "0" . $duration_hh) . ":" . ($duration_mm >= 10 ? $duration_mm : "0" . $duration_mm)) ?></b>
						<?php else: ?>
							<b><?php echo ThemeMakersHelper::get_days_of_week(date("w", $ev_date)) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_mktime) ?></strong> (<?php echo date("d/m/Y", $ev_mktime) ?>) - <strong><?php if($ev_end_mktime)echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_end_mktime) ?></strong> (<?php if($ev_end_mktime)echo date("d/m/Y", $ev_end_mktime) ?>) <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span>, <strong><?php _e('Duration', TMM_THEME_FOLDER_NAME); ?>: <?php echo (($duration_hh >= 10 ? $duration_hh : "0" . $duration_hh) . ":" . ($duration_mm >= 10 ? $duration_mm : "0" . $duration_mm)) ?></strong>
						<?php endif; ?>


					</span>

					<?php $repeats_every = get_post_meta($event['post_id'], 'event_repeating', true); ?>
					<?php if ($repeats_every != "no_repeat"): ?>
						<span class="e-date">
							<b><?php _e('Repeats every', TMM_THEME_FOLDER_NAME); ?>:</b> <strong><?php echo Thememakers_Application_Events::$event_repeatings[$repeats_every] ?></strong><br />
						</span>
					<?php endif; ?>

					<?php if (!empty($event_place_address)): ?>
						<span class="place"><b><?php _e('Place', TMM_THEME_FOLDER_NAME); ?>: </b><?php echo $event_place_address ?></span><br />
					<?php endif; ?>

					<span class="place"><b><?php _e('Categories', TMM_THEME_FOLDER_NAME); ?>: </b><?php echo get_the_term_list($event['post_id'], 'events', '', ', ', ''); ?></span>

				</div><!--/ .entry-title-->

			</div><!--/ .entry-body -->

			<div class="" style="padding-left: 0;">

				<?php
				$post = get_post($event['post_id']);
				echo $post->post_excerpt;
				?>

				<div class="clearfix"></div>
				<br />
				<a href="<?php echo get_permalink($event['post_id']); ?>" class="button default small"><?php _e('Event details', TMM_THEME_FOLDER_NAME); ?></a>

			</div>

		</article><!--/ .entry-->


	<?php endforeach; ?>
<?php endif; ?>




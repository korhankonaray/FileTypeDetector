<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
//for calendar
$year = (int) $_GET['yy'];
$month = (int) $_GET['mm'];
$day = (int) $_GET['dd'];
$start = @mktime(0, 0, 0, $month, $day, $year);
$end = $start + 86400 - 1;


$result = Thememakers_Application_Events::get_events($start, $end);

$buffer = array();
foreach ($result as $value) {
	if ($value['start_mktime'] >= $start AND $value['start_mktime'] <= $end) {
		$buffer[] = $value;
	}
}

$result = $buffer;

if (!empty($result)) {
	$events_ids = array();
	foreach ($result as $value) {
		$events_ids[] = $value['post_id'];
	}

	query_posts(array(
		'post_type' => 'event',
		'posts_per_page' => -1,
		'post__in' => $events_ids
	));
}
?>

<script type="text/javascript">
	jQuery(function() {
		jQuery(".events_archive_title").text(jQuery(".events_archive_title").text() + " (" +<?php echo(count($result)) ?> + ")");
	});
</script>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class("entry event"); ?>>

			<?php
			$hide_event_place = get_post_meta($post->ID, 'hide_event_place', true);
			$event_place_address = get_post_meta($post->ID, 'event_place_address', true);
			?>

			<?php if (!$hide_event_place) : ?>
				<div class="bordered">
					<figure class="add-border">
						<div class="map">
							<?php
							$event_map_longitude = get_post_meta($post->ID, 'event_map_longitude', true);
							$event_map_latitude = get_post_meta($post->ID, 'event_map_latitude', true);
							$event_map_zoom = get_post_meta($post->ID, 'event_map_zoom', true);

							echo '<img alt="' . get_the_title() . '" src="http://maps.googleapis.com/maps/api/staticmap?center=' . $event_map_latitude . ',' . $event_map_longitude . '&zoom=' . $event_map_zoom . '&size=574x258&markers=color:red|label:P|' . $event_map_latitude . ',' . $event_map_longitude . '&sensor=false">';
							?>
						</div>

					</figure>
				</div><!--/ .bordered-->
			<?php endif; ?>



			<div class="entry-meta">
				<span class="date"><?php echo date("j", $start) ?></span>
				<span class="month"><?php echo ThemeMakersHelper::get_short_monts_names((int) date("n", $start) - 1) ?> <?php echo date("Y", $start) ?></span>

			</div><!--/ .entry-meta-->

			<div class="entry-body">

				<div class="entry-title">

					<h2 class="title"><?php the_title(); ?></h2>

					<span class="e-date">
						<?php
						$ev_mktime = Thememakers_Application_Events::get_single_event_date($post->ID);
						$ev_end_mktime = get_post_meta($post->ID, 'ev_end_mktime', true);
						$ev_date = Thememakers_Application_Events::get_single_event_date($post->ID);

						$event_duration_sec = get_post_meta($post->ID, 'event_duration_sec', true);
						//*****
						$duration_hh = (int) ($event_duration_sec / 3600);
						$duration_mm = (int) (($event_duration_sec % 3600) / 60);
						?>

						<?php if (date('d', $ev_mktime) == date('d', $ev_end_mktime)): ?>
							<b><?php echo ThemeMakersHelper::get_days_of_week(date("w", $ev_date)) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_mktime) ?> - <?php echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_end_mktime) ?> <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span>, <?php _e('Duration', TMM_THEME_FOLDER_NAME); ?>: <?php echo (($duration_hh >= 10 ? $duration_hh : "0" . $duration_hh) . ":" . ($duration_mm >= 10 ? $duration_mm : "0" . $duration_mm)) ?></b>
						<?php else: ?>
							<b><?php echo ThemeMakersHelper::get_days_of_week(date("w", $ev_date)) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_mktime) ?></strong> (<?php echo date("d/m/Y", $ev_mktime) ?>) - <strong><?php echo date((get_option(TMM_THEME_PREFIX . "events_time_format") == 1 ? "h:i A" : "H:i"), $ev_end_mktime) ?></strong> (<?php echo date("d/m/Y", $ev_end_mktime) ?>) <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span>, <strong><?php _e('Duration', TMM_THEME_FOLDER_NAME); ?>: <?php echo (($duration_hh >= 10 ? $duration_hh : "0" . $duration_hh) . ":" . ($duration_mm >= 10 ? $duration_mm : "0" . $duration_mm)) ?></strong>
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


			<div class="nine columns offset-by-one alpha omega" style="padding-left: 0;">

				<?php the_excerpt() ?>

				<div class="clearfix"></div>
				<br />
				<a href="<?php the_permalink(); ?>" class="button default small"><?php _e('Event details', TMM_THEME_FOLDER_NAME); ?></a>

			</div><!--/ .nine-columns-->

		</article><!--/ .entry-->


		<?php
	endwhile;
	?>
<?php else: ?>
	<h2><?php _e('NO EVENTS TODAY', TMM_THEME_FOLDER_NAME); ?></h2>
<?php
endif;
?>	






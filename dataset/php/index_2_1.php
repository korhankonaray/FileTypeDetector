<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
define('THEMEMAKERS_APP_MAIL_EVENTS_PREFIX', TMM_THEME_PREFIX . "app_events_");
//*********
add_action("init", array('Thememakers_Application_Events', 'init'));
add_action("admin_init", array('Thememakers_Application_Events', 'admin_init'));
add_action('save_post', array('Thememakers_Application_Events', 'save_post'));
add_action('admin_head', array('Thememakers_Application_Events', 'admin_head'));
add_action('wp_head', array('Thememakers_Application_Events', 'wp_head'));
//AJAX callbacks
if (!is_user_logged_in()) {
	add_action('wp_ajax_nopriv_app_events_get_calendar_data', array('Thememakers_Application_Events', 'get_calendar_data'));
	add_action('wp_ajax_nopriv_app_events_get_widget_calendar_data', array('Thememakers_Application_Events', 'get_widget_calendar_data'));
	add_action('wp_ajax_nopriv_app_events_get_events_listing', array('Thememakers_Application_Events', 'get_events_listing'));
} else {
	add_action('wp_ajax_app_events_get_calendar_data', array('Thememakers_Application_Events', 'get_calendar_data'));
	add_action('wp_ajax_app_events_get_widget_calendar_data', array('Thememakers_Application_Events', 'get_widget_calendar_data'));
	add_action('wp_ajax_app_events_get_events_listing', array('Thememakers_Application_Events', 'get_events_listing'));
}

class Thememakers_Application_Events {

	public static $event_repeatings = array();
	public static $gmt_offset = "";

	public static function init() {

		self::$gmt_offset = get_option('gmt_offset');

		self::$event_repeatings = array(
			'no_repeat' => __('No repating', TMM_THEME_FOLDER_NAME),
			'week' => __('Week', TMM_THEME_FOLDER_NAME),
			'2week' => __('2 weeks', TMM_THEME_FOLDER_NAME),
			'3week' => __('3 weeks', TMM_THEME_FOLDER_NAME),
			'month' => __('Month', TMM_THEME_FOLDER_NAME),
			'year' => __('Year', TMM_THEME_FOLDER_NAME),
		);

		$args = array(
			'labels' => array(
				'name' => __('Events', TMM_THEME_FOLDER_NAME),
				'singular_name' => __('Event', TMM_THEME_FOLDER_NAME),
				'add_new' => __('Add New', TMM_THEME_FOLDER_NAME),
				'add_new_item' => __('Add New Event', TMM_THEME_FOLDER_NAME),
				'edit_item' => __('Edit Event', TMM_THEME_FOLDER_NAME),
				'new_item' => __('New Event', TMM_THEME_FOLDER_NAME),
				'view_item' => __('View Event', TMM_THEME_FOLDER_NAME),
				'search_items' => __('Search In Events', TMM_THEME_FOLDER_NAME),
				'not_found' => __('Nothing found', TMM_THEME_FOLDER_NAME),
				'not_found_in_trash' => __('Nothing found in Trash', TMM_THEME_FOLDER_NAME),
				'parent_item_colon' => ''
			),
			'public' => true,
			'archive' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => true,
			'menu_position' => null,
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'tags', 'comments'),
			'rewrite' => array('slug' => 'event'),
			'show_in_admin_bar' => true,
			'taxonomies' => array('events') //this is IMPORTANT
		);

		register_post_type('event', $args);
		flush_rewrite_rules(false);
		//*** taxonomies ****
		register_taxonomy("events", array("event"), array(
			"hierarchical" => true,
			"labels" => array(
				'name' => __('Events categories', TMM_THEME_FOLDER_NAME),
				'singular_name' => __('Event category', TMM_THEME_FOLDER_NAME),
				'add_new' => __('Add New', TMM_THEME_FOLDER_NAME),
				'add_new_item' => __('Add New Event category', TMM_THEME_FOLDER_NAME),
				'edit_item' => __('Edit Event category', TMM_THEME_FOLDER_NAME),
				'new_item' => __('New Event category', TMM_THEME_FOLDER_NAME),
				'view_item' => __('View Event category', TMM_THEME_FOLDER_NAME),
				'search_items' => __('Search Events categories', TMM_THEME_FOLDER_NAME),
				'not_found' => __('No Events categories found', TMM_THEME_FOLDER_NAME),
				'not_found_in_trash' => __('No Events categories found in Trash', TMM_THEME_FOLDER_NAME),
				'parent_item_colon' => ''
			),
			"singular_label" => __("Events", TMM_THEME_FOLDER_NAME),
			'public' => true,
			"show_tagcloud" => true,
			'query_var' => true,
			"rewrite" => true,
			'show_in_nav_menus' => true,
			'capabilities' => array('manage_terms'),
			'show_ui' => true
		));

		add_filter("manage_event_posts_columns", array(__CLASS__, "show_edit_columns"));
		add_action("manage_event_posts_custom_column", array(__CLASS__, "show_edit_columns_content"));
		//***
		add_filter("manage_edit-event_sortable_columns", array(__CLASS__, "event_sortable_columns"));
		add_action('pre_get_posts', array(__CLASS__, "event_column_orderby"));
	}

	public static function get_application_path() {
		return THEMEMAKERS_APPLICATION_PATH . '/events';
	}

	public static function get_application_uri() {
		return THEMEMAKERS_APPLICATION_URI . '/events';
	}

	public static function admin_head() {
		wp_enqueue_style('thememakers_app_events_css', THEMEMAKERS_APPLICATION_URI . '/events/css/styles.css');
		?>
		<script type="text/javascript">
			var error_fetching_events = "<?php _e("there was an error while fetching events!", TMM_THEME_FOLDER_NAME) ?>";
			var lang_time = "<?php _e("Time", TMM_THEME_FOLDER_NAME) ?>";
			var lang_place = "<?php _e("Place", TMM_THEME_FOLDER_NAME) ?>";
		</script>
		<?php
	}

	public static function wp_head() {
		wp_enqueue_style('thememakers_app_events_css', THEMEMAKERS_APPLICATION_URI . '/events/css/styles.css');
		wp_enqueue_script('thememakers_app_events_js', THEMEMAKERS_APPLICATION_URI . '/events/js/general.js');
		?>
		<script type="text/javascript">
			var tmm_lang_no_events = "<?php _e("No events at this period!", TMM_THEME_FOLDER_NAME) ?>";
			//***
			var lang_january = "<?php _e("January", TMM_THEME_FOLDER_NAME) ?>";
			var lang_february = "<?php _e("February", TMM_THEME_FOLDER_NAME) ?>";
			var lang_march = "<?php _e("March", TMM_THEME_FOLDER_NAME) ?>";
			var lang_april = "<?php _e("April", TMM_THEME_FOLDER_NAME) ?>";
			var lang_may = "<?php _e("May", TMM_THEME_FOLDER_NAME) ?>";
			var lang_june = "<?php _e("June", TMM_THEME_FOLDER_NAME) ?>";
			var lang_july = "<?php _e("July", TMM_THEME_FOLDER_NAME) ?>";
			var lang_august = "<?php _e("August", TMM_THEME_FOLDER_NAME) ?>";
			var lang_september = "<?php _e("September", TMM_THEME_FOLDER_NAME) ?>";
			var lang_october = "<?php _e("October", TMM_THEME_FOLDER_NAME) ?>";
			var lang_november = "<?php _e("November", TMM_THEME_FOLDER_NAME) ?>";
			var lang_december = "<?php _e("December", TMM_THEME_FOLDER_NAME) ?>";
			//***
			var lang_jan = "<?php _e("Jan", TMM_THEME_FOLDER_NAME) ?>";
			var lang_feb = "<?php _e("Feb", TMM_THEME_FOLDER_NAME) ?>";
			var lang_mar = "<?php _e("Mar", TMM_THEME_FOLDER_NAME) ?>";
			var lang_apr = "<?php _e("Apr", TMM_THEME_FOLDER_NAME) ?>";
			var lang_may = "<?php _e("May", TMM_THEME_FOLDER_NAME) ?>";
			var lang_jun = "<?php _e("Jun", TMM_THEME_FOLDER_NAME) ?>";
			var lang_jul = "<?php _e("Jul", TMM_THEME_FOLDER_NAME) ?>";
			var lang_aug = "<?php _e("Aug", TMM_THEME_FOLDER_NAME) ?>";
			var lang_sep = "<?php _e("Sep", TMM_THEME_FOLDER_NAME) ?>";
			var lang_oct = "<?php _e("Oct", TMM_THEME_FOLDER_NAME) ?>";
			var lang_nov = "<?php _e("Nov", TMM_THEME_FOLDER_NAME) ?>";
			var lang_dec = "<?php _e("Dec", TMM_THEME_FOLDER_NAME) ?>";
			//***
			var lang_sunday = "<?php _e("Sunday", TMM_THEME_FOLDER_NAME) ?>";
			var lang_monday = "<?php _e("Monday", TMM_THEME_FOLDER_NAME) ?>";
			var lang_tuesday = "<?php _e("Tuesday", TMM_THEME_FOLDER_NAME) ?>";
			var lang_wednesday = "<?php _e("Wednesday", TMM_THEME_FOLDER_NAME) ?>";
			var lang_thursday = "<?php _e("Thursday", TMM_THEME_FOLDER_NAME) ?>";
			var lang_friday = "<?php _e("Friday", TMM_THEME_FOLDER_NAME) ?>";
			var lang_saturday = "<?php _e("Saturday", TMM_THEME_FOLDER_NAME) ?>";
			//***
			var lang_sun = "<?php _e("Sun", TMM_THEME_FOLDER_NAME) ?>";
			var lang_mon = "<?php _e("Mon", TMM_THEME_FOLDER_NAME) ?>";
			var lang_tue = "<?php _e("Tue", TMM_THEME_FOLDER_NAME) ?>";
			var lang_wed = "<?php _e("Wed", TMM_THEME_FOLDER_NAME) ?>";
			var lang_thu = "<?php _e("Thu", TMM_THEME_FOLDER_NAME) ?>";
			var lang_fri = "<?php _e("Fri", TMM_THEME_FOLDER_NAME) ?>";
			var lang_sat = "<?php _e("Sat", TMM_THEME_FOLDER_NAME) ?>";
		</script>
		<?php
	}

	public static function admin_init() {
		add_meta_box("credits_meta", __("Event attributes", TMM_THEME_FOLDER_NAME), array(__CLASS__, 'credits_meta'), "event", "normal", "low");
	}

	public static function save_post() {
		if (!empty($_POST)) {
			if (isset($_POST['thememakers_meta_saving'])) {
				global $post;
				$post_type = get_post_type($post->ID);
				if ($post_type == 'event') {
					update_post_meta($post->ID, "event_date", @$_POST["event_date"]);
					update_post_meta($post->ID, "event_end_date", @$_POST["event_end_date"]);
					update_post_meta($post->ID, "event_hh", @$_POST["event_hh"]);
					update_post_meta($post->ID, "event_mm", @$_POST["event_mm"]);
					update_post_meta($post->ID, "event_end_hh", @$_POST["event_end_hh"]);
					update_post_meta($post->ID, "event_end_mm", @$_POST["event_end_mm"]);
					update_post_meta($post->ID, "event_repeating", @$_POST["event_repeating"]);
					update_post_meta($post->ID, "event_repeating_week", @$_POST["event_repeating_week"]);
					//*****
					$date = explode("-", @$_POST["event_date"]);
					$date_end = explode("-", @$_POST["event_end_date"]);
					$event_mktime = strtotime($date[0] . '-' . $date[1] . '-' . $date[2] . " " . @$_POST["event_hh"] . ":" . @$_POST["event_mm"]);
					$event_end_mktime = strtotime($date_end[0] . '-' . $date_end[1] . '-' . $date_end[2] . " " . @$_POST["event_end_hh"] . ":" . @$_POST["event_end_mm"]);

					update_post_meta($post->ID, "ev_mktime", $event_mktime);
					update_post_meta($post->ID, "ev_end_mktime", $event_end_mktime);
					//*****
					update_post_meta($post->ID, "event_duration_sec", @$_POST["event_duration_sec"]);
					//*****
					update_post_meta($post->ID, "hide_event_place", @$_POST["hide_event_place"]);
					update_post_meta($post->ID, "event_place_address", @$_POST["event_place_address"]);
					update_post_meta($post->ID, "event_map_zoom", @$_POST["event_map_zoom"]);
					update_post_meta($post->ID, "event_map_latitude", @$_POST["event_map_latitude"]);
					update_post_meta($post->ID, "event_map_longitude", @$_POST["event_map_longitude"]);
				}
			}
		}
	}

	public static function credits_meta() {
		global $post;
		$data = array();
		$custom = get_post_custom($post->ID);
		$data['event_date'] = @$custom['event_date'][0];
		$data['event_end_date'] = @$custom['event_end_date'][0];
		$data['event_duration_sec'] = @$custom['event_duration_sec'][0];

		//*****
		$data['event_hh'] = @$custom['event_hh'][0];
		$data['event_mm'] = @$custom['event_mm'][0];

		$data['event_end_hh'] = @$custom['event_end_hh'][0];
		$data['event_end_mm'] = @$custom['event_end_mm'][0];
		//*****

		$data['event_repeating'] = @$custom['event_repeating'][0];
		$data['event_repeating_week'] = @$custom['event_repeating_week'][0];

		//*****

		$data['hide_event_place'] = @$custom['hide_event_place'][0];
		$data['event_place_address'] = @$custom['event_place_address'][0];
		$data['event_map_zoom'] = @$custom['event_map_zoom'][0];
		$data['event_map_latitude'] = @$custom['event_map_latitude'][0];
		$data['event_map_longitude'] = @$custom['event_map_longitude'][0];


		echo ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/credits_meta.php', $data);
	}

	public static function show_edit_columns_content($column) {
		global $post;

		switch ($column) {
			case "place":
				echo "<h3>" . get_post_meta($post->ID, 'event_place_address', true) . "</h3>";
				$lat = get_post_meta($post->ID, 'event_map_latitude', true);
				$lng = get_post_meta($post->ID, 'event_map_longitude', true);
				echo '<img src="http://maps.googleapis.com/maps/api/staticmap?center=' . $lat . ',' . $lng . '&zoom=' . get_post_meta($post->ID, 'event_map_zoom', true) . '&size=350x250&markers=color:red|label:P|' . $lat . ',' . $lng . '&sensor=false">';
				break;
			case "description":
				the_excerpt();
				break;
			case "ev_mktime":
				$ev_mktime = (int) get_post_meta($post->ID, 'ev_mktime', true);
				$ev_end_mktime = get_post_meta($post->ID, 'ev_end_mktime', true);
				?>
				<?php if (date('d', $ev_mktime) == @date('d', $ev_end_mktime)): ?>
					<strong><?php echo date("d/m/Y", $ev_mktime) ?>, <?php echo date("H:i", $ev_mktime) ?> - <?php echo date("H:i", $ev_end_mktime) ?> <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span></strong>
				<?php else: ?>
					<strong><?php echo date("d/m/Y H:i", $ev_mktime) ?> - <?php if($ev_end_mktime)echo date("d/m/Y H:i", $ev_end_mktime) ?> <span class="zones"><?php echo Thememakers_Application_Events::get_timezone_string() ?></span></strong>
				<?php endif; ?>
				<?php
				//echo date("d-m-Y H:i", self::get_single_event_date($post->ID));
				break;
			case "event_repeating":
				echo self::$event_repeatings[get_post_meta($post->ID, 'event_repeating', true)];
				break;
			case "ev_duration":
				$event_duration_sec = get_post_meta($post->ID, 'event_duration_sec', true);
				//*****
				$hh = (int) ($event_duration_sec / 3600);
				$mm = (int) (($event_duration_sec % 3600) / 60);
				echo '<i>' . (($hh >= 10 ? $hh : "0" . $hh) . ":" . ($mm >= 10 ? $mm : "0" . $mm)) . '</i>';
				break;
			case "ev_cat":
				echo get_the_term_list($post->ID, 'events', '', ', ', '');
				break;
		}
	}

	public static function show_edit_columns($columns) {
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => __("Title", TMM_THEME_FOLDER_NAME),
			"place" => __("Place", TMM_THEME_FOLDER_NAME),
			"description" => __("Description", TMM_THEME_FOLDER_NAME),
			"ev_mktime" => __("Date", TMM_THEME_FOLDER_NAME),
			"ev_duration" => __("Duration", TMM_THEME_FOLDER_NAME),
			"ev_cat" => __("Category", TMM_THEME_FOLDER_NAME),
			"event_repeating" => __("Repeating", TMM_THEME_FOLDER_NAME),
		);

		return $columns;
	}

	public static function event_sortable_columns($columns) {
		$columns['ev_mktime'] = 'ev_mktime';
		return $columns;
	}

	public static function event_column_orderby($query) {
		if (!is_admin())
			return;

		$orderby = $query->get('orderby');

		if ('ev_mktime' == $orderby) {
			$query->set('meta_key', 'ev_mktime');
			$query->set('orderby', 'ev_mktime');
		}

		return $query;
	}

	//*****


	public static function get_events($start, $end, $category = 0) {
		$start = (int) $start;
		$end = (int) $end;

		$current_year = (int) date('Y', $start + 86400 * 7 + 1);
		$current_month = (int) date('m', $start + 86400 * 7 + 1);

		//$start = @mktime(0, 0, 0, (int) date('m', $start), (int) date('d', $start), $current_year, 0);
		$data = array();

		global $wpdb;
		$result = $wpdb->get_results("
          SELECT post_id,meta_value
          FROM $wpdb->postmeta
          WHERE meta_key='ev_mktime'
          AND concat('',meta_value * 1) = meta_value
          AND meta_value>=$start
          AND meta_value<=$end
          ORDER BY meta_key ASC", ARRAY_A);


		$featured_image_width = 200;
		$featured_image_height = 130;


		$result_by_post_id = array();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$result_by_post_id[$value['post_id']] = $value['meta_value'];
			}


			$posts = get_posts(
					array(
						'include' => implode(',', array_keys($result_by_post_id)),
						'post_type' => 'event',
						'numberposts' => -1,
						'post_status' => 'publish'
			));



			if (!empty($posts)) {
				foreach ($posts as $post) {
					$event_date = $result_by_post_id[$post->ID];
					$post_meta = get_post_meta($post->ID);
					$event_duration_sec = (int) $post_meta['event_duration_sec'][0];
					$event_repeating = (int) $post_meta['event_repeating'][0];
					$event_end_date = $event_date + $event_duration_sec;

					$featured_image_src = "";
					if (has_post_thumbnail($post->ID)) {
						$featured_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
						$featured_image_src = ThemeMakersHelper::resize_image($featured_image_src[0], $featured_image_width, true, $featured_image_height);
					}





					$data[] = array(
						'id' => uniqid(),
						'post_id' => $post->ID,
						'title' => $post->post_title,
						'start' => date("Y-m-d H:i", $event_date),
						'end' => date("Y-m-d H:i", $event_end_date),
						'start_mktime' => $event_date,
						'end_mktime' => $event_end_date,
						'event_duration_sec' => $post_meta['event_duration_sec'][0],
						'event_place_address' => $post_meta['event_place_address'][0],
						'featured_image_src' => $featured_image_src,
						'post_excerpt' => $post->post_excerpt,
						'allDay' => 0,
						'url' => get_permalink($post->ID),
					);
				}
			}
		}



		//***********************************
		$result_by_post_id = array();
		$all_repeatable_events = $wpdb->get_results("
          SELECT post_id,meta_value
          FROM $wpdb->postmeta
          WHERE meta_key='event_repeating'
          AND meta_value IN('week','2week','3week','month','year')
          ORDER BY meta_value DESC", ARRAY_A);


		if (!empty($all_repeatable_events)) {

			foreach ($all_repeatable_events as $key => $value) {
				$result_by_post_id[$value['post_id']] = $value['meta_value'];
			}

			$posts = get_posts(
					array(
						'include' => implode(',', array_keys($result_by_post_id)),
						'post_type' => 'event',
						'numberposts' => -1,
						'post_status' => 'publish'
			));

			//*****
			if (!empty($posts)) {
				foreach ($posts as $post) {
					$event_repeating = $result_by_post_id[$post->ID];
					$post_meta = get_post_meta($post->ID);
					$event_date = (int) $post_meta['ev_mktime'][0];

					$insert_in_data = true;

					switch ($event_repeating) {
						case 'week':
						case '2week':
						case '3week':
							$event_year = (int) date('Y', $event_date);
							$event_month = (int) date('m', $event_date);

							if ($current_year < $event_year) {
								$insert_in_data = false;
								break;
							}

							if ($event_year == $current_year) {
								if ($current_month < $event_month) {
									//$insert_in_data = false;
									//break;
								}
							}

							$event_duration_sec = (int) $post_meta['event_duration_sec'][0];
							$event_repeating_week = unserialize($post_meta['event_repeating_week'][0]);

							//*****
							//if first date of event is more than first date of calendar
							if ($start < $event_date) {
								$start = $event_date;
							}
							//***

							$tmp_start = $start;
							$week_coefficient = 1;
							switch ($event_repeating) {
								case '2week':
									$week_coefficient = 2;
									break;
								case '3week':
									$week_coefficient = 3;
									break;

								default:
									break;
							}

							$diff = 60 * 60 * 24 * $week_coefficient - 1;
							$counter = 42 + 1;
							while ($counter) {

								if ($event_year == $current_year) {
									if ($current_month == $event_month) {
										if (date("d", $tmp_start) <= date("d", $event_date) AND date("m", $tmp_start) == date("m", $event_date)) {
											$tmp_start+=$diff;
											continue;
										}
									}
								}

								//*****

								$day_of_week = (int) date('N', $tmp_start) - 1; //in this system 0 is Monday, 6 is Saturday

								if (in_array($day_of_week, $event_repeating_week)) {

									$year = (int) date('Y', $tmp_start);
									$day = (int) date('d', $tmp_start);

									/*
									  if ($is_calendar) {
									  if ($current_month == 1) {
									  $year--;
									  $day++;
									  }
									  }
									 *
									 */



									$ev_start = @mktime((int) date('H', $event_date), (int) date('i', $event_date), 0, (int) date('m', $tmp_start), $day, $year, 0);
									$event_end_date = $ev_start + $event_duration_sec;

									//*** check: is event ended
									if ($post_meta['ev_end_mktime'][0] < $event_end_date) {
										break;
									}
									//***

									$featured_image_src = "";
									if (has_post_thumbnail($post->ID)) {
										$featured_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
										$featured_image_src = ThemeMakersHelper::resize_image($featured_image_src[0], $featured_image_width, true, $featured_image_height);
									}

									//hide in previous month
									if ($tmp_start >= $event_date) {
										$data[] = array(
											'id' => uniqid(),
											'post_id' => $post->ID,
											'title' => $post->post_title,
											'start' => date("Y-m-d H:i", $ev_start),
											'end' => date("Y-m-d H:i", $event_end_date),
											'start_mktime' => $ev_start,
											'end_mktime' => $event_end_date,
											'event_duration_sec' => $post_meta['event_duration_sec'][0],
											'event_place_address' => $post_meta['event_place_address'][0],
											'featured_image_src' => $featured_image_src,
											'post_excerpt' => $post->post_excerpt,
											'allDay' => 0,
											'url' => get_permalink($post->ID),
										);
									}
								}

								$tmp_start+=$diff;
								$counter--;
							}


							//*****
							$insert_in_data = false;
							break;
						case 'month':
							$event_year = (int) date('Y', $event_date);
							$event_month = (int) date('m', $event_date);

							if ($current_year < $event_year) {
								$insert_in_data = false;
								break;
							}

							if ($current_year <= $event_year) {
								if ($current_month < $event_month) {
									$insert_in_data = false;
									break;
								}
							}


							//when next month under view on calendar or widget
							$event_date = @mktime((int) date('H', $event_date), (int) date('i', $event_date), 0, $current_month + 1, (int) date('d', $event_date), $current_year, 0);
							$event_duration_sec = (int) $post_meta['event_duration_sec'][0];
							$event_end_date = $event_date + $event_duration_sec;
							//***
							if ($insert_in_data) {

								$featured_image_src = "";
								if (has_post_thumbnail($post->ID)) {
									$featured_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
									$featured_image_src = ThemeMakersHelper::resize_image($featured_image_src[0], $featured_image_width, true, $featured_image_height);
								}

								$data[] = array(
									'id' => uniqid(),
									'post_id' => $post->ID,
									'title' => $post->post_title,
									'start' => date("Y-m-d H:i", $event_date),
									'end' => date("Y-m-d H:i", $event_end_date),
									'start_mktime' => $event_date,
									'end_mktime' => $event_end_date,
									'event_duration_sec' => $post_meta['event_duration_sec'][0],
									'event_place_address' => $post_meta['event_place_address'][0],
									'featured_image_src' => $featured_image_src,
									'post_excerpt' => $post->post_excerpt,
									'allDay' => 0,
									'url' => get_permalink($post->ID),
								);
							}
							//+++++++++++++++++++++++++++++++++++++++++++++++++++++++


							$event_date = @mktime((int) date('H', $event_date), (int) date('i', $event_date), 0, $current_month, (int) date('d', $event_date), $current_year, 0);

							break;

						case 'year':

							$insert_in_data = true;
							$event_year = (int) date('Y', $event_date);

							if ($current_year <= $event_year) {
								$insert_in_data = false;
								break;
							}

							$event_date = @mktime((int) date('H', $event_date), (int) date('i', $event_date), 0, (int) date('m', $event_date), (int) date('d', $event_date), $current_year, 0);

							break;

						default:
							$insert_in_data = false;
							break;
					}

					if ($insert_in_data) {
						$event_duration_sec = (int) $post_meta['event_duration_sec'][0];
						$event_end_date = $event_date + $event_duration_sec;
						//***

						$featured_image_src = "";
						if (has_post_thumbnail($post->ID)) {
							$featured_image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
							$featured_image_src = ThemeMakersHelper::resize_image($featured_image_src[0], $featured_image_width, true, $featured_image_height);
						}

						$data[] = array(
							'id' => uniqid(),
							'post_id' => $post->ID,
							'title' => $post->post_title,
							'start' => date("Y-m-d H:i", $event_date),
							'end' => date("Y-m-d H:i", $event_end_date),
							'start_mktime' => $event_date,
							'end_mktime' => $event_end_date,
							'event_duration_sec' => $post_meta['event_duration_sec'][0],
							'event_place_address' => $post_meta['event_place_address'][0],
							'featured_image_src' => $featured_image_src,
							'post_excerpt' => $post->post_excerpt,
							'allDay' => 0,
							'url' => get_permalink($post->ID),
						);
					}
				}
			}
		}

		//*****
		//for prevent one data event in array $data
		$filtered_data = array();
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				//check if are some events has the same date and time of start
				if (!isset($filtered_data[$value['start_mktime']])) {
					$filtered_data[$value['start_mktime']] = $value;
				} else {
					$val = $value['start_mktime'] + 1;
					while (isset($filtered_data[$val])) {
						++$val;
					}
					$value['start_mktime'] = $val;
					$filtered_data[$val] = $value;
				}
			}
		}
		$data = array();
		if (!empty($filtered_data)) {
			foreach ($filtered_data as $key => $value) {
				$data[] = $value;
			}
		}
		//***** SELECTING EVENTS BY CATEGORY
		if ($category > 0) {

			$post__in = array();
			foreach ($data as $event) {
				$post__in[] = $event['post_id'];
			}
			//***
			$args = array(
				'numberposts' => -1,
				'post_type' => 'event',
				'post_status' => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'events',
						'field' => 'term_id',
						'terms' => $category,
						'compare' => 'AND'
					)
				),
				'post__in' => $post__in
			);

			$postslist = get_posts($args);
			$posts_ids = array();
			if (!empty($postslist)) {
				foreach ($postslist as $post) {
					$posts_ids[] = $post->ID;
				}
			}

			if (!empty($data) AND !empty($posts_ids)) {
				foreach ($data as $key => $post) {
					if (!in_array($post['post_id'], $posts_ids)) {
						unset($data[$key]);
					}
				}
			} else {
				$data = array();
			}
		}

		//*****

		return $data;
	}

	//ajax
	public static function get_calendar_data() {
		$data = self::get_events($_REQUEST['start'], $_REQUEST['end']);
		echo json_encode($data);
		exit;
	}

	//ajax
	public static function get_widget_calendar_data() {
		$data = self::get_events($_REQUEST['start'], $_REQUEST['end']);
		$now = current_time('timestamp');

		$buffer = array();
		$description_buffer = array();
		$result = array();

		if (!empty($data)) {
			foreach ($data as $value) {
				$tmp = explode(" ", $value['start']);
				@$buffer[$tmp[0]]+=1;
				$description_buffer[$tmp[0]] = $value;
			}

			$counter = 1;
			foreach ($buffer as $date => $count) {
				$tmp = array();
				$tmp['id'] = (string) uniqid();
				$tmp['title'] = (string) $count;
				//$tmp['title'] = $description_buffer[$date]['title'] . "\n" . $description_buffer[$date]['event_place_address'];
				$tmp['start'] = $date;
				$tmp['start_mktime'] = strtotime($date, $now);
				$tmp['end'] = $date;
				$tmp['allDay'] = 0;
				//***
				$date_array = explode("-", $date);
				$tmp['url'] = home_url() . "/event?yy=" . $date_array[0] . "&mm=" . $date_array[1] . "&dd=" . $date_array[2];
				//***
				$result[] = $tmp;
				$counter++;
			}
		}


		echo json_encode($result);
		exit;
	}

	public static function get_soonest_event($start, $count = 1, $distance = 0) {

		if (!$distance) {
			$distance = 1 * 60 * 60 * 24 * 31; //1 month by default
		} else {
			$distance = $distance * 60 * 60 * 24 * 31;
		}

		$end = $start + $distance;
		$now = current_time('timestamp');

		$data = self::get_events($start, $end);

		$buffer = array();

		if (!empty($data)) {
			//usort($data, "compare_events");
			//*****

			foreach ($data as $key => $value) {
				if ($value['start_mktime'] > $now) {
					if ($distance > 0) {
						if ($value['start_mktime'] > $start + $distance) {
							continue;
						}
					}
					$buffer[$value['start_mktime']] = $value;
				}
			}
		}


		$key_buffer = array();
		if (!empty($buffer)) {
			foreach ($buffer as $key => $value) {
				$key_buffer[] = $key;
			}
		}


		if (!empty($key_buffer)) {
			//****************** for widget upcoming events ************************

			sort($key_buffer, SORT_NUMERIC);
			$key_buffer = array_slice($key_buffer, 0, $count);
			$result = array();
			for ($i = 0; $i < $count; $i++) {
				if (isset($key_buffer[$i])) {
					$result[] = $buffer[$key_buffer[$i]];
				} else {
					break;
				}
			}

			return $result;
		}



		return array();
	}

	private static function compare_events($a, $b) {
		return $a['start_mktime'] - $b['start_mktime'];
	}

	public static function get_single_event_date($post_id) {
		$event_repeat = get_post_meta($post_id, 'event_repeating', true);
		$ev_mktime = (int) get_post_meta($post_id, 'ev_mktime', true);
		$now = current_time('timestamp');

		switch ($event_repeat) {
			case 'week':
				if ($ev_mktime < $now) {

					$event_repeating_week = get_post_meta($post_id, 'event_repeating_week', true);
					//*****
					if (!empty($event_repeating_week)) {
						//shift days for date("w", $ev_mktime); because now 0 is monday, 6 - is sunday
						foreach ($event_repeating_week as $key => $value) {
							$event_repeating_week[$key]+=1;
							if ($event_repeating_week[$key] == 7) {
								$event_repeating_week[$key] = 0;
							}
						}
					}
					//*****
					while (true) {
						$ev_mktime = strtotime("+1 week", $ev_mktime);
						if ($ev_mktime > $now) {
							if (!empty($event_repeating_week) AND count($event_repeating_week) > 1) {
								$last_approoved_mktime = $ev_mktime;
								$tmp_mktime = strtotime("-1 day", $last_approoved_mktime);

								foreach ($event_repeating_week as $key => $value) {
									$day_num = date("w", $tmp_mktime); //0 - sunday, 6 - saturday
									if (in_array($day_num, $event_repeating_week)) {

										if ($tmp_mktime < $now) {
											$ev_mktime = $last_approoved_mktime;
											break;
										} else {
											$last_approoved_mktime = $tmp_mktime;
										}
									}

									$tmp_mktime = strtotime("-1 day", $tmp_mktime);
								}
								$ev_mktime = $last_approoved_mktime;

								break;
							} else {
								break;
							}
						}
					}
				}
				break;
			case 'month':
				if ($ev_mktime < $now) {
					while (true) {
						$ev_mktime = strtotime("+1 month", $ev_mktime);

						if ($ev_mktime > $now) {
							break;
						}
					}
				}
				break;
			case 'year':
				if ($ev_mktime < $now) {
					while (true) {
						$ev_mktime = strtotime("+1 year", $ev_mktime);
						if ($ev_mktime > $now) {
							break;
						}
					}
				}

				break;

			default:
				break;
		}




		return $ev_mktime;
	}

	//ajax
	public static function get_events_listing() {
		$request_start = 0;
		if (isset($_REQUEST['start'])) {
			$request_start = $_REQUEST['start'];
		}


		$now = current_time('timestamp');

		$start = ($request_start != 0 ? $request_start : $now);
		//$days_in_curr_month = cal_days_in_month(CAL_GREGORIAN, date("m", $start), date("Y", $start));$days_in_curr_month = date('t', @mktime(0, 0, 0, date("m", $start), 1, date("Y", $start)));
		$days_in_curr_month = date('t', @mktime(0, 0, 0, date("m", $start), 1, date("Y", $start)));

		//$end = strtotime(date("Y", $start) . '-' . date("m", $start) . '-' . $days_in_curr_month . " " . 23 . ":" . 59 . ":" . 59, $now);

		$distance = 60 * 60 * 24 * $days_in_curr_month - 1;
		$end = $start + $distance;
		if ($request_start == 0) {//current month
			$distance = $end - $start;
		}

		$events = self::get_events($start, $end, (int) @$_REQUEST['category']);

		//events filtering
		$filtered_events = array();
		if (!empty($events)) {
			foreach ($events as $key => $value) {
				if ($value['start_mktime'] > $end) {
					unset($events[$key]);
					continue;
				}
				$filtered_events[$value['start_mktime']] = $value;
			}
		}
		//sorting
		ksort($filtered_events);
		$events = $filtered_events;
		//*****


		$args = array();
		$args['events'] = $events;
		$result = array();
		$result['html'] = ThemeMakersThemeView::draw_free_page(self::get_application_path() . '/views/events_list.php', $args);

		$result['year'] = date("Y", $start);
		$result['month'] = ThemeMakersHelper::get_monts_names(date("m", $start) - 1);
		$result['month_num'] = date("m", $start);

		//*****
		$result['next_time'] = $end + 1;
		$result['prev_time'] = $end - $distance - 1;

		if ($result['prev_time'] < $now) {
			$result['prev_time'] = $now;
		}

		$result['prev_time'] = strtotime(date("Y", $result['prev_time']) . '-' . date("m", $result['prev_time']) . '-' . 1 . " " . 00 . ":" . 00 . ":" . 00, $now);
		//*****

		echo json_encode($result);
		exit;
	}

	public static function get_timezone_string() {
		$hide_time_zone = get_option(TMM_THEME_PREFIX . "events_hide_time_zone");

		if ($hide_time_zone == 1) {
			return "";
		}

		$current_offset = self::$gmt_offset;
		$tzstring = get_option('timezone_string');

		$check_zone_info = true;

		if (false !== strpos($tzstring, 'Etc/GMT'))
			$tzstring = '';

		if (empty($tzstring)) { // Create a UTC+- zone if no timezone string exists
			$check_zone_info = false;
			if (0 == $current_offset)
				$tzstring = 'UTC+0';
			elseif ($current_offset < 0)
				$tzstring = 'UTC' . $current_offset;
			else
				$tzstring = 'UTC+' . $current_offset;
		}

		return "(" . $tzstring . ")";
	}

	//format: 2013-03-01 17:11  YYYY-mm-dd H:i
	public static function convert_time_to_zone_time($time) {
		$gmt_offset = (int) self::$gmt_offset;
		$mk_time = strtotime($time);
		$mk_time+=($gmt_offset * (-1) * 3600);
		$time_converted = date('Y-m-d', $mk_time) . " " . date('H', $mk_time) . ":" . date('i', $mk_time);
		return $time_converted;
	}

}

//****************************
include_once Thememakers_Application_Events::get_application_path() . '/widgets.php';



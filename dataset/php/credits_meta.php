<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" value="1" name="thememakers_meta_saving" />
<?php
wp_enqueue_script('jquery-ui-datepicker');

@$event_date = (@$event_date ? @$event_date : "");
@$event_end_date = (@$event_end_date ? @$event_end_date : "");

@$event_hh = (@$event_hh ? @$event_hh : "12");
@$event_mm = (@$event_mm ? @$event_mm : "00");
@$event_repeating = (@$event_repeating ? @$event_repeating : "no");
@$event_place_address = (@$event_place_address ? @$event_place_address : "");
@$event_map_zoom = ($event_map_zoom ? $event_map_zoom : 14);
@$event_map_latitude = ($event_map_latitude ? $event_map_latitude : "40.714623");
@$event_map_longitude = ($event_map_longitude ? $event_map_longitude : "-74.006605");
?>
<table class="form-table">
    <tbody>

        <tr>
            <th style="width:25%">
                <label for="event_repeating">
                    <strong><?php _e('Event Repeating', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>

                <select name="event_repeating">
					<?php foreach (Thememakers_Application_Events::$event_repeatings as $key => $value) : ?>
						<option value="<?php echo $key ?>" <?php echo($event_repeating == $key ? 'selected' : '') ?>><?php echo $value ?></option>
					<?php endforeach; ?>
                </select>
				<?php $week_repeatings_array = array('week', '2week', '3week') ?>
                <ul style="display: <?php echo(in_array($event_repeating, $week_repeatings_array) ? 'block' : 'none') ?>;" id="event_week_days">

					<?php
					$week_days_array = array(
						__('Monday', TMM_THEME_FOLDER_NAME), //0
						__('Tuesday', TMM_THEME_FOLDER_NAME),
						__('Wednesday', TMM_THEME_FOLDER_NAME),
						__('Thursday', TMM_THEME_FOLDER_NAME),
						__('Friday', TMM_THEME_FOLDER_NAME),
						__('Saturday', TMM_THEME_FOLDER_NAME),
						__('Sunday', TMM_THEME_FOLDER_NAME), //6
					);
					$event_repeating_week = unserialize($event_repeating_week);
					?>

					<?php foreach ($week_days_array as $key => $value) : ?>
						<li><input type="checkbox" value="<?php echo $key ?>" <?php if (is_array($event_repeating_week)) echo(in_array($key, $event_repeating_week) ? 'checked' : '') ?> name="event_repeating_week[]" />&nbsp;<?php echo $value ?><br /></li>
					<?php endforeach; ?>

                </ul>

            </td>
        </tr>

        <tr>
            <th style="width:25%">
                <label for="event_date">
                    <strong><?php _e('Event Date and Time', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>

                <div id="error_event_datas" style="display: none;">
                    <p>
                        <strong><?php _e('Warning! Event start time must be earlier than event end time!', TMM_THEME_FOLDER_NAME); ?></strong>
                    </p>
                </div>

                <input type="text" value="<?php echo $event_date ?>" id="event_date" name="event_date" readonly="" />&nbsp;<select name="event_hh" id="event_hh" class="event_time_select">
					<?php for ($i = 0; $i <= 23; $i++): ?>
						<option value="<?php echo $i ?>" <?php echo($event_hh == $i ? 'selected' : '') ?>><?php echo ($i < 10 ? "0" . $i : $i); ?></option>
					<?php endfor; ?>
                </select>&nbsp;:&nbsp;<select name="event_mm" id="event_mm" class="event_time_select">
					<?php for ($i = 0; $i <= 55; $i+=5): ?>
						<option value="<?php echo $i ?>" <?php echo($event_mm == $i ? 'selected' : '') ?>><?php echo ($i < 10 ? "0" . $i : $i); ?></option>
					<?php endfor; ?>
                </select>&nbsp;<?php echo Thememakers_Application_Events::get_timezone_string() ?>
            </td>
        </tr>




        <tr>
            <th style="width:25%">
                <label>
                    <strong><?php _e('Event End Date and Time', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
                <input type="text" value="<?php echo $event_end_date ?>" id="event_end_date" name="event_end_date" readonly="" />&nbsp;<select name="event_end_hh" id="event_end_hh" class="event_time_select">
					<?php for ($i = 0; $i <= 23; $i++): ?>
						<option value="<?php echo $i ?>" <?php echo($event_end_hh == $i ? 'selected' : '') ?>><?php echo ($i < 10 ? "0" . $i : $i); ?></option>
					<?php endfor; ?>
                </select>&nbsp;:&nbsp;<select name="event_end_mm" id="event_end_mm" class="event_time_select">
					<?php for ($i = 0; $i <= 55; $i+=5): ?>
						<option value="<?php echo $i ?>" <?php echo($event_end_mm == $i ? 'selected' : '') ?>><?php echo ($i < 10 ? "0" . $i : $i); ?></option>
					<?php endfor; ?>
                </select>&nbsp;<?php echo Thememakers_Application_Events::get_timezone_string() ?>
            </td>
        </tr>


		<tr>
            <th style="width:25%">
                <label>
                    <strong><?php _e('Event Duration', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
				<?php
				$durations_array = array();
				$start = 5;
				$step = 5;
				while (true) {
					$durations_array[] = $start;
					$start+=$step;

					if ($start > 1200) {
						break;
					}
				}
				?>

				<select name="event_duration_sec">
					<?php foreach ($durations_array as $key => $value) : ?>
						<?php
						$hh=(int)($value/60);
						if($hh<10){
							$hh="0".$hh;
						}
						
						$mm=(int)($value%60);
						if($mm<10){
							$mm="0".$mm;
						}
						?>
						<option <?php echo($event_duration_sec == ($value*60) ? 'selected' : '') ?> value="<?php echo ($value*60) ?>"><?php echo $hh ?>:<?php echo $mm ?></option>
					<?php endforeach; ?>
				</select>
            </td>
        </tr>


        <tr>
            <th style="width:25%">
                <label for="hide_event_place">
                    <strong><?php _e('Hide Event Place', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
                <input type="checkbox" name="hide_event_place" value="1" <?php echo($hide_event_place ? 'checked' : '') ?> /><br />
            </td>
        </tr>
		<tr>
            <th style="width:25%">
                <label for="event_place">
                    <strong><?php _e('Event Place', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
                &nbsp;<input type="text" value="<?php echo $event_place_address ?>" id="event_place_address" name="event_place_address" style="width: 725px;" />&nbsp;<a class="repeatable-add button" style="float:left;" href="#" id="set_event_place"><?php _e('Set place', TMM_THEME_FOLDER_NAME); ?></a><br />
                <br />
				<?php echo do_shortcode('[google_map width="800" height="600" latitude="' . $event_map_latitude . '" longitude="' . $event_map_longitude . '" zoom="' . $event_map_zoom . '" controls="" enable_scrollwheel="0" map_type="ROADMAP" enable_marker="1" enable_popup="0"][/google_map]') ?>
            </td>
        </tr>
        <tr>
            <th style="width:25%">
                <label for="event_map_zoom">
                    <strong><?php _e('Event Map Zoom', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
                <select name="event_map_zoom" id="event_map_zoom">
					<?php for ($i = 0; $i <= 30; $i++): ?>
						<option value="<?php echo $i ?>" <?php echo($event_map_zoom == $i ? 'selected' : '') ?>><?php echo ($i < 10 ? "0" . $i : $i); ?></option>
					<?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th style="width:25%">
                <label for="event_map_latitude">
                    <strong><?php _e('Event Map Latitude', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
                <input type="text" value="<?php echo $event_map_latitude ?>" id="event_map_latitude" name="event_map_latitude" /><br />
            </td>
        </tr>
        <tr>
            <th style="width:25%">
                <label for="event_map_longitude">
                    <strong><?php _e('Event Map Longitude', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
                <input type="text" value="<?php echo $event_map_longitude ?>" id="event_map_longitude" name="event_map_longitude" /><br />
            </td>
        </tr>
    </tbody>
</table>

<style type="text/css">
    #error_event_datas {
        background-color: #FFEBE8;
        border-color: #CC0000;
        margin: 5px 0 2px 0;
        padding: 0 0.6em;
    }
</style>

<script type="text/javascript">
	var calendar_event_date = "<?php echo $event_date ?>";
	var calendar_event_end_date = "<?php echo $event_end_date ?>";

	jQuery(function() {

		jQuery("#event_date").datepicker({
			dateFormat: "dd-mm-yy",
			showButtonPanel: true,
			showOtherMonths: true,
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			showWeek: true,
			setDate: "<?php echo $event_date ?>",
			onClose: function(selectedDate) {
				calendar_event_date = selectedDate;
				jQuery("#event_end_date").datepicker("option", "minDate", selectedDate);
				check_date_errors();
			}
		});


		jQuery("#event_end_date").datepicker({
			dateFormat: "dd-mm-yy",
			showButtonPanel: true,
			showOtherMonths: true,
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			showWeek: true,
			setDate: "<?php echo $event_end_date ?>",
			onClose: function(selectedDate) {
				calendar_event_end_date = selectedDate;
				jQuery("#event_date").datepicker("option", "maxDate", selectedDate);
				check_date_errors();
			}
		});
		

		jQuery(".event_time_select").change(function() {
			check_date_errors();
		});
		

		jQuery("#set_event_place").click(function() {
			var map_canvas_id = jQuery(jQuery(".google_map").eq(0)).attr('id');
			var geo = new google.maps.Geocoder;
			var address = jQuery("#event_place_address").val();

			geo.geocode({'address': address}, function(results, status) {
				var latitude = null;
				var longitude = null;
				//***
				if (status == google.maps.GeocoderStatus.OK) {
					//latitude = results[0].geometry.location.hb;
					//longitude = results[0].geometry.location.ib;
					latitude = results[0].geometry.location.lat();
					longitude = results[0].geometry.location.lng();
					//***
					jQuery("#event_map_latitude").val(latitude);
					jQuery("#event_map_longitude").val(longitude);
				} else {
					alert("<?php _e('Geocode was not successful for the following reason', TMM_THEME_FOLDER_NAME); ?>: " + status);
					return false;
				}

				jQuery("#" + map_canvas_id).html("");
				gmt_init_map(latitude, longitude, map_canvas_id, <?php echo $event_map_zoom ?>, "ROADMAP", "", true, false, false);

			});

			return false;
		});


		jQuery('[name="event_repeating"]').live('change', function() {
			var val = jQuery(this).val();
			if (val === 'week' | val === '2week' | val === '3week') {
				jQuery("#event_week_days").show(333);
			} else {
				jQuery("#event_week_days").hide(333);
			}
		});

		check_date_errors();

	});


	function check_date_errors() {
		if (calendar_event_date == calendar_event_end_date) {
			var event_hh = parseInt(jQuery("#event_hh").val());
			var event_mm = parseInt(jQuery("#event_mm").val());
			var event_end_hh = parseInt(jQuery("#event_end_hh").val());
			var event_end_mm = parseInt(jQuery("#event_end_mm").val());

			var show_error_event_datas = false;

			if (event_end_hh < event_hh) {
				show_error_event_datas = true;
			}

			if (event_hh == event_end_hh) {
				if (event_end_mm < event_mm) {
					show_error_event_datas = true;
				}
			}

			if (show_error_event_datas) {
				jQuery("#error_event_datas").show(200);
			} else {
				jQuery("#error_event_datas").hide(200);
			}


		} else {
			jQuery("#error_event_datas").hide(200);
		}
	}


</script>
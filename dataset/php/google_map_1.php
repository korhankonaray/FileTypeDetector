<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div id="thememakers_shortcode_template" class="thememakers_shortcode_template clearfix">

	<div class="one-half">
		<h4 class="label"><?php _e('Width', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="500" class="js_shortcode_template_changer data-input" data-shortcode-field="width">	
	</div><!--/ .one-half-->

	<div class="one-half">
		<h4 class="label"><?php _e('Height', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="500" class="js_shortcode_template_changer data-input" data-shortcode-field="height">	
	</div><!--/ .one-half-->

	<div class="one-half">
		<h4 class="label"><?php _e('Latitude', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="40.714623" class="js_shortcode_template_changer data-input" data-shortcode-field="latitude"><br />
		<span class="preset_description">
			<?php _e('Point on which the viewport will be centered. If not given and no markers are defined the viewport defaults to world view.', TMM_THEME_FOLDER_NAME); ?>
		</span>
	</div><!--/ .one-half-->

	<div class="one-half">
		<h4 class="label"><?php _e('Longitude', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="-74.006605" class="js_shortcode_template_changer data-input" data-shortcode-field="longitude"><br />
		<span class="preset_description"><?php _e('Same as above but for Latitude ...', TMM_THEME_FOLDER_NAME); ?></span>	
	</div><!--/ .one-half-->

	<div class="one-half">
		<h4 class="label"><?php _e('Zoom', TMM_THEME_FOLDER_NAME); ?></h4>
		<?php
		$zoom_array = array();
		for ($i = 1; $i <= 19; $i++) {
			$zoom_array[$i] = $i;
		}
		?>

		<select class="js_shortcode_template_changer data-select" data-shortcode-field="zoom">
			<?php if (!empty($zoom_array)): ?>
				<?php foreach ($zoom_array as $zoom) : ?>
					<option <?php echo($zoom == 12 ? 'selected' : '') ?> value="<?php echo $zoom ?>"><?php echo $zoom ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>

		<span class="preset_description"><?php _e('Zoom value from 1 to 19 where 19 is the greatest and 1 the smallest.', TMM_THEME_FOLDER_NAME); ?></span>	
	</div><!--/ .one-half-->

	
	<div class="one-half">
        <h4 class="label"><?php _e('Enable Scrollwheel', TMM_THEME_FOLDER_NAME); ?></h4>
        <div class="radio-holder">
            <input type="checkbox" id="enable_scrollwheel" value="0" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="enable_scrollwheel">
            <label for="enable_scrollwheel"><span></span><i class="description"><?php _e('Set to false to disable zooming with your mouses scrollwheel.', TMM_THEME_FOLDER_NAME); ?></i></label>
        </div><!--/ .radio-holder-->
    </div><!--/ .ona-half-->

	<div class="one-half">
		<h4 class="label"><?php _e('Maptype', TMM_THEME_FOLDER_NAME); ?></h4>
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="map_type">
			<option value="ROADMAP">ROADMAP</option>
			<option value="SATELLITE">SATELLITE</option>
			<option value="HYBRID">HYBRID</option>
			<option value="TERRAIN">TERRAIN</option>
		</select>
	</div><!--/ .one-half-->
	
	
	 <div class="one-half">
        <h4 class="label"><?php _e('Enable Marker', TMM_THEME_FOLDER_NAME); ?></h4>
        <div class="radio-holder">
            <input type="checkbox" id="enable_marker" value="0" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="enable_marker">
            <label for="enable_marker"><span></span><i class="description"><?php _e('Set to false to disable display a marker in the viewport.', TMM_THEME_FOLDER_NAME); ?></i></label>
        </div><!--/ .radio-holder-->
    </div><!--/ .ona-half-->

	 <div class="one-half">
        <h4 class="label"><?php _e('Enable Popup', TMM_THEME_FOLDER_NAME); ?></h4>
        <div class="radio-holder">
            <input type="checkbox" id="enable_popup" value="0" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="enable_popup">
            <label for="enable_popup"><span></span><i class="description"><?php _e('If true the info window for this marker will be shown when the map finished loading. If html is empty this option will be ignored.', TMM_THEME_FOLDER_NAME); ?></i></label>
        </div><!--/ .radio-holder-->
    </div><!--/ .ona-half-->

	<div class="one-half">
		<h4 class="label"><?php _e('Html content', TMM_THEME_FOLDER_NAME); ?></h4>
		<textarea class="js_shortcode_template_changer data-area" data-shortcode-field="content"></textarea>
		<span class="preset_description"><?php _e('Content that will be shown after marker click', TMM_THEME_FOLDER_NAME); ?></span>	
	</div><!--/ .one-half-->

</div><!--/ .thememakers_template_changer-->

<!-- --------------------------  PROCESSOR  --------------------------- -->

<div class="fullwidth-frame">

	<h4 class="label"><?php _e('Preview', TMM_THEME_FOLDER_NAME); ?></h4>

	<?php $frame_uri = Thememakers_Application_Shortcodes::get_application_uri() . "/preview.php"; ?>

	<div class="shortcode_app_frame_block">
		<div class="thememakers_shortcode_info_popup" style="display: none"></div>
		<iframe src="<?php echo $frame_uri ?>" class="shortcode_app_frame" frameborder="1" id="thememakers_shortcode_template_preview"></iframe>
	</div>

	<script type="text/javascript">
		var thememakers_app_shortcodes_preview_url = "<?php echo $frame_uri ?>";
		jQuery(function() {
			var shortcode_name = "google_map";
			thememakers_app_shortcodes.changer(shortcode_name);
			jQuery("#thememakers_shortcode_template .js_shortcode_template_changer").on('keyup, change', function() {
				thememakers_app_shortcodes.changer(shortcode_name);
			});

		});
	</script>

</div><!--/ .fullwidth-frame-->




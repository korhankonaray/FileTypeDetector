<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div id="thememakers_shortcode_template" class="thememakers_shortcode_template clearfix">
	
	<div class="one-half">
		<h4 class="label"><?php _e('Chart Type', TMM_THEME_FOLDER_NAME); ?></h4>
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="type">
			<option value="pie"><?php _e('Pie Chart', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="bar"><?php _e('Bar Chart', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="column"><?php _e('Column Chart', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="geochart"><?php _e('Geochart', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="line"><?php _e('Line chart', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="area"><?php _e('Area chart', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="combo"><?php _e('Combo Chart', TMM_THEME_FOLDER_NAME); ?></option>
		</select>
		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Title', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="title">	
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Chart Width', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="500" class="js_shortcode_template_changer data-input" data-shortcode-field="width">	
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Chart Height', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="500" class="js_shortcode_template_changer data-input" data-shortcode-field="height">
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Font Family', TMM_THEME_FOLDER_NAME); ?></h4>
		<?php
		$content_fonts = array();
		$content_fonts_tmp = ThemeMakersHelperFonts::get_content_fonts();
		foreach ($content_fonts_tmp as $key => $value) {
			$content_fonts[$value] = $value;
		}
		?>
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="font_family">
			<?php if (!empty($content_fonts)): ?>
				<?php foreach ($content_fonts as $value) : ?>
					<option value="<?php echo $value ?>"><?php echo $value ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>	
		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Font Size', TMM_THEME_FOLDER_NAME); ?></h4>
		<?php
		$font_size_array = array();
		for ($i = 8; $i <= 72; $i++) {
			$font_size_array[$i] = $i;
		}
		?>
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="font_size">
			<?php if (!empty($font_size_array)): ?>
				<?php foreach ($font_size_array as $size) : ?>
					<option <?php echo($size == 14 ? 'selected' : '') ?> value="<?php echo $size ?>"><?php echo $size ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Chart Titles', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="chart_titles">
		<span class="preset_description">
			<?php _e('Example', TMM_THEME_FOLDER_NAME); ?>:<br />
			Pie => Task,Hours per Day<br />
			Bar, Column, Line, Area => Year, Sales, Expenses<br />
			Combo => Month,Bolivia,Ecuador,Madagascar,Papua New Guinea,Rwanda,Average<br />
			Geochart => Country,Popularity<br />
		</span>	
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Chart Data', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" class="js_shortcode_template_changer data-area" data-shortcode-field="content" /> 
		<span class="preset_description">
			<?php _e('Example', TMM_THEME_FOLDER_NAME); ?>:<br />
			Pie => sleep:2,eat:2,work:2<br />
			Bar, Column => 2004:1000:400,2005:980:570,2006:800:300<br />
			Line, Area => 2004:1000:400,2005:1170:460,2006:660:1120,2007:1030:540<br />
			Combo => 2004/05:165:938:522:998:450:614.6,2005/06:135:1120:599:1268:288:682,2006/07:157:1167:587:807:397:623,2007/08:139:1110:615:968:215:609.4,2008/09:136:691:629:1026:366:569.6<br />
			Geochart => Germany:200,France:300,United States:400<br />
		</span>
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Background Color', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer colorpicker_input data-input" data-shortcode-field="bgcolor">
	</div><!--/ .one-half-->
 
</div><!--/ .thememakers_shortcode_template-->

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
			var shortcode_name = "chart";
			thememakers_app_shortcodes.changer(shortcode_name);
			jQuery("#thememakers_shortcode_template .js_shortcode_template_changer").on('keyup, change', function() {
				thememakers_app_shortcodes.changer(shortcode_name);
			});

		});
	</script>
	
</div><!--/ .fullwidth-frame-->





<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div id="thememakers_shortcode_template" class="thememakers_shortcode_template clearfix">
	
	<div class="one-half">
		<h4 class="label"><?php _e('Select Type', TMM_THEME_FOLDER_NAME); ?></h4>
		<?php
		$all_posts = get_posts(array('numberposts' => -1));
		$post_select_array = array();
		foreach ($all_posts as $post) {
			$post_select_array[$post->ID] = $post->post_title;
		}
		?>
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="post_id">
			<?php if (!empty($post_select_array)): ?>
				<?php foreach ($post_select_array as $term_id => $name) : ?>
					<option value="<?php echo $term_id ?>"><?php echo $name ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Content', TMM_THEME_FOLDER_NAME); ?></h4>   
		<input checked="" type="radio" name="content" id="content_radio_1" value="1" class="js_shortcode_radio_self_update data-radio" />
		<label for="content_radio_1" class="label-form"><span></span><?php _e('Content', TMM_THEME_FOLDER_NAME); ?></label>
		<input type="radio" name="content" id="content_radio_0" value="0" class="js_shortcode_radio_self_update" />
		<label for="content_radio_0" class="label-form"><span></span><?php _e('Excerpt', TMM_THEME_FOLDER_NAME); ?></label>
		<input type="hidden" value="1" class="js_shortcode_template_changer" data-shortcode-field="content" />
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Excerpt Char Count', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="140" class="js_shortcode_template_changer data-input" data-shortcode-field="char_count">
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Featured Image', TMM_THEME_FOLDER_NAME); ?></h4>  
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="show_featured_image">
			<option value="0"><?php _e('No image', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="1"><?php _e('Show featured image', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="2"><?php _e('Use custom image link', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="3"><?php _e('Show image in fancybox', TMM_THEME_FOLDER_NAME); ?></option>
		</select>	
		
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Custom Image Link', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="#" class="js_shortcode_template_changer data-input" data-shortcode-field="custom_image_link">
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Thumb Width', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="150" class="js_shortcode_template_changer data-input" data-shortcode-field="thumb_width">	
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Thumb Height', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="150" class="js_shortcode_template_changer data-input" data-shortcode-field="thumb_height">
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Read More Button', TMM_THEME_FOLDER_NAME); ?></h4>
		<input checked="" type="radio" name="show_readmore_button" id="show_button_0" value="0" class="js_shortcode_radio_self_update data-radio" />
		<label for="show_button_0" class="label-form"><span></span><?php _e('No readmore button', TMM_THEME_FOLDER_NAME); ?></label>
		<input type="radio" name="show_readmore_button" id="show_button_1" value="1" class="js_shortcode_radio_self_update" />
		<label for="show_button_1" class="label-form"><span></span><?php _e('Show readmore button', TMM_THEME_FOLDER_NAME); ?></label>
		<input type="hidden" value="0" class="js_shortcode_template_changer" data-shortcode-field="show_readmore_button" />	
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Button Color', TMM_THEME_FOLDER_NAME); ?></h4>
		<?php $colors = ThemeMakersHelper::get_theme_buttons(); ?>
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="button_color">
			<?php if (!empty($colors)): ?>
				<?php foreach ($colors as $key => $name) : ?>
					<option value="<?php echo $key ?>"><?php echo $name ?></option>
				<?php endforeach; ?>
			<?php endif; ?>

		</select>
		
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Button Size', TMM_THEME_FOLDER_NAME); ?></h4>
		<?php $size = ThemeMakersHelper::get_theme_buttons_sizes() ?>
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="button_size">

			<?php if (!empty($size)): ?>
				<?php foreach ($size as $key => $name) : ?>
					<option value="<?php echo $key ?>"><?php echo $name ?></option>
				<?php endforeach; ?>
			<?php endif; ?>

		</select>	
		
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Title Align', TMM_THEME_FOLDER_NAME); ?></h4>  
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="title_align">
			<option value="left"><?php _e('Left', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="center"><?php _e('Center', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="right"><?php _e('Right', TMM_THEME_FOLDER_NAME); ?></option>
		</select>
	</div><!--/ .on-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Text Align', TMM_THEME_FOLDER_NAME); ?></h4>  
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="text_align">
			<option value="left"><?php _e('Left', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="center"><?php _e('Center', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="right"><?php _e('Right', TMM_THEME_FOLDER_NAME); ?></option>
		</select>	
		
	</div><!--/ .one-half-->

</div><!--/ .thememakers_shorcode_template-->


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
			var shortcode_name = "column_post";
			thememakers_app_shortcodes.changer(shortcode_name);
			jQuery("#thememakers_shortcode_template .js_shortcode_template_changer").on('keyup, change', function() {
				thememakers_app_shortcodes.changer(shortcode_name);
			});

		});
	</script>
	
</div><!--/ .fullwidth-frame-->




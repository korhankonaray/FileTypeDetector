<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div id="thememakers_shortcode_template" class="thememakers_shortcode_template clearfix">
	
	<div class="one-half">
		<h4 class="label"><?php _e('Image URL', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="http://" class="js_shortcode_template_changer data-input data-upload" data-shortcode-field="content" />
		<a title="" class="admin-button button-gray button-medium button_upload ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" href="#">
			<?php _e('Upload', TMM_THEME_FOLDER_NAME); ?>
		</a>	
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Link Target', TMM_THEME_FOLDER_NAME); ?></h4>  
		
		<div class="radio-holder">
			<input checked="" type="radio" name="target" id="target_self" value="_self" class="js_shortcode_radio_self_update data-check" />
			<label for="target_self" class="label-form"><span></span><?php _e('Self', TMM_THEME_FOLDER_NAME); ?></label>
			<input type="radio" name="target" id="target_blank" value="_blank" class="js_shortcode_radio_self_update" />
			<label for="target_blank" class="label-form"><span></span><?php _e('Blank', TMM_THEME_FOLDER_NAME); ?></label>
			<input type="hidden" value="_self" class="js_shortcode_template_changer" data-shortcode-field="target" />		
		</div><!--/ .radio-holder-->
		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Action', TMM_THEME_FOLDER_NAME); ?></h4>
		
		<select class="js_shortcode_template_changer data-select" data-shortcode-field="action" onchange="app_shortcode_show_action_link(this);">
			<option value="none"><?php _e('No link on image', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="link"><?php _e('Open link', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="fancybox"><?php _e('Show image in Fancybox', TMM_THEME_FOLDER_NAME); ?></option>
		</select>
		
		<div id="image_action_link" style="display: none;">
			<h4 class="label"><?php _e('Image Action Link', TMM_THEME_FOLDER_NAME); ?></h4>
			<input type="text" value="http://" class="js_shortcode_template_changer data-input" data-shortcode-field="image_action_link" />
		</div>
		
		<div id="image_fancybox_group" style="display: none;">
			<h4 class="label"><?php _e('Fancybox Group', TMM_THEME_FOLDER_NAME); ?></h4>
			<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="fancybox_group" />
		</div>
		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Show Border', TMM_THEME_FOLDER_NAME); ?></h4>   
		
		<div class="radio-holder">
			<input checked="" type="radio" name="show_border" id="show_border_1" value="1" class="js_shortcode_radio_self_update data-check" />
			<label for="show_border_1" class="label-form"><span></span><?php _e('Yes', TMM_THEME_FOLDER_NAME); ?></label>
			<input type="radio" name="show_border" value="0" id="show_border_0" class="js_shortcode_radio_self_update data-radio" />&nbsp;
			<label for="show_border_0" class="label-form"><span></span><?php _e('No', TMM_THEME_FOLDER_NAME); ?></label>
			<input type="hidden" value="1" class="js_shortcode_template_changer" data-shortcode-field="show_border" onchange="app_shortcode_show_border_align_values(this);" />		
		</div><!--/ .radio-holder-->
	
		<h4 class="label"><?php _e('Align', TMM_THEME_FOLDER_NAME); ?></h4>

		<select class="js_shortcode_template_changer data-select" data-shortcode-field="align">
			<option value="none"><?php _e('None', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="right"><?php _e('Right', TMM_THEME_FOLDER_NAME); ?></option>
			<option value="left"><?php _e('Left', TMM_THEME_FOLDER_NAME); ?></option>
		</select>
			
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Width', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="200" class="js_shortcode_template_changer data-input" data-shortcode-field="width" />	
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Height', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="200" class="js_shortcode_template_changer data-input" data-shortcode-field="height" />		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Image Alt', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="image_alt" />	
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Link Title', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="link_title" />		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Top Indent (px)', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="margin_top" />		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Right Indent (px)', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="margin_right" />
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Bottom Indent (px)', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="margin_bottom" />		
	</div><!--/ .one-half-->
	
	<div class="one-half">
		<h4 class="label"><?php _e('Left Indent (px)', TMM_THEME_FOLDER_NAME); ?></h4>
		<input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="margin_left" />		
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
				var shortcode_name = "image";
				thememakers_app_shortcodes.changer(shortcode_name);
				jQuery("#thememakers_shortcode_template .js_shortcode_template_changer").on('keyup change', function() {
					thememakers_app_shortcodes.changer(shortcode_name);
				});

			});

			function app_shortcode_show_action_link(self) {
				jQuery("#image_action_link, #image_fancybox_group").hide(333);
				if (jQuery(self).val() == 'link') {
					jQuery("#image_action_link").show(333);
				}

				if (jQuery(self).val() == 'fancybox') {
					jQuery("#image_fancybox_group").show(333);
				}

			}

			function app_shortcode_show_border_align_values(self) {
				jQuery("#image_border_align_values").hide(333);
				if (jQuery(self).val() == 1) {
					jQuery("#image_border_align_values").show(333);
				}
			}


	</script>	
	
</div><!--/ .fullwidth-frame-->




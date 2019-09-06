<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" name="thememakers_meta_saving" value="1" />

<h4><?php _e('Custom Page Background', TMM_THEME_FOLDER_NAME); ?></h4>
<table style="width: auto;">
    <tr>
        <td valign="top">
            <select name="pagebg_type">
                <?php
                $types = array(
                    "color" => __("Color", TMM_THEME_FOLDER_NAME),
                    "image" => __("Image", TMM_THEME_FOLDER_NAME),
                );

                if (!$pagebg_type) {
                    $pagebg_type = "color";
                }
                ?>
                <?php foreach ($types as $key => $type) : ?>
                    <option <?php echo($key == $pagebg_type ? "selected" : "") ?> value="<?php echo $key; ?>"><?php echo $type; ?></option>
                <?php endforeach; ?>
            </select><br  />

        </td>
        <td valign="top">

            <ul id="pagebg_type_options" style="margin: 0; padding: 0;">

                <li id="pagebg_type_image" style="display: none;">
                    <input type="text" value="<?php echo $pagebg_image; ?>" name="pagebg_image" style="width: 105px;" />&nbsp;<a href="#" class="button_upload body_pattern button" title=""><?php _e('Upload', TMM_THEME_FOLDER_NAME); ?></a><br />
                    <div class="clear"></div>
                    <div style="position: relative; margin: 5px 0 5px -65px;">
                        <?php _e('Set options', TMM_THEME_FOLDER_NAME); ?>:&nbsp;
                        <select name="pagebg_type_image_option" style="width: 170px;">
                            <?php
                            $options = array(
                                "repeat" => "Repeat",
                                "repeat-x" => "Repeat-X",
                                "fixed" => "Fixed",
                            );

                            if (!$pagebg_type_image_option) {
                                $pagebg_type_image_option = "repeat";
                            }
                            ?>
                            <?php foreach ($options as $key => $option) : ?>
                                <option <?php echo($key == $pagebg_type_image_option ? "selected" : "") ?> value="<?php echo $key; ?>"><?php echo $option; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </li>

                <li id="pagebg_type_color" style="display: none;">
                    <input type="text" class="colorpicker_input" value="<?php echo $pagebg_color; ?>" name="pagebg_color" style="width: 178px;" />
                </li>


        </td>
    </tr>
    <tr>
        <td colspan="2">
            <a style="float: right" href="#" class="body_pattern button button_reset" title=""><?php _e('Reset', TMM_THEME_FOLDER_NAME); ?></a>
            <div class="clear"></div>
        </td>
    </tr>
</table>


<h4><?php _e('Page sidebar position', TMM_THEME_FOLDER_NAME); ?></h4>
<input type="hidden" value="<?php echo (!$page_sidebar_position ? "sbr" : $page_sidebar_position)?>" name="page_sidebar_position" />

<ul class="admin-page-choice-sidebar clearfix">
	<li class="lside <?php echo ($page_sidebar_position == "sbl" ? "current-item" : "")?>"><a data-val="sbl" href="#"><?php _e('Left Sidebar', TMM_THEME_FOLDER_NAME); ?></a></li>
	<li class="wside <?php echo ($page_sidebar_position == "no_sidebar" ? "current-item" : "")?>"><a data-val="no_sidebar" href="#"><?php _e('Without Sidebar', TMM_THEME_FOLDER_NAME); ?></a></li>
	<li class="rside <?php echo ($page_sidebar_position == "sbr" ? "current-item" : "")?>"><a data-val="sbr" href="#"><?php _e('Right Sidebar', TMM_THEME_FOLDER_NAME); ?></a></li>
</ul>
<div class="clear"></div>

<div id="html_buffer"></div>


<script src="<?php echo TMM_THEME_URI ?>/admin/js/general.js" type="text/javascript"></script>
<script src="<?php echo TMM_THEME_URI ?>/admin/js/colorpicker/colorpicker.js" type="text/javascript"></script>
<link type="text/css" href="<?php echo TMM_THEME_URI ?>/admin/js/colorpicker/colorpicker.css" rel="stylesheet" />

<script type="text/javascript">
    jQuery(document).ready(function() {
        
        jQuery("#pagebg_type_<?php echo $pagebg_type; ?>").show();
        
        jQuery("[name=pagebg_type]").change(function(){
            jQuery("#pagebg_type_options li").hide(200);
            jQuery("#pagebg_type_"+jQuery(this).val()).show(400);
        });
        
        jQuery('.button_upload').live('click', function()
        {
            get_tb_editor_image_link(jQuery(this).prev('input'));
            return false;
        });
        
        jQuery('.button_reset').live('click', function()
        {
            jQuery("#pagebg_type_options input").val("");
            jQuery("#pagebg_type_options select").val(0); 
            return false;
        });
        
        
    });
</script>


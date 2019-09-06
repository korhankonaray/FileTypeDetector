<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<ul id="slider_options">
   
    <?php foreach ($slider_object->slider_types_options as $slider_key => $slider) : ?>
         
        <li id="<?php echo $slider_key ?>" style="display: <?php echo($slider_key == $slider_object->current_slider_type ? "block" : "none"); ?>;">
            
            <h1><?php _e('Slider Settings', TMM_THEME_FOLDER_NAME); ?></h1>
            <h2><?php echo $slider_object->slider_types[$slider_key] ?></h2>
            <?php $counter=count($slider); ?>
            <?php foreach ($slider as $option => $options_array) : ?>
                
                <?php if ($options_array['type'] != 'checkbox'): ?>
                    <h4><?php echo $options_array['title'] ?></h4>
                <?php endif; ?>

                <div class="clearfix ">

                    <div class="admin-one-half">                        

                        <?php
                        $option_value = get_option(TMM_THEME_PREFIX . "slider_" . $slider_key . "_" . $option);
                        switch ($options_array['type']) {
                            case 'text':
                                ?>
                                <input type="text" value="<?php echo($option_value ? $option_value : $options_array['default']) ?>" name="slider_<?php echo $slider_key ?>_<?php echo $option ?>" min-value="0" max-value="<?php echo $options_array['max'] ?>" class="ui_slider_item slide_option_textinput" /><br />
                                <?php
                                break;

                            case 'select':
                                if (empty($option_value)) {
                                    $option_value = $options_array['default'];
                                }
                                ?>
                                <select name="slider_<?php echo $slider_key ?>_<?php echo $option ?>">
                                    <?php foreach ($options_array['values_list'] as $val_key => $val_title) : ?>
                                        <option <?php if ($option_value == $val_key): ?>selected<?php endif; ?> value="<?php echo $val_key; ?>"><?php echo $val_title; ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <?php
                                break;

                            case 'image_link':
                                ?>
                                <input class="slide_option_textinput" type="text" value="<?php echo($option_value ? $option_value : $options_array['default']) ?>" name="slider_<?php echo $slider_key ?>_<?php echo $option ?>" /><a href="#" class="button_upload button_upload admin-button button-gray button-medium" title=""><?php _e('Upload', TMM_THEME_FOLDER_NAME); ?></a><br />
                                <?php
                                break;

                            case 'color':
                                ?>
                                <input class="bg_hex_color" type="text" value="<?php echo ($option_value ? $option_value : $options_array['default']) ?>" name="slider_<?php echo $slider_key ?>_<?php echo $option ?>" /><div class="bgpicker" style="background-color: <?php echo $option_value; ?>;"></div><br />
                                <?php
                                break;

                            case 'checkbox':
                                ?>
                                &nbsp;<input class="option_checkbox" type="checkbox" <?php echo($option_value ? 'checked=""' : '') ?> />
                                <input type="hidden" name="slider_<?php echo $slider_key ?>_<?php echo $option ?>" value="<?php echo($option_value ? 1 : 0) ?>" />&nbsp;<strong><?php echo $options_array['title'] ?></strong>
                                <br />
                                <?php
                                break;

                            default:
                                _e('Such type not exists!', TMM_THEME_FOLDER_NAME);
                                break;
                        }
                        ?>



                    </div><!--/ .admin-one-half-->

                    <div class="admin-one-half last">

                        <?php if (!empty($options_array['description'])): ?>
                            <p class="admin-info">
                                <?php echo $options_array['description'] ?> 
                            </p>
                        <?php endif; ?>
                    </div><!--/ .admin-one-half-->

                </div>

                     <?php $counter--; ?>
                     <?php if ($counter>1): ?>
                        <hr class="admin-divider">
                    <?php endif; ?>
                
             
            <?php endforeach; ?>


        </li>
    <?php endforeach; ?>
</ul>

<h4><?php _e('Slider Height', TMM_THEME_FOLDER_NAME); ?></h4>
<input type="text" class="ui_slider_item" max-value="900" min-value="50" name="slider_height_option" value="<?php echo $slider_object->slider_height_option ?>" /><br />



<script type="text/javascript">
    //slider_type
    jQuery(document).ready(function() {        
        jQuery("#tab4-1").html(jQuery("#nivo").html());
        jQuery("#nivo").remove();
        jQuery("#tab4-2").html(jQuery("#circle").html());
        jQuery("#circle").remove();
        jQuery("#tab4-3").html(jQuery("#accordion").html());
        jQuery("#accordion").remove();
        jQuery("#tab4-4").html(jQuery("#rama").html());
        jQuery("#rama").remove();
        jQuery("#tab4-5").html(jQuery("#flexslider").html());
        jQuery("#flexslider").remove();
        jQuery("#tab4-6").html(jQuery("#revolution").html());
        jQuery("#revolution").remove();
        jQuery("#tab4-7").html(jQuery("#mosaic").html());
        jQuery("#mosaic").remove();
    });
</script>


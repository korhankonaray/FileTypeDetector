<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
$slider_object = new Thememakers_Entity_Slider();
if (!empty($slides) AND is_array($slides)):
    ?>
    <?php foreach ($slides as $group_key => $slide) : ?>
        <?php if (isset($slide['name'])): ?>
            <?php if ($slide['name']): ?>
                <div class="tab-content" id="slider_group_<?php echo $group_key ?>" style="display: none;">


                    <div class="add-holder-sliders clearfix">
                        <div class="slider-holder">

                            <span class="slider-group-title"><?php echo $slide['name'] ?></span>
                            <a href="#" class="add-slider-group" group-index="<?php echo $group_key ?>" title="<?php _e("Add Slide", TMM_THEME_FOLDER_NAME) ?>"></a>
                            <a href="#" class="remove-slider-group" group-index="<?php echo $group_key ?>" title="<?php _e("Delete Group", TMM_THEME_FOLDER_NAME) ?>"></a>


                            <ul class="sliders_list">
                                <?php if (!empty($slide['options'])): ?>
                                    <?php foreach ($slide['options'] as $slide_key => $item) : ?>

                                        <?php
                                        $slide_key = $slide_key + 1000;
                                        if (!isset($item['title'])) {
                                            continue;
                                        }
                                        ?>


                                        <li class="list_item_<?php echo $group_key ?>_<?php echo $slide_key ?>">
                                            <div class="admin-drag-holder clearfix slide_view_container">
                                                <a title="<?php _e("Delete Slide", TMM_THEME_FOLDER_NAME) ?>" class="close-drag-holder button_delete_slide" list-item="list_item_<?php echo $group_key ?>_<?php echo $slide_key ?>" href="#"></a>
                                                <a title="<?php _e("Edit Slide", TMM_THEME_FOLDER_NAME) ?>" class="edit-drag-holder edit_slider_item" href="#"></a>

                                                <?php
                                                $img_src = $item['image'];
                                                if (empty($img_src)) {
                                                    $img_src = TMM_THEME_URI . '/admin/images/noimage.png';
                                                } else {
                                                    $img_src = ThemeMakersHelper::resize_image($img_src, 104);
                                                }
                                                ?>

                                                <img width="104" class="slide_preview admin-add-border" src="<?php echo $img_src ?>" alt="" class="admin-add-border" />

                                                <h3><?php echo $item['title'] ?></h3>
                                                <p><?php echo $item['description'] ?></p>
                                            </div>


                                            <div class="admin-drag-holder clearfix slide_edit_container" style="display: none; height: 0; overflow: hidden;">

                                                <a href="#" class="close-drag-holder button_delete_slide" title="<?php _e("Delete Slide", TMM_THEME_FOLDER_NAME) ?>"></a>
                                                <a href="#" class="check-drag-holder stop_edit_slider_item" title="<?php _e("Apply Slide Edition", TMM_THEME_FOLDER_NAME) ?>"></a>

                                                <?php
                                                $img_src = $item['image'];
                                                if (empty($img_src)) {
                                                    $img_src = TMM_THEME_URI . '/admin/images/noimage.png';
                                                } else {
                                                    $img_src = ThemeMakersHelper::resize_image($img_src, 104);
                                                }
                                                ?>

                                                <img width="104" class="slide_preview admin-add-border" src="<?php echo $img_src ?>" alt="" class="admin-add-border" />


                                                <label><?php _e("Choose Image", TMM_THEME_FOLDER_NAME) ?></label>

                                                <div class="admin-file clearfix">
                                                    <input type="text" name="sliders[<?php echo $group_key ?>][options][<?php echo $slide_key ?>][image]" value="<?php echo $item['image'] ?>" class="slide_preview_link" />
                                                    <a href="#" class="admin-button button-gray button-medium button_upload"><?php _e("Upload", TMM_THEME_FOLDER_NAME) ?></a>
                                                </div><!--/ .admin-file-->

                                                <p class="slider_title">
                                                    <label><?php _e("Slide Title", TMM_THEME_FOLDER_NAME) ?></label>
                                                    <input type="text" class="fullwidth" name="sliders[<?php echo $group_key ?>][options][<?php echo $slide_key ?>][title]" value="<?php echo $item['title'] ?>" />
                                                </p>


                                                <p class="slider_description">
                                                    <label><?php _e("Slide Description", TMM_THEME_FOLDER_NAME) ?></label>
                                                    <textarea name="sliders[<?php echo $group_key ?>][options][<?php echo $slide_key ?>][description]"><?php echo $item['description'] ?></textarea>
                                                </p>

                                                <p>
                                                    <label><?php _e("Slide Link", TMM_THEME_FOLDER_NAME) ?></label>
                                                    <input type="text" class="fullwidth" name="sliders[<?php echo $group_key ?>][options][<?php echo $slide_key ?>][link]" placeholder="http://themeforest.net" value="<?php echo $item['link'] ?>" />
                                                </p>

                                                <p>
                                                    <a href="#slide_additional_features_<?php echo $group_key ?>_<?php echo $slide_key ?>" class="slide_additional_features_link admin-button button-gray button-medium"><?php _e("Advanced options", TMM_THEME_FOLDER_NAME) ?></a>


                                                    <input type="hidden" id="slide_title_color_<?php echo $group_key ?>_<?php echo $slide_key ?>" name="sliders[<?php echo $group_key ?>][options][<?php echo $slide_key ?>][additional][slide_title_color]" value="<?php echo @$item['additional']['slide_title_color'] ?>" />
                                                    <input type="hidden" id="slide_description_color_<?php echo $group_key ?>_<?php echo $slide_key ?>" name="sliders[<?php echo $group_key ?>][options][<?php echo $slide_key ?>][additional][slide_description_color]" value="<?php echo @$item['additional']['slide_description_color'] ?>" />



                                                </p>

                                            </div><!--/ .admin-drag-holder-->




                                        </li>

                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>


                            <!-- additional features -->
                            <div style="display: none;">
                                <ul id="slide_additional_features_list_<?php echo $group_key ?>">

                                    <?php if (!empty($slide['options'])): ?>
                                        <?php foreach ($slide['options'] as $slide_key => $item) : ?>
                                            <?php $slide_key = $slide_key + 1000; ?>
                                            <li class="list_item_<?php echo $group_key ?>_<?php echo $slide_key ?>">
                                                <div class="slide_additional_features" id="slide_additional_features_<?php echo $group_key ?>_<?php echo $slide_key ?>">



                                                    <h4><?php _e("Title text color", TMM_THEME_FOLDER_NAME) ?></h4>
                                                    <input data-id="slide_title_color_<?php echo $group_key ?>_<?php echo $slide_key ?>" type="text" value="<?php echo @$item['additional']['slide_title_color'] ?>" style="width: 215px;" class="bg_hex_color text slide_info_box_background_color"><div style="background-color: <?php echo @$item['additional']['slide_title_color'] ?>;" class="bgpicker"></div>

                                                    <div class="clear"></div>
                                                    <br />


                                                    <h4><?php _e("Description text color", TMM_THEME_FOLDER_NAME) ?></h4>
                                                    <input data-id="slide_description_color_<?php echo $group_key ?>_<?php echo $slide_key ?>" type="text" value="<?php echo @$item['additional']['slide_description_color'] ?>" style="width: 215px;" class="bg_hex_color text slide_info_box_background_color"><div style="background-color: <?php echo @$item['additional']['slide_description_color'] ?>;" class="bgpicker"></div>

                                                    <div class="clear"></div>
                                                    <br />
                                                    

                                                    <br />
                                                    <a class="admin-button button-gray button-medium" href="javascript:jQuery.fancybox.close();"><?php _e("Close", TMM_THEME_FOLDER_NAME) ?></a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>


                        </div><!--/ .slider-holder-->


                    </div><!--/ .add-holder-sliders-->




                    <?php if ($slide_key != count($slides) - 1): ?>
                        <hr class="admin-divider" />
                    <?php endif; ?>

                </div><!--/ #tab-->
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>

<?php endif; ?>





<div style="display: none;">

    <div id="slide_template">

        <li style="display: none;" class="list_item___GROUP_INDEX_____SLIDE_INDEX__">


            <div class="admin-drag-holder clearfix slide_view_container" style="display: none; height: 0;">

                <a title="<?php _e("Delete Slide", TMM_THEME_FOLDER_NAME) ?>" class="close-drag-holder button_delete_slide" href="#" list-item="list_item___GROUP_INDEX_____SLIDE_INDEX__"></a>
                <a title="<?php _e("Edit Slide", TMM_THEME_FOLDER_NAME) ?>" class="edit-drag-holder edit_slider_item" href="#"></a>


                <img width="104" class="slide_preview admin-add-border" src="<?php echo TMM_THEME_URI; ?>/admin/images/noimage.png" alt="" class="admin-add-border" />

                <h3></h3>
                <p></p>
            </div>

            <div class="admin-drag-holder clearfix slide_edit_container">

                <a href="#" class="close-drag-holder button_delete_slide" title="<?php _e("Delete Slide", TMM_THEME_FOLDER_NAME) ?>"></a>
                <a href="#" class="check-drag-holder stop_edit_slider_item" title="<?php _e("Apply Slide Edition", TMM_THEME_FOLDER_NAME) ?>"></a>

                <img width="104" class="slide_preview admin-add-border" src="<?php echo TMM_THEME_URI; ?>/admin/images/noimage.png" alt="" class="admin-add-border" />

                <label><?php _e("Choose Image", TMM_THEME_FOLDER_NAME) ?></label>

                <div class="admin-file clearfix">
                    <input type="text" name="sliders[__GROUP_INDEX__][options][__SLIDE_INDEX__][image]" class="slide_preview_link" />

                    <a href="#" class="admin-button button-gray button-medium button_upload"><?php _e("Upload", TMM_THEME_FOLDER_NAME) ?></a>

                </div><!--/ .admin-file-->

                <p class="slider_title">
                    <label><?php _e("Slide Title", TMM_THEME_FOLDER_NAME) ?></label>
                    <input type="text" class="fullwidth" name="sliders[__GROUP_INDEX__][options][__SLIDE_INDEX__][title]" />
                </p>



                <p class="slider_description">
                    <label><?php _e("Slide Description", TMM_THEME_FOLDER_NAME) ?></label>
                    <textarea name="sliders[__GROUP_INDEX__][options][__SLIDE_INDEX__][description]"></textarea>
                </p>



                <p>
                    <label><?php _e("Slide Link", TMM_THEME_FOLDER_NAME) ?></label>
                    <input type="text" class="fullwidth" name="sliders[__GROUP_INDEX__][options][__SLIDE_INDEX__][link]" placeholder="http://themeforest.net" value="" />
                </p>


                <p>
                    <a href="#slide_additional_features___GROUP_INDEX_____SLIDE_INDEX__" class="slide_additional_features_link admin-button button-gray button-medium"><?php _e("Advanced options", TMM_THEME_FOLDER_NAME) ?></a>


                    <input type="hidden" id="slide_title_color___GROUP_INDEX_____SLIDE_INDEX__" name="sliders[__GROUP_INDEX__][options][__SLIDE_INDEX__][additional][slide_title_color]" value="" />
                    <input type="hidden" id="slide_description_color___GROUP_INDEX_____SLIDE_INDEX__" name="sliders[__GROUP_INDEX__][options][__SLIDE_INDEX__][additional][slide_description_color]" value="" />

                    
                </p>

            </div><!--/ .admin-drag-holder-->
        </li>

    </div>


    <div id="group_template">

        <div id="slider_group___INDEX__" class="tab-content" style="display: none;">
            <div class="add-holder-sliders clearfix">
                <div class="slider-holder">
                    <span class="slider-group-title">__NAME__</span>
                    <a class="add-slider-group" href="#" group-index="__GROUP_INDEX__" title="Add Slide"></a>
                    <a class="remove-slider-group" href="#" group-index="__GROUP_INDEX__" title="Delete Group"></a>
                    <ul class="sliders_list ui-sortable"></ul>
                    <div style="display: none;">
                        <ul id="slide_additional_features_list___GROUP_INDEX__"></ul>
                    </div>
                </div><!--/ .slider-holder-->
            </div><!--/ .add-holder-sliders-->
        </div>

    </div>


    <div id="slide_additional_features_template">
        <li class="list_item___GROUP_INDEX_____SLIDE_INDEX__">
            <div class="slide_additional_features" id="slide_additional_features___GROUP_INDEX_____SLIDE_INDEX__">

                <h4><?php _e("Title text color", TMM_THEME_FOLDER_NAME) ?></h4>
                <input data-id="slide_title_color___GROUP_INDEX_____SLIDE_INDEX__" type="text" value="#ffffff" style="width: 215px;" class="bg_hex_color text slide_info_box_background_color"><div style="background-color: #ffffff;" class="bgpicker"></div>

                <div class="clear"></div>
                <hr class="admin-divider" />

                <br />
                <h4><?php _e("Description text color", TMM_THEME_FOLDER_NAME) ?></h4>
                <input data-id="slide_description_color___GROUP_INDEX_____SLIDE_INDEX__" type="text" value="#ffffff" style="width: 215px;" class="bg_hex_color text slide_info_box_background_color"><div style="background-color: #ffffff;" class="bgpicker"></div>

                <div class="clear"></div>
                <br />
              


              


                
                


                
                


                <br />
                <a class="admin-button button-gray button-medium" href="javascript:jQuery.fancybox.close();"><?php _e("Close", TMM_THEME_FOLDER_NAME) ?></a>
            </div>
        </li>
    </div>



    <div id="revolution_slider_options">

        <li type="__TYPE__" class="revolution_item_options___GROUP_INDEX_____SLIDE_INDEX_____KEY__">
            <div class="js_slider_revolution_item_options">
                <h4><?php _e("Slide options", TMM_THEME_FOLDER_NAME) ?></h4>
                <ul>
                    <li>
                        <label><?php _e("Type", TMM_THEME_FOLDER_NAME) ?>:</label> __TYPE__<input type="hidden" value="__TYPE__" /><br />
                    </li>
                    <li>
                        <label>&nbsp;</label> <textarea class="fullwidth revolution_slide_content" onkeyup="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___content')"></textarea>

                        &nbsp;<a href="#" class="admin-button button-gray button-medium button_upload"><?php _e("Upload", TMM_THEME_FOLDER_NAME) ?></a>

                        <br />
                    </li>
                    <li>
                        <label><?php _e("Inline Styles (optional)", TMM_THEME_FOLDER_NAME) ?>:</label> <textarea class="fullwidth" onkeyup="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___styles')"></textarea>
                        <br />
                    </li>
                    <li>
                        <label><?php _e("Preset styles", TMM_THEME_FOLDER_NAME) ?>:</label>
                        <?php $preset_styles = array('big_white' => 'Big White', 'big_orange' => 'Big Orange', 'big_black' => 'Big Black', 'very_big_white' => 'Very Big White', 'medium_text' => 'Medium Text', 'medium_grey' => 'Medium Grey', 'small_text' => 'Small Text', 'boxshadow' => 'Boxshadow'); ?>
                        <select class="exclude_uniform_on_load" onchange="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___preset_styles')">
                            <?php foreach ($preset_styles as $style => $style_name) : ?>
                                <option value="<?php echo $style ?>"><?php echo $style_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br />
                    </li>
                    <li>
                        <label><?php _e("Move direction", TMM_THEME_FOLDER_NAME) ?>:</label>
                        <?php $move_direction = array('fade' => 'Fading', 'lft' => 'Long from Top', 'lfr' => 'Long from Right', 'lfb' => 'Long from Bottom', 'lfl' => 'Long from Left', 'sft' => 'Short from Top', 'sfr' => 'Short from Right', 'sfb' => 'Short from Bottom', 'sfl' => 'Short from Left'); ?>
                        <select class="exclude_uniform_on_load" onchange="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___move_direction')">
                            <?php foreach ($move_direction as $direction_key => $direction) : ?>
                                <option value="<?php echo $direction_key ?>"><?php echo $direction ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br />
                    </li>
                    <li>
                        <label><?php _e("Width (image,video)", TMM_THEME_FOLDER_NAME) ?>:</label> <input type="text" value="50" onkeyup="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___width')" /><br />
                    </li>
                    <li>
                        <label><?php _e("Height (image,video)", TMM_THEME_FOLDER_NAME) ?>:</label> <input type="text" value="50" onkeyup="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___height')" /><br />
                    </li>
                    <li>
                        <label><?php _e("Data X", TMM_THEME_FOLDER_NAME) ?>:</label> <input type="text" value="0" onkeyup="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___data_x')" /><br />
                    </li>
                    <li>
                        <label><?php _e("Data Y", TMM_THEME_FOLDER_NAME) ?>:</label> <input type="text" value="0" onkeyup="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___data_y')" /><br />
                    </li>
                    <li>
                        <label><?php _e("Data speed", TMM_THEME_FOLDER_NAME) ?>:</label> <input type="text" value="777" onkeyup="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___data_speed')" /><br />
                    </li>
                    <li>
                        <label><?php _e("Data start", TMM_THEME_FOLDER_NAME) ?>:</label> <input type="text" value="777" onkeyup="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___data_start')" /><br />
                    </li>
                    <li>
                        <label><?php _e("Data easing", TMM_THEME_FOLDER_NAME) ?>:</label>
                        <?php $data_easings = array('easeOutExpo', 'easeOutBack', 'easeOutSine'); ?>
                        <select class="exclude_uniform_on_load" onchange="set_additional_data(this, 'sliders___GROUP_INDEX___options___SLIDE_INDEX___additional_revolution_items___KEY___data_easing')">
                            <?php foreach ($data_easings as $data_easing) : ?>
                                <option value="<?php echo $data_easing ?>"><?php echo $data_easing ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br />
                    </li>
                </ul>
            </div>
        </li>

    </div>



</div>

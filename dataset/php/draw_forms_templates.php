<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div style="display: none;" id="contact_form_template">
	
    <div class="form-holder">
		
        <input type="hidden" name="contact_form[__INIQUE_ID__][inique_id]" value="__INIQUE_ID__" />
        <span class="form-group-title"><input type="text" class="form_name" value="__FORM_NAME__" name="contact_form[__INIQUE_ID__][title]"></span>
        
		<div class="switch">
            <label><input type="checkbox" class="form_captcha option_checkbox" />
                <input type="hidden" name="contact_form[__INIQUE_ID__][has_capture]" value="0" /><?php _e('Enable Captcha Protection', TMM_THEME_FOLDER_NAME); ?></label>
            <input type="hidden" name="contact_form_index" value="__INIQUE_ID__" />
        </div><!--/ .switch-->
		
        <a href="#" class="add-button add_contact_field_button add-slider-group" form-id="__INIQUE_ID__"></a>
        <a href="#" class="delete_contact_form remove-button remove-slider-group" form-list-index="__INIQUE_ID__"></a><br />

        <div class="admin-drag-holder clearfix">
			
            <p>
             <label><?php _e('Select submit button', TMM_THEME_FOLDER_NAME); ?></label>

            <div class="contact_form_submit_button">
                <?php
                $buttons = ThemeMakersHelper::get_theme_buttons();
                $buttons_sizes = ThemeMakersHelper::get_theme_buttons_sizes();
                ?>

                <select name="contact_form[__INIQUE_ID__][submit_button]">
                    <?php foreach ($buttons as $code => $name) : ?>
                        <option value="<?php echo $code ?>"><?php echo $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
			
            </p>
            
            
             <p>
                <label><?php _e('Recipient\'s e-mail field:', TMM_THEME_FOLDER_NAME); ?></label>
                <input type="text" name="contact_form[__INIQUE_ID__][recepient_email]" value="" />                
            </p>
			
        </div>



        <ul class="drag_contact_form_list">
			
            <li class="admin-drag-holder clearfix">

                <a href="#" class="delete_contact_field_button close-drag-holder"></a>

                <p>
                    <label><?php _e('Choose Field Type', TMM_THEME_FOLDER_NAME); ?></label>
                    <?php echo $form_constructor->get_types_select("contact_form[__INIQUE_ID__][inputs][0][type]") ?>
                </p>

                <p>
                    <label><?php _e('Field Label', TMM_THEME_FOLDER_NAME); ?></label>
                    <input type="text" value="" class="label" name="contact_form[__INIQUE_ID__][inputs][0][label]">
                </p>
                <div class="select_options" style="display: none;">
                    <p>
                        <label><?php _e('Options (comma separated)', TMM_THEME_FOLDER_NAME); ?></label>
                        <input type="text" value="" class="options" name="contact_form[__INIQUE_ID__][inputs][0][options]">
                    </p>
                </div>

                <p>
                    <label><?php _e('Additional Options', TMM_THEME_FOLDER_NAME); ?></label>
                    <label class="with-check">
                        <input type="checkbox" class="form_required option_checkbox" />
                        <input type="hidden" name="contact_form[__INIQUE_ID__][inputs][0][is_required]" value="0" />
                        &nbsp;<?php _e('Required Field', TMM_THEME_FOLDER_NAME); ?>
                    </label>
                </p>

            </li><!--/ .admin-drag-holder-->
			
        </ul>


    </div><!--/ .form-holder-->
</div>

<div style="display: none;" id="contact_form_field_template">

    <li class="admin-drag-holder clearfix">

        <a href="#" class="delete_contact_field_button close-drag-holder"></a>

        <p>
            <label><?php _e('Choose Field Type', TMM_THEME_FOLDER_NAME); ?></label>
            <?php echo $form_constructor->get_types_select("contact_form[__INDEX__][inputs][__INPUTINDEX__][type]") ?>
        </p>

        <p>
            <label><?php _e('Field Label', TMM_THEME_FOLDER_NAME); ?></label>
            <input type="text" value="" class="label" name="contact_form[__INDEX__][inputs][__INPUTINDEX__][label]">
        </p>
        <div class="select_options" style="display: none;">
            <p>
                <label><?php _e('Options (comma separated)', TMM_THEME_FOLDER_NAME); ?></label>
                <input type="text" value="" class="options" name="contact_form[__INDEX__][inputs][__INPUTINDEX__][options]">
            </p>
        </div>

        <p>
            <label><?php _e('Additional Options', TMM_THEME_FOLDER_NAME); ?></label>
            <label class="with-check">
                <input type="checkbox" class="form_required option_checkbox" />
                <input type="hidden" name="contact_form[__INDEX__][inputs][__INPUTINDEX__][is_required]" value="0" />
                &nbsp;<?php _e('Required Field', TMM_THEME_FOLDER_NAME); ?>
            </label>
        </p>

    </li><!--/ .admin-drag-holder-->

</div>




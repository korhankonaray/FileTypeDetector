<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div id="contact_forms">
    <?php
    if (is_string($contact_forms) AND !empty($contact_forms)) {
        $contact_forms = unserialize($contact_forms);
    }
    ?>


    <?php if (!empty($contact_forms) AND is_array($contact_forms)) : ?>
        <?php $counter = 0; ?>
        <?php foreach ($contact_forms as $contact_form) : ?>
            <div id="contact_form_<?php echo $counter ?>" class="tab-content" style="display: none">
                <?php
                $form_index = 0;
                if (isset($contact_form['inique_id'])) {
                    $form_index = $contact_form['inique_id'];
                } else {
                    $form_index = uniqid();
                }
                ?>
				
                <input type="hidden" name="contact_form[<?php echo $form_index; ?>][inique_id]" value="<?php echo $form_index ?>" />
                
				<div class="form-holder">

                    <span class="form-group-title"><input type="text" class="form_name" value="<?php echo $contact_form['title'] ?>" name="contact_form[<?php echo $form_index; ?>][title]"></span>
                   
					<div class="switch">
                        <label><input type="checkbox" <?php echo($contact_form['has_capture'] ? "checked" : "") ?> class="form_captcha option_checkbox" />
                            <input type="hidden" name="contact_form[<?php echo $form_index; ?>][has_capture]" value="<?php echo($contact_form['has_capture'] ? 1 : 0) ?>" /><?php _e('Enable Captcha Protection', TMM_THEME_FOLDER_NAME); ?></label>
                        <input type="hidden" name="contact_form_index" value="<?php echo $form_index; ?>" />
                    </div>
					
                    <a href="#" class="add-button add_contact_field_button add-slider-group" form-id="<?php echo $form_index ?>"></a>
                    <a href="#" class="delete_contact_form remove-button remove-slider-group" form-list-index="<?php echo $counter ?>"></a><br />

                    <div class="admin-drag-holder clearfix">
						
                        <p>
                            <label><?php _e('Select submit button', TMM_THEME_FOLDER_NAME); ?></label>
							
                        <div class="contact_form_submit_button">
                            <?php
                            $buttons = ThemeMakersHelper::get_theme_buttons();
                            $buttons_sizes = ThemeMakersHelper::get_theme_buttons_sizes();
                            ?>

                            <select name="contact_form[<?php echo $form_index; ?>][submit_button]">
                                <?php foreach ($buttons as $code => $name) : ?>
                                    <option <?php echo(@$contact_form['submit_button'] == $code ? "selected" : "") ?> value="<?php echo $code ?>"><?php echo $name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
						
                        </p>
                        
                        
                          <p>
                            <label><?php _e('Recipient\'s e-mail field:', TMM_THEME_FOLDER_NAME); ?></label>
                            <input type="text" name="contact_form[<?php echo $form_index; ?>][recepient_email]" value="<?php echo @$contact_form['recepient_email'] ?>" />                
                        </p>

                    </div>

                    <ul class="drag_contact_form_list">
                        <?php if (!empty($contact_form['inputs'])) : ?>
                            <?php foreach ($contact_form['inputs'] as $key_input => $input) : ?>
                                <?php $key_input = uniqid(); ?>
                                <li class="admin-drag-holder clearfix">

                                    <a href="#" class="delete_contact_field_button close-drag-holder"></a>

                                    <p>
                                        <label><?php _e('Choose Field Type', TMM_THEME_FOLDER_NAME); ?></label>
                                        <?php echo $form_constructor->get_types_select("contact_form[$form_index][inputs][$key_input][type]", $input['type']) ?>
                                    </p>

                                    <p>
                                        <label><?php _e('Field Label', TMM_THEME_FOLDER_NAME); ?></label>
                                        <input type="text" value="<?php echo $input['label']; ?>" class="label" name="contact_form[<?php echo $form_index; ?>][inputs][<?php echo $key_input; ?>][label]">
                                    </p>
                                    <div class="select_options" style="display: <?php echo($input['type'] == "select" ? "block" : "none") ?>;">
                                        <p>
                                            <label><?php _e('Options (comma separated)', TMM_THEME_FOLDER_NAME); ?></label>
                                            <input type="text" value="<?php echo $input['options'] ?>" class="options" name="contact_form[<?php echo $form_index; ?>][inputs][<?php echo $key_input; ?>][options]">
                                        </p>
                                    </div>

                                    <p>
                                        <label><?php _e('Additional Options', TMM_THEME_FOLDER_NAME); ?></label>
                                        <label class="with-check">
                                            <input type="checkbox" <?php echo($input['is_required'] ? "checked" : "") ?> class="form_required option_checkbox" />
                                            <input type="hidden" name="contact_form[<?php echo $form_index; ?>][inputs][<?php echo $key_input; ?>][is_required]" value="<?php echo($input['is_required'] ? 1 : 0) ?>" />
                                            &nbsp;<?php _e('Required Field', TMM_THEME_FOLDER_NAME); ?>
                                        </label>
                                    </p>

                                </li><!--/ .admin-drag-holder-->

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>


                </div><!--/ .form-holder-->
            </div>
            <?php $counter++; ?>
        <?php endforeach; ?>
    <?php endif; ?>

</div>


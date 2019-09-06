<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" name="tmm_meta_saving" value="1" />
<a href="javascript:tmm_ext_layout_constructor.add_row(); void(0);" class="button button-primary button-large"><?php _e("Add New Row", TMM_THEME_FOLDER_NAME) ?></a><br />

<ul id="layout_constructor_items" class="page-methodology" style="clear: both; display: none;">
	<?php if (!empty($tmm_layout_constructor)): ?>
		<?php foreach ($tmm_layout_constructor as $row => $row_data) : ?>
			<?php
			if (!is_integer($row)) {
				//continue;
			}
			?>
			<li id="layout_constructor_row_<?php echo $row ?>" class="layout_constructor_item">
				<table>
					<tr>
						<td>
							<a href="javascript:tmm_ext_layout_constructor.add_column(<?php echo $row ?>);void(0);" class="button" style="width: 110px;text-align:center;margin-right:5px;"><?php _e("Add Column", TMM_THEME_FOLDER_NAME) ?></a><br />
							<a href="javascript:tmm_ext_layout_constructor.edit_row(<?php echo $row ?>);void(0);" class="button" style="width: 45px;"><?php _e("Edit", TMM_THEME_FOLDER_NAME) ?></a><a href="javascript:tmm_ext_layout_constructor.delete_row(<?php echo $row ?>);void(0);" class="button" style="width: 60px;margin:0 0 0 5px;"><?php _e("Delete", TMM_THEME_FOLDER_NAME) ?></a>
						</td>
						<td class="col_items">
							<span class="row_columns_container" id="row_columns_container_<?php echo $row ?>">
								<?php if (!empty($row_data)): ?>
									<?php foreach ($row_data as $uniqid => $column) : ?>
										<?php
										if ($uniqid == 'row_data') {
											continue;
										}
										?>
										<?php TMM_Ext_LayoutConstructor::draw_column_item($row, $uniqid, $column['css_class'], $column['front_css_class'], $column['value'], $column['content'], $column['title']) ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</span>
						</td>
						<td><div class="row-mover"><?php _e("Row Mover", TMM_THEME_FOLDER_NAME) ?></div></td>
					</tr>
				</table>

				<input type="hidden" id="row_bg_type_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_type'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_type]" />
				<input type="hidden" id="row_bg_data_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['bg_data'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][bg_data]" />
				<input type="hidden" id="row_border_type_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['border_type'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][border_type]" />
				<input type="hidden" id="row_border_width_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['border_width'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][border_width]" />
				<input type="hidden" id="row_border_color_<?php echo $row ?>" value="<?php echo (isset($tmm_layout_constructor_row[$row]) ? @$tmm_layout_constructor_row[$row]['border_color'] : '') ?>" name="tmm_layout_constructor_row[<?php echo $row ?>][border_color]" />

			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>


<div style="display: none;">
	<div id="layout_constructor_column_item">
		<?php TMM_Ext_LayoutConstructor::draw_column_item('__ROW_ID__', '__UNIQUE_ID__', 'element1-4', 'four columns', '1/4', "", "") ?>
	</div>
	<div id="layout_constructor_column_row">
		<li id="layout_constructor_row___ROW_ID__" class="layout_constructor_item">
			<table>
				<tr>
					<td>
						<a href="javascript:tmm_ext_layout_constructor.add_column(__ROW_ID__);void(0);" class="button" style="width: 110px;text-align:center;margin-right:5px;"><?php _e("Add Column", TMM_THEME_FOLDER_NAME) ?></a><br />
						<a href="javascript:tmm_ext_layout_constructor.edit_row(__ROW_ID__);void(0);" class="button" style="width: 45px;"><?php _e("Edit", TMM_THEME_FOLDER_NAME) ?></a><a href="javascript:tmm_ext_layout_constructor.delete_row(__ROW_ID__);void(0);" class="button" style="width: 60px;margin:0 0 0 5px;"><?php _e("Delete", TMM_THEME_FOLDER_NAME) ?></a>
					</td>
					<td class="col_items">
						<span class="row_columns_container" id="row_columns_container___ROW_ID__"></span>
					</td>
					<td><div class="row-mover"><?php _e("Row Mover", TMM_THEME_FOLDER_NAME) ?></div></td>
				</tr>
			</table>
			<input type="hidden" id="row_bg_type___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][bg_type]" />
			<input type="hidden" id="row_bg_data___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][bg_data]" />
			<input type="hidden" id="row_border_type___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][border_type]" />
			<input type="hidden" id="row_border_width___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][border_width]" />
			<input type="hidden" id="row_border_color___ROW_ID__" value="" name="tmm_layout_constructor_row[__ROW_ID__][border_color]" />
		</li>
	</div>

	<!-------------------------- DIALOGs TEMPLATES ----------------------------------------- -->


	<div style="display: none;">
		<div id="layout_constructor_layout_dialog"></div>
		<div id="layout_constructor_row_dialog">
			<div class="tmm_shortcode_template clearfix">
				<div class="one-half">
					<?php
					Thememakers_Application_Shortcodes::draw_shortcode_option(array(
						'type' => 'select',
						'title' => __('Row Background Type', TMM_THEME_FOLDER_NAME),
						'shortcode_field' => 'row_background_type',
						'id' => 'row_background_type',
						'options' => array(
							'color' => __('Color', TMM_THEME_FOLDER_NAME),
							'image' => __('Image', TMM_THEME_FOLDER_NAME),
						),
						'default_value' => 'color',
						'description' => ''
					));
					?>
				</div>
				<div class="clear"></div>
				<div class="one-half" id="row_background_color_box" style="display: none;">
					<?php
					Thememakers_Application_Shortcodes::draw_shortcode_option(array(
						'title' => __('Background Color', TMM_THEME_FOLDER_NAME),
						'shortcode_field' => 'row_background_color',
						'type' => 'color',
						'description' => '',
						'default_value' => '',
						'id' => 'row_background_color'
					));
					?>
				</div>
				<div class="clear"></div>
				<div class="one-half" id="row_background_image_box" style="display: none;">
					<?php
					Thememakers_Application_Shortcodes::draw_shortcode_option(array(
						'type' => 'upload',
						'title' => __('Background Image', TMM_THEME_FOLDER_NAME),
						'shortcode_field' => 'row_background_image',
						'id' => 'row_background_image',
						'default_value' => '',
						'description' => ''
					));
					?>

				</div>
				<div class="clear"></div>
				<div class="one-half">
					<?php
					Thememakers_Application_Shortcodes::draw_shortcode_option(array(
						'type' => 'select',
						'title' => __('Border width', TMM_THEME_FOLDER_NAME),
						'shortcode_field' => 'row_border_width',
						'id' => 'row_border_width',
						'options' => array(
							0 => 0,
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
							5 => 5,
						),
						'default_value' => 0,
						'description' => ''
					));
					?>
				</div>
				<div class="clear"></div>
				<div class="one-half">
					<?php
					Thememakers_Application_Shortcodes::draw_shortcode_option(array(
						'type' => 'select',
						'title' => __('Border type', TMM_THEME_FOLDER_NAME),
						'shortcode_field' => 'row_border_type',
						'id' => 'row_border_type',
						'options' => array(
							'solid' => __('Solid', TMM_THEME_FOLDER_NAME),
							'dashed' => __('Dashed', TMM_THEME_FOLDER_NAME),
							'dotted' => __('Dotted', TMM_THEME_FOLDER_NAME),
						),
						'default_value' => 'solid',
						'description' => ''
					));
					?>
				</div>
				<div class="clear"></div>

				<div class="one-half">
					<?php
					Thememakers_Application_Shortcodes::draw_shortcode_option(array(
						'title' => __('Border Color', TMM_THEME_FOLDER_NAME),
						'shortcode_field' => 'row_border_color',
						'type' => 'color',
						'description' => '',
						'default_value' => '',
						'id' => 'row_border_color'
					));
					?>
				</div>


			</div>

			<div class="clear"></div>
		</div>
	</div>

</div>
<!-- programmer realmag777 -->

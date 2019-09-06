<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" value="1" name="thememakers_meta_saving" />

<table class="form-table">
    <tbody>
        <tr>
            <th style="width:25%">
                <label for="portfolio_date">
                    <strong><?php _e('Release Date', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
                <input type="text" style="width:75%; margin-right: 20px; float:left;" size="30" value="<?php echo $portfolio_date ?>" id="portfolio_date" name="portfolio_date">
            </td>
        </tr>
        <tr style="border-top:1px solid #eeeeee;">
            <th style="width:25%">
                <label for="portfolio_url">
                    <strong><?php _e('Project URL', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"><?php _e('For example', TMM_THEME_FOLDER_NAME); ?> http://demolink.org</span>
                </label>
            </th>
            <td>
                <input type="text" style="width:75%; margin-right: 20px; float:left;" size="30" value="<?php echo $portfolio_url ?>" id="portfolio_url" name="portfolio_url">
            </td>
        </tr>
        <tr style="border-top:1px solid #eeeeee;">
            <th style="width:25%">
                <label for="portfolio_url_title">
                    <strong><?php _e('URL Title', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"></span>
                </label>
            </th>
            <td>
                <input type="text" style="width:75%; margin-right: 20px; float:left;" size="30" value="<?php echo $portfolio_url_title ?>" id="portfolio_url_title" name="portfolio_url_title">
            </td>
        </tr>
        <tr style="border-top:1px solid #eeeeee;">
            <th style="width:25%">
                <label for="portfolio_tools">
                    <strong><?php _e('Tools', TMM_THEME_FOLDER_NAME); ?></strong>
                    <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;"><?php _e('Tools used to create this portfolio.', TMM_THEME_FOLDER_NAME); ?></span>
                </label>
            </th>
            <td>
                <input type="text" style="width:75%; margin-right: 20px; float:left;" size="30" value="<?php echo $portfolio_tools ?>" id="portfolio_tools" name="portfolio_tools">
            </td>
        </tr>


        <?php
        global $post;
        if ($post->post_type != 'gall'):
            ?>

            <tr style="border-top:1px solid #eeeeee;">
                <th style="width:25%">
                    <label for="thememakers_portfolio">
                        <strong><?php _e('Media Gallery', TMM_THEME_FOLDER_NAME); ?></strong>
                        <span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">
                            <?php _e('Add or remove media fields.', TMM_THEME_FOLDER_NAME); ?>
                        </span>
                    </label>
                </th>
                <td>
                    <a href="#" style="float:left;" class="repeatable-add button"><?php _e('Add Field', TMM_THEME_FOLDER_NAME); ?></a>
                </td>
            </tr>

            <?php if (!empty($thememakers_portfolio) AND is_array($thememakers_portfolio)): ?>
                <?php foreach ($thememakers_portfolio as $key => $value) : ?>
                    <tr style="border-top:1px solid #eeeeee;" class="repeatable-field">
                        <th style="width:25%"></th>
                        <td>
                            <input type="text" style="width:75%; margin-right: 20px; float:left;" size="30" value="<?php echo $value; ?>" class="" name="thememakers_portfolio[]">
                            <a class="button image-button" href="#" style="float: left;"><?php _e('Browse', TMM_THEME_FOLDER_NAME); ?></a>
                            <a href="#" class="repeatable-remove button" style="float:left;margin-left:10px;"><?php _e('Remove', TMM_THEME_FOLDER_NAME); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr style="border-top:1px solid #eeeeee;" class="repeatable-field">
                    <th style="width:25%"></th>
                    <td>
                        <input type="text" style="width:75%; margin-right: 20px; float:left;" size="30" value="" class="" name="thememakers_portfolio[]">
                        <a class="button image-button" href="#" style="float: left;"><?php _e('Browse', TMM_THEME_FOLDER_NAME); ?></a>
                        <a href="#" class="repeatable-remove button" style="float:left;margin-left:10px;"><?php _e('Remove', TMM_THEME_FOLDER_NAME); ?></a>
                    </td>
                </tr>
            <?php endif; ?>

        <?php endif; ?>

    </tbody>
</table>
<div id="thememakers_image_buffer"></div>
<?php if ($post->post_type != 'gall'): ?>
    <?php wp_enqueue_script('thememakers_theme_admin_gallery_js', TMM_THEME_URI . '/admin/js/gallery.js'); ?>
<?php endif; ?>


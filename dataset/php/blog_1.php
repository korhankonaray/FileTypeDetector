<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div id="thememakers_shortcode_template" class="thememakers_shortcode_template clearfix">

    <div class="one-half">
        <h4 class="label"><?php _e('Blog Title', TMM_THEME_FOLDER_NAME); ?></h4>
        <input type="text" value="<?php _e('Blog', TMM_THEME_FOLDER_NAME); ?>" class="js_shortcode_template_changer data-input" data-shortcode-field="title">
    </div><!--/ .ona-half-->

    <div class="one-half">
        <h4 class="label"><?php _e('Blog View', TMM_THEME_FOLDER_NAME); ?></h4>
        <select class="js_shortcode_template_changer data-select" data-shortcode-field="blog_view">
            <option value="default"><?php _e('Default Blog Layout', TMM_THEME_FOLDER_NAME); ?></option>
            <option value="alternate"><?php _e('Alternate Blog Layout', TMM_THEME_FOLDER_NAME); ?></option>
        </select>
    </div><!--/ .ona-half-->

    <div class="one-half">
        <h4 class="label"><?php _e('Category', TMM_THEME_FOLDER_NAME); ?></h4>
        <?php $post_categories = ThemeMakersHelper::get_post_categories(); ?>
        <select class="js_shortcode_template_changer data-select" data-shortcode-field="category">
            <?php if (!empty($post_categories)): ?>
                <?php foreach ($post_categories as $term_id => $name) : ?>
                    <option value="<?php echo $term_id ?>"><?php echo $name ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div><!--/ .ona-half-->

    <div class="one-half">
        <h4 class="label"><?php _e('Order By', TMM_THEME_FOLDER_NAME); ?></h4>
        <?php $post_sort = ThemeMakersHelper::get_post_sort_array(); ?>
        <select class="js_shortcode_template_changer data-select" data-shortcode-field="orderby">

            <?php if (!empty($post_sort)): ?>
                <?php foreach ($post_sort as $sort) : ?>
                    <option value="<?php echo $sort ?>"><?php echo $sort ?></option>
                <?php endforeach; ?>
            <?php endif; ?>

        </select>
    </div><!--/ .ona-half-->

    <div class="one-half">
        <h4 class="label"><?php _e('Order', TMM_THEME_FOLDER_NAME); ?></h4>
        <div class="radio-holder">
            <input checked="" type="radio" name="order" id="order_desc" value="DESC" class="js_shortcode_radio_self_update" />
            <label for="order_desc" class="label-form"><span></span>DESC</label>
            <input type="radio" name="order" value="ASC" id="order_asc" class="js_shortcode_radio_self_update" />
            <label for="order_asc" class="label-form"><span></span>ASC</label>
            <input type="hidden" value="DESC" class="js_shortcode_template_changer" data-shortcode-field="order" />
        </div><!--/ .radio-holder-->
    </div><!--/ .ona-half-->

    <div class="one-half">
        <h4 class="label"><?php _e('Posts Per Page', TMM_THEME_FOLDER_NAME); ?></h4>
        <input type="text" value="10" class="js_shortcode_template_changer data-input" data-shortcode-field="posts_per_page">
    </div><!--/ .ona-half-->

    <div class="one-half">
        <h4 class="label"><?php _e('Posts', TMM_THEME_FOLDER_NAME); ?></h4>
        <input type="text" value="" class="js_shortcode_template_changer data-input" data-shortcode-field="posts">
        <span class="preset_description"><?php _e('Example: 56,73,119', TMM_THEME_FOLDER_NAME); ?></span>
    </div><!--/ .ona-half-->


    <div class="one-half">
        <h4 class="label"><?php _e('Show full content', TMM_THEME_FOLDER_NAME); ?></h4>
        <div class="radio-holder">
            <input checked="" type="radio" name="show_full_content" id="show_full_content_1" value="0" class="js_shortcode_radio_self_update" />
            <label for="show_full_content_1" class="label-form"><span></span><?php _e('No', TMM_THEME_FOLDER_NAME); ?></label>
            <input type="radio" name="show_full_content" id="show_full_content_2" value="1" class="js_shortcode_radio_self_update" />
            <label for="show_full_content_2" class="label-form"><span></span><?php _e('Yes', TMM_THEME_FOLDER_NAME); ?></label>
            <input type="hidden" value="0" class="js_shortcode_template_changer" data-shortcode-field="show_full_content" />
        </div><!--/ .radio-holder-->
    </div><!--/ .ona-half-->

    <div class="one-half">
        <h4 class="label"><?php _e('Show Image', TMM_THEME_FOLDER_NAME); ?></h4>

        <div class="radio-holder">
            <input checked="" type="checkbox" value="1" id="show_image" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="show_image">
            <label for="show_image"><span></span><i class="description"><?php _e('Whether to display featured image in alternate layout', TMM_THEME_FOLDER_NAME); ?></i></label>
        </div><!--/ .radio-holder-->

    </div><!--/ .ona-half-->

    <div class="one-half">
        <h4 class="label"><?php _e('Show Pagination', TMM_THEME_FOLDER_NAME); ?></h4>
        <div class="radio-holder">
            <input type="checkbox" id="show_pagination" value="0" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="show_pagination">
            <label for="show_pagination"><span></span><i class="description"><?php _e('Enable Pagination', TMM_THEME_FOLDER_NAME); ?></i></label>
        </div><!--/ .radio-holder-->
    </div><!--/ .ona-half-->

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
            var shortcode_name = "blog";
            thememakers_app_shortcodes.changer(shortcode_name);
            jQuery("#thememakers_shortcode_template .js_shortcode_template_changer").on('keyup, change', function() {
                thememakers_app_shortcodes.changer(shortcode_name);
            });

        });
    </script>

</div><!--/ .fullwidth-frame-->





<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class Thememakers_Entity_Staff {

    public function register() {

        $args = array(
            'labels' => array(
                'name' => __('Staff', TMM_THEME_FOLDER_NAME),
                'singular_name' => __('Staff', TMM_THEME_FOLDER_NAME),
                'add_new' => __('Add New', TMM_THEME_FOLDER_NAME),
                'add_new_item' => __('Add New Staff', TMM_THEME_FOLDER_NAME),
                'edit_item' => __('Edit Staff', TMM_THEME_FOLDER_NAME),
                'new_item' => __('New Staff', TMM_THEME_FOLDER_NAME),
                'view_item' => __('View Staff', TMM_THEME_FOLDER_NAME),
                'search_items' => __('Search In Staff', TMM_THEME_FOLDER_NAME),
                'not_found' => __('Nothing found', TMM_THEME_FOLDER_NAME),
                'not_found_in_trash' => __('Nothing found in Trash', TMM_THEME_FOLDER_NAME),
                'parent_item_colon' => ''
            ),
            'public' => false,
            'archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'staff-page'),
            'show_in_admin_bar' => true,
            'taxonomies' => array('position') // this is IMPORTANT
        );
        register_post_type('staff-page', $args);
        flush_rewrite_rules(false);
        //*** taxonomies ****
        register_taxonomy("position", array("staff-page"), array(
            "hierarchical" => true,
            "labels" => array(
                'name' => __('Positions', TMM_THEME_FOLDER_NAME),
                'singular_name' => __('Position', TMM_THEME_FOLDER_NAME),
                'add_new' => __('Add New', TMM_THEME_FOLDER_NAME),
                'add_new_item' => __('Add New Position', TMM_THEME_FOLDER_NAME),
                'edit_item' => __('Edit Position', TMM_THEME_FOLDER_NAME),
                'new_item' => __('New Position', TMM_THEME_FOLDER_NAME),
                'view_item' => __('View Position', TMM_THEME_FOLDER_NAME),
                'search_items' => __('Search Positions', TMM_THEME_FOLDER_NAME),
                'not_found' => __('No Positions found', TMM_THEME_FOLDER_NAME),
                'not_found_in_trash' => __('No Positions found in Trash', TMM_THEME_FOLDER_NAME),
                'parent_item_colon' => ''
            ),
            "singular_label" => __("position", TMM_THEME_FOLDER_NAME),
            "rewrite" => true,
            'show_in_nav_menus' => false,
            'capabilities' => array('manage_terms'),
            'show_ui' => true
        ));


        //***

        add_filter("manage_staff-page_posts_columns", array(__CLASS__, "show_edit_columns"));
        add_action("manage_staff-page_posts_custom_column", array(__CLASS__, "show_edit_columns_content"));
    }

    public function credits_meta() {
        global $post;
        $data = array();
        $custom = get_post_custom($post->ID);
        $data['staff_email'] = @$custom["staff_email"][0];        
        echo ThemeMakersThemeView::draw_html('staff/credits_meta', $data);
    }

    public static function save($post_id) {
        if (isset($_POST)) {
            update_post_meta($post_id, "staff_email", @$_POST["staff_email"]);           
        }
    }

    public static function init_meta_boxes() {
        add_meta_box("credits_meta", __("Staff attributes", TMM_THEME_FOLDER_NAME), array(__CLASS__, 'credits_meta'), "staff-page", "normal", "low");
    }

    public function show_edit_columns_content($column) {
        global $post;

        switch ($column) {
            case "image":
                if (has_post_thumbnail($post->ID)) {
                    echo '<img alt="" src="' . ThemeMakersHelper::get_post_featured_image($post->ID, 200,true,200) . '"/>';
                }
                break;
            case "description":
                the_content();
                break;
            case "position":
                echo get_the_term_list($post->ID, 'position', '', ', ', '');
                break;            
        }
    }

    public function show_edit_columns($columns) {
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __("Name", TMM_THEME_FOLDER_NAME),
            "image" => __("Photo", TMM_THEME_FOLDER_NAME),
            "description" => __("Description", TMM_THEME_FOLDER_NAME),
            "position" => __("Position", TMM_THEME_FOLDER_NAME),
        );

        return $columns;
    }

}


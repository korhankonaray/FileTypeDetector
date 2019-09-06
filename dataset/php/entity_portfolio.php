<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class Thememakers_Entity_Portfolio {

    public function register() {

        $args = array(
            'labels' => array(
                'name' => __('Portfolios', TMM_THEME_FOLDER_NAME),
                'singular_name' => __('Portfolio', TMM_THEME_FOLDER_NAME),
                'add_new' => __('Add New', TMM_THEME_FOLDER_NAME),
                'add_new_item' => __('Add New Portfolio', TMM_THEME_FOLDER_NAME),
                'edit_item' => __('Edit Portfolio', TMM_THEME_FOLDER_NAME),
                'new_item' => __('New Portfolio', TMM_THEME_FOLDER_NAME),
                'view_item' => __('View Portfolio', TMM_THEME_FOLDER_NAME),
                'search_items' => __('Search Portfolios', TMM_THEME_FOLDER_NAME),
                'not_found' => __('No Portfolios found', TMM_THEME_FOLDER_NAME),
                'not_found_in_trash' => __('No Portfolios found in Trash', TMM_THEME_FOLDER_NAME),
                'parent_item_colon' => ''
            ),
            'public' => false,
            //'menu_icon' => TMM_THEME_URI . '/images/icons/icon_portfolio.png',
            'archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'tags', 'comments'),
            'rewrite' => array('slug' => 'folio'),
            'show_in_admin_bar' => true,
            'taxonomies' => array('clients', 'skills') // this is IMPORTANT
        );
        register_post_type('folio', $args);
        flush_rewrite_rules(false);
        //*** taxonomies ****
        register_taxonomy("clients", array("folio","gall"), array(
            "hierarchical" => true,
            "labels" => array(
                'name' => __('Clients', TMM_THEME_FOLDER_NAME),
                'singular_name' => __('Client', TMM_THEME_FOLDER_NAME),
                'add_new' => __('Add New', TMM_THEME_FOLDER_NAME),
                'add_new_item' => __('Add New Client', TMM_THEME_FOLDER_NAME),
                'edit_item' => __('Edit Client', TMM_THEME_FOLDER_NAME),
                'new_item' => __('New Client', TMM_THEME_FOLDER_NAME),
                'view_item' => __('View Client', TMM_THEME_FOLDER_NAME),
                'search_items' => __('Search Clients', TMM_THEME_FOLDER_NAME),
                'not_found' => __('No Clients found', TMM_THEME_FOLDER_NAME),
                'not_found_in_trash' => __('No Clients found in Trash', TMM_THEME_FOLDER_NAME),
                'parent_item_colon' => ''
            ),
            "singular_label" => __("client", TMM_THEME_FOLDER_NAME),
            "rewrite" => true,
            'show_in_nav_menus' => false,
            'capabilities' => array('manage_terms'),
            'show_ui' => true
        ));

        register_taxonomy("skills", array("folio","gall"), array(
            "hierarchical" => true,
            "labels" => array(
                'name' => __('Skills', TMM_THEME_FOLDER_NAME),
                'singular_name' => __('Skill', TMM_THEME_FOLDER_NAME),
                'add_new' => __('Add New', TMM_THEME_FOLDER_NAME),
                'add_new_item' => __('Add New Skill', TMM_THEME_FOLDER_NAME),
                'edit_item' => __('Edit Skill', TMM_THEME_FOLDER_NAME),
                'new_item' => __('New Skill', TMM_THEME_FOLDER_NAME),
                'view_item' => __('View Skill', TMM_THEME_FOLDER_NAME),
                'search_items' => __('Search Skills', TMM_THEME_FOLDER_NAME),
                'not_found' => __('No Skills found', TMM_THEME_FOLDER_NAME),
                'not_found_in_trash' => __('No Skills found in Trash', TMM_THEME_FOLDER_NAME),
                'parent_item_colon' => ''
            ),
            "singular_label" => __("skill", TMM_THEME_FOLDER_NAME),
            "show_tagcloud" => true,
            'query_var' => true,
            'rewrite' => true,
            'show_in_nav_menus' => false,
            'capabilities' => array('manage_terms'),
            'show_ui' => true
        ));


        //***

        add_filter("manage_folio_posts_columns", array("Thememakers_Entity_Portfolio", "show_edit_columns"));
        add_action("manage_folio_posts_custom_column", array("Thememakers_Entity_Portfolio", "show_edit_columns_content"));
    }

    public function credits_meta() {
        global $post;
        $data = array();
        $custom = get_post_custom($post->ID);
        $data['portfolio_date'] = @$custom["portfolio_date"][0];
        $data['portfolio_url'] = @$custom["portfolio_url"][0];
        $data['portfolio_url_title'] = @$custom["portfolio_url_title"][0];
        $data['portfolio_client'] = @$custom["portfolio_client"][0];
        $data['portfolio_tools'] = @$custom["portfolio_tools"][0];
        $data['portfolio_clients'] = @$custom["portfolio_clients"][0];
        $data['thememakers_portfolio'] = unserialize(@$custom["thememakers_portfolio"][0]);
        echo ThemeMakersThemeView::draw_html('portfolio/credits_meta', $data);
    }

    public static function save($post_id) {
        if (isset($_POST)) {
            update_post_meta($post_id, "portfolio_url", @$_POST["portfolio_url"]);
            update_post_meta($post_id, "portfolio_date", @$_POST["portfolio_date"]);
            update_post_meta($post_id, "portfolio_url_title", @$_POST["portfolio_url_title"]);
            update_post_meta($post_id, "portfolio_client", @$_POST["portfolio_client"]);
            update_post_meta($post_id, "portfolio_tools", @$_POST["portfolio_tools"]);
            update_post_meta($post_id, "thememakers_portfolio", @$_POST["thememakers_portfolio"]);
            update_post_meta($post_id, "portfolio_clients", @$_POST["portfolio_clients"]);
        }
    }

    public static function init_meta_boxes() {
        add_meta_box("credits_meta", __("Portfolio attributes", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Portfolio', 'credits_meta'), "folio", "normal", "low");
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
                the_excerpt();
                break;
            case "clients":
                echo get_the_term_list($post->ID, 'clients', '', ', ', '');
                break;
            case "skills":
                echo get_the_term_list($post->ID, 'skills', '', ', ', '');
                break;
        }
    }

    public function show_edit_columns($columns) {
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __("Title", TMM_THEME_FOLDER_NAME),
            "image" => __("Cover", TMM_THEME_FOLDER_NAME),
            "description" => __("Description", TMM_THEME_FOLDER_NAME),
            "clients" => __("Clients", TMM_THEME_FOLDER_NAME),
            "skills" => __("Skills", TMM_THEME_FOLDER_NAME),
        );

        return $columns;
    }

}


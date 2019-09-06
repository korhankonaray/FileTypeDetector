<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class Thememakers_Entity_Page {

    public static $post_pod_types = array();

    public function register() {

        self::$post_pod_types = array(
            'default' => __("Default", TMM_THEME_FOLDER_NAME),
            'video' => __("Video", TMM_THEME_FOLDER_NAME),
            'audio' => __("Audio", TMM_THEME_FOLDER_NAME),
            'link' => __("Link", TMM_THEME_FOLDER_NAME),
            'quote' => __("Quote", TMM_THEME_FOLDER_NAME),
            'gallery'=>__("Gallery", TMM_THEME_FOLDER_NAME),
        );
    }

    public static function save($post_id) {
        //update_post_meta($post_id, "page_top", @$_POST["page_top"]);
        //update_post_meta($post_id, "page_bottom", @$_POST["page_bottom"]);
        //*****
        update_post_meta($post_id, "meta_title", @$_POST["meta_title"]);
        update_post_meta($post_id, "meta_keywords", @$_POST["meta_keywords"]);
        update_post_meta($post_id, "meta_description", @$_POST["meta_description"]);
        //*****
        update_post_meta($post_id, "post_pod_type", @$_POST["post_pod_type"]);
        update_post_meta($post_id, "post_type_values", @$_POST["post_type_values"]);
    }

    public static function init_meta_boxes() {

        add_meta_box("seo_options", __("Seo options", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Page', 'page_seo_options'), "page", "normal", "low");
        add_meta_box("seo_options", __("Seo options", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Page', 'page_seo_options'), "post", "normal", "low");
        add_meta_box("seo_options", __("Seo options", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Page', 'page_seo_options'), "folio", "normal", "low");
        add_meta_box("seo_options", __("Seo options", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Page', 'page_seo_options'), "gall", "normal", "low");
        //*****
        //add_meta_box("content_areas", __("Content areas", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Page', 'content_areas_meta'), "page", "normal", "low");
        //add_meta_box("content_areas", __("Content areas", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Page', 'content_areas_meta'), "post", "normal", "low");
        //*****
        add_meta_box("post_types", __("Post type", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Page', 'post_type_meta_box'), "post", "side", "low");
        add_meta_box("post_types_data", __("Post type data", TMM_THEME_FOLDER_NAME), array('Thememakers_Entity_Page', 'post_type_meta_panel'), "post", "normal");
    }

    public function content_areas_meta() {
        global $post;
        $data = array();
        $custom = get_post_custom($post->ID);
        $data['page_top'] = @$custom["page_top"][0];
        $data['page_bottom'] = @$custom["page_bottom"][0];
        echo ThemeMakersThemeView::draw_html('page/before_after', $data);
    }

    public function page_seo_options() {
        global $post;
        $data = array();
        $custom = get_post_custom($post->ID);
        $data['meta_title'] = @$custom["meta_title"][0];
        $data['meta_keywords'] = @$custom["meta_keywords"][0];
        $data['meta_description'] = @$custom["meta_description"][0];
        echo ThemeMakersThemeView::draw_html('page/seo_options', $data);
    }

    public function post_type_meta_box() {
        global $post;
        $data = array();
        $custom = get_post_custom($post->ID);
        $data['post_pod_types'] = self::$post_pod_types;
        $data['current_post_pod_type'] = @$custom["post_pod_type"][0];
        if (!$data['current_post_pod_type']) {
            $data['current_post_pod_type'] = 'default';
        }
        echo ThemeMakersThemeView::draw_html('page/post_pod_type_box', $data);
    }
    
     public function post_type_meta_panel() {
        global $post;
        $data = array();
        $custom = get_post_custom($post->ID);
        $data['post_pod_types'] = self::$post_pod_types;
        $data['current_post_pod_type'] = @$custom["post_pod_type"][0];
        if (!$data['current_post_pod_type']) {
            $data['current_post_pod_type'] = 'default';
        }
        $data['post_type_values'] = unserialize(@$custom["post_type_values"][0]);
        
        echo ThemeMakersThemeView::draw_html('page/post_pod_type_panel', $data);
    }

}


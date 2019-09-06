<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class Thememakers_Entity_Custom_Sidebars {

    public function get_categories_select($selected = '', $name = '', $id = '') {
        $args = array(
            'show_option_none' => __('No categories', TMM_THEME_FOLDER_NAME),
            'hide_empty' => 0,
            'echo' => 0,
            'selected' => $selected,
            'hierarchical' => 0,
            'name' => $name,
            'id' => $id,
            'class' => 'postform',
            'depth' => 0,
            'tab_index' => 0,
            'taxonomy' => 'category',
            'hide_if_empty' => false
        );

        return wp_dropdown_categories($args);
    }

    public function get_pages_select($selected = '', $name = '', $id = '') {
        $args = array(
            'show_option_none' => __('No pages', TMM_THEME_FOLDER_NAME),
            'selected' => $selected,
            'echo' => 0,
            'name' => $name,
            'id' => $id
        );

        return wp_dropdown_pages($args);
    }

    public function draw_sidebars_panel() {
        $sidebars = get_option(TMM_THEME_PREFIX . "thememakers_sidebars");
        $data = array();
        $data['sidebars'] = $sidebars;
        $data['entity_sidebars'] = new Thememakers_Entity_Custom_Sidebars();
        return ThemeMakersThemeView::draw_html('custom_sidebars/draw_sidebars', $data);
    }

    //ajax
    public function add_sidebar() {
        $obj = new Thememakers_Entity_Custom_Sidebars();
        $data = array();
        $sidebar_id = uniqid();
        $data['sidebar_id'] = $sidebar_id;
        $data['sidebar_name'] = $_REQUEST['sidebar_name'];
        $data['categories_select'] = $obj->get_pages_select('', "sidebars[" . $sidebar_id . "][page][0]", "sidebars_page_" . $sidebar_id);
        $data['pages_select'] = $obj->get_categories_select('', "sidebars[" . $sidebar_id . "][cat][0]", "sidebars_cat_" . $sidebar_id);
        //***
        $newdata = array(
            "sidebar_id" => $sidebar_id,
            "name" => trim($_REQUEST['sidebar_name']),
            "pages" => array(),
            "cat" => array()
        );
        //$obj->save_sidebars($newdata, true);
        //***
        $responce = array();
        $responce['html'] = ThemeMakersThemeView::draw_html('custom_sidebars/add_sidebar', $data);
        $responce['sidebar_id'] = $sidebar_id;
        echo json_encode($responce);
        exit;
    }

    public function add_sidebar_page() {
        $obj = new Thememakers_Entity_Custom_Sidebars();
        $sidebar_id = $_REQUEST['sidebar_id'];
        $page_id = $_REQUEST['page_id'];
        $data = array();
        $data['select'] = $obj->get_pages_select('', "sidebars[" . $sidebar_id . "][page][" . $page_id . "]", "sidebars_page_" . $sidebar_id);

        echo ThemeMakersThemeView::draw_html('custom_sidebars/add_sidebar_page', $data);
        exit;
    }

    public function add_sidebar_category() {
        $obj = new Thememakers_Entity_Custom_Sidebars();
        $sidebar_id = $_REQUEST['sidebar_id'];
        $cat_id = $_REQUEST['cat_id'];
        $data = array();
        $data['select'] = $obj->get_categories_select('', "sidebars[" . $sidebar_id . "][cat][" . $cat_id . "]", "sidebars_cat_" . $sidebar_id);

        echo ThemeMakersThemeView::draw_html('custom_sidebars/add_sidebar_page', $data);
        exit;
    }

    //****
    public function save_sidebars($newdata, $is_new = false) {
        /* $sidebars = array();
          if ($is_new) {
          $sidebars = get_option("thememakers_sidebars");
          if (empty($sidebars)) {
          $sidebars = array();
          } else {
          $sidebars = unserialize($sidebars);
          }
          $sidebars[$newdata['sidebar_id']] = $newdata;
          } else { */
        $sidebars = $newdata;
        //}

        update_option(TMM_THEME_PREFIX . "thememakers_sidebars", $sidebars);
    }

    public static function register_custom_sidebars($before_widget, $after_widget, $before_title, $after_title) {
        $sidebars = get_option(TMM_THEME_PREFIX . "thememakers_sidebars");
        $data = array();

        if (!empty($sidebars) AND is_array($sidebars)) {
            foreach ($sidebars as $key => $sidebar) {
                $data[$key]['name'] = $sidebar['name'];
                $data[$key]['id'] = strtolower(str_replace(" ", "_", trim($sidebar['name'])));
            }
        }


        if (!empty($data)) {
            foreach ($data as $area) {
                $area['before_widget'] = $before_widget;
                $area['after_widget'] = $after_widget;
                $area['before_title'] = $before_title;
                $area['after_title'] = $after_title;
                register_sidebar($area);
            }
        }
    }

    //Show sidebar for current page
    public static function show_custom_sidebars() {

        //set areas
        $sidebars = get_option(TMM_THEME_PREFIX . "thememakers_sidebars");
        //get current page id
        $type = "page";
        $current_id = 0;
        wp_reset_query();
        global $post;
        if (is_category()) {
            $type = 'cat';
            $current_id = get_query_var('cat');
        } else if (is_page()) {
            $type = 'page';
            $current_id = $post->ID;
        }


        //open wigitised areas

        $show_default_sidebar = true;


        if (is_array($sidebars)) {
            //show custom sidebar
            foreach ($sidebars as $area) {
                if ($type == "cat") {
                    $cat_id = $current_id;
                    if (in_array($cat_id, $area['cat'])) {
                        if ($cat_id != 0) {
                            $show_default_sidebar = false;
                            dynamic_sidebar($area['name']);
                        }
                    }
                } else {
                    $post_id = $current_id;
                    if (in_array($post_id, $area['page'])) {
                        if ($post_id != 0) {
                            $show_default_sidebar = false;
                            dynamic_sidebar($area['name']);
                        }
                    }
                }
            }
        }

        //show default sidebar
        if ($show_default_sidebar) {
            if (function_exists('dynamic_sidebar') AND dynamic_sidebar('Thememakers Default Sidebar')):else:
                ?>
                <div class="widget widget_categories">
                    <h3 class="widget-title"><?php _e('Categories', TMM_THEME_FOLDER_NAME) ?></h3>
                    <ul class="categories">
                        <?php wp_list_categories('sort_column=name&optioncount=1&hierarchical=0&title_li=0'); ?>
                    </ul>                    
                </div>
                <div class="widget widget_calendar">
                    <h3 class="widget-title"><?php _e('Calendar', TMM_THEME_FOLDER_NAME) ?></h3>
                    <?php get_calendar(); ?>

                </div>

                <div class="widget widget_meta">
                    <h3 class="widget-title"><?php _e('Meta', TMM_THEME_FOLDER_NAME) ?></h3>
                    <ul>
                        <?php wp_register(); ?>
                        <li>
                            <?php wp_loginout(); ?>
                        </li>
                        <?php wp_meta(); ?>
                    </ul>

                </div>				
				
            <?php
            endif;
        }
    }

}


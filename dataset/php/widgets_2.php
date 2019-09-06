<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class ThemeMakers_Soonest_Event_Widget extends WP_Widget {

    //Widget Setup
    function __construct() {
        //Basic settings
        $settings = array('classname' => __CLASS__, 'description' => __('Soonest Event', TMM_THEME_FOLDER_NAME));

        //Creation
        $this->WP_Widget(__CLASS__, __('ThemeMakers Soonest Event', TMM_THEME_FOLDER_NAME), $settings);
    }

    //Widget view
    function widget($args, $instance) {
        $args['instance'] = $instance;
        echo ThemeMakersThemeView::draw_free_page(Thememakers_Application_Events::get_application_path() . '/views/widgets/soonest_event.php', $args);
    }

    //Update widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['boxtitle'] = $new_instance['boxtitle'];
        $instance['show_title'] = $new_instance['show_title'];
        $instance['month_deep'] = $new_instance['month_deep'];
        $instance['show_time_zone'] = $new_instance['show_time_zone'];
        return $instance;
    }

    //Widget form
    function form($instance) {
        //Defaults
        $defaults = array(
            'boxtitle' => 'Soonest event',
            'show_title' => 0,
            'month_deep' => 1,
            'show_time_zone'=>1
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $args = array();
        $args['instance'] = $instance;
        $args['widget'] = $this;
        echo ThemeMakersThemeView::draw_free_page(Thememakers_Application_Events::get_application_path() . '/views/widgets/soonest_event_form.php', $args);
    }

}

class ThemeMakers_Event_Calendar_Widget extends WP_Widget {

    //Widget Setup
    function __construct() {
        //Basic settings
        $settings = array('classname' => __CLASS__, 'description' => __('Events calendar', TMM_THEME_FOLDER_NAME));

        //Creation
        $this->WP_Widget(__CLASS__, __('ThemeMakers Events calendar', TMM_THEME_FOLDER_NAME), $settings);
    }

    //Widget view
    function widget($args, $instance) {
        $args['instance'] = $instance;
        echo ThemeMakersThemeView::draw_free_page(Thememakers_Application_Events::get_application_path() . '/views/widgets/calendar.php', $args);
    }

    //Update widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    //Widget form
    function form($instance) {
        //Defaults
        $defaults = array(
            'title' => 'Events calendar',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $args = array();
        $args['instance'] = $instance;
        $args['widget'] = $this;
        echo ThemeMakersThemeView::draw_free_page(Thememakers_Application_Events::get_application_path() . '/views/widgets/calendar_form.php', $args);
    }

}

class ThemeMakers_Upcoming_Events_Widget extends WP_Widget {

    //Widget Setup
    function __construct() {
        //Basic settings
        $settings = array('classname' => __CLASS__, 'description' => __('Upcoming Events', TMM_THEME_FOLDER_NAME));

        //Creation
        $this->WP_Widget(__CLASS__, __('ThemeMakers Upcoming Events', TMM_THEME_FOLDER_NAME), $settings);
    }

    //Widget view
    function widget($args, $instance) {
        $args['instance'] = $instance;
        echo ThemeMakersThemeView::draw_free_page(Thememakers_Application_Events::get_application_path() . '/views/widgets/upcoming_events.php', $args);
    }

    //Update widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['count'] = $new_instance['count'];
        $instance['month_deep'] = $new_instance['month_deep'];
        return $instance;
    }

    //Widget form
    function form($instance) {
        //Defaults
        $defaults = array(
            'title' => __('Upcoming Events', TMM_THEME_FOLDER_NAME),
            'count' => 3,
            'month_deep'=>1
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $args = array();
        $args['instance'] = $instance;
        $args['widget'] = $this;
        echo ThemeMakersThemeView::draw_free_page(Thememakers_Application_Events::get_application_path() . '/views/widgets/upcoming_events_form.php', $args);
    }

}

//***************************************************************************************

register_widget('ThemeMakers_Soonest_Event_Widget');
register_widget('ThemeMakers_Event_Calendar_Widget');
register_widget('ThemeMakers_Upcoming_Events_Widget');


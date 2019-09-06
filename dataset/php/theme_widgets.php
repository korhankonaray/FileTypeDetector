<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class ThemeMakers_Testimonials_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('Rotates testimonials in random order.', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Testimonials', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/testimonials', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['pause'] = (int) $new_instance['pause'];
		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => __('Testimonials', TMM_THEME_FOLDER_NAME),
			'pause' => '7000',
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/testimonials_form', $args);
	}

}

class ThemeMakers_Latest_Tweets_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('A widget that displays your latest tweets.', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Latest Tweets', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/latest_tweets', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['postcount'] = (int) $new_instance['postcount'];
		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Twitter Feed',
			'twitter_id' => '',
			'postcount' => '3',
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/latest_tweets_form', $args);
	}

}

class ThemeMakers_Social_Links_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('Links to your account at most popular web services.', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Social Links', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/social_links', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['twitter_links'] = $new_instance['twitter_links'];
		$instance['twitter_tooltip'] = $new_instance['twitter_tooltip'];
		$instance['facebook_links'] = $new_instance['facebook_links'];
		$instance['facebook_tooltip'] = $new_instance['facebook_tooltip'];
		$instance['dribble_links'] = $new_instance['dribble_links'];
		$instance['dribble_tooltip'] = $new_instance['dribble_tooltip'];
		$instance['vimeo_links'] = $new_instance['vimeo_links'];
		$instance['vimeo_tooltip'] = $new_instance['vimeo_tooltip'];
		$instance['youtube_links'] = $new_instance['youtube_links'];
		$instance['youtube_tooltip'] = $new_instance['youtube_tooltip'];
		$instance['rss_tooltip'] = $new_instance['rss_tooltip'];
		$instance['show_rss_tooltip'] = $new_instance['show_rss_tooltip'];
		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Social Links',
			'twitter_links' => 'https://twitter.com/ThemeMakers',
			'twitter_tooltip' => 'Twitter',
			'facebook_links' => 'http://www.facebook.com/wpThemeMakers',
			'facebook_tooltip' => 'Facebook',
			'dribble_links' => '',
			'dribble_tooltip' => 'Dribble',
			'vimeo_links' => '',
			'vimeo_tooltip' => 'Vimeo',
			'youtube_links' => '',
			'youtube_tooltip' => 'Youtube',
			'rss_tooltip' => 'RSS',
			'show_rss_tooltip' => 1,
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/social_links_form', $args);
	}

}

class ThemeMakers_Recent_Posts_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('The most recent posts from selected category.', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Recent Posts', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/recent_posts', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['category'] = $new_instance['category'];
		$instance['post_number'] = $new_instance['post_number'];
		$instance['show_thumbnail'] = $new_instance['show_thumbnail'];
		$instance['show_exerpt'] = $new_instance['show_exerpt'];
		$instance['show_see_all_button'] = $new_instance['show_see_all_button'];
		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Recent Posts',
			'category' => '',
			'post_number' => 5,
			'show_thumbnail' => 1,
			'show_exerpt' => 0,
			'show_see_all_button' => 1
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/recent_posts_form', $args);
	}

}

class ThemeMakers_Contact_Form_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('A widget that shows custom contact form.', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Contact Form', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/contact_form', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['form'] = $new_instance['form'];
		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Contact Form',
			'form' => '',
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/contact_form_form', $args);
	}

}

class ThemeMakers_Flickr_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('A widget that displays flickr images', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Flickr', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/flickr', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['username'] = $new_instance['username'];
		$instance['imagescount'] = (int) $new_instance['imagescount'];
		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Flickr Photos',
			'username' => '54958895@N06',
			'imagescount' => '6',
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/flickr_form', $args);
	}

}

class ThemeMakers_Recent_Projects_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('The most recent projects from portfolio.', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Recent Projects', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/recent_projects', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['post_number'] = $new_instance['post_number'];
		$instance['show_thumbnail'] = $new_instance['show_thumbnail'];
		$instance['show_exerpt'] = $new_instance['show_exerpt'];
		$instance['show_date'] = $new_instance['show_date'];
		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Recent Projects',
			'post_number' => 5,
			'show_thumbnail' => 1,
			'show_exerpt' => 0,
			'show_date' => 1,
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/recent_projects_form', $args);
	}

}

class ThemeMakers_Google_Map_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('Google map', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Google map', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/google_map', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['width'] = $new_instance['width'];
		$instance['height'] = $new_instance['height'];
		$instance['latitude'] = $new_instance['latitude'];
		$instance['longitude'] = $new_instance['longitude'];
		$instance['zoom'] = $new_instance['zoom'];
		$instance['scrollwheel'] = $new_instance['scrollwheel'];
		$instance['maptype'] = $new_instance['maptype'];
		$instance['marker'] = $new_instance['marker'];
		$instance['popup'] = $new_instance['popup'];
		$instance['html'] = $new_instance['html'];
		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Google Map',
			'width' => 200,
			'height' => 200,
			'latitude' => "40.714623",
			'longitude' => "-74.006605",
			'zoom' => 12,
			'scrollwheel' => 0,
			'maptype' => 'ROADMAP',
			'marker' => 1,
			'popup' => 1,
			'html' => ""
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/google_map_form', $args);
	}

}

class ThemeMakers_Visit_Card_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('Contacts', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Contacts Widget', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view
	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/visit_card', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['text'] = $new_instance['text'];
		$instance['address'] = $new_instance['address'];
		$instance['phone'] = $new_instance['phone'];
		$instance['email'] = $new_instance['email'];

		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Visit Us',
			'text' => '',
			'address' => '',
			'phone' => '',
			'email' => '',
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/visit_card_form', $args);
	}

}

class ThemeMakers_Facebook_LikeBox_Widget extends WP_Widget {

	//Widget Setup
	function __construct() {
		//Basic settings
		$settings = array('classname' => __CLASS__, 'description' => __('Facebook likeBox', TMM_THEME_FOLDER_NAME));

		//Creation
		$this->WP_Widget(__CLASS__, __('ThemeMakers Facebook likeBox', TMM_THEME_FOLDER_NAME), $settings);
	}

	//Widget view

	function widget($args, $instance) {
		$args['instance'] = $instance;
		echo ThemeMakersThemeView::draw_html('widgets/facebook', $args);
	}

	//Update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['pageID'] = $new_instance['pageID'];
		$instance['connection'] = $new_instance['connection'];
		$instance['width'] = $new_instance['width'];
		$instance['height'] = $new_instance['height'];
		$instance['header'] = $new_instance['header'];


		return $instance;
	}

	//Widget form
	function form($instance) {
		//Defaults
		$defaults = array(
			'title' => 'Facebook',
			'pageID' => '273813622709585',
			'connection' => 6,
			'width' => '',
			'height' => '300',
			'header' => 'yes'
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$args = array();
		$args['instance'] = $instance;
		$args['widget'] = $this;
		echo ThemeMakersThemeView::draw_html('widgets/facebook_form', $args);
	}

}

//*****************************************************

register_widget('ThemeMakers_Testimonials_Widget');
register_widget('ThemeMakers_Latest_Tweets_Widget');
register_widget('ThemeMakers_Social_Links_Widget');
register_widget('ThemeMakers_Recent_Posts_Widget');
register_widget('ThemeMakers_Contact_Form_Widget');
register_widget('ThemeMakers_Flickr_Widget');
register_widget('ThemeMakers_Recent_Projects_Widget');
register_widget('ThemeMakers_Google_Map_Widget');
register_widget('ThemeMakers_Visit_Card_Widget');
register_widget('ThemeMakers_Facebook_LikeBox_Widget');



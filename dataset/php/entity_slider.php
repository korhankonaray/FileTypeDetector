<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class Thememakers_Entity_Slider {

	public $slider_types = array();
	public $slider_types_options = array();
	public $current_slider_type;
	public $slider_height_option = 415;

	public function __construct() {
		$this->slider_types = array(
			//'nivo' => "Nivo Slider",
			//'circle' => "Circle Effect slider",
			//'accordion' => "Elegant Accordion",
			//'rama' => "Rama Slider",
			//'mosaic' => "Mosaic",
			'flexslider' => 'Flex Slider',
			'revolution' => 'Revolution'
		);

		if (!$this->current_slider_type) {
			$this->current_slider_type = 'flexslider'; //default
		}
		$this->slider_height_option = get_option(TMM_THEME_PREFIX . "slider_height_option") > 0 ? get_option(TMM_THEME_PREFIX . "slider_height_option") : $this->slider_height_option;
		$this->slider_types_options = array(
			'flexslider' => array(
				'slide_width' => array(
					'title' => __('Slide width', TMM_THEME_FOLDER_NAME),
					'type' => 'text',
					'description' => "",
					'default' => 1220,
					'max' => 1220
				),
				'item_width' => array(
					'title' => __('Item width', TMM_THEME_FOLDER_NAME),
					'type' => 'text',
					'description' => __("Width of blocks", TMM_THEME_FOLDER_NAME),
					'default' => 245,
					'max' => 1220
				),
				'enable_caption' => array(
					'title' => __('Enable caption', TMM_THEME_FOLDER_NAME),
					'type' => 'checkbox',
					'description' => "",
					'default' => 1,
				),
				'animation_loop' => array(
					'title' => __('Animation loop', TMM_THEME_FOLDER_NAME),
					'type' => 'checkbox',
					'description' => __("Should the animation loop? If false, directionNav will received 'disable' classes at either end", TMM_THEME_FOLDER_NAME),
					'default' => 0,
				),
				'slideshow' => array(
					'title' => __('Slideshow', TMM_THEME_FOLDER_NAME),
					'type' => 'checkbox',
					'description' => __("Animate slider automatically", TMM_THEME_FOLDER_NAME),
					'default' => 1,
				),
				'init_delay' => array(
					'title' => __('initDelay', TMM_THEME_FOLDER_NAME),
					'type' => 'text',
					'description' => __("Integer: Set an initialization delay, in milliseconds", TMM_THEME_FOLDER_NAME),
					'default' => 0,
					'max' => 500
				),
				'animation_speed' => array(
					'title' => __('Animation Speed', TMM_THEME_FOLDER_NAME),
					'type' => 'text',
					'description' => __("Set the speed of animations, in milliseconds", TMM_THEME_FOLDER_NAME),
					'default' => 600,
					'max' => 2000
				),
				'slideshow_speed' => array(
					'title' => __('Slideshow Speed', TMM_THEME_FOLDER_NAME),
					'type' => 'text',
					'description' => __("Set the speed of the slideshow cycling, in milliseconds", TMM_THEME_FOLDER_NAME),
					'default' => 7000,
					'max' => 20000
				),
				'animation' => array(
					'title' => __('Animation', TMM_THEME_FOLDER_NAME),
					'type' => 'select',
					'values_list' => array(
						'fade' => __('Fade', TMM_THEME_FOLDER_NAME),
						'slide' => __('Slide', TMM_THEME_FOLDER_NAME),
					),
					'description' => __('Select your animation type, "fade" or "slide"', TMM_THEME_FOLDER_NAME),
					'default' => 'fade',
				),
				'randomize' => array(
					'title' => __('Randomize', TMM_THEME_FOLDER_NAME),
					'type' => 'checkbox',
					'description' => __("Randomize slide order", TMM_THEME_FOLDER_NAME),
					'default' => 1,
				),
				'reverse' => array(
					'title' => __('Reverse', TMM_THEME_FOLDER_NAME),
					'type' => 'checkbox',
					'description' => __("Reverse the animation direction", TMM_THEME_FOLDER_NAME),
					'default' => 1,
				),
			),
			'revolution' => array(),
		);
	}

	public function draw_sliders_options() {
		$data = array();
		$data['slider_object'] = $this;
		return ThemeMakersThemeView::draw_html('slider/sliders_options', $data);
	}

	public function get_slider_options($slider_type) {
		$options_list = @$this->slider_types_options[$slider_type];

		$options = array();
		if (!empty($options_list)) {
			foreach ($options_list as $option_key => $values) {
				$option = get_option(TMM_THEME_PREFIX . "slider_" . $slider_type . "_" . $option_key);
				if (empty($option) AND !is_numeric($option)) {
					$option = $values['default'];
				}

				$options[$option_key] = $option;
			}
		}

		return $options;
	}

	public static function get_slides() {
		$slides = get_option(TMM_THEME_PREFIX . 'sliders');
		return $slides;
	}

	public static function get_slide_group($slide_name) {
		$slides = self::get_slides();
		$slide = array();
		if (!empty($slides)) {
			foreach ($slides as $key => $value) {
				if (@$value['name'] == $slide_name) {
					$slide = $value['options'];
					break;
				}
			}
		}


		return $slide;
	}

	public static function get_sliders_types() {
		$obj = new Thememakers_Entity_Slider();
		return $obj->slider_types;
	}

}


<?php
/**
 * Customizer  Settings
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */


add_action( 'customize_register', 'vmagazine_lite_customizer_register' );

if( !function_exists( 'vmagazine_lite_customizer_register' ) ):
function vmagazine_lite_customizer_register( $wp_customize ) { 

/**
 * Add General Settings panel
 */

$wp_customize->add_panel( 'general_settings', array(
    'priority'         =>      1,
    'capability'       =>      'edit_theme_options',
    'theme_supports'   =>      '',
    'title'            =>      esc_html__( 'General Settings', 'vmagazine-lite' ),
    'description'      =>      esc_html__( 'This allows to edit general theme settings', 'vmagazine-lite' ),
));

$wp_customize->get_section('title_tagline')->panel = 'general_settings';
$wp_customize->remove_section('header_image');
$wp_customize->get_section('background_image')->panel = 'general_settings';
$wp_customize->get_section('static_front_page')->panel = 'general_settings';
$wp_customize->get_section('colors')->panel = 'general_settings';

/*--------------------------------------------------------------------------------------------------*/


/**
 * Theme color option
 */
$wp_customize->add_setting('vmagazine_lite_theme_color', array(
        'default'			      => '#e52d6d',
        'sanitize_callback'	=> 'sanitize_hex_color',
    )
);
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,'vmagazine_lite_theme_color', array(
            'label'         => esc_html__( 'Theme color', 'vmagazine-lite' ),
            'section'       => 'colors',
            'settings'      => 'vmagazine_lite_theme_color',
            'priority'      => 15
)));

/**
 * Add Header Settings panel
 */
$wp_customize->add_panel('vmagazine_lite_header_settings_panel',array(
    		  'priority'       => 2,
        	'capability'     => 'edit_theme_options',
        	'theme_supports' => '',
        	'title'          => esc_html__( 'Header Settings', 'vmagazine-lite' ),
));

$wp_customize->add_section( 'vmagazine_lite_header_option', array(
	'title'           =>      esc_html__('Header Option', 'vmagazine-lite'),
	'priority'        =>      '1',
  'panel'           =>      'vmagazine_lite_header_settings_panel'
));


	    
	
/**
 * Home Icon
*/
$wp_customize->add_setting( 'vmagazine_lite_home_icon_picker', array(
    'default'           => 'fa-home',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'postMessage'
) );
$wp_customize->add_control( new vmagazine_lite_Customize_Icons_Control( $wp_customize, 'vmagazine_lite_home_icon_picker', array(
      'type'        => 'vmagazine_lite_icons',                 
      'label'       => esc_html__( 'Home Icon', 'vmagazine-lite' ),
      'description' => esc_html__( 'Choose your desired home icons from the available icon lists', 'vmagazine-lite' ),
      'section'     => 'vmagazine_lite_header_option',
  ) ) );

$wp_customize->selective_refresh->add_partial( 'vmagazine_lite_home_icon_picker', array(
      'selector'            => '.index-icon',
      'container_inclusive' => true,
      'render_callback'     => 'vmagazine_lite_home_icon',
    ) );

/** Enable/Disable header search */
$wp_customize->add_setting( 'vmagazine_lite_header_search_enable', array(
  'default'           => 'show',
  'sanitize_callback' => 'vmagazine_lite_sanitize_switch_option',
) );

$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control( $wp_customize, 'vmagazine_lite_header_search_enable',array(
  'type'      => 'switch',                    
  'label'     => esc_html__( 'Enable/Disable Header Search', 'vmagazine-lite' ),
  'section'   => 'vmagazine_lite_header_option',
  'choices'   => array(
        'show'  => esc_html__( 'Enable', 'vmagazine-lite' ),
        'hide'  => esc_html__( 'Disable', 'vmagazine-lite' )
      )
) ) ); 

/** Enable/Disable ajax search */
$wp_customize->add_setting( 'vmagazine_lite_ajax_search_enable', array(
  'default'				    => 'show',
  'sanitize_callback'	=> 'vmagazine_lite_sanitize_switch_option',
) );

$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control( $wp_customize, 'vmagazine_lite_ajax_search_enable',array(
  'type'      => 'switch',                    
  'label'     => esc_html__( 'Enable/Disable Ajax Search', 'vmagazine-lite' ),
  'section'   => 'vmagazine_lite_header_option',
  'choices'   => array(
        'show'  => esc_html__( 'Enable', 'vmagazine-lite' ),
        'hide'  => esc_html__( 'Disable', 'vmagazine-lite' )
      )
) ) ); 

/*
* show/hide WooCommerce Cart
*/
$wp_customize->add_setting( 'vmagazine_lite_cart_show', array(
  'default'           => 'show',
  'sanitize_callback' => 'vmagazine_lite_sanitize_switch_option',
) );

$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control( $wp_customize, 'vmagazine_lite_cart_show',  array(
  'type'      => 'switch',                    
  'label'     => esc_html__( 'Hide/Show Shopping Cart', 'vmagazine-lite' ),
  'description'=> esc_html__( 'Install and activate WooCommerce plugin to make shopping cart working', 'vmagazine-lite' ),
  'section'   => 'vmagazine_lite_header_option',
  'choices'   => array(
        'show'  => esc_html__( 'Show', 'vmagazine-lite' ),
        'hide'  => esc_html__( 'Hide', 'vmagazine-lite' )
      )
) ) ); 

//Show/Hide social icons from header
$wp_customize->add_setting( 'vmagazine_lite_header_icon_show', array(
  'default'           => 'hide',
  'sanitize_callback' => 'vmagazine_lite_sanitize_switch_option',
) );

$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control( $wp_customize, 'vmagazine_lite_header_icon_show',  array(
  'type'      => 'switch',                    
  'label'     => esc_html__( 'Hide/Show Social Icons', 'vmagazine-lite' ),
  'description'=> esc_html__( 'To add social icons go to "General Settings"', 'vmagazine-lite' ),
  'section'   => 'vmagazine_lite_header_option',
  'choices'   => array(
        'show'  => esc_html__( 'Show', 'vmagazine-lite' ),
        'hide'  => esc_html__( 'Hide', 'vmagazine-lite' )
      )
) ) ); 


/* social Icons */

$wp_customize->add_section( 'vmagazine_lite_header_icons', array(
	'title'           => esc_html__('Social Icons', 'vmagazine-lite'),
  'panel'           => 'general_settings'
));



$wp_customize->add_section( 'vmagazine_lite_header_layouts', array(
	'title'           => esc_html__('Header Layouts', 'vmagazine-lite'),
	'priority'        => '2',
  'panel'           => 'vmagazine_lite_header_settings_panel'
));

/**
* Mobile navigation settings
*
*/
$wp_customize->add_section( 'vmagazine_lite_mobile_header_options', array(
	'title'           =>      esc_html__('Mobile Navigation Option', 'vmagazine-lite'),
  'panel'           => 'vmagazine_lite_header_settings_panel'
));

 /** BG color **/
 $wp_customize->add_setting('vmagazine_lite_mobile_header_bg_color', array(
    'sanitize_callback' => 'esc_html',
    'transport' 		    => 'postMessage'

));

$wp_customize->add_control( new vmagazine_lite_Bg_Color_Picker( $wp_customize,'vmagazine_lite_mobile_header_bg_color', array(
    'section'  		=> 'vmagazine_lite_mobile_header_options',
    'label'    		=> esc_html__('Background Color', 'vmagazine-lite'),
    'description'	=> esc_html__('This will change image overlay color if background image exists', 'vmagazine-lite'),
)));

//mobile navigation logo
$wp_customize->add_setting('vmagazine_lite_mobile_header_logo', array(
    'sanitize_callback' => 'esc_url_raw',
));

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'vmagazine_lite_mobile_header_logo', array(
    'section'     => 'vmagazine_lite_mobile_header_options',
    'label'       => esc_html__('Logo', 'vmagazine-lite'),
    'description' => esc_html__('Add logo to display on mobile devices', 'vmagazine-lite'),
    'type'        => 'image'
)));

//mobile navigation background image
$wp_customize->add_setting('vmagazine_lite_mobile_header_bg', array(
    'sanitize_callback' => 'esc_url_raw',
));

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'vmagazine_lite_mobile_header_bg', array(
    'section'  		=> 'vmagazine_lite_mobile_header_options',
    'label'    		=> esc_html__('Background Image', 'vmagazine-lite'),
    'description'	=> esc_html__('Add background image for navigation menu and search to display on mobile view', 'vmagazine-lite'),
    'type'     		=> 'image'
)));

//bg repeat
$wp_customize->add_setting( 'vmagazine_lite_mobile_header_bg_repeat',array(
                  'sanitize_callback'   => 'esc_html',
                  'transport'           => 'postMessage',
                  'default'             => 'no-repeat'
                ));

$wp_customize->add_control( 'vmagazine_lite_mobile_header_bg_repeat', array(
            'label' 	  => esc_html__('Background Repeat','vmagazine-lite'),
            'section'   => 'vmagazine_lite_mobile_header_options',
            'type'      => 'select',
            'choices'   => array(
                'no-repeat' =>  esc_html__('No Repeat','vmagazine-lite'),
                'repeat-x'  => esc_html__('Repeat-X','vmagazine-lite'),
                'repeat-y'  => esc_html__('Repeat-Y','vmagazine-lite'),
                'repeat'    =>  esc_html__('Repeat','vmagazine-lite'),
            )
));


/**
 * Add Design Settings panel
 */
$wp_customize->add_panel('vmagazine_lite_design_settings_panel',array(
    		'priority'       => 30,
        'title'          => esc_html__( 'Design Settings', 'vmagazine-lite' ),
        ) 
);
/*------------------------------------------------------------------------------------*/
/**
 * Archive Settings
 */
$wp_customize->add_section('vmagazine_lite_archive_settings_section', array(
        'title'		=> esc_html__( 'Archive Settings', 'vmagazine-lite' ),
        'panel'     => 'vmagazine_lite_design_settings_panel',
        'priority'  => 5,
    )
);

/**
 * Archive sidebars
 */
$wp_customize->add_setting( 'vmagazine_lite_archive_sidebar', array(
		'default'			      => 'right_sidebar',
    'capability'		    => 'edit_theme_options',
		'sanitize_callback' => 'vmagazine_lite_sanitize_page_sidebar'
       )
);
$wp_customize->add_control( new vmagazine_lite_Image_Radio_Control($wp_customize, 'vmagazine_lite_archive_sidebar', array(
		'type'			  => 'radio',
		'label' 		  => esc_html__( 'Available Sidebars', 'vmagazine-lite' ),
    'description'	=> esc_html__( 'Select sidebar for whole site archives, categories, search page etc.', 'vmagazine-lite' ),
		'section' 		=> 'vmagazine_lite_archive_settings_section',
    'priority'  	=> 5,
		'choices' 		=> array(
	      'right_sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
        'left_sidebar' 	=> get_template_directory_uri() . '/assets/images/left-sidebar.png',
        'both_sidebar' 	=> get_template_directory_uri() . '/assets/images/both-sidebar.png',
        'no_sidebar' 	  => get_template_directory_uri() . '/assets/images/no-sidebar.png',
                
    		)
       )
    )
);

/**
 * Length of archive excerpt
 */
$wp_customize->add_setting( 'vmagazine_lite_archive_excerpt_lenght', array(
        'default' 			    => '150',
        'sanitize_callback' => 'vmagazine_lite_sanitize_number',
    )
);
$wp_customize->add_control('vmagazine_lite_archive_excerpt_lenght', array(
        'type'			    => 'number',
        'priority'		  => 15,
        'label'			    => esc_html__( 'Excerpt length', 'vmagazine-lite' ),
        'description'   => esc_html__( 'Choose number of words in archive pages.', 'vmagazine-lite' ),
        'section'		    => 'vmagazine_lite_archive_settings_section',
        'input_attrs'	  => array(
            'min'   => 10,
            'max'   => 100,
            'step'  => 1
        )
    )
);

/**
 * Archive read more button text
 */
$wp_customize->add_setting( 'vmagazine_lite_archive_read_more_text', array(
        'default'			      => esc_html__( 'Read More', 'vmagazine-lite' ),
        'transport'			    => 'postMessage',
        'sanitize_callback' => 'vmagazine_lite_sanitize_text'	                
   	)
);    
$wp_customize->add_control( 'vmagazine_lite_archive_read_more_text', array(
        'type'		  => 'text',
        'label' 	  => esc_html__( 'Read More Button', 'vmagazine-lite' ),
        'section' 	=> 'vmagazine_lite_archive_settings_section',
        'priority' 	=> 20
    )
);

/*------------------------------------------------------------------------------------*/
/**
 * Post Settings
 */
$wp_customize->add_section('vmagazine_lite_posts_settings_section',array(
        'title'		  => esc_html__( 'Single Post Settings', 'vmagazine-lite' ),
        'panel'     => 'vmagazine_lite_design_settings_panel',
        'priority'  => 10,
    )
);

/**
 * Post sidebars
 */
$wp_customize->add_setting('vmagazine_lite_default_post_sidebar', array(
		'default' 			    => 'right_sidebar',
        'capability' 		=> 'edit_theme_options',
		'sanitize_callback' => 'vmagazine_lite_sanitize_page_sidebar'
       )
);
$wp_customize->add_control( new vmagazine_lite_Image_Radio_Control($wp_customize,'vmagazine_lite_default_post_sidebar',array(
		'type' 			  => 'radio',
		'label' 		  => esc_html__( 'Available Sidebars', 'vmagazine-lite' ),
    'description' => esc_html__( 'Select sidebar for single post.', 'vmagazine-lite' ),
		'section' 		=> 'vmagazine_lite_posts_settings_section',
    'priority'  	=> 5,
		'choices' 		=> array(
	      'right_sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
        'left_sidebar' 	=> get_template_directory_uri() . '/assets/images/left-sidebar.png',
        'both_sidebar' 	=> get_template_directory_uri() . '/assets/images/both-sidebar.png',
        'no_sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
    		)
       )
    )
);

//Social Share options
$wp_customize->add_setting('vmagazine_lite_post_share_option',array(
        'default'           => 'hide',
        'sanitize_callback' => 'vmagazine_lite_sanitize_switch_option',
        )
);
$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control($wp_customize, 'vmagazine_lite_post_share_option', array(
            'type'        => 'switch',                  
            'label'       => esc_html__( 'Show/Hide Post Share', 'vmagazine-lite' ),
            'description' => esc_html__( 'First install and activate the plugin AccessPress Social Share.', 'vmagazine-lite' ),
            'section'     => 'vmagazine_lite_posts_settings_section',
            'choices'     => array(
                'show'    => esc_html__( 'Show', 'vmagazine-lite' ),
                'hide'    => esc_html__( 'Hide', 'vmagazine-lite' )
                ),
            'priority'    => 11,
        )
    )
);

/**
 * Switch for related post section
 */
$wp_customize->add_setting('vmagazine_lite_related_posts_option',array(
        'default' 			     => 'hide',
        'sanitize_callback'  => 'vmagazine_lite_sanitize_switch_option',
        )
);
$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control($wp_customize,'vmagazine_lite_related_posts_option', array(
            'type' 			  => 'switch',	                
            'label' 		  => esc_html__( 'Related Posts', 'vmagazine-lite' ),
            'description' => esc_html__( 'Enable/Disable related posts section in single post page.', 'vmagazine-lite' ),
            'section' 		=> 'vmagazine_lite_posts_settings_section',
            'choices'   	=> array(
                'show' 		=> esc_html__( 'Show', 'vmagazine-lite' ),
                'hide' 		=> esc_html__( 'Hide', 'vmagazine-lite' )
                ),
            'priority'  	=> 30,
        )
    )
);

/**
 * Related section title
 */
$wp_customize->add_setting('vmagazine_lite_related_posts_title', array(
        'default' 			    => esc_html__( 'Related Articles', 'vmagazine-lite' ),
        'transport' 		    => 'postMessage',
        'sanitize_callback' => 'vmagazine_lite_sanitize_text'	                
   	)
);
$wp_customize->add_control('vmagazine_lite_related_posts_title',array(
        'type'				    => 'text',
        'label' 			    => esc_html__( 'Related Section Title', 'vmagazine-lite' ),
        'section' 			  => 'vmagazine_lite_posts_settings_section',
        'priority' 			  => 35,
        'active_callback'	=> 'vmagazine_lite_related_post_option_callback'
    )
);

/**
 * Types of related posts
 */
$wp_customize->add_setting('vmagazine_lite_related_post_type',array(
        'default'           => 'related_cat',
        'sanitize_callback' => 'vmagazine_lite_sanitize_related_type',
    )
);
$wp_customize->add_control('vmagazine_lite_related_post_type',array(
        'type'        		=> 'radio',
        'label'       		=> esc_html__( 'Types of Related Posts', 'vmagazine-lite' ),
        'description' 		=> esc_html__( 'Option to display related posts from category or tags.', 'vmagazine-lite' ),
        'section'     		=> 'vmagazine_lite_posts_settings_section',            
        'choices' 			  => array(
            'related_cat' => esc_html__( 'Related Posts by Category', 'vmagazine-lite' ),
            'related_tag' => esc_html__( 'Related Posts by Tags', 'vmagazine-lite' )
        ),
        'active_callback'	=> 'vmagazine_lite_related_post_option_callback',
        'priority' 			  => 40
    )
);

/**
* Related post numbers
*
*/
$wp_customize->add_setting( 'vmagazine_lite_related_post_count', array(
		'default' 			    => 3,
		'sanitize_callback' => 'absint'
	));
$wp_customize->add_control( 'vmagazine_lite_related_post_count', array(
	'section'      => 'vmagazine_lite_posts_settings_section', 
	'priority'		 => 41,
	'label' 		   => esc_html__('Number of related posts to show','vmagazine-lite'),
	'type'			   => 'number'

));

//Related post exerpt length
$wp_customize->add_setting( 'vmagazine_lite_related_post_excerpt', array(
    'default'           => 200,
    'sanitize_callback' => 'absint'
  ));
$wp_customize->add_control( 'vmagazine_lite_related_post_excerpt', array(
  'section'      => 'vmagazine_lite_posts_settings_section', 
  'priority'     => 42,
  'label'        => esc_html__('Related Post Excerpt','vmagazine-lite'),
  'description'  => esc_html__('Enter number of letters for related posts','vmagazine-lite'),
  'type'         => 'number'

));

/*------------------------------------------------------------------------------------*/
/**
 * Page Settings
 */
$wp_customize->add_section('vmagazine_lite_page_settings_section',array(
        'title'		=> esc_html__( 'Page Settings', 'vmagazine-lite' ),
        'panel'     => 'vmagazine_lite_design_settings_panel',
        'priority'  => 15,
    )
);

/**
 * Page sidebars
 */
$wp_customize->add_setting('vmagazine_lite_default_page_sidebar', array(
		'default' 			=> 'right_sidebar',
    'capability' 		=> 'edit_theme_options',
		'sanitize_callback' => 'vmagazine_lite_sanitize_page_sidebar'
    )
);
$wp_customize->add_control( new vmagazine_lite_Image_Radio_Control($wp_customize, 'vmagazine_lite_default_page_sidebar', array(
		'type' 			  => 'radio',
		'label' 		  => esc_html__( 'Available Sidebars', 'vmagazine-lite' ),
    'description' => esc_html__( 'Select sidebar for every pages.', 'vmagazine-lite' ),
		'section' 		=> 'vmagazine_lite_page_settings_section',
    'priority'  	=> 5,
		'choices' 		=> array(
			'right_sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
            'left_sidebar' 	=> get_template_directory_uri() . '/assets/images/left-sidebar.png',
            'both_sidebar' 	=> get_template_directory_uri() . '/assets/images/both-sidebar.png',
            'no_sidebar' 	=> get_template_directory_uri() . '/assets/images/no-sidebar.png',
                
    		)
       )
    )
);

/**
 * Add Footer Settings panel
 */
$wp_customize->add_panel('access_footer_settings_panel', array(
    		  'priority'       => 40,
        	'title'          => esc_html__( 'Footer Settings', 'vmagazine-lite' ),
        ) 
);

/* Buttom Footer section */

$wp_customize->add_section( 'vmagazine_lite_buttom_footer_option', array(
	'title'           => esc_html__('Footer Options', 'vmagazine-lite'),
	'priority'        => 2,
  'panel'           => 'access_footer_settings_panel'
));

$wp_customize->add_setting( 'vmagazine_lite_buttom_footer_menu', array(
	  'default' 			      => 'hide',
	  'sanitize_callback' 	=> 'vmagazine_lite_sanitize_switch_option',
));

$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control( $wp_customize, 'vmagazine_lite_buttom_footer_menu',  array(
	  'type'      => 'switch',                    
	  'label'     => esc_html__( 'Hide / Show Footer Menu', 'vmagazine-lite' ),
	  'section'   => 'vmagazine_lite_buttom_footer_option',
	  'priority'  => 7,
	  'choices'   => array(
	        'show'  => esc_html__( 'Show', 'vmagazine-lite' ),
	        'hide'  => esc_html__( 'Hide', 'vmagazine-lite' )
	      )
) ) ); 

$wp_customize->add_setting('vmagazine_lite_footer_logo', array(
    'sanitize_callback' => 'esc_url_raw',
));

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'vmagazine_lite_footer_logo', array(
    'section'  => 'vmagazine_lite_buttom_footer_option',
    'label'    => esc_html__('Upload Footer Logo', 'vmagazine-lite'),
    'type'     => 'image'
)));

$wp_customize->add_setting( 'vmagazine_lite_buttom_footer_icons', array(
  'default' 			      => 'hide',
  'sanitize_callback' 	=> 'vmagazine_lite_sanitize_switch_option',
));

$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control( $wp_customize, 'vmagazine_lite_buttom_footer_icons',  array(
  'type'      => 'switch',                    
  'label'     => esc_html__( 'Hide / Show Social Icons', 'vmagazine-lite' ),
  'section'   => 'vmagazine_lite_buttom_footer_option',
  'active_callback' => 'vmagazine_lite_footer_layout_switcher',
  'priority'  => 5,
  'choices'   => array(
        'show'  => esc_html__( 'Show', 'vmagazine-lite' ),
        'hide'  => esc_html__( 'Hide', 'vmagazine-lite' )
      )
) ) ); 

/** 
 * copyright textarea
 */
$wp_customize->add_setting('vmagazine_lite_copyright_text',array(
        'capability' 		    => 'edit_theme_options',
        'sanitize_callback' => 'wp_kses_post'
    )
);
$wp_customize->add_control( new vmagazine_lite_Textarea_Custom_Control($wp_customize,'vmagazine_lite_copyright_text',array(
            'type' 		  => 'vmagazine_lite_textarea',
            'label' 	  => esc_html__( 'Copyright Info', 'vmagazine-lite' ),
            'section' 	=> 'vmagazine_lite_buttom_footer_option'
        )
    )
);

/**
* Footer information
*/
$wp_customize->add_setting('vmagazine_lite_description_text',array(
        'sanitize_callback' => 'wp_kses_post'
    )
);
$wp_customize->add_control( new vmagazine_lite_Textarea_Custom_Control($wp_customize,'vmagazine_lite_description_text',array(
            'type'      => 'vmagazine_lite_textarea',
            'label'     => esc_html__( 'Footer Description Text', 'vmagazine-lite' ),
            'active_callback' => 'vmagazine_lite_footer_layout_switcher',
            'section'   => 'vmagazine_lite_buttom_footer_option'
        )
    )
);

	

/*------------------------------------------------------------------------------------*/
/**
 * News Ticker
 */
$wp_customize->add_section( 'vmagazine_lite_news_ticker_section',array(
        'title'		  => esc_html__( 'News Ticker', 'vmagazine-lite' ),
        'panel'     => 'vmagazine_lite_header_settings_panel',
        'priority'  => 15,
    )
);

// News ticker option
$wp_customize->add_setting('vmagazine_lite_ticker_option',array(
    	'default'			        => 'show',
        'sanitize_callback' => 'vmagazine_lite_sanitize_switch_option'
    )
);
$wp_customize->add_control( new vmagazine_lite_Customize_Switch_Control($wp_customize, 'vmagazine_lite_ticker_option', array(
            'type' 			    => 'switch',
            'label' 		    => esc_html__( 'News Ticker', 'vmagazine-lite' ),
            'description' 	=> esc_html__( 'Enable/Disable news ticker ', 'vmagazine-lite' ),
            'section' 		=> 'vmagazine_lite_news_ticker_section',
            'choices'   	=> array(
                'show' 		=> esc_html__( 'Show', 'vmagazine-lite' ),
                'hide' 		=> esc_html__( 'Hide', 'vmagazine-lite' )
                ),
            'priority'  	=> 5,
        )	            	
    )
);

$wp_customize->add_setting( 'vmagazine_lite_ticker_disp_option', array(
    	'default'			=> 'latest-post',
      'sanitize_callback' => 'vmagazine_lite_sanitize_text'
    ) );
$wp_customize->add_control( 'vmagazine_lite_ticker_disp_option', array(
		'section'			=> 'vmagazine_lite_news_ticker_section',
		'label'				=> esc_html__( 'Select News Display Type', 'vmagazine-lite' ),
		'type'				=> 'radio',
		'choices'			=> array(
			'latest-post'	=> esc_html__('Display From Latest Posts','vmagazine-lite'),
			'cat-post'		=> esc_html__('Display From Selected Category','vmagazine-lite')
		),

	));


$cat_list = vmagazine_lite_category_lists();

$wp_customize->add_setting( 'vmagazine_lite_ticker_cat', array(
    	'default'			      => 0,
      'sanitize_callback' => 'absint'
    ) );
$wp_customize->add_control( 'vmagazine_lite_ticker_cat', array(
		'section'			    => 'vmagazine_lite_news_ticker_section',
		'label'				    => esc_html__( 'Select News Category', 'vmagazine-lite' ),
		'type'				    => 'select',
		'active_callback'	=> 'vmagazine_lite_ticker_disp_typ',
		'choices'			    => $cat_list

	));

//News ticker caption
$wp_customize->add_setting( 'vmagazine_lite_ticker_caption',  array(
        'default' 			      => esc_html__( 'Recent News', 'vmagazine-lite' ),
        'transport' 		      => 'postMessage',
        'sanitize_callback'   => 'vmagazine_lite_sanitize_text'
   	) );    
$wp_customize->add_control( 'vmagazine_lite_ticker_caption', array(
        'type'		  => 'text',
        'label' 	  => esc_html__( 'Ticker Title', 'vmagazine-lite' ),
        'section' 	=> 'vmagazine_lite_news_ticker_section',
       
    ));

//News ticker count
$wp_customize->add_setting('vmagazine_lite_ticker_count', array(
        'default' 			    => 5,
        'transport' 		    => 'postMessage',
        'sanitize_callback' => 'vmagazine_lite_sanitize_number'
   	)
);    
$wp_customize->add_control('vmagazine_lite_ticker_count',array(
        'type'			    => 'number',
        'label' 		    => esc_html__( 'Number of Posts', 'vmagazine-lite' ),
        'section' 		  => 'vmagazine_lite_news_ticker_section',
        'input_attrs' 	=> array(
            'min'   => 3,
            'max'   => 15,
            'step'  => 1
        )
    )
);
	    


}


endif;
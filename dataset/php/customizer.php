<?php
/**
 * swing lite Theme Customizer
 *
 * @package swing
 */

/**
 * Load file for customizer sanitization functions
*/
require $swing_lite_sanitize_functions_file_path = swing_lite_file_directory('inc/customizer/swing-sanitize.php');

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function swing_lite_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

/**
* General Settings Panel
*/
$wp_customize->add_panel( 'swing_lite_general_settings_panel', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'General Settings', 'swing-lite' ),
) );

	$wp_customize->get_section('title_tagline')->panel = 'swing_lite_general_settings_panel';
	
	$wp_customize->get_section('colors')->panel = 'swing_lite_general_settings_panel';
	
	$wp_customize->get_section('background_image')->panel = 'swing_lite_general_settings_panel';
	
	$wp_customize->get_section('static_front_page')->panel = 'swing_lite_general_settings_panel';

	$wp_customize->get_section('colors')->title = esc_html__( 'Themes Colors', 'swing-lite' );

      /* Inner Pages Image*/

    $wp_customize->add_panel( 
        'header_image', 
            array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Inner Pages Header Image', 'swing-lite' ),
            'description' => esc_html__( 'Description of what this panel does.', 'swing-lite' ),
        ) 
    );

    $wp_customize->add_section(
        'header_image',
        array(
            'title' => esc_html__( 'Inner Pages Header Image', 'swing-lite' ),
            'description' => esc_html__( 'Configure inner page header.', 'swing-lite' ),
            'priority' => 10,
            'panel' => 'swing_lite_general_settings_panel',
        )
    );


    /* Theme color*/
       $wp_customize->add_setting( 'swing_lite_theme_color', array( 'default' => '#d77b5c', 'sanitize_callback' => 'sanitize_hex_color' ) );
       $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 
        'swing_lite_theme_color', 
        array(
            'label'      => esc_html__( 'Swing Theme Color', 'swing-lite' ),
            'section'    => 'colors',
            'settings'   => 'swing_lite_theme_color',
        ) ) );

	/**
	 * Load Customizer Custom Control File
	*/
	require $swing_lite_customizer_file_path = swing_lite_file_directory('inc/customizer/swing-custom-controls.php');

	/**
	 * Load header panel file
	*/
	require $swing_lite_customizer_header_settings_file_path = swing_lite_file_directory('inc/customizer/header-section/header-settings.php');

	/**
	* Active call back function
	*/
	require $swing_lite_custom_active_callback_function_path = swing_lite_file_directory('inc/customizer/active-cbk.php');	

	/**
	 * Home page panel file
	*/
	require $swing_lite_customizer_home_settings_file_path = swing_lite_file_directory('inc/customizer/home-section/home-settings.php');

    /**
    * General room panel file
    */
    require $swing_lite_customizer_room_lists_settings_file_path = swing_lite_file_directory('inc/customizer/room-listing-section/room-settings.php');

	/**
	 * Footer Settings panel file
	*/
	require $swing_lite_customizer_footer_settings_file_path = swing_lite_file_directory('inc/customizer/footer-section/footer-settings.php');        

    /** pre Loader **/
        $wp_customize->add_section(
            'swing_lite_preloader_section',
            array(
                'title' => esc_html__('Pre Loader Setting','swing-lite'),
                'priority' => 5,
                'capability' => 'edit_theme_options',
                'theme_support' => '',
                'panel' => 'swing_lite_general_settings_panel'
            )
        );
        $wp_customize->add_setting( 'swing_lite_enable_pre_loader', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control(
            'swing_lite_enable_pre_loader',array(
                'label' => esc_html__('Enable Pre Loader','swing-lite'),
                'description' => esc_html__( 'Check the option to display preloader in your site.', 'swing-lite' ),
                'section' => 'swing_lite_preloader_section',
                'type' => 'checkbox',
                'priority' => 3,
            ));

    /*------------------------------------------------------------------------------------*/
    /**
     * Upgrade to Swing
    */
    // Register custom section types.
    $wp_customize->register_section_type( 'Swing_Lite_Customize_Section_Pro' );

    // Register sections.
    $wp_customize->add_section(
        new Swing_Lite_Customize_Section_Pro(
            $wp_customize,
            'swing',
            array(
                'title'    => esc_html__( 'Free Vs Pro', 'swing-lite' ),
                'pro_text' => esc_html__( 'Compare','swing-lite' ),
                'pro_url'  => admin_url( 'themes.php?page=swinglite-welcome&section=free_vs_pro'),
                'priority' => 1,
            )
        )
    );
    $wp_customize->add_setting(
        'swing_lite_upbuton',
        array(
            'section' => 'swing',
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'swing_lite_upbuton',
        array(
            'section' => 'swing'
        )
    );
}
add_action( 'customize_register', 'swing_lite_customize_register' );

/**
 * Enqueue scripts and style for customizer
*/
function swing_lite_customize_backend_scripts() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/library/fontawesome/css/font-awesome.min.css');
    wp_enqueue_style( 'swing-lite-customizer-style', get_template_directory_uri() . '/inc/customizer/assets/css/customizer-style.css' );
	wp_enqueue_style( 'swing-lite-preloader', get_template_directory_uri() . '/assets/css/preloader.css' );
	wp_enqueue_script( 'swing-lite-customizer-script', get_template_directory_uri() . '/inc/customizer/assets/js/customizer-scripts.js', array( 'jquery', 'customize-controls' ), '20160715', true );
}
add_action( 'customize_controls_enqueue_scripts', 'swing_lite_customize_backend_scripts', 10 );
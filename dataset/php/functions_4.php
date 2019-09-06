<?php
/**
 * vmagazine functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package vmagazine-lite
 */

/** important constants **/
$vmagazine_lite_theme_ob = wp_get_theme();
$vmagazine_lite_ver      = $vmagazine_lite_theme_ob -> get( 'Version' );
define( 'VMAG_VER',$vmagazine_lite_ver);
define( 'VMAG_URI', get_template_directory_uri() );
define( 'VMAG_DIR', get_template_directory() );
define( 'VMAG_LIB_URI', get_template_directory_uri(). '/assets/library/' );

if ( ! function_exists( 'vmagazine_lite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vmagazine_lite_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on vmagazine, use a find and replace
		 * to change 'vmagazine-lite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vmagazine-lite', VMAG_DIR . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );


	/*
	 * Enable support for custom logo.
	 */
	
	add_theme_support( 
		'custom-logo', array( 
			'height'      => 90,
		   	'width'       => 268,
		   	'flex-width' => true,
		   	'flex-hight' => true,
   			) 
		);
    add_image_size( 'vmagazine-lite-rectangle-thumb', 510, 369, true );
	add_image_size( 'vmagazine-lite-small-thumb', 320, 224, true );
	add_image_size( 'vmagazine-lite-single-large', 1920, 1000, true );
	add_image_size( 'vmagazine-lite-large-category', 1200, 500, true );
	add_image_size( 'vmagazine-lite-small-square-thumb', 321, 257, true );
    add_image_size( 'vmagazine-lite-slider-thumb', 300, 200, true );
    add_image_size( 'vmagazine-lite-vertical-slider-thumb', 400, 340, true );
    add_image_size( 'vmagazine-lite-post-slider-lg', 600, 400, true );


	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary_menu' => esc_html__( 'Primary Menu', 'vmagazine-lite' ),
		'top_menu' => esc_html__( 'Top Header Menu', 'vmagazine-lite' ),
		'footer_menu' => esc_html__( 'Footer Menu', 'vmagazine-lite' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'audio',
		'video',
		'gallery',
		'quote',
		'link',
	) );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );


	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'vmagazine_lite_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

	}
endif;
add_action( 'after_setup_theme', 'vmagazine_lite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vmagazine_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vmagazine_lite_content_width', 640 );
}
add_action( 'after_setup_theme', 'vmagazine_lite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vmagazine_lite_widgets_init() {
	
		register_sidebar( array(
			'name'          => esc_html__( 'Right Sidebar', 'vmagazine-lite' ),
			'id'            => 'vmagazine-lite-sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'vmagazine-lite' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title"><span class="title-bg">',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Left Sidebar', 'vmagazine-lite' ),
			'id'            => 'vmagazine_lite_left_sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'vmagazine-lite' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title"><span class="title-bg">',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Header Ads Area', 'vmagazine-lite' ),
			'id'            => 'vmagazine_lite_header_ads_area',
			'description'   => esc_html__( 'Display selected widget beside site logo.', 'vmagazine-lite' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title"><span class="title-bg">',
			'after_title'   => '</span></h4>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Side Navigation Menu Area', 'vmagazine-lite' ),
			'id'            => 'vmagazine_lite_sidebar_area',
			'description'   => esc_html__( 'Add widgets to display on sidebar', 'vmagazine-lite' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title"><span class="title-bg">',
			'after_title'   => '</span></h4>',
		) );

}
add_action( 'widgets_init', 'vmagazine_lite_widgets_init' );

/** Adding Editor Styles **/
function vmagazine_lite_add_editor_styles() {
    add_editor_style( get_template_directory_uri().'/assets/css/custom-editor-style.css' );
}

add_action( 'admin_init', 'vmagazine_lite_add_editor_styles' );

/**
 * Enqueue scripts and styles.
 */
function vmagazine_lite_scripts() {
    $vmagazine_lite_lazyload_option = get_theme_mod('vmagazine_lite_lazyload_option','enable');
    if( $vmagazine_lite_lazyload_option == 'enable' ){
	   wp_enqueue_script( 'jquery-lazy',VMAG_LIB_URI.'lazy-load/jquery.lazy.min.js', array( 'jquery' ), VMAG_VER, true );
    }
	wp_enqueue_script( 'jquery-mCustomScrollbar',VMAG_LIB_URI.'mCustomScrollbar/jquery.mCustomScrollbar.js', array( 'jquery' ), VMAG_VER, true );	
	wp_enqueue_script('jquery-fitvids',VMAG_URI.'/assets/js/jquery.fitvids.js',array('jquery'), VMAG_VER, true );
	wp_enqueue_script( 'vmagazine-lite-navigation',VMAG_URI.'/assets/js/navigation.js', array(), VMAG_VER, true );
	wp_enqueue_script( 'vmagazine-lite-skip-link-focus-fix',VMAG_URI.'/assets/js/skip-link-focus-fix.js', array(), VMAG_VER, true );
    wp_enqueue_script( 'jquery-lightslider',VMAG_LIB_URI.'lightslider/lightslider.js', array( 'jquery' ), VMAG_VER, true ); 
    wp_enqueue_script( 'jquery-wow',VMAG_URI.'/assets/js/wow.js', array( 'jquery' ), VMAG_VER, true );
    wp_enqueue_script( 'jquery-prettyphoto',VMAG_LIB_URI.'prettyPhoto/js/jquery.prettyPhoto.js', array( 'jquery' ), VMAG_VER, true );
    wp_enqueue_script( 'jquery-theia-sticky-sidebar',VMAG_LIB_URI.'theia-sticky-sidebar/theia-sticky-sidebar.js', array( 'jquery' ), VMAG_VER, true );
    wp_enqueue_script( 'jquery-slick',VMAG_LIB_URI.'slick/slick.min.js', array( 'jquery' ), VMAG_VER, true );	
	wp_register_script( 'vmagazine-lite-custom-script',VMAG_URI.'/assets/js/vmagazine-lite-custom.js', array( 'jquery' ), VMAG_VER, true );
	
	/**
	* wp localize
	*/
	$ticker_option = 'default-layout';
	$vmagazine_lite_ajax_search_enable = get_theme_mod('vmagazine_lite_ajax_search_enable','show');
    $animation_option = get_theme_mod( 'vmagazine_lite_wow_animation_option', 'enable' );
    $dir_url = VMAG_URI;
    $rtl_val = (is_rtl()) ? 'true' : 'false';
    
    $localize_options =  array(
        'mode'			=> esc_attr($animation_option),
        'ajax_search'	=> esc_attr($vmagazine_lite_ajax_search_enable),
        'ajaxurl'		=> admin_url( 'admin-ajax.php'),
        'fileUrl'		=> $dir_url,
        'lazy'          => $vmagazine_lite_lazyload_option,
        'controls'		=> $ticker_option,
        );

    wp_localize_script( 'vmagazine-lite-custom-script', 'vmagazine_lite_ajax_script', $localize_options  );
    wp_enqueue_script( 'vmagazine-lite-custom-script' );

/*===============================================================================================================================*/
    $vmagazine_lite_font_args = array(
        'family' => 'Open+Sans:400,600,700,400italic,300|Poppins:300,400,500,600,700|Montserrat:300,300i,400,800,800i|Lato:300,400,700,900',
        );
    wp_enqueue_style( 'vmagazine-lite-google-fonts', add_query_arg( $vmagazine_lite_font_args, "//fonts.googleapis.com/css" ) );
    wp_enqueue_style( 'jquery-mcustomscrollbar',VMAG_LIB_URI.'mCustomScrollbar/jquery.mCustomScrollbar.min.css', array(), VMAG_VER );
    wp_enqueue_style( 'elegant-fonts',VMAG_LIB_URI.'elegant_font/HTML-CSS/style.css', array(), VMAG_VER );  
    wp_enqueue_style( 'lightslider-style',VMAG_LIB_URI.'lightslider/lightslider.css', array(), VMAG_VER );  
    wp_enqueue_style( 'font-awesome-style',VMAG_LIB_URI.'font-awesome/css/font-awesome.min.css', array(), VMAG_VER );
    wp_enqueue_style( 'animate-css', VMAG_URI .'/assets/css/animate.css', array(), VMAG_VER );

    wp_enqueue_style( 'prettyPhoto-style',VMAG_LIB_URI.'prettyPhoto/css/prettyPhoto.css', array(), VMAG_VER );
    wp_enqueue_style( 'slick-style',VMAG_LIB_URI.'slick/slick.css', array(), VMAG_VER );
    wp_enqueue_style( 'slick-style1',VMAG_LIB_URI.'slick/slick-theme.css', array(), VMAG_VER );
    wp_enqueue_style( 'vmagazine-lite-style', get_stylesheet_uri(), array(), VMAG_VER );
    wp_enqueue_style( 'vmagazine-lite-responsive', VMAG_URI. '/assets/css/responsive.css',array(), VMAG_VER );    

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vmagazine_lite_scripts' );


/**
 * Enqueue admin scripts and styles.
 */
add_action( 'admin_enqueue_scripts', 'vmagazine_lite_admin_scripts' );
function vmagazine_lite_admin_scripts( $hook ) {
    
    $vmagazine_lite_font_args = array(
        'family' => 'Open+Sans:400,600,700,400italic,300|Poppins:300,400,500,600,700|Montserrat:300,300i,400,800,800i|Lato:300,400,700,900',
        );
    wp_enqueue_style( 'vmagazine-lite-google-fonts', add_query_arg( $vmagazine_lite_font_args, "//fonts.googleapis.com/css" ) );
    
    if ( function_exists( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

    wp_register_script( 'vmagazine-lite-of-media-uploader', VMAG_URI . '/assets/js/media-uploader.js', array('jquery'), VMAG_VER);
    wp_enqueue_script( 'vmagazine-lite-of-media-uploader' );
    wp_localize_script( 'vmagazine-lite-of-media-uploader', 'vmagazine_lite_l10n', array(
        'upload' => esc_html__( 'Upload', 'vmagazine-lite' ),
        'remove' => esc_html__( 'Remove', 'vmagazine-lite' )
        ));

    wp_enqueue_script( 'vmagazine-lite-admin-script', VMAG_URI .'/inc/assets/admin.js', array( 'jquery','jquery-ui-button' ), VMAG_VER, true );
    
    wp_enqueue_style( 'wp-color-picker' );        
    wp_enqueue_script( 'wp-color-picker' );

    wp_enqueue_style( 'vmagazine-lite-fontawesome-style',VMAG_LIB_URI.'font-awesome/css/font-awesome.min.css', array(), VMAG_VER );
    
    wp_enqueue_style( 'vmagazine-lite-admin-style', VMAG_URI . '/inc/assets/admin.css', VMAG_VER );

    wp_enqueue_style('vmagazine-lite-spectrum-css',VMAG_URI.'/inc/assets/spectrum/spectrum.css');
	wp_enqueue_script('vmagazine-lite-spectrum-js', VMAG_URI . '/inc/assets/spectrum/spectrum.js',array('jquery'));
}

/**
 * Enqueue editor styles for Gutenberg
 */
function vmagazine_lite_editor_styles() {
	$vmagazine_lite_font_args = array(
        'family' => 'Open+Sans:400,600,700,400italic,300|Poppins:300,400,500,600,700|Montserrat:300,300i,400,800,800i|Lato:300,400,700,900',
        );
    wp_enqueue_style( 'vmagazine-lite-google-fonts', add_query_arg( $vmagazine_lite_font_args, "//fonts.googleapis.com/css" ) );

    wp_enqueue_style( 'vmagazine-lite-editor-style', get_template_directory_uri() . '/assets/css/style-editor.css' );
}
add_action( 'enqueue_block_editor_assets', 'vmagazine_lite_editor_styles' );

/**
 * Implement the Custom Header feature.
 */
require VMAG_DIR . '/inc/etc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require VMAG_DIR . '/inc/etc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require VMAG_DIR . '/inc/etc/template-functions.php';

/**
 * Customizer additions.
 */
require VMAG_DIR . '/inc/customizer/customizer.php';

/**
 * Extra Init.
 */
require VMAG_DIR . '/inc/init.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require VMAG_DIR . '/inc/etc/jetpack.php';
}
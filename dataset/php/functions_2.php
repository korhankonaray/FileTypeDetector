<?php
/**
 * swing lite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package swing
 */

if ( ! function_exists( 'swing_lite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function swing_lite_setup() {
		/*
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on swing, use a find and replace
		 * to change 'swing-lite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'swing-lite', get_template_directory() . '/languages' );

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
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size('swing-lite-banner-image', 1920, 795, true); // banner image size

		add_image_size('swing-lite-about-image', 370, 250, true); // about image size

		add_image_size('swing-lite-testimonial-image', 200, 200, true); // testimonial image size

		add_image_size('swing-lite-team-image', 270, 370, true); // team image size

		add_image_size('swing-lite-gallery-image', 375, 360, true); // gallery image size

		add_image_size('swing-lite-news-offer-image', 560, 455, true); // news & offer image size

		add_image_size('swing-lite-room-lists-image', 370, 315
		, true); // rooms lists image size

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'swing-lite' ),
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

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// woocommerce single page image pop up and gallery support function
		add_theme_support('woocommerce');
	    add_theme_support( 'wc-product-gallery-zoom' );
	    add_theme_support( 'wc-product-gallery-lightbox' );
	    add_theme_support( 'wc-product-gallery-slider' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'swing_lite_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		*/
		add_editor_style( 'assets/css/editor-style.css' );

	}
endif;
add_action( 'after_setup_theme', 'swing_lite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function swing_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'swing_lite_content_width', 640 );
}
add_action( 'after_setup_theme', 'swing_lite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function swing_lite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'swing-lite' ),
		'id'            => 'swing-lite-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'swing-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Home Search Room', 'swing-lite' ),
		'id'            => 'swing-lite-home-search-room',
		'description'   => esc_html__( 'Add widgets here.', 'swing-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'WooSidebar', 'swing-lite' ),
		'id'            => 'swing-lite-woo-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'swing-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'swing_lite_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function swing_lite_scripts() {

	$swing_lite_font_url = '';
    
    $karla = _x( 'on', 'Karla font: on or off', 'swing-lite' );
    $marcellus = _x( 'on', 'Marcellus font: on or off', 'swing-lite' );
    
    if ( 'off' !== $karla || 'off' !== $marcellus ) {
		$font_families = array();
		 
		if ( 'off' !== $karla ) {
			$font_families[] = 'Karla';
		}
		 
		if ( 'off' !== $marcellus ) {
			$font_families[] = 'Marcellus';
		}
		 
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		 
		$swing_lite_font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	/**
	 * Preloader
	*/
	wp_enqueue_style( 'swing-lite-preloader', get_template_directory_uri() . '/assets/css/preloader.css');
	
	/** Swing Style **/
	wp_enqueue_style( 'swing-lite-style', get_stylesheet_uri(), array('dashicons') );
    
    /** Swing Responsive Styles **/
	wp_enqueue_style( 'swing-lite-responsive-style', get_template_directory_uri() . '/assets/css/responsive.css' );
    
    /** Swing Dynamic Styles **/
	wp_enqueue_style( 'swing-lite-dynamic-style', get_template_directory_uri() . '/assets/css/dynamic.css' );

	/** Owl Carousel Style **/
	wp_enqueue_style( 'jquery-owl-carousel', get_template_directory_uri() . '/assets/library/owl-carousel/owl.carousel.css' );

	
	wp_enqueue_style( 'swing-lite-editor-style', get_template_directory_uri() . '/assets/css/style-editor.css' );


	/** Icon Icons **/
	wp_enqueue_style( 'ionicons', get_template_directory_uri() . '/assets/library/ionicons/css/ionicons.min.css' );

	/** Selectric **/
	wp_enqueue_style('selectric', get_template_directory_uri() . '/assets/css/selectric.css');

	/** Fancybox **/
	wp_enqueue_style( 'jquery-fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css');

	/** Google Fonts **/
	wp_enqueue_style( 'swing-lite-googlefonts', $swing_lite_font_url );
    
    /** Font Awesome **/
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/library/fontawesome/css/font-awesome.min.css');

	/** Owl carousel js **/
	wp_enqueue_script( 'jquery-owl-carousel', get_template_directory_uri() . '/assets/library/owl-carousel/owl.carousel.js', array('jquery'), false, true );

	wp_enqueue_script( 'jquery-fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js', array('jquery'));

	/** selectskin **/
	wp_enqueue_script( 'jquery-selectric', get_template_directory_uri() . '/assets/js/jquery.selectric.js', array('jquery'));

	/** customizer js **/
	wp_enqueue_script( 'swing-lite-custom', get_template_directory_uri() . '/assets/js/custom.js', array( 'jquery', 'jquery-owl-carousel', 'imagesloaded', 'jquery-masonry' ) );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'swing_lite_scripts' );

/**
 * Load Repeater files.
 */
require get_template_directory() .'/inc/customizer/repeater-controller/customizer.php';

/**
 * Load Require init file.
 */
require  get_template_directory() .'/inc/init.php';
	
/**
*	Custom dynamic style
*/
require get_template_directory() . '/assets/css/style.php';

if(!function_exists('swing_lite_custom_logo_remove_itemprop')) {

	add_filter( 'get_custom_logo', 'swing_lite_custom_logo_remove_itemprop' );

	function swing_lite_custom_logo_remove_itemprop() {
	    $custom_logo_id = get_theme_mod( 'custom_logo' );
	    $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
            esc_url( home_url( '/' ) ),
            wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                'class'    => 'custom-logo',
            ) )
        );

	    return $html;
	}
}

if(!function_exists('swing_lite_admin_backend_scripts')) {
	if(is_admin()):
		function swing_lite_admin_backend_scripts() {
		    wp_enqueue_style( 'swing-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css' );            
		    wp_enqueue_script( 'swing-admin-js', get_template_directory_uri() . '/inc/admin/js/admin.js', array( 'jquery', 'jquery-ui-datepicker'), false );
		    wp_enqueue_script( 'swing-media-uploader-js', get_template_directory_uri() . '/inc/admin/js/media-uploader.js', array( 'jquery'), false );
		}
		add_action( 'admin_enqueue_scripts', 'swing_lite_admin_backend_scripts', 10 );
	endif;
}

/**
 * Enqueue editor styles for Gutenberg
 */
function swing_lite_editor_styles() {
	
	wp_enqueue_style( 'swing-lite-googlefonts', $swing_lite_font_url );

    wp_enqueue_style( 'swing-lite-editor-style', get_template_directory_uri() . '/assets/css/style-editor.css' );
}
add_action( 'enqueue_block_editor_assets', 'swing_lite_editor_styles' );

if( function_exists( 'pll_register_string' ) ) {
	$service_tags = get_theme_mod( 'swing_lite_home_services_tabs' );
	$service_tags = json_decode( $service_tags, true );

	$hotel_services = get_theme_mod( 'swing_lite_hotel_service_lists' );
	$hotel_services = json_decode( $hotel_services, true );

	$swing_lite_trans = array_merge( $service_tags, $hotel_services );

	foreach( $swing_lite_trans as $swing_lite_tran ) {

		if( isset( $swing_lite_tran['services_text'] ) ){
			pll_register_string( $swing_lite_tran['services_text'], $swing_lite_tran['services_text'] );
		}

		if( isset( $swing_lite_tran['service_title'] ) ){
			pll_register_string( $swing_lite_tran['service_title'], $swing_lite_tran['service_title'] );
		}

		if( isset( $swing_lite_tran['service_text'] ) ){
			pll_register_string( $swing_lite_tran['service_text'], $swing_lite_tran['service_text'] );
		}

		if( isset( $swing_lite_tran['service_price'] ) ){
			pll_register_string( $swing_lite_tran['service_price'], $swing_lite_tran['service_price'] );
		}

	}
}

if( !function_exists( 'pll__' ) ) {
	function pll__( $string ) {
		return esc_html($string);
	}
}
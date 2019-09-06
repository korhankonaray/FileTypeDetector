<?php
	/**
	 * Welcome Page Initiation
	*/

	include get_template_directory() . '/inc/welcome/welcome.php';

	/** Plugins **/
	$plugins = array(
		// *** Companion Plugins
		'companion_plugins' => array(),

		// *** Required Plugins
		'required_plugins' => array(
			'ap-theme-utility-plugin' => array(
				'slug' => 'ap-theme-utility-plugin',
				'name' => esc_html__('AP Theme Utility', 'vmagazine-lite'),
				'filename' =>'ap-theme-utility-plugin.php',
				'host_type' => 'wordpress', // Use either bundled, remote, wordpress
				'class' => 'APTU_Class',
				'location' => 'https://accesspressthemes.com/plugin-repo/ap-theme-utility-plugin/ap-theme-utility-plugin.zip', //get_template_directory().'/welcome/plugins/ap-theme-utility-plugin.zip',
				'info' => esc_html__('AP Theme Utility Plugin adds the feature to Import the Demo Content with a single click.', 'vmagazine-lite'),
			),
			'siteorigin-panels' => array(
				'slug' => 'siteorigin-panels',
				'name' => esc_html__('Siteorigin Pagebuilder', 'vmagazine-lite'),
				'filename' =>'siteorigin-panels.php',
				'host_type' => 'wordpress', // Use either bundled, remote, wordpress
				'class' => 'SiteOrigin_Panels',
				'location' => '', //get_template_directory().'/welcome/plugins/ap-theme-utility-plugin.zip',
				'info' => esc_html__('Page Builder by SiteOrigin makes it easy to build responsive grid-based page content that adapts to mobile devices with pixel perfect accuracy.', 'vmagazine-lite'),
			)
		),

		// *** Recommended Plugins
		'recommended_plugins' => array(
			// Free Plugins
			'free_plugins' => array(
				'accesspress-twitter-feed' => array(
					'slug' => 'accesspress-twitter-feed',
					'filename' => 'accesspress-twitter-feed.php',
					'class' => 'APTF_Class'
				),

				'siteorigin-panels' => array(
					'slug' => 'siteorigin-panels',
					'filename' => 'siteorigin-panels.php',
					'class' => 'SiteOrigin_Panels'
				),
				'contact-form-7' => array(
					'slug' => 'contact-form-7',
					'filename' => 'wp-contact-form-7.php',
					'class' => 'WPCF7'
				)
			),

			// Pro Plugins
			'pro_plugins' => array(
			)
		),
	);

	$strings = array(
		// Welcome Page General Texts
		'welcome_menu_text' => esc_html__( 'VMagazine Setup', 'vmagazine-lite' ),
		'theme_short_description' => esc_html__( 'VMagazine is a responsive free multi layout news magazine WordPress theme. The theme is perfect for all newspaper, magazines and blog websites. In fact, this is one of the quickest and simplest way to create a news magazine website. The theme is also highly configurable, uses SiteOrigin Page Builder, has 8 built in widgets, 4 elegantly designed demo layouts that can be imported with just one click and the flexibility to place your ads as you desire.', 'vmagazine-lite' ),

		// Plugin Action Texts
		'install_n_activate' => esc_html__('Install and Activate', 'vmagazine-lite'),
		'deactivate' => esc_html__('Deactivate', 'vmagazine-lite'),
		'activate' => esc_html__('Activate', 'vmagazine-lite'),

		// Getting Started Section
		'doc_heading' => esc_html__('Step 1 - Documentation', 'vmagazine-lite'),
		'doc_description' => esc_html__('Read the Documentation and follow the instructions to manage the site , it helps you to set up the theme more easily and quickly. The Documentation is very easy with its pictorial  and well managed listed instructions. ', 'vmagazine-lite'),
		'doc_read_now' => esc_html__( 'Read Now', 'vmagazine-lite' ),
		'cus_heading' => esc_html__('Step 2 - Customizer Options Panel', 'vmagazine-lite'),
		'cus_description' => esc_html__('Using the WordPress Customizer you can easily customize every aspect of the theme.', 'vmagazine-lite'),
		'cus_read_now' => esc_html__( 'Go to Customizer Panels', 'vmagazine-lite' ),

		// Recommended Plugins Section
		'pro_plugin_title' => esc_html__( 'Pro Plugins', 'vmagazine-lite' ),
		'pro_plugin_description' => esc_html__( 'Take Advantage of some of our Premium Plugins.', 'vmagazine-lite' ),
		'free_plugin_title' => esc_html__( 'Free Plugins', 'vmagazine-lite' ),
		'free_plugin_description' => esc_html__( 'These Free Plugins might be handy for you.', 'vmagazine-lite' ),

		// Demo Actions
		'activate_btn' => esc_html__('Activate', 'vmagazine-lite'),
		'installed_btn' => esc_html__('Activated', 'vmagazine-lite'),
		'demo_installing' => esc_html__('Installing Demo', 'vmagazine-lite'),
		'demo_installed' => esc_html__('Demo Installed', 'vmagazine-lite'),
		'demo_confirm' => esc_html__('Are you sure to import demo content ?', 'vmagazine-lite'),

		// Actions Required
		'req_plugins_installed' => esc_html__( 'All Recommended action has been successfully completed.', 'vmagazine-lite' ),
		'customize_theme_btn' => esc_html__( 'Customize Theme', 'vmagazine-lite' ),
	);

	/**
	 * Initiating Welcome Page
	*/
	$my_theme_wc_page = new constructera_Welcome( $plugins, $strings );


	/**
	 * Initiate Demo Importer if plugin Exists
	*/
	if(class_exists('APTU_Class')) :

		$demos = array(

			'world-demo' => array(
				'title' => esc_html__('World Mag Demo', 'vmagazine-lite'),
				'name' => 'world-demo',
				'preview_url' => 'https://demo.accesspressthemes.com/vmagazine-lite/worldmag/',
				'screenshot' => get_template_directory_uri().'/inc/welcome/demos/world-demo/screen.jpg',
				'home_page' => 'home',
				'menus' => array(
					'primary menu' => 'primary_menu',
					'Footer Menu' => 'footer_menu',
					'Top Menus' => 'top_menu',

				)
			),
            
            'tech-demo' => array(
				'title' => esc_html__('Tech Mag Demo', 'vmagazine-lite'),
				'name' => 'tech-demo',
				'preview_url' => 'https://demo.accesspressthemes.com/vmagazine-lite/techmag/',
				'screenshot' => get_template_directory_uri().'/inc/welcome/demos/tech-demo/screen.jpg',
				'home_page' => 'home-2',
				'menus' => array(
					'primary menu' => 'primary_menu',
					'Footer Menu' => 'footer_menu',
					'top menu' => 'top_menu',
				)
			),
            
            'fashion-demo' => array(
				'title' => esc_html__('Fashion Demo', 'vmagazine-lite'),
				'name' => 'fashion-demo',
				'preview_url' => 'https://demo.accesspressthemes.com/vmagazine-lite/fashion/',
				'screenshot' => get_template_directory_uri().'/inc/welcome/demos/fashion-demo/screen.jpg',
				'home_page' => 'home',
				'menus' => array(
					'Fashion Menu' => 'primary_menu',
					'Footer Menu' => 'footer_menu',
					'top menu' => 'top_menu',
				)
			),
            
            'gaming-demo' => array(
				'title' => esc_html__('Gaming Demo', 'vmagazine-lite'),
				'name' => 'gaming-demo',
				'preview_url' => 'https://demo.accesspressthemes.com/vmagazine-lite/gaming/',
				'screenshot' => get_template_directory_uri().'/inc/welcome/demos/gaming-demo/screen.jpg',
				'home_page' => 'home',
				'menus' => array(
					'primary menu' => 'primary_menu',
					'Footer Menu' => 'footer_menu',
					'Top Header Menu' => 'top_menu',
				)
			),

			'newspaper-demo' => array(
				'title' => esc_html__('Newspaper Demo', 'vmagazine-lite'),
				'name' => 'newspaper-demo',
				'preview_url' => 'https://demo.accesspressthemes.com/vmagazine-lite/newspaper/',
				'screenshot' => get_template_directory_uri().'/inc/welcome/demos/newspaper-demo/screen.jpg',
				'home_page' => 'home',
				'menus' => array(
					'primary menu' => 'primary_menu',
					'Footer Menu' => 'footer_menu',
					'Top Header Menu' => 'top_menu',
				)
			),
			
		);

		$demoimporter = new APTU_Class( $demos, $demo_dir = get_template_directory().'/inc/welcome/demos/' );

	endif;
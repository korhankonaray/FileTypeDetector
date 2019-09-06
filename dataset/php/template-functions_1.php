<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package vmagazine-lite
 */

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
// function vmagazine_lite_pingback_header() {
// 	if ( is_singular() && pings_open() ) {
// 		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
// 	}
// }
// add_action( 'wp_head', 'vmagazine_lite_pingback_header' );


/*-------------------------------------------------------------------------------------------------------------------------
** vmagazine template functions start
**------------------------------------------------------------------------------------------------------------------------*/


if(! function_exists('vmagazine_lite_nav_header')){
	function vmagazine_lite_nav_header(){
	?>
	<div class="vmagazine-lite-nav-wrapper">
		<div class="vmagazine-lite-container clearfix">			
			<nav id="site-navigation" class="main-navigation clearfix" >
				<div class="nav-wrapper">
					
		            <?php vmagazine_lite_home_icon(); ?>
					<?php wp_nav_menu( array( 'theme_location' => 'primary_menu','container_class'=>'menu-mmnu-container', 'fallback_cb' => 'vmagazine_lite_menu_fallback_message' ) ); ?>
				</div><!-- .nav-wrapper -->
			</nav><!-- #site-navigation -->

			<?php
			$vmagazine_lite_cart_show = get_theme_mod('vmagazine_lite_cart_show','show');
			if ( function_exists( 'vmagazine_lite_woocommerce_header_cart')  && ($vmagazine_lite_cart_show == 'show')  ) {
				vmagazine_lite_woocommerce_header_cart();
			}
			
			?>

		</div><!-- .vmagazine-lite-container -->	
	</div>
	<?php	
	}
}

/*-------------------------------------------------------------------------------------------------------------------------
/**
* Mobile navigation menu
*/
if(! function_exists('vmagazine_lite_nav_mobile_header')){
	function vmagazine_lite_nav_mobile_header(){
	?>
	<div class="vmagazine-lite-nav-wrapper">
		<div class="vmagazine-lite-container">			
			<nav class="main-navigation clearfix" >
				<div class="nav-wrapper">
					
		            <?php vmagazine_lite_home_icon(); ?>
					<?php wp_nav_menu( array( 'theme_location' => 'primary_menu','container_class'=>'menu-mmnu-container', 'menu_id' => 'primary-menu', 'fallback_cb' => 'vmagazine_lite_wp_page_menu','menu_class' => 'vmagazine_lite_mega_menu' ) ); ?>
				</div><!-- .nav-wrapper -->
			</nav><!-- #site-navigation -->

			<?php
			$vmagazine_lite_cart_show = get_theme_mod('vmagazine_lite_cart_show','show');
			if ( function_exists( 'vmagazine_lite_woocommerce_header_cart')  && ($vmagazine_lite_cart_show == 'show')  ) {
				vmagazine_lite_woocommerce_header_cart();
			}
			
			?>

		</div><!-- .vmagazine-lite-container -->	
	</div>
	<?php	
	}
}
/**
 * Function to display home icon
 *
 * @since 1.0.0
 */
if( !function_exists( 'vmagazine_lite_home_icon' ) ):
    function vmagazine_lite_home_icon() {
        $home_icon = get_theme_mod( 'vmagazine_lite_home_icon_picker', 'fa-home');
        if( $home_icon != '' ) {
    ?>
        <div class="index-icon">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa <?php echo esc_attr($home_icon); ?>"></i></a>
        </div>
    <?php
        }
    }
endif;

/**
 * Function to display social icons
 *
 * @since 1.0.0
 */

if(!function_exists('vmagazine_lite_social_icons')){
	function vmagazine_lite_social_icons(){
	    $vmagazine_lite_icons_value =  get_theme_mod('vmagazine_lite_social_icons');
	    $vmagazine_lite_icons = json_decode($vmagazine_lite_icons_value);
	    ?>
	    <ul class="social">
	    	<?php 
	    	if( $vmagazine_lite_icons ):
	    	foreach( $vmagazine_lite_icons as $vmagazine_lite_icon ){
	    		$social_link = $vmagazine_lite_icon->social_url;
	    		$social_icon = $vmagazine_lite_icon->social_icons; ?>
		        <li>
		        	<a href="<?php echo esc_url($social_link);?>">
		        		<i class="<?php echo esc_attr($social_icon);?>"></i>
		        	</a>
		        </li>
	        <?php }
	        endif; ?>
		</ul>									
	    <?php
	}
}


if ( ! function_exists( 'vmagazine_lite_credit' ) ) {
	/**
	 * Display the theme credit/button footer
	 * @since  1.0.0
	 * @return void
	 */
	function vmagazine_lite_credit() {
		?>
				<div class="site-info">
					<?php $copyright = get_theme_mod( 'vmagazine_lite_copyright_text' ); 
					if( !empty( $copyright ) ) { 
						echo wp_kses_post($copyright) . " | "; 
		            } ?>
		            <?php echo esc_html__('WordPress Theme :', 'vmagazine-lite'); ?> <a href="https://accesspressthemes.com/" target="_blank">VMagazine Lite</a> 
				</div><!-- .site-info -->				
		<?php
	}
}


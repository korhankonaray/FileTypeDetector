<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package vmagazine-lite
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function vmagazine_lite_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'vmagazine_lite_woocommerce_setup' );




/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function vmagazine_lite_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';
    
    
    if( is_woocommerce() ){
        $classes[] = 'columns-3';
    }

	return $classes;
}
add_filter( 'body_class', 'vmagazine_lite_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function vmagazine_lite_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'vmagazine_lite_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function vmagazine_lite_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'vmagazine_lite_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function vmagazine_lite_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'vmagazine_lite_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function vmagazine_lite_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'vmagazine_lite_woocommerce_related_products_args' );

if ( ! function_exists( 'vmagazine_lite_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function vmagazine_lite_woocommerce_product_columns_wrapper() {
		$columns = vmagazine_lite_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'vmagazine_lite_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'vmagazine_lite_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function vmagazine_lite_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'vmagazine_lite_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'vmagazine_lite_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function vmagazine_lite_woocommerce_wrapper_before() {
				$sidebar_class = '';
		    	if( is_active_sidebar( 'shop-right' ) ){
		    		$sidebar_class = 'sidebar-shop';
		    	}
		?>
        <div class="vmagazine-lite-container <?php echo esc_attr($sidebar_class)?>">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'vmagazine_lite_woocommerce_wrapper_before' );

if ( ! function_exists( 'vmagazine_lite_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function vmagazine_lite_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->
    	<?php 
    	if( is_active_sidebar( 'shop-right' ) ){
    		get_sidebar('shop');
    	}
     	?>
        </div><!-- #container -->    
<?php
	}
}
add_action( 'woocommerce_after_main_content', 'vmagazine_lite_woocommerce_wrapper_after' );



/**
* Remove woocommerce sidebar
*/
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/** remove woocommerce breadcrumb **/
remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);


if ( ! function_exists( 'vmagazine_lite_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function vmagazine_lite_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		//vmagazine_lite_woocommerce_cart_link();
        ?>
         <span class="count"><?php echo absint(WC()->cart->get_cart_contents_count()); ?></span>
        <?php
		//$fragments['a.cart-contents'] = ob_get_clean();
        $fragments['span.count'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'vmagazine_lite_woocommerce_cart_link_fragment' );


if ( ! function_exists( 'vmagazine_lite_woocommerce_cart_links' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function vmagazine_lite_woocommerce_cart_links() {
		?>		
				<a href="<?php echo esc_url(wc_get_cart_url());?>">
					<span class="icon">
						<i class="icon_bag_alt"></i>
					</span>
				</a>
				 <span class="count">
					 <?php echo  esc_attr(WC()->cart->get_cart_contents_count() )?>
					  


				 </span>
			
		<?php
	}
}

if ( ! function_exists( 'vmagazine_lite_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function vmagazine_lite_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul class="site-header-cart">
			<li class="cart-icon <?php echo esc_attr( $class ); ?>">
				<?php vmagazine_lite_woocommerce_cart_links(); ?>
			</li>
        <?php if ( WC()->cart->get_cart_contents_count() != 0 ) { ?>
			<li class="cart-items">
				<?php
					$instance = array(
						'title' => '',
					);

					the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
        <?php } ?>
		</ul>
		<?php
	}
}


/**
* Shop Widget area
*/
if( ! function_exists( 'vmagazine_lite_shop_sidebar_area') ){
    function vmagazine_lite_shop_sidebar_area(){
        
        register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'vmagazine-lite' ),
		'id'            => 'shop-right',
		'description'   => esc_html__( 'Add widgets here to show on shop page.', 'vmagazine-lite' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title' 		=> '<h4 class="widget-title"><span class="title-bg">',
		'after_title' 		=> '</span></h4>',
	) );
        
    }
}add_action( 'widgets_init', 'vmagazine_lite_shop_sidebar_area' );


remove_action('woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10 );
function vmagazine_lite_product_img_wrapper(){
	echo '<div class="product-img-wrap">';
	woocommerce_template_loop_product_link_open();
}
add_action('woocommerce_before_shop_loop_item','vmagazine_lite_product_img_wrapper', 10 );



remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
remove_action('woocommerce_template_loop_product_title','woocommerce_template_loop_product_thumbnail',10);

function vmagazine_lite_product_wrap(){
    woocommerce_template_loop_product_thumbnail();
    woocommerce_template_loop_product_link_close();
}

add_action('woocommerce_template_loop_product_title','vmagazine_lite_product_wrap',10);

/**
* Remove woocommerce arhive title
*/
add_filter( 'woocommerce_show_page_title', 'vmagazine_lite_shop_title' );
function vmagazine_lite_shop_title(){
	return false;
}


remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10);
function vmagazine_lite_cart_move(){
	woocommerce_template_loop_add_to_cart();
	echo '</div>';
}
add_action('woocommerce_before_shop_loop_item_title','vmagazine_lite_cart_move',10);



remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);
function vmagazine_lite_product_title_link(){
	woocommerce_template_loop_product_link_open();
	woocommerce_template_loop_product_title();
	woocommerce_template_loop_product_link_close();
}
add_action('woocommerce_shop_loop_item_title','vmagazine_lite_product_title_link',10);


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action('woocommerce_archive_description','woocommerce_product_archive_description', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
function vmagazine_lite_archive_sorting(){
	woocommerce_result_count();
	woocommerce_catalog_ordering();

}
add_action('woocommerce_archive_description','vmagazine_lite_archive_sorting',10);
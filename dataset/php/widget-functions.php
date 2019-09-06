<?php
/**
 * Register widget area and call widget files
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

/**
* constants for widgets
*/
define( 'VMAG_WIDGET_IMG_URI', get_template_directory_uri() .'/assets/images/widgets-layouts/' );

/*===========================================================================================================*/
/**
 * Define categories lists in array
 */
$vmagazine_lite_categories = get_categories( array( 'hide_empty' => true ) );
foreach ( $vmagazine_lite_categories as $vmagazine_lite_category ) {
    $vmagazine_lite_cat_array[$vmagazine_lite_category->term_id] = $vmagazine_lite_category->cat_name.' ('. $vmagazine_lite_category->category_count.')';
}

//categories in dropdown
$vmagazine_lite_cat_dropdown['0'] = esc_html__( '--Select Category--', 'vmagazine-lite' );
foreach ( $vmagazine_lite_categories as $vmagazine_lite_category ) {
    $vmagazine_lite_cat_dropdown[$vmagazine_lite_category->term_id] = $vmagazine_lite_category->cat_name.' ('. $vmagazine_lite_category->category_count.')';
}

/**
 * radio option for types
 */
$vmagazine_lite_posts_type = array(
    'latest_posts'   => esc_html__( 'From Latest Posts', 'vmagazine-lite' ),
    'random_posts'   => esc_html__( 'Random Posts', 'vmagazine-lite' ),
    'category_posts' => esc_html__( 'From Selected Category', 'vmagazine-lite' )
    );
/*--------------------------------------------------------------------------------------------------------*/
/**
 * Widget title function
 *
 * @param $widget_title string
 * @param $widget_title url
 *
 *  @return <h4>Widget title</h4> or <h4><a href="widget_title_url">widget title</a></h4> ( if widet url is not empty )
 */

if( ! function_exists( 'vmagazine_lite_widget_title' ) ):
  function vmagazine_lite_widget_title( $widget_title, $vmagazine_lite_cat_id ) {
    if( empty($widget_title) && empty( $vmagazine_lite_cat_id ) ) {
      return;
    }
?>
    <h4 class="block-title"><span class="title-bg">
<?php
    if( !empty( $widget_title ) ) {
      echo esc_html( $widget_title );
    } else {
      echo esc_html(get_cat_name( $vmagazine_lite_cat_id ));
    }
?>
    </span></h4>
<?php
  }
endif;


function vmagazine_lite_html_widget_title( $old_title ) {

  if(  is_page_template('tpl-blank.php') ){
    $output = '<span class="title-bg">';
    $output .= $old_title;
    $output .= '</span>';
    return $output;
  }else{
    return $old_title;
  }

}
add_filter( 'widget_title', 'vmagazine_lite_html_widget_title' );

/*===========================================================================================================*/
/**
 * Function about custom query arguments
 * 
 * @param string $vmagazine_lite_query_type (required options "latest_posts" or "   ")
 * @param int $vmagazine_lite_post_count
 * @param int $vmagazine_lite_cat_id
 * @return array $vmagazine_lite_args
 */
if( ! function_exists( 'vmagazine_lite_query_args' ) ) :
    function vmagazine_lite_query_args( $vmagazine_lite_query_type, $vmagazine_lite_post_count, $vmagazine_lite_cat_id = null) {

        if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
        elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
        else { $paged = 1; }
        
        if( $vmagazine_lite_query_type == 'category_posts' && !empty( $vmagazine_lite_query_type ) ) {
           $vmagazine_lite_args = array(
               'post_type'      => 'post',
               'paged'          => $paged,
               'category__in'   => $vmagazine_lite_cat_id,
               'posts_per_page' => $vmagazine_lite_post_count,                       
               );
       } elseif( $vmagazine_lite_query_type == 'latest_posts' ) {
           $vmagazine_lite_args = array(
               'post_type'            => 'post',  
               'paged'                => $paged,                 
               'posts_per_page'       => $vmagazine_lite_post_count,
               'ignore_sticky_posts'  => 1
               );

       }else{
        $vmagazine_lite_args = array(
               'post_type'            => 'post',
               'orderby'              => 'rand',  
               'paged'                => $paged,                 
               'posts_per_page'       => $vmagazine_lite_post_count,
               'ignore_sticky_posts'  => 1
               );
       }
       return $vmagazine_lite_args;
   }
   endif;


/*--------------------------------------------------------------------------------------------------------*/
/**
 * View all button in block section
 */
if( !function_exists( 'vmagazine_lite_block_view_all' ) ):
  function vmagazine_lite_block_view_all( $vmagazine_lite_block_cat_id, $view_all_text ) {
    if( $vmagazine_lite_block_cat_id != null ) {
      $vmagazine_lite_block_cat_link = get_category_link( $vmagazine_lite_block_cat_id );
?>
      <span class="view-all"><a href="<?php echo esc_url( $vmagazine_lite_block_cat_link ); ?>"><?php echo esc_html( $view_all_text ); ?></a></span>
<?php
    }
  }
endif;

/*--------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue all widget's admin scripts
 */
function vmagazine_lite_widget_enqueue_scripts(){
    
    wp_enqueue_style( 'vmagazine-lite-widget',VMAG_URI.'/inc/widgets/assets/vmagazine-lite_wie.css', array(), VMAG_VER );
    wp_enqueue_script( 'vmagazine-lite-widget',VMAG_URI.'/inc/widgets/assets/vmagazine-lite_wie.js', array( 'jquery' ), VMAG_VER, true );
}
add_action( 'admin_print_scripts-widgets.php', 'vmagazine_lite_widget_enqueue_scripts' );
// Add this to enqueue your scripts on Page Builder too
add_action('siteorigin_panel_enqueue_admin_scripts', 'vmagazine_lite_widget_enqueue_scripts');

/*--------------------------------------------------------------------------------------------------------*/
/**
 * Load individual widgets file and required related files too.
 */

require get_template_directory() . '/inc/widgets/widget-fields.php'; // widget fields
require get_template_directory() . '/inc/widgets/vmagazine-lite-featured-slider.php'; // Feature slider
require get_template_directory() . '/inc/widgets/vmagazine-lite-fullwidth-slider.php'; // Fullwidth slider
require get_template_directory() . '/inc/widgets/vmagazine-lite-category-slider.php'; // Category posts slider
require get_template_directory() . '/inc/widgets/vmagazine-lite-timeline-posts.php'; // Timeline Posts
require get_template_directory() . '/inc/widgets/vmagazine-lite-medium-ad.php'; // Medium ad
require get_template_directory() . '/inc/widgets/vmagazine-lite-recent-posts.php';
require get_template_directory() . '/inc/widgets/vmagazine-lite-slider-tab-carousel.php';
require get_template_directory() . '/inc/widgets/vmagazine-lite-multiple-category-tabbed.php';
require get_template_directory() . '/inc/widgets/vmagazine-lite-block-post-slider.php';


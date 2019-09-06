<?php
/**
 * Define function under assign hook
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

/*===========================================================================================================*/
/**
 * Function to display different layout of header
 *
 * @since 1.0.0
 */
add_action( 'vmagazine_lite_mobile_header_navigation', 'vmagazine_lite_skip_links', 0 );
if ( ! function_exists( 'vmagazine_lite_skip_links' ) ) {
    /**
     * Skip links
     * @since  1.0.0
     * @return void
     */
    function vmagazine_lite_skip_links() {
        ?>
            <a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'vmagazine-lite' ); ?></a>
            <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'vmagazine-lite' ); ?></a>
        <?php
    }
}


/*===========================================================================================================*/
/**
 * Function to display current date at top header
 *
 * @since 1.0.0
 */
add_action( 'vmagazine_lite_header_date', 'vmagazine_lite_header_date_hook' );

if( ! function_exists( 'vmagazine_lite_header_date_hook' ) ):
    function vmagazine_lite_header_date_hook() {
        $vmagazine_lite_date_option = get_theme_mod( 'vmagazine_lite_header_date_option', 'show' );
        if( $vmagazine_lite_date_option != 'hide' ) {
?>
            <div class="vmagazine-lite-current-date"><?php echo esc_html( date_i18n( 'l, F j, Y' ) ); ?></div>
<?php
        }
    }
endif;
/*===========================================================================================================*/
/**
 * Related posts section
 *
 * @since 1.0.0
 */
add_action( 'vmagazine_lite_related_posts', 'vmagazine_lite_related_posts_hook' );

if( !function_exists( 'vmagazine_lite_related_posts_hook' ) ):
    function vmagazine_lite_related_posts_hook() {
        $vmagazine_lite_related_posts_option = get_theme_mod( 'vmagazine_lite_related_posts_option', 'hide' );
        $vmagazine_lite_related_post_title = get_theme_mod( 'vmagazine_lite_related_posts_title', esc_html__( 'Related Articles', 'vmagazine-lite' ) );
        if( $vmagazine_lite_related_posts_option == 'hide' ) 
            return;

                wp_reset_postdata();
                global $post;
                if( empty( $post ) ) {
                    $post_id = '';
                } else {
                    $post_id = $post->ID;
                }

                $vmagazine_lite_related_posts_type = get_theme_mod( 'vmagazine_lite_related_post_type', 'related_cat' );
                
                $vmagazine_lite_related_post_count = get_theme_mod('vmagazine_lite_related_post_count',3);
                $vmagazine_lite_related_post_excerpt = get_theme_mod('vmagazine_lite_related_post_excerpt',200);
                // Define related post arguments
                $related_args = array(
                    'no_found_rows'            => true,
                    'update_post_meta_cache'   => false,
                    'update_post_term_cache'   => false,
                    'ignore_sticky_posts'      => 1,
                    'orderby'                  => 'rand',
                    'post__not_in'             => array( $post_id ),
                    'posts_per_page'           => absint($vmagazine_lite_related_post_count)
                );

                
                if ( $vmagazine_lite_related_posts_type == 'related_tag' ) {
                    $tags = wp_get_post_tags( $post_id );
                    if ( $tags ) {
                        $tag_ids = array();
                        foreach( $tags as $individual_tag ) $tag_ids[] = $individual_tag->term_id;
                        $related_args['tag__in'] = $tag_ids;
                    }
                } else {
                    $categories = get_the_category( $post_id );
                    if ( $categories ) {
                        $category_ids = array();
                        foreach( $categories as $individual_category ) {
                            $category_ids[] = $individual_category->term_id;
                        }
                        $related_args['category__in'] = $category_ids;
                    }
                }

                $related_query = new WP_Query( $related_args );
                if( $related_query->have_posts() ) {
                    ?>
                    <div class="vmagazine-lite-related-wrapper">
                <h4 class="related-title">
                    <span class="title-bg"><?php echo esc_html( $vmagazine_lite_related_post_title ); ?></span>
                </h4>
                <?php
                    echo '<div class="related-posts-wrapper clearfix">';
                    while( $related_query->have_posts() ) {
                        $related_query->the_post();
                        $image_id = get_post_thumbnail_id();
                        $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $image_path = wp_get_attachment_image_src( $image_id, 'vmagazine-lite-rectangle-thumb', true );
                        $img_src = vmagazine_lite_home_element_img('vmagazine-lite-rectangle-thumb');
                        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                ?>
                        <div class="single-post">
                            <?php if( $img_src ): ?>
                            <div class="post-thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php the_title(); ?>" />
                                </a>
                                <?php do_action( 'vmagazine_lite_post_cat_or_tag_lists' ); ?>
                            </div>
                            <?php endif; ?>
                            <div class="related-content-wrapper">
                                <div class="post-meta"><?php do_action( 'vmagazine_lite_icon_meta' ); ?></div>
                                 <h3 class="small-font"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="post-contents">
                                    <?php echo vmagazine_lite_get_excerpt_content( absint($vmagazine_lite_related_post_excerpt)) // WPCS: XSS ok. ?> 
                                </div>   
                                <a href="<?php the_permalink() ?>" class="vmagazine-lite-related-more">
                                    <?php echo esc_html__('Read More','vmagazine-lite');?>
                                </a>
                            </div>
                            
                        </div><!--. single-post -->
                <?php
                    }
                     wp_reset_postdata();
                    echo '</div>';
                    ?>
                    </div><!-- .vmagazine-lite-related-wrapper -->
                <?php 
                }
               
        ?>
           
<?php
    }
endif;
/*===========================================================================================================*/
/**
 * Get random icon at primary menu
 *
 * @since 1.0.0
 */
add_action( 'vmagazine_lite_menu_random_icon', 'vmagazine_lite_menu_random_icon_hook' );

if( ! function_exists( 'vmagazine_lite_menu_random_icon_hook' ) ):
    function vmagazine_lite_menu_random_icon_hook() {
        $vmagazine_lite_random_icon = get_theme_mod( 'vmagazine_lite_menu_random_option', 'show' );
        $vmagazine_lite_random_icon_class = get_theme_mod( 'vmagazine_lite_random_post_icon', 'fa-random' );
        if( $vmagazine_lite_random_icon != 'hide' ) {
            $vmagazine_lite_random_post_args = array( 
                        'posts_per_page'        => 1,
                        'post_type'             => 'post',
                        'ignore_sticky_posts'   => true,
                        'orderby'               => 'rand'
                    );
            $vmagazine_lite_random_post_query = new WP_Query( $vmagazine_lite_random_post_args );
            while( $vmagazine_lite_random_post_query->have_posts() ) {
                $vmagazine_lite_random_post_query->the_post();
    ?>
                <a href="<?php the_permalink(); ?>" class="icon-random" title="<?php esc_attr_e( 'View a random post', 'vmagazine-lite' ); ?>">
                    <i class="fa <?php echo esc_attr( $vmagazine_lite_random_icon_class ); ?>"></i>
                </a>
    <?php
            }
            wp_reset_postdata();
        }
    }
endif;

/*===========================================================================================================*/
/**
 * Function to display post categories or tags lists
 *
 * @since 1.0.0
 */
add_action( 'vmagazine_lite_post_cat_or_tag_lists', 'vmagazine_lite_post_cat_or_tag_lists_cb' );
if( ! function_exists( 'vmagazine_lite_post_cat_or_tag_lists_cb' ) ) :
    function vmagazine_lite_post_cat_or_tag_lists_cb() {

       

        if ( 'post' === get_post_type() ) {
            
                global $post;
                $categories = get_the_category();
                $separator = ' ';
                $output = '';
                if( $categories ) {
                    $output .= '<span class="cat-links">';
                    foreach( $categories as $category ) {
                        $output .= '<a href="'.get_category_link( $category->term_id ).'" class="cat-' . $category->term_id . '" rel="category tag">'.$category->cat_name.'</a>';                   
                    }
                    $output .='</span>';
                    echo wp_kses_post(trim( $output, $separator ));
                }
        }
    }
endif;
/*===========================================================================================================*/
/**
* Display single category name only
*
*/
add_action('vmagazine_lite_single_cat','vmagazine_lite_single_cat');
if( ! function_exists('vmagazine_lite_single_cat') ){
    function vmagazine_lite_single_cat(){
        $categories = get_the_category();
        $cat_link = get_category_link( $categories[0]->term_id );
        if ( ! empty( $categories ) ) {
        echo '<span class="cat-links">';
            echo '<a href="'.esc_url($cat_link).'">'.esc_html($categories[0]->name).'</a>';
        echo '</span>';
       }
    }
}
/*===========================================================================================================*/
/**
 * Post format icon for homepage widget
 *
 * @since 1.0.0
 */
add_action( 'vmagazine_lite_post_format_icon', 'vmagazine_lite_post_format_icon_cb' );

if( ! function_exists( 'vmagazine_lite_post_format_icon_cb' ) ) {
    function vmagazine_lite_post_format_icon_cb() {
        global $post;
        $post_id = $post->ID;
        $post_format = get_post_format( $post_id );
        if( $post_format == 'video' ) {
            echo '<span class="post-format-icon video-icon "><i class="icon_film"></i></span>';
        } elseif( $post_format == 'audio' ) {
            echo '<span class="post-format-icon audio-icon"><i class="icon_volume-high_alt"></i></span>';
        } elseif( $post_format == 'gallery' ) {
            echo '<span class="post-format-icon gallery-icon"><i class="icon_images"></i></span>';
        } else { } 
    }    
}

/*===========================================================================================================*/
/**
* Mobile Navigation 
*
*/
if( ! function_exists('vmagazine_lite_mob_nav_logo') ){
    function vmagazine_lite_mob_nav_logo(){
        $vmagazine_lite_mobile_header_logo = get_theme_mod('vmagazine_lite_mobile_header_logo');
        $image_id   = get_post_thumbnail_id();
        $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        $image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

        if( $vmagazine_lite_mobile_header_logo ){ ?>
            <a href="<?php echo esc_url(home_url('/'));?>">
                <img src="<?php echo esc_url($vmagazine_lite_mobile_header_logo); ?>" alt="<?php echo esc_attr($alt);?>" >
            </a>
        <?php
        }else{
            the_custom_logo();
        }
    }
}


add_action('vmagazine_lite_mobile_header','vmagazine_lite_mobile_header');
function vmagazine_lite_mobile_header(){
?>
    <div class="vmagazine-lite-mob-outer">
        <div class="vmagazine-lite-mobile-nav-wrapp">
            <div class="mob-search-icon">
                <span>
                    <i class="fa fa-search" aria-hidden="true"></i>
                </span>
             </div>
             <div class="vmagazine-lite-logo">
                <?php vmagazine_lite_mob_nav_logo(); ?>
             </div>
             <div class="nav-toggle">
                <div class="toggle-wrap">
                 <span></span>
                </div>
             </div>
        </div>
    </div>
<?php 
}
add_action('vmagazine_lite_mobile_header_navigation','vmagazine_lite_header_navigation',10);
function vmagazine_lite_header_navigation(){
?>
    
    <div class="vmagazine-lite-mobile-search-wrapper">
        <div class="mob-search-form">
             <div class="img-overlay"></div>
           
            <div class="mob-srch-wrap">
                <div class="nav-close">
                    <span></span>
                    <span></span>
                </div>
                <div class="mob-search-wrapp">
                    <?php get_search_form(); ?>
                    <div class="search-content"></div>
                    <div class="block-loader" style="display:none;">
                        <div class="sampleContainer">
                            <div class="loader">
                                <span class="dot dot_1"></span>
                                <span class="dot dot_2"></span>
                                <span class="dot dot_3"></span>
                                <span class="dot dot_4"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="vmagazine-lite-mobile-navigation-wrapper">
 
    <div class="mobile-navigation">
        <div class="img-overlay"></div>
        
        <div class="vmag-opt-wrap">
            <div class="nav-close">
                <span></span>
                <span></span>
            </div>

            <div class="icon-wrapper">
                <?php echo vmagazine_lite_social_icons(); // WPCS: XSS ok.?>
            </div>
            <div class="site-branding">                 
                <?php vmagazine_lite_mob_nav_logo(); ?>
                <div class="site-title-wrapper">
                    <?php
                    if ( is_front_page() || is_home() ) : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php else : ?>
                        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php
                    endif;

                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) : ?>
                        <p class="site-description"><?php echo esc_html($description);  ?></p>
                    <?php
                    endif; ?>
                </div>
            </div><!-- .site-branding -->
            <?php echo vmagazine_lite_nav_mobile_header(); // WPCS: XSS ok.?>    
        </div>
    </div>
</div>
<?php
}
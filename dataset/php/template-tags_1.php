<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */


/*===========================================================================================================*/
/* Post Meta with icons **/
if( ! function_exists( 'vmagazine_lite_icon_meta') ){
    function vmagazine_lite_icon_meta(){
        
		$posted_on = get_the_date();
	    $comments  = get_comments_number();
	   
	    echo '<span class="posted-on"><i class="fa fa-clock-o"></i>'. esc_html($posted_on) .'</span>';
	    echo '<span class="comments"><i class="fa fa-comments"></i>'. esc_html($comments) .'</span>';
    }
}
add_action( 'vmagazine_lite_icon_meta', 'vmagazine_lite_icon_meta' );


/*===========================================================================================================*/
/* Post date for timeline */

if ( ! function_exists( 'vmagazine_lite_timeline_posted_on' ) ) :
function vmagazine_lite_timeline_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s"><span class="posted-day">%2$s</span> <span class="posted-month">%3$s</span></time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%5$s">%6$s</time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'd' ) ),
		esc_html( get_the_date( 'M' ) ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	$posted_on = $time_string ;
	echo '<span class="posted-on">' . esc_html($posted_on) . '</span>';
}
endif;

add_action('vmagazine_lite_timeline_date','vmagazine_lite_timeline_posted_on');

/*===========================================================================================================*/
/**
 * Function for entry footer
 */
if ( ! function_exists( 'vmagazine_lite_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function vmagazine_lite_entry_footer() {

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'vmagazine-lite' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<footer class="entry-footer"><span class="edit-link">',
		'</span></footer>'
	);
}
endif;

/*===========================================================================================================*/
/**
 * Get post comment number
 */
if( ! function_exists( 'vmagazine_lite_post_comments' ) ):
	function vmagazine_lite_post_comments() {
		
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="comments-count">';
				echo  '<i class="fa fa-comment-o"></i>';
					comments_popup_link('0', __( '1', 'vmagazine-lite' ), '%' );
				echo '</span>';
			}
	}
endif;

/*===========================================================================================================*/
/**
 * Single post Categories lists
 */

if( ! function_exists( 'vmagazine_lite_post_cat_lists' ) ) :
	function vmagazine_lite_post_cat_lists() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			global $post;
			$categories = get_the_category();
			$separator = ' ';
			$output = '';
			if( $categories ) {
				$output .= '<span class="cat-links">';
				foreach( $categories as $category ) {
					$output .= '<a href="'.esc_url(get_category_link( $category->term_id )).'" class="cat-' . esc_attr($category->term_id) . '" rel="category tag">'.esc_html($category->cat_name).'</a>';					
				}
				$output .='</span>';
				echo trim( $output, $separator );// WPCS: XSS OK.
			}
		}
	}
endif;
/*===========================================================================================================*/
/**
 * Single post Tags lists
 */

if( ! function_exists( 'vmagazine_lite_single_post_tags_list' ) ) :
	function vmagazine_lite_single_post_tags_list() {

		// Hide tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', ' ');
			if ( $tags_list ) {
				echo '<span class="tags-links clearfix">' . wp_kses_post($tags_list) . '</span>'; 
			}
		}
	}
endif;
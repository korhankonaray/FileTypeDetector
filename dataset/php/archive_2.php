<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package swing
 */

get_header(); ?>

<div class="s-container clear">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="room-listing-main-content-wrapper">
			<div class="s-container">

					<div class="list-layout">
					  <div class="s-container">
			            <?php
		                if(have_posts()) {
		                ?>
		                <div class="rooms-section">
		                    <div class="rooms-content">
		                    <?php
			                    while ( have_posts() ) : the_post();

			                    $originalDate = get_the_date();
		                		$author_name =  get_the_author();
								$post_class = 'rooms-loops clear';
		                       	if(is_sticky()) {
		                       		$post_class .= ' sticky';
		                       	}
	                     	?>
		                        <div class="<?php echo esc_attr($post_class); ?>">
		                            <div class="image-wrapper">
		                                <a href="<?php the_permalink(); ?>">
		                                    <?php 
		                                    if (has_post_thumbnail()) { 
			                                    $swing_lite_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'swing-lite-room-lists-image');
			                                    $swing_lite_img_src = $swing_lite_img[0];
			                                    $alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
		                                    ?>
		                                    <div class="rooms-thumbnail">
		                                        <img src="<?php echo esc_url($swing_lite_img_src); ?>" alt="<?php echo esc_attr($alt); ?>" />
		                                    </div>
		                                    <?php 
		                                    }
		                                    ?>
		                                </a>
		                            </div>

		                        <div class="rooms-features-wrapper">
		                            <div class="rooms-title">
		                                <h3><a href="<?php the_permalink();?>"><?php the_title(); ?> </a></h3>
		                            </div>

		                          	<div class="feature-post-attributes">

				                        <?php if($originalDate) { ?>
					                        <span class="post-date"> <i class=" fa fa-clock-o "></i> <?php echo esc_html($originalDate); ?> </span>
					                    <?php } if($author_name) { ?>
					                        <span class="post-author"> <i class=" fa fa-pencil-square-o"></i> <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php the_author(); ?></a> </span>
					                    <?php } ?>

				                    </div>
		                        
		                          <?php if(get_the_content()) { ?>
			                          <div class="rooms-content">
			                            <?php 
			                                 echo esc_html(substr(wp_strip_all_tags(get_the_content()), 0, 150));
			                             ?>
			                          </div>
		                          <?php }  ?>

		                          <div class="s-rooms-price">
		                            
		                              <div class="price">
		                                <a class="price-tag" href="<?php the_permalink();?>">
		                                 <?php echo esc_html__('Read More', 'swing-lite')?>
		                                </a>
		                              </div>
		                       
		                          </div>
		                        </div>
		                    </div>
		                    	<?php endwhile; wp_reset_postdata(); ?>
		                    </div>
		                </div>
			            
                    	<nav class="pagination">
						    <?php
								the_posts_pagination( array(
									'mid_size' => 2,
									'prev_text' => "'<i class='fa fa-angle-double-left'></i>'" . esc_html__( ' Previous', 'swing-lite' ),
									'next_text' => esc_html__( 'Next ', 'swing-lite' ) . "<i class='fa fa-angle-double-right'></i>",
								));
							?>
						</nav>

	                 <?php }  ?>
					</div>
				</div>
			</div>
		</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();

echo '</div>';

get_footer();
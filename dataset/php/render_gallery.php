<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
global $post;
$query = new WP_Query(array(
	'post_type' => 'gall',
	'post__in' => array($post_id)
));

?>

<?php

	$gallery_layout_selected = get_option(TMM_THEME_PREFIX . "gallery_slider_width"); 
	
	if(!$gallery_layout_selected) {
		$gallery_layout_selected = 400;
	}

	switch ($gallery_layout_selected) {
		case 340:
			$gallery_layout_class = "six columns";
			$gallery_layout_height = 244;
			break;
		case 400:
			$gallery_layout_class = "seven columns";
			$gallery_layout_height = 283;
			break;
		case 460:
			$gallery_layout_class = "eight columns";
			$gallery_layout_height = 322;
			break;
		case 520:
			$gallery_layout_class = "nine columns";
			$gallery_layout_height = 360;
			break;
		default:
		    $gallery_layout_class = "seven columns";
			$gallery_layout_height = 283;
			break;
	}
	
	if ($template_sidebar_position !== 'no_sidebar') {
		$gallery_layout_selected = 580;
		$gallery_layout_height = 360;
	}
	
?>


<?php

if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

        ?>

        <div class="pics-wrapper <?php echo($template_sidebar_position !== 'no_sidebar' ? "" : $gallery_layout_class) ?>">
			
			<div class="image-gallery-slider">
				
				<a href="#" class="closeWorkPanel close"><?php _e('Close', TMM_THEME_FOLDER_NAME); ?></a>
				
               <div id="sudo-slider" class="sudo-slider">
				   
                    <ul>                              

                        <?php
                        //get images quantity

                        $images = get_post_meta($post->ID, 'thememakers_gallery', true);
                        if (!empty($images) AND !empty($images[0])) {

                            $video_width = $gallery_layout_selected;
                            $video_height = $gallery_layout_height;

                            foreach ($images as $source_url) {
                                if (!empty($source_url)) {

                                    $video_type = 'youtube.com';
                                    $allows_array = array('youtube.com', 'player.vimeo.com', '.mp4', '.jpg', '.png', '.gif', '.bmp');

                                    foreach ($allows_array as $key => $needle) {
                                        $count = strpos($source_url, $needle);
                                        if ($count !== FALSE) {
                                            $video_type = $allows_array[$key];
                                        }
                                    }

                                    switch ($video_type) {
                                        case $allows_array[0]:
                                            $source_url = explode("?v=", $source_url);
                                            $source_url = explode("&", $source_url[1]);
                                            if (is_array($source_url)) {
                                                $source_url = $source_url[0];
                                            }
                                            echo "<li>" . do_shortcode('[video type="youtube" html5_poster="" html5_video_url="" src_webm="" src_ogg="" width="' . $video_width . '" height="' . $video_height . '"]' . $source_url . '[/video]') . "</li>";
                                            break;
                                        case $allows_array[1]:
                                            $source_url = explode("/", $source_url);
                                            if (is_array($source_url)) {
                                                $source_url = $source_url[count($source_url) - 1];
                                            }

                                            echo "<li>" . do_shortcode('[video type="vimeo" html5_poster="" html5_video_url="" src_webm="" src_ogg="" width="' . $video_width . '" height="' . $video_height . '"]' . $source_url . '[/video]') . "</li>";
                                            break;
                                        case $allows_array[2]:

                                            //nothing

                                            break;

                                        default:
                                            ?>
                                            <li>
												<div class="bordered">
													<figure class="add-border">
														<img src="<?php echo ThemeMakersHelper::resize_image($source_url, $gallery_layout_selected, true, $gallery_layout_height) ?>" width="<?php echo ($gallery_layout_selected) ?>" height="<?php echo ($gallery_layout_height) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
													</figure>
												</div><!--/ .bordered-->		
											</li>
                                            <?php
                                            break;
                                    }
                                }
                            }
                        } else {
                            ?>

                            <li>
                                <?php if (has_post_thumbnail()) : ?>
									<div class="bordered">
										<div class="add-border">
											 <img src="<?php echo ThemeMakersHelper::get_post_featured_image($post->ID, $gallery_layout_selected, true, $gallery_layout_height); ?>" alt="<?php the_title(); ?>"/>
										</div>
									</div>
                                   
                                <?php else: ?>
									<div class="bordered">
										<div class="add-border">
											 <img src="<?php echo ThemeMakersHelper::resize_image(TMM_THEME_URI . '/images/no-image.jpg', $gallery_layout_selected, true, $gallery_layout_height); ?>" alt="<?php the_title(); ?>"/>
										</div>
									</div>
                                   
                                <?php endif; ?>
                            </li>

                            <?php
                        }
                        ?>	

                    </ul>

                </div><!--/ #sudo-slider-->   
				
			</div><!--/ .image-gallery-slider-->
 
        </div><!--/ .pics-wrapper-->
		
        <div class="descr-wrapper">

            <h4><?php the_title(); ?></h4>

            <p>
                <?php if (get_the_terms($post->ID, 'clients')) : ?>
                    <span><?php _e('Client(s)', TMM_THEME_FOLDER_NAME); ?>:</span>  <?php echo get_the_term_list($post->ID, 'clients', '', ', ', ''); ?><br>
                <?php endif; ?>
                <?php if (get_post_meta($post->ID, 'portfolio_url', true) != '') : ?>
                    <span><?php _e('URL', TMM_THEME_FOLDER_NAME); ?>:</span> <a target="_blank" href="<?php echo get_post_meta($post->ID, 'portfolio_url', true); ?>"><?php echo get_post_meta($post->ID, 'portfolio_url_title', true); ?></a><br>
                <?php endif; ?>
                <?php if (get_post_meta($post->ID, 'portfolio_date', true) != '') : ?>
                    <span><?php _e('Date', TMM_THEME_FOLDER_NAME); ?>:</span> <?php echo get_post_meta($post->ID, 'portfolio_date', true); ?><br>
                <?php endif; ?>
                <?php if (get_post_meta($post->ID, 'portfolio_tools', true) != '') : ?>
                    <span><?php _e('Tools', TMM_THEME_FOLDER_NAME); ?>:</span> <?php echo get_post_meta($post->ID, 'portfolio_tools', true); ?><br />
                <?php endif; ?>
                <?php if (get_the_terms($post->ID, 'skills')) : ?>
                    <span><?php _e('Skill(s)', TMM_THEME_FOLDER_NAME); ?>:</span> <?php echo get_the_term_list($post->ID, 'skills', '', ', ', ''); ?><br>
                <?php endif; ?>               
            </p>

            <p><?php the_content() ?></p>

        </div><!--/ .descr-wrapper-->

        <?php
    endwhile;
endif;
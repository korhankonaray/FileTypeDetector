<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
get_header();

$portfolio_layout_selected = get_option(TMM_THEME_PREFIX . "portfolio_slider_width");

if (!$portfolio_layout_selected) {
    $portfolio_layout_selected = 400;
}

switch ($portfolio_layout_selected) {
    case 340:
        $portfolio_layout_class = "six columns";
        $portfolio_layout_height = 244;
        break;
    case 400:
        $portfolio_layout_class = "seven columns";
        $portfolio_layout_height = 283;
        break;
    case 460:
        $portfolio_layout_class = "eight columns";
        $portfolio_layout_height = 322;
        break;
    case 520:
        $portfolio_layout_class = "nine columns";
        $portfolio_layout_height = 360;
        break;
    default:
        $portfolio_layout_class = "seven columns";
        $portfolio_layout_height = 283;
        break;
}

//get images quantity
$images = get_post_meta($post->ID, 'thememakers_portfolio', true);
?>

<?php // $portfolio_slider_width = get_option(TMM_THEME_PREFIX . "portfolio_slider_width"); ?>	


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php if ((!empty($images) AND !empty($images[0])) OR has_post_thumbnail($post->ID)): ?>

            <div class="pics-wrapper <?php echo $portfolio_layout_class ?> alpha">

                <div class="image-gallery-slider">

                    <div class="sudo-slider" id="sudo_slider">

                        <ul>

                            <?php
                            if (!empty($images) AND !empty($images[0])) {
                                $video_width = $portfolio_layout_selected;
                                $video_height = $portfolio_layout_height;

                                foreach ($images as $source_url) {
                                    if (!empty($source_url)) {

                                        $video_type = 'youtube.com';
                                        $allows_array = array('youtube.com', 'player.vimeo.com', '.mp4', '.jpg', '.jpeg', '.png', '.gif', '.bmp');

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
                                                $html5_poster = TMM_THEME_URI . "/images/video_poster.jpg";
                                                if (has_post_thumbnail($post->ID)) {
                                                    $html5_poster = ThemeMakersHelper::get_post_featured_image($post->ID, $video_width, true, $video_height);
                                                }
                                                echo "<li>" . do_shortcode('[video type="html5" html5_poster="' . $html5_poster . '" html5_video_url="' . $source_url . '" src_webm="" src_ogg="" width="' . $video_width . '" height="' . $video_height . '"][/video]') . "</li>";
                                                break;

                                            default:
                                                ?>
                                                <li>

                                                    <div class="bordered">
                                                        <figure class="add-border">
                                                            <img src="<?php echo ThemeMakersHelper::resize_image($source_url, $portfolio_layout_selected, true, $portfolio_layout_height) ?>" width="<?php echo $portfolio_layout_selected ?>" height="<?php echo $portfolio_layout_height ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />	
                                                        </figure>
                                                    </div><!--/ .bordered-->

                                                </li>
                                                <?php
                                                break;
                                        }
                                    }
                                }
                            } else {

                                if (has_post_thumbnail($post->ID)) {
                                    ?>
                                    <li>

                                        <div class="bordered">
                                            <figure class="add-border">
                                                <img src="<?php echo ThemeMakersHelper::get_post_featured_image($post->ID, $portfolio_layout_selected, true, $portfolio_layout_height) ?>" width="<?php echo $portfolio_layout_selected ?>" height="<?php echo $portfolio_layout_height ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
                                            </figure>
                                        </div><!--/ .bordered-->

                                    </li>

                                    <?php
                                }
                            }
                            ?>

                        </ul>

                    </div>	

                </div><!--/ .image-gallery-slider-->

            </div><!--/ .pics-wrapper-->

        <?php endif; ?>

        <div <?php post_class("descr-wrapper"); ?>>

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

            <p><?php the_content(); ?></p>

        </div><!--/ .descr-wrapper-->

        <div class="clear"></div>

        <?php
    endwhile;
endif;
?>

<?php //wp_reset_query();  ?>
<?php if (!get_option(TMM_THEME_PREFIX . 'disable_portfolio_comments')): ?>
    <?php comments_template(); ?>
<?php endif; ?>



<?php get_footer(); ?>
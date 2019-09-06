<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
global $post;

if (!is_object($post) OR is_home()) {
    return;
}

$page_settings = Thememakers_Entity_Page_Constructor::get_page_settings($post->ID);

if ($page_settings['page_slider_type'] == 'revolution') {
    if (!$page_settings['revolution_slide_group']) {
        return;
    }
} else {
    if (!$page_settings['page_slider']) {
        return;
    }
}




$slider = new Thememakers_Entity_Slider();
$slides = Thememakers_Entity_Slider::get_slide_group($page_settings['page_slider']);
$options = $slider->get_slider_options($page_settings['page_slider_type']);
switch ($page_settings['page_slider_type']) {
    case 'flexslider':
        ?>

        <div class="slider container">

            <?php wp_enqueue_script('thememakers_theme_slider_flexslider_js', TMM_THEME_URI . '/js/sliders/flexslider/jquery.flexslider-min.js'); ?>
            <?php wp_enqueue_style("thememakers_theme_slider_flexslider_css", TMM_THEME_URI . '/js/sliders/flexslider/flexslider.css'); ?>
            <script type="text/javascript">

                jQuery(function() {

                    jQuery('#carousel').flexslider({
                        animation: "<?php echo $options['animation'] ?>",
                        controlNav: 0,
                        animationLoop: <?php echo $options['animation_loop'] ?>,
                        slideshow: <?php echo ($options['slideshow'] ? 'true' : 'false') ?>,
                        animationSpeed: <?php echo $options['animation_speed'] ?>,
                        itemWidth: <?php echo $options['item_width'] ?>,
                        directionNav: false,
                        slideshowSpeed: <?php echo $options['slideshow_speed'] ?>,
                        initDelay: <?php echo $options['init_delay'] ?>,
                        randomize: <?php echo $options['randomize'] ?>,
                        reverse: <?php echo $options['reverse'] ?>,
                        pauseOnAction: 1,
                        touch: 1,
                        keyboard: 1,
                        asNavFor: '#slider'
                    });
                    jQuery('#slider').flexslider({
                        animation: "<?php echo $options['animation'] ?>",
                        controlNav: 0,
                        directionNav: false,
                        animationLoop: <?php echo ($options['animation_loop'] ? 'true' : 'false') ?>,
                        slideshow: <?php echo ($options['slideshow'] ? 'true' : 'false') ?>,
                        sync: "#carousel"
                    });
                });</script>

            <section id="slider">

                <div class="flexslider">

                    <ul class="slides clearfix">

                        <?php
                        if (!empty($slides)) {
                            foreach ($slides as $key => $slide) {
                                $slide_url = ThemeMakersHelper::resize_image($slide['image'], $options['slide_width'], true, $slider->slider_height_option);
                                $slide_link_url = $slide['link'];
                                $slide_title = ThemeMakersHelper::quotes_shield($slide['title']);
                                $slide_desciption = ThemeMakersHelper::quotes_shield($slide['description']);

                                $slide_title_color = $slide['additional']['slide_title_color'];
                                $slide_description_color = $slide['additional']['slide_description_color'];
                                ?>

                                <li>
                                    <img src="<?php echo $slide_url ?>" alt="<?php echo $slide_title; ?>" />

                                    <section class="caption-<?php echo($key % 4 + 1) ?>">

                                        <?php if ($options['enable_caption']) : ?>

                                            <a href="<?php echo $slide_link_url ?>" title="<?php echo $slide_title; ?>"><h2 <?php if (!empty($slide_title_color)): ?>style="color:<?php echo $slide_title_color ?> !important;"<?php endif; ?>><?php echo $slide_title; ?></h2></a>



                                            <p class="desc tcolor" <?php if (!empty($slide_description_color)): ?>style="color:<?php echo $slide_description_color ?> !important;"<?php endif; ?>><?php echo $slide_desciption; ?></p>
                                        <?php endif; ?>
                                    </section>
                                </li>


                                <?php
                            }
                        }
                        ?>

                    </ul><!--/ .slides-->

                </div><!--/ .flexslider-->

            </section><!--/ #slider-->

            <?php if (/* $options['enable_caption'] */false) : ?>
                <section id="carousel">

                    <ul class="slides clearfix">

                        <?php
                        if (!empty($slides)) {
                            foreach ($slides as $slide) {
                                $slide_link_url = $slide['link'];
                                $slide_title = ThemeMakersHelper::quotes_shield($slide['title']);
                                $slide_desciption = ThemeMakersHelper::quotes_shield($slide['description']);

                                $slide_title_color = $slide['additional']['slide_title_color'];
                                $slide_description_color = $slide['additional']['slide_description_color'];
                                ?>

                                <li>
                                    <a>
                                        <a href="<?php echo $slide_link_url ?>" title="<?php echo $slide_title; ?>"><h6 <?php if (!empty($slide_title_color)): ?>style="color:<?php echo $slide_title_color ?> !important;"<?php endif; ?>><?php echo $slide_title; ?></h6></a>
                                        <p class="desc tcolor" <?php if (!empty($slide_description_color)): ?>style="color:<?php echo $slide_description_color ?> !important;"<?php endif; ?>><?php echo $slide_desciption; ?></p>
                                    </a>
                                </li>

                                <?php
                            }
                        }
                        ?>

                    </ul><!--/ .slides-->

                </section><!--/ #carousel-->
            <?php endif; ?>
        </div><!--/ .slider-->

        <?php
        break;


    case 'revolution':

        if (function_exists("putRevSlider")) {
            if (isset($page_settings['revolution_slide_group'])) {
                if (!empty($page_settings['revolution_slide_group'])) {
                    putRevSlider($page_settings['revolution_slide_group']);
                }
            }
        }


        break;


    default:
        break;
}
?>

<div style="clear:both;"></div>



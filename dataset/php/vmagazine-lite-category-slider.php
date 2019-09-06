<?php
/**
 * Vmagazine: Category Posts (Slider)
 *
 * Widget to display selected category posts as on slider style.
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

add_action( 'widgets_init', 'vmagazine_lite_register_category_posts_slider_widget' );

function vmagazine_lite_register_category_posts_slider_widget() {
    register_widget( 'vmagazine_lite_category_posts_slider' );
}

class Vmagazine_Lite_Category_Posts_Slider extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'vmagazine_lite_category_posts_slider',
            'description' => esc_html__( 'Display posts from selected category as slider.', 'vmagazine-lite' )
        );
        $width = array(
                'width'  => 600
        );
        parent::__construct( 'vmagazine_lite_category_posts_slider', esc_html__( 'vmagazine-lite : Category Posts(Slider)', 'vmagazine-lite' ), $widget_ops , $width );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

        global $vmagazine_lite_cat_dropdown,$vmagazine_lite_posts_type;
        
        $fields = array(
                'block_slider_layout' => array(
                    'vmagazine_lite_widgets_name' => 'block_slider_layout',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Layout will be like this', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_layout_img'   => VMAG_WIDGET_IMG_URI.'cps-1.png',
                    'vmagazine_lite_widgets_field_type'   => 'widget_layout_image',
                ),
                'block_title' => array(
                    'vmagazine_lite_widgets_name'         => 'block_title',
                    'vmagazine_lite_widgets_title'        => esc_html__( 'Block Title', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type'   => 'text'
                ),
                'block_post_type' => array(
                    'vmagazine_lite_widgets_name'        => 'block_post_type',
                    'vmagazine_lite_widgets_title'       => esc_html__( 'Block posts: ', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type'  => 'radio',
                    'vmagazine_lite_widgets_default'     => 'latest_posts',
                    'vmagazine_lite_widgets_field_options' => $vmagazine_lite_posts_type
                ),
                'block_post_category' => array(
                    'vmagazine_lite_widgets_name' => 'block_post_category',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Select Category for Slider', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_default'      => 0,
                    'vmagazine_lite_widgets_field_type' => 'select',
                    'vmagazine_lite_widgets_field_options' => $vmagazine_lite_cat_dropdown
                ),
                'block_posts_count' => array(
                    'vmagazine_lite_widgets_name'         => 'block_posts_count',
                    'vmagazine_lite_widgets_title'        => esc_html__( 'No. of Posts', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_default'      => 4,
                    'vmagazine_lite_widgets_field_type'   => 'number'
                ),
                'block_section_excerpt' => array(
                    'vmagazine_lite_widgets_name' => 'block_section_excerpt',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Excerpt For Post Description', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_description' => esc_html__( 'Enter Excerpts in number of letters default: 180 &#40; exerpt will work on first layout only &#41;', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type' => 'number',
                    'vmagazine_lite_widgets_default'     => 180
                ), 
                 'block_view_all_text' => array(
                    'vmagazine_lite_widgets_name' => 'block_view_all_text',
                    'vmagazine_lite_widgets_title' => esc_html__( 'View All Button Text', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type' => 'text',
                ),
                'block_section_meta' => array(
                    'vmagazine_lite_widgets_name' => 'block_section_meta',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Hide/Show Meta', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_default'=>'show',
                    'vmagazine_lite_widgets_field_options'=>array('show'=>'Show','hide'=>'Hide'),
                    'vmagazine_lite_widgets_field_type' => 'switch',
                    'vmagazine_lite_widgets_description'  => esc_html__('Show or hide post meta options like author name, post date etc','vmagazine-lite'),
                ),
                'cat_bg_image' => array(
                    'vmagazine_lite_widgets_name' => 'cat_bg_image',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Background Image', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type' => 'upload',
                ),

                'block_header_op' => array(
                'vmagazine_lite_widgets_name' => 'block_header_op',
                'vmagazine_lite_widgets_title' => esc_html__(' Display Header', 'vmagazine-lite'),
                'vmagazine_lite_widgets_field_type' => 'checkbox'
            ),
        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }

        $vmagazine_lite_block_title       = empty( $instance['block_title'] ) ? '' : $instance['block_title'];
        $vmagazine_lite_block_posts_count = empty( $instance['block_posts_count'] ) ? 4 : $instance['block_posts_count'];
        $vmagazine_lite_block_cat_id      = empty( $instance['block_post_category'] ) ? null: $instance['block_post_category'];
        $block_post_type = empty($instance['block_post_type']) ? 'latest_posts' : $instance['block_post_type'];
        $cat_slider_bg = empty( $instance['cat_bg_image'] ) ? '' : $instance['cat_bg_image'];
        $block_view_all_text = isset( $instance['block_view_all_text'] ) ? $instance['block_view_all_text']  : '';
        $block_section_excerpt = empty($instance['block_section_excerpt']) ? '' : $instance['block_section_excerpt'];
        $block_header_op =  empty($instance['block_header_op']) ? 'hide' : 'show';

        $bg_image = 'style="background-image: url('.esc_url($cat_slider_bg).')"';
        $wid_wrapper_st = '<div class="content-wrapper-featured-slider">';
        $wid_wrapper_ed = '</div>';
        

        $block_section_meta = empty($instance['block_section_meta']) ? 'show' : $instance['block_section_meta'];
        echo wp_kses_post($before_widget);
    ?>
        <div class="vmagazine-lite-cat-slider block-post-wrapper block_layout_1" <?php echo wp_kses_post($bg_image);?>>
            
            <?php echo wp_kses_post($wid_wrapper_st); ?>
            <?php if($block_header_op == 'hide'){ ?>
            <?php vmagazine_lite_widget_title( $vmagazine_lite_block_title,$vmagazine_lite_block_posts_count,$vmagazine_lite_block_cat_id); ?>
            <?php } ?>
                <?php
                    $block_args = vmagazine_lite_query_args( $block_post_type, $vmagazine_lite_block_posts_count, $vmagazine_lite_block_cat_id );
                    $block_query = new WP_Query( $block_args );
                    if( $block_query->have_posts() ) {
                        echo '<ul class="widget-cat-slider cS-hidden">';
                        while( $block_query->have_posts() ) {
                            $block_query->the_post();
                            $total_posts_count = $block_query->post_count+1;
                            $image_id = get_post_thumbnail_id();
                            
                            $img_src = vmagazine_lite_home_element_img('vmagazine-lite-large-category');
                            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

                            $font_class = 'extra-large-font';

                            ?>
                            <li class="single-post clearfix">
                                <div class="post-thumb">
                                    <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" />
                                </div>
                                <div class="post-caption">
                                    <?php 
                                    do_action( 'vmagazine_lite_post_cat_or_tag_lists' ); 
                                    if( $block_section_meta == 'show' ): ?>
                                    <div class="post-meta">
                                        <?php do_action( 'vmagazine_lite_icon_meta' ); ?>
                                    </div>
                                    <?php endif; ?>
                                    <h3 class="<?php echo esc_attr($font_class);?>">
                                        <a href="<?php the_permalink(); ?>">
                                             <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <?php if($block_section_excerpt ){ ?>
                                    <p>
                                      <?php 
                                        echo vmagazine_lite_get_excerpt_content( absint($block_section_excerpt) ); // WPCS: XSS OK.
                                      ?>
                                      <?php if( $block_view_all_text ): ?>
                                      <span class="read-more">
                                          <a href="<?php the_permalink();?>"><?php echo esc_html($block_view_all_text); ?></a>
                                      </span>
                                     <?php endif; ?>
                                    </p>
                                    <?php } ?>
                                </div><!-- .post-caption -->
                            </li><!-- .single-post -->
                            <?php
                        }
                        echo '</ul>';
                    }
                wp_reset_postdata();
            ?>
        <?php echo wp_kses_post($wid_wrapper_ed); ?><!-- .content-wrapper -->
        </div><!-- .block-post-wrapper -->
    <?php
        echo wp_kses_post($after_widget);

    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses   vmagazine_lite_widgets_updated_field_value()      defined in vmagazine-lite-widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$vmagazine_lite_widgets_name] = vmagazine_lite_widgets_updated_field_value( $widget_field, $new_instance[$vmagazine_lite_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses   vmagazine_lite_widgets_show_widget_field()        defined in vmagazine-lite-widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $vmagazine_lite_widgets_field_value = !empty( $instance[$vmagazine_lite_widgets_name]) ? esc_attr($instance[$vmagazine_lite_widgets_name] ) : '';
           vmagazine_lite_widgets_show_widget_field( $this, $widget_field, $vmagazine_lite_widgets_field_value );
        }
    }
}
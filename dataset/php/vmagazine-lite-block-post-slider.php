<?php
/**
 * Vmagazine Lite: Block Post Slider
 *
 * Widget to display latest or selected category posts as Tab styles
 *
 * @package AccessPress Themes
 * @subpackage Vmagazine Lite
 * @since 1.0.0
 */

add_action( 'widgets_init', 'vmagazine_lite_block_post_slider_widget' );

function vmagazine_lite_block_post_slider_widget() {
    register_widget( 'vmagazine_lite_block_post_slider' );
}

class Vmagazine_lite_Block_Post_Slider extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'vmagazine_lite_block_post_slider',
            'description' => __( 'Display posts from selected category as tabbed slider.', 'vmagazine-lite' ),
        );
        $width = array(
                'width'  => 600
        );
        parent::__construct( 'vmagazine_lite_block_post_slider', esc_html__( 'Vmagazine : Block Post Slider', 'vmagazine-lite' ), $widget_ops,$width );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

       global   $vmagazine_lite_cat_dropdown, $vmagazine_lite_posts_type;

        $fields = array(
            
            'block_layout' => array(
                'vmagazine_lite_widgets_name'         => 'block_layout',
                'vmagazine_lite_widgets_title'        => esc_html__( 'Layout will be like this', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_layout_img'   => VMAG_WIDGET_IMG_URI.'bps.png',
                'vmagazine_lite_widgets_field_type'   => 'widget_layout_image'
            ),
            
            'block_post_type' => array(
                    'vmagazine_lite_widgets_name'        => 'block_post_type',
                    'vmagazine_lite_widgets_title'       => esc_html__( 'Block posts: ', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type'  => 'radio',
                    'vmagazine_lite_widgets_default'     => 'latest_posts',
                    'vmagazine_lite_widgets_field_options' => $vmagazine_lite_posts_type
                ),

            'block_title' => array(
                'vmagazine_lite_widgets_name'         => 'block_title',
                'vmagazine_lite_widgets_title'        => esc_html__( 'Block Title', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_field_type'   => 'text'
            ),

           'block_post_cats' => array(
              'vmagazine_lite_widgets_name' => 'block_post_cats',
              'vmagazine_lite_widgets_title' => esc_html__( 'Select Category', 'vmagazine-lite' ),
              'vmagazine_lite_widgets_default'      => 0,
              'vmagazine_lite_widgets_field_type' => 'select',
              'vmagazine_lite_widgets_field_options' => $vmagazine_lite_cat_dropdown
          ),

            'block_posts_count' => array(
                'vmagazine_lite_widgets_name'         => 'block_posts_count',
                'vmagazine_lite_widgets_title'        => esc_html__( 'No. of Posts', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_default'      => 10,
                'vmagazine_lite_widgets_field_type'   => 'number',
                'vmagazine_lite_widgets_description' => esc_html__( 'Add Multiple of 5 Posts', 'vmagazine-lite' ),
            ),

            'block_header_op' => array(
                'vmagazine_lite_widgets_name' => 'block_header_op',
                'vmagazine_lite_widgets_title' => esc_html__(' Disable Header', 'vmagazine-lite'),
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

        $vmagazine_lite_block_title   = empty( $instance['block_title'] ) ? '' : $instance['block_title'];
        $vmagazine_lite_block_posts_count = empty( $instance['block_posts_count'] ) ? 5 : $instance['block_posts_count'];
        $vmagazine_lite_block_cat_id      = empty( $instance['block_post_cats'] ) ? null: $instance['block_post_cats'];
        $block_post_type = empty($instance['block_post_type']) ? 'latest_posts' : $instance['block_post_type'];
        $block_section_meta = isset( $instance['block_section_meta'] ) ? $instance['block_section_meta'] : 'show';
        $block_header_op =  empty($instance['block_header_op']) ? 'hide' : 'show';

       
        echo wp_kses_post($before_widget);
    ?>
        <div class="vmagazine-block-post-slider block-post-wrapper clearfix">
            <?php if($block_header_op == 'hide'){ ?>
            <div class="block-header clearfix >">
                <?php
                    vmagazine_lite_widget_title(  $vmagazine_lite_block_title,$vmagazine_lite_block_posts_count, $vmagazine_lite_block_cat_id);
                ?>
            </div><!-- .block-header-->
            <?php } ?>
            <div class="block-content-wrapper">
                <div class="block-cat-content ">

            <?php
                $block_args = vmagazine_lite_query_args( $block_post_type, $vmagazine_lite_block_posts_count, $vmagazine_lite_block_cat_id);
                $block_query = new WP_Query( $block_args );
                $post_count = 0;
                $post_counter = 0;
                $total_posts_count = $block_query->post_count;
                if( $block_query->have_posts() ) { ?>
                   <div class="block-post-slider-wrapper"> 
                    <?php 
                    while( $block_query->have_posts() ) {
                        $block_query->the_post();
                        $post_count++;
                        $post_counter++;
                        $image_id = get_post_thumbnail_id();
                        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true ); 
                        $big_image_path = vmagazine_lite_home_element_img('vmagazine-lite-post-slider-lg');
                        $sm_image_path = vmagazine_lite_home_element_img('vmagazine-lite-slider-thumb');
                        
                            if( $post_count == 1 ) { ?>
                            <div class="slider-item-wrapper">
                                    <div class="slider-bigthumb">
                                            <div class="slider-img">
                                                <img src="<?php echo esc_url($big_image_path) ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                            </div>
                                            <div class="post-captions">
                                                <?php do_action( 'vmagazine_lite_post_cat_or_tag_lists' ); ?>
                                                <?php if( $block_section_meta == 'show' ): ?>
                                                <div class="post-meta clearfix">
                                                    <?php do_action( 'vmagazine_lite_icon_meta' ); ?>
                                                </div>
                                                 <?php endif; ?>  
                                                <h3 class="large-font">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                            </div>
                                    </div>
                                <?php 
                            }elseif( $post_count <= 5 ){ 

                                if( $post_count == 2 ){ ?>
                                    <div class="small-thumbs-wrapper">
                                       <div class="small-thumbs-inner"> 
                                 <?php } ?>

                               <div class="slider-smallthumb">
                                    <div class="slider-img">
                                        <img src="<?php echo esc_url($sm_image_path) ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                    </div>
                                    <div class="post-captions">
                                        <?php if( $block_section_meta == 'show' ): ?>
                                        <div class="post-meta clearfix">
                                            <?php do_action( 'vmagazine_lite_icon_meta' ); ?>
                                        </div>
                                        <?php endif; ?>  
                                        <h3 class="large-font">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                    </div>
                               </div>
                            <?php if( ($post_count == 5) || ($total_posts_count == $post_counter) ){ ?>
                                   </div><!-- .small-thumbs-inner -->
                                    </div><!-- .small-thumbs-wrapper -->  
                            <?php } ?>
                          <?php  }
                          if( ($post_count == 5) || ($total_posts_count == $post_counter) ){ ?>
                            </div>
                        <?php 
                          }
                          if( $post_count == 5 ){
                            $post_count = 0;
                          }  
                }
                 echo '</div>';
            }
                wp_reset_query();
            ?>

            </div>
            
            </div>
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
     * @uses    vmagazine_widgets_updated_field_value()      defined in vmag-widget-fields.php
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
     * @uses    vmagazine_widgets_show_widget_field()        defined in vmag-widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $vmagazine_lite_widgets_field_value = !empty( $instance[$vmagazine_lite_widgets_name]) ? $instance[$vmagazine_lite_widgets_name] : '';
            vmagazine_lite_widgets_show_widget_field( $this, $widget_field, $vmagazine_lite_widgets_field_value );
        }
    }
}
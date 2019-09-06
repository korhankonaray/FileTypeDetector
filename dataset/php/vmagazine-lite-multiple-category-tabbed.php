<?php
/**
 * Vmagazine: Multiple Category Tabbed
 *
 * Widget to display latest or selected category posts as Tab styles
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

add_action( 'widgets_init', 'vmagazine_lite_register_cat_tabbed_ajax_widget' );

function vmagazine_lite_register_cat_tabbed_ajax_widget() {
    register_widget( 'vmagazine_lite_cat_tabbed_ajax' );
}

class Vmagazine_Lite_Cat_Tabbed_Ajax extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'vmagazine_lite_cat_tabbed_ajax',
            'description' => __( 'Display posts from selected category as tabbed sytles.', 'vmagazine-lite' )
        );
        $width = array(
                'width'  => 600
        );
        parent::__construct( 'vmagazine_lite_cat_tabbed_ajax', esc_html__( 'vmagazine-lite : Multiple Category Tabbed', 'vmagazine-lite' ), $widget_ops, $width );
    }


    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

        global  $vmagazine_lite_cat_dropdown,$vmagazine_lite_posts_type;

        $fields = array(

                'block_layout' => array(
                    'vmagazine_lite_widgets_name'         => 'block_layout',
                    'vmagazine_lite_widgets_title'        => esc_html__( 'Layout will be like this', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_layout_img'   => VMAG_WIDGET_IMG_URI.'mct.png',
                    'vmagazine_lite_widgets_field_type'   => 'widget_layout_image'
                ),

                'block_title' => array(
                    'vmagazine_lite_widgets_name'         => 'block_title',
                    'vmagazine_lite_widgets_title'        => esc_html__( 'Block Title', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type'   => 'text'
                ),

                'block_post_type' => array(
                    'vmagazine_lite_widgets_name'        => 'block_post_type',
                    'vmagazine_lite_widgets_title'       => esc_html__( 'Block Display Type', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type'  => 'radio',
                    'vmagazine_lite_widgets_default'     => 'latest_posts',
                    'vmagazine_lite_widgets_field_options' => $vmagazine_lite_posts_type
                ),


                'block_single_cats' => array(
                    'vmagazine_lite_widgets_name' => 'block_single_cats',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Choose categories', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_default'     => 0,
                    'vmagazine_lite_widgets_field_type' => 'select',
                    'vmagazine_lite_widgets_field_options' => $vmagazine_lite_cat_dropdown

                ),

                'block_section_excerpt' => array(
                    'vmagazine_lite_widgets_name' => 'block_section_excerpt',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Excerpt for post description', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_description' => esc_html__( 'Enter Excerpts in number of letters default: 200', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type' => 'number',
                    'vmagazine_lite_widgets_default'     => 200
                ),
                'block_view_all_text' => array(
                    'vmagazine_lite_widgets_name' => 'block_view_all_text',
                    'vmagazine_lite_widgets_title' => esc_html__( 'View All Text', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type' => 'text',
                ),
                'block_section_meta' => array(
                    'vmagazine_lite_widgets_name' => 'block_section_meta',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Hide/Show Meta Description', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_default'=>'show',
                    'vmagazine_lite_widgets_field_options'=>array('show'=>'Show','hide'=>'Hide'),
                    'vmagazine_lite_widgets_field_type' => 'switch'
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
        $vmagazine_lite_block_posts_count = 7;
        $vmagazine_lite_block_posts_type = empty($instance['block_post_type']) ? 'latest_posts' : $instance['block_post_type'];
        $block_section_excerpt = empty($instance['block_section_excerpt']) ? '' :$instance['block_section_excerpt'];
        $vmagazine_lite_block_cat_id = empty($instance['block_post_category']) ? null: $instance['block_post_category'];
        $vmagazine_lite_block_single_cats = empty( $instance['block_single_cats'] ) ? null : $instance['block_single_cats'];
        $block_view_all_text = isset( $instance['block_view_all_text'] ) ? $instance['block_view_all_text']  : '';
        $block_section_meta = isset( $instance['block_section_meta'] ) ? $instance['block_section_meta'] : 'show';
        $block_header_op =  empty($instance['block_header_op']) ? 'show' : 'hide';

       
        echo wp_kses_post($before_widget);
    ?>
        <div class="vmagazine-lite-mul-cat-tabbed block-post-wrapper clearfix">
            <?php if($block_header_op == 'show'){ ?>
                <div class="block-header clearfix">
                    <?php
                       vmagazine_lite_widget_title( $vmagazine_lite_block_title,$vmagazine_lite_block_single_cats);
                    ?>
                </div><!-- .block-header-->
            <?php } ?>
            <div class="block-content-wrapper">
                <div class="block-cat-content">

            <?php
                $block_args = vmagazine_lite_query_args( $vmagazine_lite_block_posts_type, $vmagazine_lite_block_posts_count, $vmagazine_lite_block_single_cats );
                $block_query = new WP_Query( $block_args );
                $post_count = 0;
                $total_posts_count = $block_query->post_count;
                if( $block_query->have_posts() ) {
                    while( $block_query->have_posts() ) {
                        $block_query->the_post();
                        $post_count++;
                        $image_id = get_post_thumbnail_id();
                        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        
                            if( $post_count == 1 ) {
                                $vmagazine_lite_font_size = 'large-font';
                                $img_src = vmagazine_lite_home_element_img('vmagazine-lite-rectangle-thumb');
                                echo '<div class="top-post-wrapper wow fadeInDown" data-wow-duration="0.7s">';
                            } elseif( $post_count == 2 ) {
                                $vmagazine_lite_font_size = 'small-font';
                                $img_src = vmagazine_lite_home_element_img('vmagazine-lite-small-thumb');
                                $vmagazine_lite_animate_class = 'fadeInUp';
                                echo '<div class="btm-posts-wrapper wow fadeInUp" data-wow-duration="0.7s">';
                                echo '<div class="first-col-wrapper">';
                            }elseif( $post_count == 5 ){
                                echo '<div class="second-col-wrapper">';
                            } else {
                                $vmagazine_lite_font_size = 'small-font';
                                $img_src = vmagazine_lite_home_element_img('vmagazine-lite-small-thumb');
                            }
                        ?>
                        <div class="single-post clearfix">
                            <div class="post-thumb">
                                <a class="thumb-zoom" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php echo vmagazine_lite_load_images($img_src); // WPCS: XSS OK.?>
                                    <div class="image-overlay"></div>
                                </a>
                                <?php if( $post_count == 1 ) { do_action( 'vmagazine_lite_post_format_icon' ); } ?>
                            </div><!-- .post-thumb -->
                            <div class="post-caption-wrapper">
                               
                                <?php if( $block_section_meta == 'show' ): ?>
                                <div class="post-meta clearfix">
                                    <?php do_action( 'vmagazine_lite_icon_meta' ); ?>
                                </div>
                                <?php endif; ?> 
                                <h3 class="<?php echo esc_attr( $vmagazine_lite_font_size ); ?>">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if( $post_count > 1 ){
                                            the_title();
                                        }else{
                                            the_title();
                                        } ?>
                                    </a>
                                </h3>
                                <?php if( $post_count == 1 ){
                                    ?>
                                    <p> 
                                    <?php echo vmagazine_lite_get_excerpt_content( absint($block_section_excerpt) ) // WPCS: XSS OK.?> 
                                    </p>
                                <?php } ?>

                            </div><!-- .post-caption-wrapper -->
                           
                        </div><!-- .single-post -->
                    <?php
                        if( $post_count == 1 ) {
                            echo '</div>';
                        }
                        if( $post_count == 4 ){
                                echo '</div>';/** first-col-wrapper **/
                        }
                        elseif( $post_count == $total_posts_count ){
                             echo '</div>';/** second-col-wrapper **/
                            echo '</div>';
                        }
                    }
                }
                wp_reset_postdata();
                if( $block_view_all_text ){
                    $vmagazine_lite_block_view_all_text = esc_html($block_view_all_text);
                   vmagazine_lite_block_view_all( $vmagazine_lite_block_single_cats, $vmagazine_lite_block_view_all_text );    
                }
                
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
     * @uses   vmagazine_lite_widgets_updated_field_value()      defined in vmag-widget-fields.php
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
     * @uses   vmagazine_lite_widgets_show_widget_field()        defined in vmag-widget-fields.php
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
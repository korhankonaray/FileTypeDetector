<?php
/**
 * Vmagazine: Timeline Posts
 *
 * Widget to display selected category posts as Timeline on list style.
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

add_action( 'widgets_init', 'vmagazine_lite_register_timeline_posts_list_widget' );

function vmagazine_lite_register_timeline_posts_list_widget() {
    register_widget( 'vmagazine_lite_timeline_posts_list' );
}

class Vmagazine_Lite_timeline_posts_list extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'vmagazine_lite_timeline_posts_list',
            'description' => esc_html__( 'Display posts from selected category as timeline list.', 'vmagazine-lite' )
        );
        parent::__construct( 'vmagazine_lite_timeline_posts_list', esc_html__( 'vmagazine-lite : Timeline Posts', 'vmagazine-lite' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

        global $vmagazine_lite_cat_dropdown,$vmagazine_lite_posts_type;
        
        $fields = array(

           'block_layout' => array(
                'vmagazine_lite_widgets_name'         => 'block_layout',
                'vmagazine_lite_widgets_title'        => esc_html__( 'Layout will be like this', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_layout_img'   => VMAG_WIDGET_IMG_URI.'tp.png',
                'vmagazine_lite_widgets_field_type'   => 'widget_layout_image'
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
                'vmagazine_lite_widgets_title' => esc_html__( 'Select Category for Lists', 'vmagazine-lite' ),
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
                    
            
            'block_view_all_text' => array(
                'vmagazine_lite_widgets_name'         => 'block_view_all_text',
                'vmagazine_lite_widgets_title'        => esc_html__( 'View all Text', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_field_type'   => 'text'
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
        $block_post_type = empty($instance['block_post_type']) ? 'latest_posts' : $instance['block_post_type'];
        $vmagazine_lite_block_posts_count = empty( $instance['block_posts_count'] ) ? 4 : $instance['block_posts_count'];
        $vmagazine_lite_block_cat_id    = empty( $instance['block_post_category'] ) ? 0: $instance['block_post_category'];
        $vmagazine_lite_block_view_all_text   = empty( $instance['block_view_all_text'] ) ? '' : $instance['block_view_all_text'];
        $block_header_op =  empty($instance['block_header_op']) ? 'hide' : 'show';

        echo wp_kses_post($before_widget);
    ?>
        <div class="vmagazine-lite-timeline-post block-post-wrapper wow fadeInUp" data-wow-duration="1s">
            <?php if($block_header_op == 'hide'){ ?>
            <?php vmagazine_lite_widget_title( $vmagazine_lite_block_title, $title_url=null, $vmagazine_lite_block_cat_id ); ?>
            <?php } ?>
            <?php 
                    $block_args = vmagazine_lite_query_args( $block_post_type, $vmagazine_lite_block_posts_count, $vmagazine_lite_block_cat_id );
                    
                    $block_query = new WP_Query( $block_args );
                    if( $block_query->have_posts() ) { ?>
                        <div class="timeline-post-wrapper">
                        <?php 
                        while( $block_query->have_posts() ):
                            $block_query->the_post();
                            ?>
                            <div class="single-post clearfix">
                                <div class="post-date">
                                    <?php do_action( 'vmagazine_lite_formated_date' ); ?>
                                </div><!-- .post-thumb -->
                                <div class="post-caption clearfix">
                                    <div class="captions-wrapper">
                                        <h3 class="small-font">
                                            <a href="<?php the_permalink(); ?>">
                                               <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        <div class="post-meta">
                                        <?php
                                           vmagazine_lite_post_comments();
                                        ?>   
                                        </div><!-- .post-meta -->
                                    </div>
                                </div><!-- .post-caption -->
                            </div><!-- .single-post -->
                            <?php
                        endwhile; 
                        if( $vmagazine_lite_block_view_all_text ){
                           vmagazine_lite_block_view_all( $vmagazine_lite_block_cat_id, $vmagazine_lite_block_view_all_text );    
                        }
                         ?>
                        </div>
                 <?php 
                    }
                    wp_reset_postdata();
            ?>
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
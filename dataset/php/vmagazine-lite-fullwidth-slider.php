<?php
/**
 * Vmagazine: Grid List Posts
 *
 * Widget to display latest or selected category posts as on list style.
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

add_action( 'widgets_init', 'vmagazine_lite_tab_posts_list_widget' );

function vmagazine_lite_tab_posts_list_widget() {
    register_widget( 'vmagazine_lite_tab_posts_list' );
}

class Vmagazine_Lite_tab_posts_list extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'vmagazine_lite_tab_posts_list',
            'description' => esc_html__( 'Display fullwidth slider with .', 'vmagazine-lite' )
        );
        $width = array(
                'width'  => 600
        );
        parent::__construct( 'vmagazine_lite_tab_posts_list', esc_html__( 'vmagazine-lite: Fullwidth slider', 'vmagazine-lite' ), $widget_ops,$width );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

        global $vmagazine_lite_posts_type, $vmagazine_lite_cat_dropdown;
        
        $fields = array(

             'block_post_layout' => array(
                'vmagazine_lite_widgets_name' => 'block_post_layout',
                'vmagazine_lite_widgets_title' => esc_html__( 'Layout will be like this', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_layout_img'   => VMAG_WIDGET_IMG_URI.'fws-2.png',
                'vmagazine_lite_widgets_field_type'   => 'widget_layout_image'
                
            ),   
                'block_post_type' => array(
                    'vmagazine_lite_widgets_name'        => 'block_post_type',
                    'vmagazine_lite_widgets_title'       => esc_html__( 'Block Display Type', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_field_type'  => 'radio',
                    'vmagazine_lite_widgets_default'     => 'latest_posts',
                    'vmagazine_lite_widgets_field_options' => $vmagazine_lite_posts_type
                ),

                'block_post_category'               => array(
                    'vmagazine_lite_widgets_name'        => 'block_post_category',
                    'vmagazine_lite_widgets_title'       => esc_html__( 'Category for Block Posts', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_default'     => 0,
                    'vmagazine_lite_widgets_field_type'  => 'select',
                    'vmagazine_lite_widgets_field_options' => $vmagazine_lite_cat_dropdown
                ),

                'block_posts_count' => array(
                    'vmagazine_lite_widgets_name'         => 'block_posts_count',
                    'vmagazine_lite_widgets_title'        => esc_html__( 'No. of Posts', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_default'      => 4,
                    'vmagazine_lite_widgets_field_type'   => 'number'
                ),
            
                'block_section_meta' => array(
                    'vmagazine_lite_widgets_name' => 'block_section_meta',
                    'vmagazine_lite_widgets_title' => esc_html__( 'Hide/Show Meta', 'vmagazine-lite' ),
                    'vmagazine_lite_widgets_default'=>'show',
                    'vmagazine_lite_widgets_field_options'=>array('show'=>'Show','hide'=>'Hide'),
                    'vmagazine_lite_widgets_field_type' => 'switch',
                    'vmagazine_lite_widgets_description'  => esc_html__('Show or hide post meta options like author name, post date etc','vmagazine-lite'),
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

        $vmagazine_lite_block_posts_count = empty($instance['block_posts_count']) ? 4 : $instance['block_posts_count'];
        $vmagazine_lite_block_posts_type = empty($instance['block_post_type']) ? 'latest_posts' : $instance['block_post_type'];
        $vmagazine_lite_block_cat_id = empty($instance['block_post_category']) ? null: $instance['block_post_category'];
        $block_section_meta = empty($instance['block_section_meta']) ? 'show' : $instance['block_section_meta'];
        
        echo wp_kses_post($before_widget);
    ?>
        <div class="vmagazine-lite-fullwid-slider block-post-wrapper block_layout_2" data-count="<?php echo absint($vmagazine_lite_block_posts_count);?>">

             <div class="slick-wrap sl-before-load">
            <?php 
                $block_args = vmagazine_lite_query_args( $vmagazine_lite_block_posts_type, $vmagazine_lite_block_posts_count, $vmagazine_lite_block_cat_id );
                $block_query = new WP_Query( $block_args );
                if( $block_query->have_posts() ) {
                    while( $block_query->have_posts() ) {
                        $block_query->the_post();
                        $image_id = get_post_thumbnail_id();
                        $img_src = vmagazine_lite_home_element_img('vmagazine-lite-single-large');
                        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            ?>
                        <div class="single-post clearfix">
                            
                                <div class="post-thumb">
                                            <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" />
                                            <div class="image-overlay"></div>
                                </div><!-- .post-thumb -->
                                <div class="post-content-wrapper clearfix">
                                    <?php do_action( 'vmagazine_lite_post_cat_or_tag_lists' ); ?>

                                    <?php if( $block_section_meta == 'show' ): ?>
                                    <div class="post-meta clearfix">
                                        <?php  do_action( 'vmagazine_lite_icon_meta' ); ?>
                                    </div><!-- .post-meta --> 
                                    <?php endif; ?>
                                    <h3 class="extra-large-font">
                                        <a href="<?php the_permalink(); ?>">
                                             <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    
                                </div><!-- .post-content-wrapper -->
                           
                        </div><!-- .single-post  -->
                        <?php
                    }
                }
                wp_reset_postdata();
            ?>
            </div> 
            <div class="vmagazine-lite-container">
            <div class="posts-tab-wrap sl-before-load">
                <?php 
                    $block_args = vmagazine_lite_query_args( $vmagazine_lite_block_posts_type, $vmagazine_lite_block_posts_count, $vmagazine_lite_block_cat_id );
                    $block_query = new WP_Query( $block_args );
                    if( $block_query->have_posts() ) {
                        while( $block_query->have_posts() ) {
                            $block_query->the_post();
                            $image_id = get_post_thumbnail_id();
                            $img_srcs = vmagazine_lite_home_element_img('vmagazine-lite-small-thumb');
                            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                ?>                
                <div class="single-post clearfix">  
                    <div class="slider-nav-inner-wrapper">
                        <div class="post-thumb">
                            <img src="<?php echo esc_url($img_srcs); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" />
                            <div class="image-overlay"></div>
                               
                            <?php do_action( 'vmagazine_lite_post_format_icon' );?>
                        </div><!-- .post-thumb -->
                        <div class="post-caption-wrapper">
                             <?php if( $block_section_meta == 'show' ):
                               $posted_on = get_the_date();
                               echo '<span class="posted-on"><i class="fa fa-clock-o"></i>'.esc_html($posted_on) .'</span>';
                             endif; ?>
                            <h3 class="large-font">
                                <?php the_title(); ?>
                            </h3>
                           
                        </div><!-- .post-caption-wrapper -->
                    </div><!-- .slider-nav-inner-wrapper -->
                </div> 
                <?php }} wp_reset_postdata();?>               
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
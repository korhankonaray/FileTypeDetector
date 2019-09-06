<?php
/**
 * Vmagazine: Leaderboard ads
 *
 * Widget to display ads size of 300x250
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

add_action( 'widgets_init', 'vmagazine_lite_register_medium_ads_widget' );

function vmagazine_lite_register_medium_ads_widget() {
    register_widget( 'vmagazine_lite_medium_ad' );
}

class Vmagazine_Lite_Medium_Ad extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'vmagazine_lite_medium_ad',
            'description' => esc_html__( 'Display ads in size of medium rectangle', 'vmagazine-lite' )
        );
        parent::__construct( 'vmagazine_lite_medium_ad', esc_html__( 'vmagazine-lite : Ads Uploader', 'vmagazine-lite' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'ad_banner_title' => array(
                'vmagazine_lite_widgets_name'         => 'ad_banner_title',
                'vmagazine_lite_widgets_title'        => esc_html__( 'Banner Title', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_field_type'   => 'text'
            ),

            'ad_banner_image' => array(
                'vmagazine_lite_widgets_name' => 'ad_banner_image',
                'vmagazine_lite_widgets_title' => esc_html__( 'Banner Image', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_field_type' => 'upload',
            ),
            'ad_banner_text' => array(
                'vmagazine_lite_widgets_name'         => 'ad_banner_text',
                'vmagazine_lite_widgets_title'        => esc_html__( 'ADS Bottom Text', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_field_type'   => 'text'
            ),
            'ad_banner_url' => array(
                'vmagazine_lite_widgets_name'         => 'ad_banner_url',
                'vmagazine_lite_widgets_title'        => esc_html__( 'Banner Url', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_field_type'   => 'url'
            ),
            'ad_banner_url_target' => array(
                'vmagazine_lite_widgets_name'         => 'ad_banner_url_target',
                'vmagazine_lite_widgets_title'        => esc_html__( 'Open link in new tab', 'vmagazine-lite' ),
                'vmagazine_lite_widgets_field_type'   => 'checkbox'
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

        $vmagazine_lite_banner_title = empty( $instance['ad_banner_title'] ) ? '' : $instance['ad_banner_title'];
        $vmagazine_lite_banner_image   = empty( $instance['ad_banner_image'] ) ? '' : $instance['ad_banner_image'];
        $ad_banner_text = empty( $instance['ad_banner_text']) ? '' : $instance['ad_banner_text'];
        $vmagazine_lite_banner_url   = empty( $instance['ad_banner_url'] ) ? '' : $instance['ad_banner_url'];
        $vmagazine_lite_link_target  = empty( $instance['ad_banner_url_target'])  ? '_self': '_blank';
        

        echo wp_kses_post($before_widget);
        if( !empty( $vmagazine_lite_banner_image ) ) {
    ?>
            <div class="vmagazine-lite-medium-rectangle-ad medium-rectangle-wrapper">
                <?php if( $vmagazine_lite_banner_title ): ?>
                <h4 class="block-title"><span class="title-bg"><?php echo esc_html( $vmagazine_lite_banner_title ); ?></span></h4>
                <?php
                endif;
                    if( !empty( $vmagazine_lite_banner_url ) ) {
                ?>
                    <a href="<?php echo esc_url( $vmagazine_lite_banner_url );?>" target="<?php echo esc_attr($vmagazine_lite_link_target); ?>">
                        <?php echo vmagazine_lite_load_images($vmagazine_lite_banner_image); // WPCS: XSS OK.?>
                        <?php if($ad_banner_text): ?>
                            <p><?php echo esc_html($ad_banner_text); ?></p>
                        <?php endif; ?>
                    </a>
                <?php
                    } else {
                ?>
                    <?php echo vmagazine_lite_load_images($vmagazine_lite_banner_image); // WPCS: XSS OK.?>
                    <?php if($ad_banner_text): ?>
                        <p><?php echo esc_html($ad_banner_text); ?></p>
                    <?php endif; ?>
                <?php
                    }
                ?>
            </div>  
    <?php
        }
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
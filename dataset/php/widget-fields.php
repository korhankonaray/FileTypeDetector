<?php
/**
 * Define custom fields for widgets
 * 
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

function vmagazine_lite_widgets_show_widget_field( $instance = '', $widget_field = '', $athm_field_value = '' ) {
    
    extract( $widget_field );

    switch ( $vmagazine_lite_widgets_field_type ) {

       
       case 'wrapper_start':
       
        echo  '<div class="'.esc_html($vmagazine_lite_widgets_name).'">';

       break;

       case 'wrapper_end':
       
        echo  '</div>';

       break;

    	// Standard text field
        case 'text' :
        ?>
            <p>
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>" type="text" value="<?php echo esc_html( $athm_field_value ); ?>" />

                <?php if ( isset( $vmagazine_lite_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $vmagazine_lite_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        // Standard url field
        case 'url' :
        ?>
            <p>
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>" type="text" value="<?php echo esc_attr( $athm_field_value ); ?>" />

                <?php if ( isset( $vmagazine_lite_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $vmagazine_lite_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        // Textarea field
        case 'textarea' :
        ?>
            <p>
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?>:</label>
                <textarea class="widefat" rows="<?php echo esc_attr($vmagazine_lite_widgets_row); ?>" id="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $athm_field_value ); ?></textarea>
            </p>
        <?php
            break;

        // Checkbox field
        case 'checkbox' :
        ?>
            <p>
                <input id="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>" type="checkbox" value="1" <?php checked('1', $athm_field_value); ?>/>
                <label for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?></label>

                <?php if ( isset( $vmagazine_lite_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $vmagazine_lite_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        // Radio fields
        case 'radio' :
        	if( empty( $athm_field_value ) ) {
        		$athm_field_value = $vmagazine_lite_widgets_default;
        	}
        ?>
            <div class="widget-radio-wrapper">
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?>:</label>
                <?php
                echo '<br />';
                foreach ( $vmagazine_lite_widgets_field_options as $athm_option_name => $athm_option_title ) {
                    ?>
                    <input id="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>" type="radio" value="<?php echo esc_attr($athm_option_name); ?>" <?php checked( $athm_option_name, $athm_field_value ); ?> class="vmagazine-lite-radio-layout-type"/>
                    <label for="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>"><?php echo esc_html( $athm_option_title ); ?></label>
                    <br />
                <?php } ?>

                <?php if ( isset( $vmagazine_lite_widgets_description ) ) { ?>
                    <small><?php echo esc_html( $vmagazine_lite_widgets_description ); ?></small>
                <?php } ?>
            </div>
        <?php
            break;
        //Radio image controller
        case 'radioimg' :
            if( empty( $athm_field_value ) ) {
                $athm_field_value = $vmagazine_lite_widgets_default;
            }
        ?>
            <div class="radio-img-layouts">
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?>:</label>
                <?php
                echo '<br />';
                 if ( isset( $vmagazine_lite_widgets_description ) ) { ?>
                    <small><?php echo esc_html( $vmagazine_lite_widgets_description ); ?></small>
                <?php } 
                 echo '<br />';
                 echo "<ul class='widget-layouts'>";
                foreach ( $vmagazine_lite_widgets_field_options as $athm_option_name => $athm_option_title ) {
                    ?>
                    <li class="img-selector">
                        <label>
                            <input style = 'display:none' id="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>" type="radio" value="<?php echo esc_attr($athm_option_name); ?>" <?php checked( $athm_option_name, $athm_field_value ); ?> class="vmagazine-lite-radio-layout-type"/>
                            <img src="<?php echo esc_url($athm_option_title)?>">
                            <span class="img-icon"></span>
                        </label>
                    </li>
                <?php } ?>
                </ul>
                
            </div>
        <?php
            break;

        // Select field
        case 'select' :
            if( empty( $athm_field_value ) ) {
                $athm_field_value = $vmagazine_lite_widgets_default;
            }
        ?><div class="vmagazine-lite-select-wrapp">
            <p>
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?>:</label>
                <select name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>" class="widefat vmagazine-lite-select-type">
                    <?php foreach ( $vmagazine_lite_widgets_field_options as $athm_option_name => $athm_option_title ) { ?>
                        <option value="<?php echo esc_attr($athm_option_name); ?>" id="<?php echo esc_attr( $instance->get_field_id($athm_option_name ) ); ?>" <?php selected( $athm_option_name, $athm_field_value ); ?>><?php echo esc_html( $athm_option_title ); ?></option>
                    <?php } ?>
                </select>

                <?php if ( isset( $vmagazine_lite_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $vmagazine_lite_widgets_description ); ?></small>
                <?php } ?>
            </p>
            </div>
        <?php
            break;

        case 'switch':
            if( empty( $athm_field_value ) ) {
                $athm_field_value = $vmagazine_lite_widgets_default;
            }
        ?>
            <p>
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?></label>
                <div class="widget_switch_options">
                    <?php 
                        foreach ( $vmagazine_lite_widgets_field_options as $key => $value ) {
                            if( $key == $athm_field_value ) {
                                echo '<span class="widget_switch_part '.esc_html($key).' selected" data-switch="'.esc_html($key).'">'. esc_html($value).'</span>';
                            } else {
                                echo '<span class="widget_switch_part '.esc_html($key).'" data-switch="'.esc_html($key).'">'. esc_html($value).'</span>';
                            }                            
                        }
                    ?>
                     <?php if ( isset( $vmagazine_lite_widgets_description ) ) { ?>
                        <br />
                        <small><?php echo esc_html( $vmagazine_lite_widgets_description ); ?></small>
                    <?php } ?>
                    <input type="hidden" id="<?php echo esc_attr( $instance->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>" value="<?php echo esc_attr($athm_field_value); ?>" />
                </div>
            </p>
        <?php
            break;

        case 'number' :
        	if( empty( $athm_field_value ) ) {
        		 $vmagazine_lite_widgets_default = $athm_field_value ;
        	}
        ?>
        <div class="vmagazine-lite-number-type">
            <p>
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>"><?php echo esc_html( $vmagazine_lite_widgets_title ); ?>:</label><br />
               
                <?php if ( isset( $vmagazine_lite_widgets_description ) ) { ?>
                    <small><?php echo esc_html( $vmagazine_lite_widgets_description ); ?></small><br/>
                <?php } ?>
                 <input name="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) ); ?>" type="number" step="1" min="1" id="<?php echo esc_attr( $instance->get_field_id( $vmagazine_lite_widgets_name ) ); ?>" value="<?php echo esc_attr( $athm_field_value ); ?>" class="small-text" />
            </p>
        </div>
       	<?php
            break;

        case 'section_header':
        ?>
        	<span class="section-header"><?php echo esc_attr( $vmagazine_lite_widgets_title ); ?></span>
        <?php
        	break;

        case 'widget_layout_image':
        ?>
            <div class="layout-image-wrapper">
                <h5 class="image-title"><?php echo esc_attr( $vmagazine_lite_widgets_title ); ?></h5>
                <img src="<?php echo esc_url( $vmagazine_lite_widgets_layout_img ); ?>" title="<?php esc_attr_e( 'Widget Layout', 'vmagazine-lite' ); ?>" />
            </div>
        <?php
            break;

        case 'upload' :

           
            $id = $instance->get_field_id( $vmagazine_lite_widgets_name );
            $class = '';
            $int = '';
            $value = $athm_field_value;
            $name = $instance->get_field_name( $vmagazine_lite_widgets_name );

            if ( $value ) {
                $class = ' has-file';
                $value = explode( 'wp-content', $value );
                $value = content_url().$value[1];
            } ?>
            <div class="sub-option widget-upload">
                <label class="wtitle" for="<?php echo esc_attr($instance->get_field_id( $vmagazine_lite_widgets_name ));?>"><?php echo esc_html($vmagazine_lite_widgets_title); ?></label><br/>
                <input id="<?php echo esc_attr($id);?>" class="upload <?php echo esc_attr($class); ?>" type="text" name="<?php echo esc_attr($name);?>" value="<?php echo esc_attr($value)?>" placeholder="<?php esc_attr_e( 'No file chosen', 'vmagazine-lite' )?>" />
                <?php
                if ( function_exists( 'wp_enqueue_media' ) ) {
                    if ( ( $value == '') ) {
                        ?>
                        <input id="upload-<?php echo esc_attr($id)?>" class="ap-upload-button button" type="button" value="<?php esc_attr_e( 'Upload', 'vmagazine-lite' )?>" />
                    <?php
                    } else {
                        ?>
                        <input id="remove-<?php echo esc_attr($id) ?>" class="remove-file button" type="button" value="<?php esc_attr_e('Remove', 'vmagazine-lite' )?>" />
                    <?php 
                    }
                } else {
                    ?>
                    <p><i><?php esc_html_e( 'Upgrade your version of WordPress for full media support.', 'vmagazine-lite' );?></i></p>
                <?php } ?>

                <div class="screenshot upload-thumb" id="<?php echo esc_attr($id)?>-image">
                <?php
                if ( $value != '' ) {
                    $remove = '<a class="remove-image">'. __( 'Remove', 'vmagazine-lite' ).'</a>';
                    $attachment_id = vmagazine_lite_get_attachment_id_from_url( $value );
                    $image_array = wp_get_attachment_image_src( $attachment_id, 'large' );
                    $image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
                    if ( $image ) {
                    ?>
                    <img src="<?php echo esc_url($image_array[0])?>" height="150px" width="150px"/>
                    <?php 
                    } else {
                        $parts = explode( "/", $value );
                        for ( $i = 0; $i < sizeof( $parts ); ++$i ) {
                            $title = $parts[$i];
                        }

                        // Standard generic output if it's not an image.
                        $title = esc_html__( 'View File', 'vmagazine-lite' );
                        ?>
                        <div class="no-image">
                            <span class="file_link">
                                <a href="<?php echo esc_attr($value)?>" target="_blank" rel="external"><?php echo esc_html($title)?></a>
                            </span>
                        </div>
                    <?php 
                    }
                } ?>
                </div>
            </div>
            <?php
            break;

        case 'section_wrapper_start':
        ?>
            
            <div id="<?php echo esc_attr( $instance->get_field_name( $vmagazine_lite_widgets_name ) );?>" class="widget-section-wrapper <?php echo esc_attr( $vmagazine_lite_widgets_class );?>">
        <?php
            break;

        case 'section_wrapper_end':
        ?>
            </div>
        <?php
            break;

         // Select field
        case 'section_tab_wrapper' :
        ?>
            <ul class="widget-tabs-wrapper">
                <?php 
                    foreach ( $vmagazine_lite_widgets_field_options as $tab_key => $tab_value ) {
                        if( $vmagazine_lite_widgets_default == $tab_key ) {
                            $active_class = 'active';
                        } else {
                            $active_class = '';
                        }
                ?>
                <li class="widget-tab-control <?php echo esc_attr( $active_class ); ?>" data-tab="<?php echo esc_attr( $tab_key ); ?>"><?php echo esc_html( $tab_value ); ?></li>
                <?php } ?>
            </ul><!-- .widget-tabs-wrapper -->
        <?php
            break;

            echo '</div>';
    }
}

function vmagazine_lite_widgets_updated_field_value( $widget_field, $new_field_value ) {
    extract( $widget_field );

    // Allow only integers in number fields
    if ( $vmagazine_lite_widgets_field_type == 'number') {
        return vmagazine_lite_sanitize_number( $new_field_value );

        // Allow some tags in textareas
    } elseif ( $vmagazine_lite_widgets_field_type == 'textarea' ) {
        // Check if field array specifed allowed tags
        if ( !isset( $vmagazine_lite_widgets_allowed_tags ) ) {
            // If not, fallback to default tags
            $vmagazine_lite_widgets_allowed_tags = '<p><strong><em><a>';
        }
        return strip_tags( $new_field_value, $vmagazine_lite_widgets_allowed_tags );

        // No allowed tags for all other fields
    } elseif ( $vmagazine_lite_widgets_field_type == 'url' ) {
        return esc_url( $new_field_value );
    } elseif ( $vmagazine_lite_widgets_field_type == 'multicheckboxes' ) {
        return $new_field_value;
    } else {
        return strip_tags( $new_field_value );
    }
}
<?php
/**
 * Extend custom classes for customizer
 *
 * @package AccessPress Themes
 * @subpackage vmagazine-lite
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

    /**
     * Pro customizer section.
     *
     * @since  1.0.0
     * @access public
     */
    class Vmagazine_Lite_Customize_Section_Pro extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'vmagazine-lite';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();
            $json['pro_text'] = $this->pro_text;  
            $json['pro_url']  = $this->pro_url;
            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() { ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    {{ data.title }}
                    <# if ( data.pro_text && data.pro_url ) { #>
                        <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
            </li>
        <?php }
    }

    class Vmagazine_Lite_Customize_Switch_Control extends WP_Customize_Control {

      /**
       * The type of customize control being rendered.
       *
       * @since  1.0.0
       * @access public
       * @var    string
       */
    public $type = 'switch';
    /**
       * Displays the control content.
       *
       * @since  1.0.0
       * @access public
       * @return void
       */
    public function render_content() { ?>
      <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <div class="description customize-control-description"><?php echo esc_html( $this->description ); ?></div>
            <div class="switch_options">
              <?php 
                $show_choices = $this->choices;
                foreach ( $show_choices as $key => $value ) {
                  echo '<span class="switch_part '.esc_attr($key).'" data-switch="'.esc_attr($key).'">'. esc_html($value).'</span>';
                }
              ?>
                    <input type="hidden" id="ap_switch_option" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
                </div>
            </label>
  <?php
    }
  }

  class Vmagazine_Lite_Seperator_Control extends WP_Customize_Control {
     public function render_content() { ?>
       <span class="customize-control-seperator">
           <?php echo esc_html( $this->label ); ?>
       </span>  
       <?php     
  }     

}

  /**
     * Image control by radtion button 
     */
    class Vmagazine_Lite_Image_Radio_Control extends WP_Customize_Control {

    public function render_content() {

      if ( empty( $this->choices ) ) {
        return;
      }

      $name = '_customize-radio-' . $this->id;

      ?>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
      <ul class="controls" id="vmagazine-lite-img-container">
      <?php
        foreach ( $this->choices as $value => $label ) :
          $class = ( $this->value() == $value ) ? 'vmagazine-lite-radio-img-selected vmagazine-lite-radio-img-img' : 'vmagazine-lite-radio-img-img';
      ?>
          <li class="inc-radio-image">
            <label>
              <input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
              <img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo esc_attr( $class ); ?>' />
            </label>
          </li>
      <?php
        endforeach;
      ?>
      </ul>
      <?php
    }
  }

  /**
     * Customize for text-area, extend the WP customizer
     */
    class Vmagazine_Lite_Textarea_Custom_Control extends WP_Customize_Control{
      /**
       * Render the control's content.
       * 
       */
      public $type = 'vmagazine_lite_textarea';
        public function render_content() {
    ?>
        <label>
          <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
          <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
              <textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
            <?php echo esc_textarea( $this->value() ); ?>
          </textarea>
        </label>
    <?php
      }
    }

  
    /** Section background color picker field **/
    class Vmagazine_Lite_Bg_Color_Picker extends WP_Customize_Control {
        public function render_content() { ?>
        <span class="customize-control-title">
            <?php echo esc_html( $this->label ); ?>
        </span>
        <span class="desc clearfix">
            <?php echo esc_html( $this->description ); ?>
        </span>
        <input type='text' class="customizer-bg-color-picker" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
    <?php
        }
    }


/** Site Preloader **/
class Vmagazine_Lite_Customize_Preloader_Control extends WP_Customize_Control {

    public function render_content() {
        $preloaders = array(
            'default',
            'coffee',
            'grid',
            'horizon',
            'list',
            'rhombus',
            'setting',
            'square',
            'text',
            'clock',
            'globe',
            'infinity',
            'loader',
            'eclipse',
            'loader-one'
        );

        if ( empty( $preloaders ) )
        return; ?>
        <label>
                    <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <?php endif;
                    if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                    <?php endif; ?>

                    <div class="cmizer-preloader-container">
                            <?php foreach($preloaders as $preloader) : ?>
                                    <span class="cmizer-preloader <?php if($preloader == $this->value()){echo "active";} ?>" preloader="<?php echo esc_attr($preloader); ?>">
                                            <img src="<?php echo esc_url(get_template_directory_uri()).'/assets/images/preloader/'.esc_attr($preloader).'.gif'; ?>" />
                                    </span>
                            <?php endforeach; ?>
                    </div>
                    <input type="hidden" <?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
        </label>
        <?php
    }
}


/**
   * A class to create a list of icons in customizer field
   *
   * @since 1.0.0
   * @access public
   */
  class Vmagazine_Lite_Customize_Icons_Control extends WP_Customize_Control {

    /**
       * The type of customize control being rendered.
       *
       * @since  1.0.0
       * @access public
       * @var    string
       */
    public $type = 'vmagazine_lite_icons';

    /**
       * Displays the control content.
       *
       * @since  1.0.0
       * @access public
       * @return void
       */
    public function render_content() {

      $saved_icon_value = $this->value(); ?>
      <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
        <div class="ap-customize-icons">
          <div class="selected-icon-preview"><?php if( !empty( $saved_icon_value ) ) { echo '<i class="fa '. esc_attr($saved_icon_value) .'"></i>'; } ?>
          </div>
          <span class="icon-toggle"><i class="fa fa-chevron-down"></i></span>
          <ul class="icons-list-wrapper">
            <?php 
              $vmagazine_lite_icons_list = vmagazine_lite_cust_icons_array();
              foreach ( $vmagazine_lite_icons_list as $key => $icon_value ) {
                if( $saved_icon_value == $icon_value ) {
                  echo '<li class="selected"><i class="fa '. esc_attr($icon_value) .'"></i></li>';

                } else {
                  echo '<li><i class="fa '. esc_attr($icon_value) .'"></i></li>';
                }
              }
            ?>
          </ul>
          <input type="hidden" class="ap-icon-value" value="" <?php $this->link(); ?>>
        </div>

      </label>
  <?php
    }
  }





} //endif class_exists


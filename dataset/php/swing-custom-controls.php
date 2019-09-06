<?php
/**
 * Define some custom classes for swing.
 * 
 * https://codex.wordpress.org/Class_Reference/WP_Customize_Control
 *
 * @package AccessPress Themes
 * @subpackage Unicon
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
     * Pro customizer section.
     *
     * @since  1.0.0
     * @access public
     */
    class Swing_Lite_Customize_Section_Pro extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'swing';

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

/**
* Switch button customize control.
*
* @since 1.0.0
* @access public
*/
    class swing_lite_Customize_Switch_Control extends WP_Customize_Control {

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
		public function render_content() { 

			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<div class="description customize-control-description"><?php echo esc_html( $this->description ); ?></div>
		        <div class="switch_options">
		        	<?php 
		        		$show_choices = $this->choices;

		        		foreach ( $show_choices as $key => $value ) {
		        			echo '<span class="switch_part ' . esc_attr($key) . '" data-switch="' . esc_attr($key) . '">' . esc_html($value) . '</span>';
		        		}
		        	?>
                  	<input type="hidden" id="ap_switch_option" <?php $this->link(); ?> value="<?php echo wp_kses_post($this->value()); ?>" />
                </div>
            </label>
	<?php
		}
	}


	/**
	 * A class to create a dropdown for all categories in your wordpress site
	 *
	 * @since 1.0.0
	 * @access public
	 */
	class Swing_lite_Customize_Category_Control extends WP_Customize_Control {
		
		/**
		 * Render the control's content.
		 *
		 * @return HTML
		 * @since 1.0.0
		 */
		public function render_content() {
			$dropdown = wp_dropdown_categories(
				array(
					'name'              => '_customize-dropdown-categories-' . $this->id,
					'echo'              => 0,
					'show_option_none'  => esc_html__( '&mdash; Select Category &mdash;', 'swing-lite' ),
					'option_none_value' => '0',
					'selected'          => $this->value(),
				)
			);


			// Hackily add in the data link parameter.
			$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
			printf(
				'<label class="customize-control-select"><span class="customize-control-title">%s</span><span class="description customize-control-description">%s</span> %s </label>',
				esc_html($this->label),
				wp_kses_post($this->description),
				$dropdown
			);
		}
	}


	 /** Datepicker Control **/
    class WP_Customize_Datepick_Control extends WP_Customize_Control {            
            public function render_content() {                
                ?>
                <label>
                    <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <?php endif;

                    if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                    <?php endif; ?>
                    
                    <input class="datepicker" <?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
                </label>
                <?php
            }
    }

	/** Swing Info Callback Function **/
    class swing_lite_Customize_Info_Control extends WP_Customize_Control {
            public $info;

            public function render_content() {                
                ?>
                <div class="swing-info-secton">
                	 <h3><?php echo esc_html__('Note :', 'swing-lite'); ?> </h3>
                	<p>
                		<?php echo wp_kses_post($this->info); ?>
                	</p>
                </div>
                <?php
            }
    }
}
<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', function( $wp_customize ) {
	
    /**
     * Color control
     */
    class Kirki_Controls_Alpha_Color_Control extends Kirki_Control_Base {

        public $type = 'alpha-color';

        /**
         * Add support for palettes to be passed in.
         *
         * Supported palette values are true, false, or an array of RGBa and Hex colors.
         */
        public $palette;

        /**
         * Add support for showing the opacity value on the slider handle.
         */
        public $show_opacity;

        /**
         * Enqueue control related scripts/styles.
         *
         * @access public
         */
        public function enqueue() {
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'analytica-color', analytica()->theme_url . '/assets/admin/js/modules/customizer/controls/alpha-color.js', array( 'jquery', 'customize-base', 'wp-color-picker' ), false, true );
            
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style( 'analytica-color', analytica()->theme_url . '/assets/admin/css/customizer/controls/alpha-color.min.css', array( 'wp-color-picker' ), '1.0.0' );

            wp_localize_script( 'analytica-color', 'analyticaLocalize', array( 'colorPalettes' => analytica_default_color_palettes() ) );
        }

        /**
         * An Underscore (JS) template for this control's content (but not its container).
         *
         * Class variables for this control class are available in the `data` JS object;
         * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
         *
         * @see WP_Customize_Control::print_template()
         *
         * @access protected
         */
        protected function content_template() { 
            
            ?><label>
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
                <div>
                    <input class="alpha-color-control" type="text" value="{{ data.value }}" data-show-opacity="{{ data.show_opacity }}" data-default-color="{{ data.default }}" {{{ data.link }}} />
                </div>
            </label><?php
        }
    }

	// Register our custom control with Kirki
	add_filter( 'kirki_control_types', function( $controls ) {
		$controls['alpha-color'] = 'Kirki_Controls_Alpha_Color_Control';
		return $controls;
	} );

    $wp_customize->register_control_type( 'Kirki_Controls_Alpha_Color_Control' );
} );

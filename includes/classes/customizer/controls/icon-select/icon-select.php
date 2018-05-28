<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', function( $wp_customize ) {

    /**
     * Range control
     */
    class Kirki_Controls_Icon_Control extends Kirki_Control_Base {

        /**
         * The control type.
         *
         * @access public
         * @var string
         */
        public $type = 'icon';

        /**
         * Enqueue control related scripts/styles.
         *
         * @access public
         */
        public function enqueue() {
            wp_enqueue_script( 'analytica-icon-select', analytica()->theme_url . '/assets/admin/js/modules/customizer/controls/icon-select.js', array( 'jquery', 'customize-base' ), false, true );
            wp_enqueue_style( 'analytica-icon-select', analytica()->theme_url . '/assets/admin/css/customizer/controls/icon-select.min.css', null );
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
            ?>
            <label class="customizer-text">
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
            </label>
            <div id="input_{{ data.id }}" class="icon-select clr">
                <# for ( key in data.choices ) { #>
                    <label>
                        <input class="icon-select-input" type="radio" value="{{ key }}" name="_customize-icon-select-{{ data.id }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked<# } #> />
                        <span class="icon-select-label"><i class="{{ key }}"></i></span>
                    </label>
                <# } #>
            </div>
            <?php
        }
    }

	// Register our custom control with Kirki
	add_filter( 'kirki_control_types', function( $controls ) {
		$controls['icon'] = 'Kirki_Controls_Icon_Control';
		return $controls;
    } );
    
    $wp_customize->register_control_type( 'Kirki_Controls_Icon_Control' );

} );
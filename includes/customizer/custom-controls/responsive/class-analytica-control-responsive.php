<?php
/**
 * Customizer Control: responsive
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A text control with validation for CSS units.
 */
class Analytica_Control_Responsive extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'ast-responsive';

	/**
	 * The control type.
	 *
	 * @access public
	 * @var array
	 */
	public $units = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		$css_uri = ANALYTICA_THEME_URI . 'includes/customizer/custom-controls/responsive/';
		$js_uri  = ANALYTICA_THEME_URI . 'includes/customizer/custom-controls/responsive/';

		wp_enqueue_script( 'analytica-responsive', $js_uri . 'responsive.js', array( 'jquery', 'customize-base' ), ANALYTICA_THEME_VERSION, true );
		wp_enqueue_style( 'analytica-responsive-css', $css_uri . 'responsive.css', null, ANALYTICA_THEME_VERSION );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}

		$val = maybe_unserialize( $this->value() );

		if ( ! is_array( $val ) || is_numeric( $val ) ) {

			$val = array(
				'desktop'      => $val,
				'tablet'       => '',
				'mobile'       => '',
				'desktop-unit' => '',
				'tablet-unit'  => '',
				'mobile-unit'  => '',
			);
		}

		$this->json['value']   = $val;
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
		$this->json['label']   = esc_html( $this->label );
		$this->json['units']   = $this->units;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

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
		<label class="customizer-text" for="" >
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
				<ul class="ast-responsive-btns">
					<li class="desktop active">
						<button type="button" class="preview-desktop active" data-device="desktop">
							<i class="dashicons dashicons-desktop"></i>
						</button>
					</li>
					<li class="tablet">
						<button type="button" class="preview-tablet" data-device="tablet">
							<i class="dashicons dashicons-tablet"></i>
						</button>
					</li>
					<li class="mobile">
						<button type="button" class="preview-mobile" data-device="mobile">
							<i class="dashicons dashicons-smartphone"></i>
						</button>
					</li>
				</ul>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } 

			value_desktop = '';
			value_tablet  = '';
			value_mobile  = '';

			if ( data.value['desktop'] ) { 
				value_desktop = data.value['desktop'];
			} 

			if ( data.value['tablet'] ) { 
				value_tablet = data.value['tablet'];
			} 

			if ( data.value['mobile'] ) { 
				value_mobile = data.value['mobile'];
			} #>

			<div class="input-wrapper ast-responsive-wrapper">

				<input {{{ data.inputAttrs }}} data-id='desktop' class="ast-responsive-input desktop active" type="number" value="{{ value_desktop }}"/>
				<select class="ast-responsive-select desktop" data-id='desktop-unit' <# if ( _.size( data.units ) === 1 ) { #> disabled="disabled" <# } #>>
				<# _.each( data.units, function( value, key ) { #>
					<option value="{{{ key }}}" <# if ( data.value['desktop-unit'] === key ) { #> selected="selected" <# } #>>{{{ data.units[ key ] }}}</option>
				<# }); #>
				</select>

				<input {{{ data.inputAttrs }}} data-id='tablet' class="ast-responsive-input tablet" type="number" value="{{ value_tablet }}"/>
				<select class="ast-responsive-select tablet" data-id='tablet-unit' <# if ( _.size( data.units ) === 1 ) { #> disabled="disabled" <# } #>>
				<# _.each( data.units, function( value, key ) { #>
					<option value="{{{ key }}}" <# if ( data.value['tablet-unit'] === key ) { #> selected="selected" <# } #>>{{{ data.units[ key ] }}}</option>
				<# }); #>
				</select>

				<input {{{ data.inputAttrs }}} data-id='mobile' class="ast-responsive-input mobile" type="number" value="{{ value_mobile }}"/>
				<select class="ast-responsive-select mobile" data-id='mobile-unit' <# if ( _.size( data.units ) === 1 ) { #> disabled="disabled" <# } #>>
				<# _.each( data.units, function( value, key ) { #>
					<option value="{{{ key }}}" <# if ( data.value['mobile-unit'] === key ) { #> selected="selected" <# } #>>{{{ data.units[ key ] }}}</option>
				<# }); #>
				</select>

			</div>
		</label>
		<?php
	}

	/**
	 * Render the control's content.
	 *
	 * @see WP_Customize_Control::render_content()
	 */
	protected function render_content() {}
}

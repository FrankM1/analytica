<?php
/**
 * Customizer Control: divider
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
class Analytica_Control_Divider extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'ast-divider';

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $caption = '';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		$css_uri = ANALYTICA_THEME_URI . 'includes/customizer/custom-controls/divider/';
		wp_enqueue_style( 'analytica-divider-css', $css_uri . 'divider.css', null, ANALYTICA_THEME_VERSION );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['label']       = esc_html( $this->label );
		$this->json['caption']     = $this->caption;
		$this->json['description'] = $this->description;
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

		<# if ( data.caption ) { #>
			<span class="customize-control-caption">{{{ data.caption }}}</span>
		<# } #>
		<hr />

		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<?php
	}
}

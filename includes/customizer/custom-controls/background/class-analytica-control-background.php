<?php
/**
 * Customizer Control: background.
 *
 * Creates a jQuery background control.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       1.0.0
 */

/**
 * Field overrides.
 */
if ( ! class_exists( 'Analytica_Control_Background' ) && class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Background Control
	 */
	class Analytica_Control_Background extends WP_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'ast-background';

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
			$this->json['value'] = $this->value();
			$this->json['link']  = $this->get_link();
			$this->json['id']    = $this->id;
			$this->json['label'] = esc_html( $this->label );

			$this->json['inputAttrs'] = '';
			foreach ( $this->input_attrs as $attr => $value ) {
				$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
			}
		}

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			$css_uri = ANALYTICA_THEME_URI . 'includes/customizer/custom-controls/background/';
			$js_uri  = ANALYTICA_THEME_URI . 'includes/customizer/custom-controls/background/';

			wp_enqueue_style( 'analytica-background', $css_uri . 'background.css', null, ANALYTICA_THEME_VERSION );
			wp_enqueue_script( 'analytica-background', $js_uri . 'background.js', array(), ANALYTICA_THEME_VERSION, true );
			wp_localize_script(
				'analytica-background', 'analyticaCustomizerControlBackground', array(
					'placeholder'  => __( 'No file selected', 'analytica' ),
					'lessSettings' => __( 'Less Settings', 'analytica' ),
					'moreSettings' => __( 'More Settings', 'analytica' ),
				)
			);
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
			<label>
				<span class="customize-control-title">{{{ data.label }}}</span>
				<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			</label>
			<div class="background-wrapper">

				<!-- background-color -->
				<div class="background-color">
					<h4><?php esc_attr_e( 'Background Color', 'analytica' ); ?></h4>
					<input type="text" data-default-color="{{ data.default['background-color'] }}" data-alpha="true" value="{{ data.value['background-color'] }}" class="ast-color-control"/>
				</div>

				<!-- background-image -->
				<div class="background-image">
					<h4><?php esc_attr_e( 'Background Image', 'analytica' ); ?></h4>
					<div class="attachment-media-view background-image-upload">
						<# if ( data.value['background-image'] ) { #>
							<div class="thumbnail thumbnail-image"><img src="{{ data.value['background-image'] }}" alt="" /></div>
						<# } else { #>
							<div class="placeholder"><?php esc_attr_e( 'No File Selected', 'analytica' ); ?></div>
						<# } #>
						<div class="actions">
							<button class="button background-image-upload-remove-button<# if ( ! data.value['background-image'] ) { #> hidden <# } #>"><?php esc_attr_e( 'Remove', 'analytica' ); ?></button>
							<button type="button" class="button background-image-upload-button"><?php esc_attr_e( 'Select File', 'analytica' ); ?></button>
							<# if ( data.value['background-image'] ) { #>
								<a href="#" class="more-settings" data-direction="up"><span class="message"><?php _e( 'Less Settings', 'analytica' ); ?></span> <span class="icon">↑</span></a>
							<# } else { #>
								<a href="#" class="more-settings" data-direction="down"><span class="message"><?php _e( 'More Settings', 'analytica' ); ?></span> <span class="icon">↓</span></a>
							<# } #>
						</div>
					</div>
				</div>

				<!-- background-repeat -->
				<div class="background-repeat">
					<select {{{ data.inputAttrs }}}>
						<option value="no-repeat"<# if ( 'no-repeat' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_attr_e( 'No Repeat', 'analytica' ); ?></option>
						<option value="repeat"<# if ( 'repeat' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_attr_e( 'Repeat All', 'analytica' ); ?></option>
						<option value="repeat-x"<# if ( 'repeat-x' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_attr_e( 'Repeat Horizontally', 'analytica' ); ?></option>
						<option value="repeat-y"<# if ( 'repeat-y' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_attr_e( 'Repeat Vertically', 'analytica' ); ?></option>
					</select>
				</div>

				<!-- background-position -->
				<div class="background-position">
					<select {{{ data.inputAttrs }}}>
						<option value="left top"<# if ( 'left top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Left Top', 'analytica' ); ?></option>
						<option value="left center"<# if ( 'left center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Left Center', 'analytica' ); ?></option>
						<option value="left bottom"<# if ( 'left bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Left Bottom', 'analytica' ); ?></option>
						<option value="right top"<# if ( 'right top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Right Top', 'analytica' ); ?></option>
						<option value="right center"<# if ( 'right center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Right Center', 'analytica' ); ?></option>
						<option value="right bottom"<# if ( 'right bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Right Bottom', 'analytica' ); ?></option>
						<option value="center top"<# if ( 'center top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Center Top', 'analytica' ); ?></option>
						<option value="center center"<# if ( 'center center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Center Center', 'analytica' ); ?></option>
						<option value="center bottom"<# if ( 'center bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Center Bottom', 'analytica' ); ?></option>
					</select>
				</div>

				<!-- background-size -->
				<div class="background-size">
					<h4><?php esc_attr_e( 'Background Size', 'analytica' ); ?></h4>
					<div class="buttonset">
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="cover" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}cover" <# if ( 'cover' === data.value['background-size'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'cover' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}cover"><?php esc_attr_e( 'Cover', 'analytica' ); ?></label>
						</input>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="contain" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}contain" <# if ( 'contain' === data.value['background-size'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'contain' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}contain"><?php esc_attr_e( 'Contain', 'analytica' ); ?></label>
						</input>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="auto" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}auto" <# if ( 'auto' === data.value['background-size'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'auto' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}auto"><?php esc_attr_e( 'Auto', 'analytica' ); ?></label>
						</input>
					</div>
				</div>

				<!-- background-attachment -->
				<div class="background-attachment">
					<h4><?php esc_attr_e( 'Background Attachment', 'analytica' ); ?></h4>
					<div class="buttonset">
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="inherit" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}inherit" <# if ( 'inherit' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'inherit' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}inherit"><?php esc_attr_e( 'Inherit', 'analytica' ); ?></label>
						</input>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="scroll" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}scroll" <# if ( 'scroll' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'scroll' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}scroll"><?php esc_attr_e( 'Scroll', 'analytica' ); ?></label>
						</input>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="fixed" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}fixed" <# if ( 'fixed' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'fixed' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}fixed"><?php esc_attr_e( 'Fixed', 'analytica' ); ?></label>
						</input>
					</div>
				</div>
				<input class="background-hidden-value" type="hidden" {{{ data.link }}}>
			<?php
		}

		/**
		 * Render the control's content.
		 *
		 * @see WP_Customize_Control::render_content()
		 */
		protected function render_content() {}
	}
endif;

<?php
/**
 * Analytica Theme Customizer
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

/**
 * Customizer Loader
 */
if ( ! class_exists( 'Analytica_Customizer' ) ) {

	/**
	 * Customizer Loader
	 *
	 * @since 1.0.0
	 */
	class Analytica_Customizer {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {

			/**
			 * Customizer
			 */
			add_action( 'customize_preview_init', array( $this, 'preview_init' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'controls_scripts' ) );
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_footer_scripts' ) );
			add_action( 'customize_register', array( $this, 'customize_register_panel' ), 2 );
			add_action( 'customize_register', array( $this, 'customize_register' ) );
			add_action( 'customize_save_after', array( $this, 'customize_save' ) );
		}

		/**
		 * Print Footer Scripts
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function print_footer_scripts() {
			$output      = '<script type="text/javascript">';
				$output .= '
	        	wp.customize.bind(\'ready\', function() {
	            	wp.customize.control.each(function(ctrl, i) {
	                	var desc = ctrl.container.find(".customize-control-description");
	                	if( desc.length) {
	                    	var title 		= ctrl.container.find(".customize-control-title");
	                    	var li_wrapper 	= desc.closest("li");
	                    	var tooltip = desc.text().replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
	                    			return \'&#\'+i.charCodeAt(0)+\';\';
								});
	                    	desc.remove();
	                    	li_wrapper.append(" <i class=\'ast-control-tooltip dashicons dashicons-editor-help\'title=\'" + tooltip +"\'></i>");
	                	}
	            	});
	        	});';

				$output .= Analytica_Fonts_Data::js();
			$output     .= '</script>';

			echo $output;
		}

		/**
		 * Register custom section and panel.
		 *
		 * @since 1.0.0
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		function customize_register_panel( $wp_customize ) {

			/**
			 * Register Extended Panel
			 */
			$wp_customize->register_panel_type( 'Analytica_WP_Customize_Panel' );
			$wp_customize->register_section_type( 'Analytica_WP_Customize_Section' );

			require ANALYTICA_THEME_DIR . 'includes/customizer/extend-customizer/class-analytica-wp-customize-panel.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/extend-customizer/class-analytica-wp-customize-section.php';

			/**
			 * Register controls
			 */
			$wp_customize->register_control_type( 'Analytica_Control_Sortable' );
			$wp_customize->register_control_type( 'Analytica_Control_Radio_Image' );
			$wp_customize->register_control_type( 'Analytica_Control_Slider' );
			$wp_customize->register_control_type( 'Analytica_Control_Responsive_Slider' );
			$wp_customize->register_control_type( 'Analytica_Control_Responsive' );
			$wp_customize->register_control_type( 'Analytica_Control_Spacing' );
			$wp_customize->register_control_type( 'Analytica_Control_Responsive_Spacing' );
			$wp_customize->register_control_type( 'Analytica_Control_Divider' );
			$wp_customize->register_control_type( 'Analytica_Control_Color' );
			$wp_customize->register_control_type( 'Analytica_Control_Description' );
			$wp_customize->register_control_type( 'Analytica_Control_Background' );

			/**
			 * Helper files
			 */
			require ANALYTICA_THEME_DIR . 'includes/customizer/customizer-controls.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/class-analytica-customizer-partials.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/class-analytica-customizer-callback.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/class-analytica-customizer-sanitizes.php';
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer.
		 *
		 * @since 1.0.0
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		function customize_register( $wp_customize ) {

			/**
			 * Analytica Pro Upsell Link
			 */
			if ( ! defined( 'ANALYTICA_EXT_VER' ) ) {
				require ANALYTICA_THEME_DIR . 'includes/customizer/analytica-pro/class-analytica-pro-customizer.php';
				require ANALYTICA_THEME_DIR . 'includes/customizer/analytica-pro/analytica-pro-section-register.php';
			}

			/**
			 * Override Defaults
			 */
			require ANALYTICA_THEME_DIR . 'includes/customizer/override-defaults.php';

			/**
			 * Register Sections & Panels
			 */
			require ANALYTICA_THEME_DIR . 'includes/customizer/register-panels-and-sections.php';

			/**
			 * Sections
			 */
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/site-identity/site-identity.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/layout/site-layout.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/layout/container.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/layout/header.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/layout/footer.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/layout/blog.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/layout/blog-single.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/layout/sidebar.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/layout/advanced-footer.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/colors-background/body.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/colors-background/footer.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/colors-background/advanced-footer.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/typography/header.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/typography/body.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/typography/content.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/typography/single.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/typography/archive.php';
			require ANALYTICA_THEME_DIR . 'includes/customizer/sections/buttons/buttons.php';

		}

		/**
		 * Customizer Controls
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function controls_scripts() {

			$js_prefix  = '.min.js';
			$css_prefix = '.min.css';
			$dir        = 'minified';
			if ( SCRIPT_DEBUG ) {
				$js_prefix  = '.js';
				$css_prefix = '.css';
				$dir        = 'unminified';
			}

			if ( is_rtl() ) {
				$css_prefix = '-rtl.min.css';
				if ( SCRIPT_DEBUG ) {
					$css_prefix = '-rtl.css';
				}
			}

			// Customizer Core.
			wp_enqueue_script( 'analytica-customizer-controls-toggle-js', ANALYTICA_THEME_URI . 'assets/js/' . $dir . '/customizer-controls-toggle' . $js_prefix, array(), ANALYTICA_THEME_VERSION, true );

			// Extended Customizer Assets - Panel extended.
			wp_enqueue_style( 'analytica-extend-customizer-css', ANALYTICA_THEME_URI . 'assets/css/' . $dir . '/extend-customizer' . $css_prefix, null, ANALYTICA_THEME_VERSION );
			wp_enqueue_script( 'analytica-extend-customizer-js', ANALYTICA_THEME_URI . 'assets/js/' . $dir . '/extend-customizer' . $js_prefix, array(), ANALYTICA_THEME_VERSION, true );

			// Customizer Controls.
			wp_enqueue_style( 'analytica-customizer-controls-css', ANALYTICA_THEME_URI . 'assets/css/' . $dir . '/customizer-controls' . $css_prefix, null, ANALYTICA_THEME_VERSION );
			wp_enqueue_script( 'analytica-customizer-controls-js', ANALYTICA_THEME_URI . 'assets/js/' . $dir . '/customizer-controls' . $js_prefix, array( 'analytica-customizer-controls-toggle-js' ), ANALYTICA_THEME_VERSION, true );

			wp_localize_script(
				'analytica-customizer-controls-toggle-js', 'analytica', apply_filters(
					'analytica_theme_customizer_js_localize', array(
						'customizer' => array(
							'settings' => array(
								'sidebars'  => array(
									'single'  => array(
										'single-post-sidebar-layout',
										'single-page-sidebar-layout',
									),
									'archive' => array(
										'archive-post-sidebar-layout',
									),
								),
								'container' => array(
									'single'  => array(
										'single-post-content-layout',
										'single-page-content-layout',
									),
									'archive' => array(
										'archive-post-content-layout',
									),
								),
							),
						),
						'theme'      => array(
							'option' => ANALYTICA_THEME_SETTINGS,
						),
					)
				)
			);

		}

		/**
		 * Customizer Preview Init
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function preview_init() {

			// Update variables.
			Analytica_Theme_Options::refresh();

			$js_prefix  = '.min.js';
			$css_prefix = '.min.css';
			$dir        = 'minified';
			if ( SCRIPT_DEBUG ) {
				$js_prefix  = '.js';
				$css_prefix = '.css';
				$dir        = 'unminified';
			}

			wp_enqueue_script( 'analytica-customizer-preview-js', ANALYTICA_THEME_URI . 'assets/js/' . $dir . '/customizer-preview' . $js_prefix, array( 'customize-preview' ), null, ANALYTICA_THEME_VERSION );
		}

		/**
		 * Called by the customize_save_after action to refresh
		 * the cached CSS when Customizer settings are saved.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function customize_save() {

			// Update variables.
			Analytica_Theme_Options::refresh();

			/* Generate Header Logo */
			$custom_logo_id = get_theme_mod( 'custom_logo' );

			add_filter( 'intermediate_image_sizes_advanced', 'Analytica_Customizer::logo_image_sizes', 10, 2 );
			Analytica_Customizer::generate_logo_by_width( $custom_logo_id );
			remove_filter( 'intermediate_image_sizes_advanced', 'Analytica_Customizer::logo_image_sizes', 10 );

			do_action( 'analytica_customizer_save' );
		}

		/**
		 * Add logo image sizes in filter.
		 *
		 * @since 1.0.0
		 * @param array $sizes Sizes.
		 * @param array $metadata attachment data.
		 *
		 * @return array
		 */
		static public function logo_image_sizes( $sizes, $metadata ) {

			$logo_width = analytica_get_option( 'ast-header-responsive-logo-width' );

			if ( is_array( $sizes ) && ( '' != $logo_width['desktop'] || '' != $logo_width['tablet'] | '' != $logo_width['mobile'] ) ) {
				$max_value              = max( $logo_width );
				$sizes['ast-logo-size'] = array(
					'width'  => (int) $max_value,
					'height' => 0,
					'crop'   => false,
				);
			}

			return $sizes;
		}

		/**
		 * Generate logo image by its width.
		 *
		 * @since 1.0.0
		 * @param int $custom_logo_id Logo id.
		 */
		static public function generate_logo_by_width( $custom_logo_id ) {
			if ( $custom_logo_id ) {

				$image = get_post( $custom_logo_id );

				if ( $image ) {
					$fullsizepath = get_attached_file( $image->ID );

					if ( false !== $fullsizepath || file_exists( $fullsizepath ) ) {

						$metadata = wp_generate_attachment_metadata( $image->ID, $fullsizepath );

						if ( ! is_wp_error( $metadata ) && ! empty( $metadata ) ) {
							wp_update_attachment_metadata( $image->ID, $metadata );
						}
					}
				}
			}
		}
	}
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Analytica_Customizer::get_instance();

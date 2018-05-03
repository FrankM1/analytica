<?php
/**
 * Loader Functions
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Enqueue Scripts
 */
if ( ! class_exists( 'Analytica_Enqueue_Scripts' ) ) {

	/**
	 * Theme Enqueue Scripts
	 */
	class Analytica_Enqueue_Scripts {

		/**
		 * Class styles.
		 *
		 * @access public
		 * @var $styles Enqueued styles.
		 */
		public static $styles;

		/**
		 * Class scripts.
		 *
		 * @access public
		 * @var $scripts Enqueued scripts.
		 */
		public static $scripts;

		/**
		 * Constructor
		 */
		public function __construct() {

			add_action( 'analytica_get_fonts', array( $this, 'add_fonts' ), 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );

		}

		/**
		 * List of all assets.
		 *
		 * @return array assets array.
		 */
		public static function theme_assets() {

			$default_assets = array(

				// handle => location ( in /assets/js/ ) ( without .js ext).
				'js'  => array(
					'analytica-theme-js' => 'style',
				),

				// handle => location ( in /assets/css/ ) ( without .css ext).
				'css' => array(
					'analytica-theme-css' => 'style',
				),
			);

			return apply_filters( 'analytica_theme_assets', $default_assets );
		}

		/**
		 * Add Fonts
		 */
		public function add_fonts() {

			$font_family = analytica_get_option( 'body-font-family' );
			$font_weight = analytica_get_option( 'body-font-weight' );

			Analytica_Fonts::add_font( $font_family, $font_weight );

			// Render headings font.
			$font_family = analytica_get_option( 'headings-font-family' );
			$font_weight = analytica_get_option( 'headings-font-weight' );

			Analytica_Fonts::add_font( $font_family, $font_weight );
		}

		/**
		 * Enqueue Scripts
		 */
		public function enqueue_scripts() {

			$analytica_enqueue = apply_filters( 'analytica_enqueue_theme_assets', true );

			if ( ! $analytica_enqueue ) {
				return;
			}

			/* Directory and Extension */
			$file_prefix = ( SCRIPT_DEBUG ) ? '' : '.min';
			$dir_name    = ( SCRIPT_DEBUG ) ? 'unminified' : 'minified';

			$js_uri  = ANALYTICA_THEME_URI . 'assets/js/' . $dir_name . '/';
			$css_uri = ANALYTICA_THEME_URI . 'assets/css/' . $dir_name . '/';

			// All assets.
			$all_assets = self::theme_assets();
			$styles     = $all_assets['css'];
			$scripts    = $all_assets['js'];

			if ( is_array( $styles ) && ! empty( $styles ) ) {
				// Register & Enqueue Styles.
				foreach ( $styles as $key => $style ) {

					// Generate CSS URL.
					$css_file = $css_uri . $style . $file_prefix . '.css';

					// Register.
					wp_register_style( $key, $css_file, array(), ANALYTICA_THEME_VERSION, 'all' );

					// Enqueue.
					wp_enqueue_style( $key );

					// RTL support.
					wp_style_add_data( $key, 'rtl', 'replace' );
				}
			}

			if ( is_array( $scripts ) && ! empty( $scripts ) ) {
				// Register & Enqueue Scripts.
				foreach ( $scripts as $key => $script ) {

					// Register.
					wp_register_script( $key, $js_uri . $script . $file_prefix . '.js', array(), ANALYTICA_THEME_VERSION, true );

					// Enqueue.
					wp_enqueue_script( $key );
				}
			}

			// Fonts - Render Fonts.
			Analytica_Fonts::render_fonts();

			/**
			 * Inline styles
			 */
			wp_add_inline_style( 'analytica-theme-css', Analytica_Dynamic_CSS::return_output() );
			wp_add_inline_style( 'analytica-theme-css', Analytica_Dynamic_CSS::return_meta_output( true ) );

			$analytica_localize = array(
				'break_point' => analytica_header_break_point(),    // Header Break Point.
			);

			wp_localize_script( 'analytica-theme-js', 'analytica', apply_filters( 'analytica_theme_js_localize', $analytica_localize ) );

			// Comment assets.
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

		}

		/**
		 * Trim CSS
		 *
		 * @since 1.0.0
		 * @param string $css CSS content to trim.
		 * @return string
		 */
		static public function trim_css( $css = '' ) {

			// Trim white space for faster page loading.
			if ( ! empty( $css ) ) {
				$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
				$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
				$css = str_replace( ', ', ',', $css );
			}

			return $css;
		}

	}

	new Analytica_Enqueue_Scripts();
}

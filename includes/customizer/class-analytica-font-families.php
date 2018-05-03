<?php
/**
 * Helper class for font settings.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.19
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Font info class for System and Google fonts.
 */
if ( ! class_exists( 'Analytica_Font_Families' ) ) :

	/**
	 * Font info class for System and Google fonts.
	 */
	final class Analytica_Font_Families {

		/**
		 * System Fonts
		 *
		 * @since 1.0.19
		 * @var array
		 */
		public static $system_fonts = array();

		/**
		 * Google Fonts
		 *
		 * @since 1.0.19
		 * @var array
		 */
		public static $google_fonts = array();

		/**
		 * Get System Fonts
		 *
		 * @since 1.0.19
		 *
		 * @return Array All the system fonts in Analytica
		 */
		public static function get_system_fonts() {
			if ( empty( self::$system_fonts ) ) {
				self::$system_fonts = array(
					'Helvetica' => array(
						'fallback' => 'Verdana, Arial, sans-serif',
						'weights'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Verdana'   => array(
						'fallback' => 'Helvetica, Arial, sans-serif',
						'weights'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Arial'     => array(
						'fallback' => 'Helvetica, Verdana, sans-serif',
						'weights'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Times'     => array(
						'fallback' => 'Georgia, serif',
						'weights'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Georgia'   => array(
						'fallback' => 'Times, serif',
						'weights'  => array(
							'300',
							'400',
							'700',
						),
					),
					'Courier'   => array(
						'fallback' => 'monospace',
						'weights'  => array(
							'300',
							'400',
							'700',
						),
					),
				);
			}

			return apply_filters( 'analytica_system_fonts', self::$system_fonts );
		}

		/**
		 * Custom Fonts
		 *
		 * @since 1.0.19
		 *
		 * @return Array All the custom fonts in Analytica
		 */
		public static function get_custom_fonts() {
			$custom_fonts = array();

			return apply_filters( 'analytica_custom_fonts', $custom_fonts );
		}

		/**
		 * Google Fonts used in analytica.
		 * Array is generated from the google-fonts.json file.
		 *
		 * @since  1.0.19
		 *
		 * @return Array Array of Google Fonts.
		 */
		public static function get_google_fonts() {

			if ( empty( self::$google_fonts ) ) {

				$google_fonts_file = apply_filters( 'analytica_google_fonts_json_file', ANALYTICA_THEME_DIR . 'assets/fonts/google-fonts.json' );

				if ( ! file_exists( ANALYTICA_THEME_DIR . 'assets/fonts/google-fonts.json' ) ) {
					return array();
				}

				global $wp_filesystem;
				if ( empty( $wp_filesystem ) ) {
					require_once( ABSPATH . '/wp-admin/includes/file.php' );
					WP_Filesystem();
				}

				$file_contants     = $wp_filesystem->get_contents( $google_fonts_file );
				$google_fonts_json = json_decode( $file_contants, 1 );

				foreach ( $google_fonts_json as $key => $font ) {
					$name = key( $font );
					foreach ( $font[ $name ] as $font_key => $single_font ) {

						if ( 'variants' === $font_key ) {

							foreach ( $single_font as $variant_key => $variant ) {
								if ( stristr( $variant, 'italic' ) ) {
									unset( $font[ $name ][ $font_key ][ $variant_key ] );
								}

								if ( 'regular' == $variant ) {
									$font[ $name ][ $font_key ][ $variant_key ] = '400';
								}
							}
						}

						self::$google_fonts[ $name ] = array_values( $font[ $name ] );
					}
				}
			}

			return apply_filters( 'analytica_google_fonts', self::$google_fonts );
		}

	}

endif;

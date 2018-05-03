<?php
/**
 * Customizer Partial.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

// No direct access, please.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Partials
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'Analytica_Customizer_Partials' ) ) {

	/**
	 * Customizer Partials initial setup
	 */
	class Analytica_Customizer_Partials {

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
		public function __construct() { }

		/**
		 * Render Partial Blog Name
		 */
		function _render_partial_blogname() {
			bloginfo( 'name' );
		}

		/**
		 * Render Partial Blog Description
		 */
		function _render_partial_blogdescription() {
			bloginfo( 'description' );
		}

		/**
		 * Render Partial Site Tagline
		 */
		static function _render_partial_site_tagline() {

			$site_tagline = analytica_get_option( 'display-site-tagline' );

			if ( true == $site_tagline ) {
				return get_bloginfo( 'description', 'display' );
			}
		}

		/**
		 * Render Partial Site Tagline
		 */
		static function _render_partial_site_title() {

			$site_title = analytica_get_option( 'display-site-title' );

			if ( true == $site_title ) {
				return get_bloginfo( 'name', 'display' );
			}
		}

		/**
		 * Render Partial Header Right Section HTML
		 */
		static function _render_header_main_rt_section_html() {

			$right_section_html = analytica_get_option( 'header-main-rt-section-html' );

			return do_shortcode( $right_section_html );
		}

		/**
		 * Render Partial Footer Section 1 Credit
		 */
		static function _render_footer_sml_section_1_credit() {

			$output = analytica_get_small_footer_custom_text( 'footer-sml-section-1-credit' );
			return do_shortcode( $output );
		}

		/**
		 * Render Partial Footer Section 2 Credit
		 */
		static function _render_footer_sml_section_2_credit() {

			$output = analytica_get_small_footer_custom_text( 'footer-sml-section-2-credit' );
			return do_shortcode( $output );
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Analytica_Customizer_Partials::get_instance();

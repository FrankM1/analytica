<?php
/**
 * Gravity Forms File.
 *
 * @package Analytica
 */

// If plugin - 'Gravity Forms' not exist then return.
if ( ! class_exists( 'GFForms' ) ) {
	return;
}

/**
 * Analytica Gravity Forms
 */
if ( ! class_exists( 'Analytica_Gravity_Forms' ) ) :

	/**
	 * Analytica Gravity Forms
	 *
	 * @since 1.0.0
	 */
	class Analytica_Gravity_Forms {

		/**
		 * Member Variable
		 *
		 * @var object instance
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
			add_filter( 'analytica_theme_assets', array( $this, 'add_styles' ) );
		}

		/**
		 * Add assets in theme
		 *
		 * @param array $assets list of theme assets (JS & CSS).
		 * @return array List of updated assets.
		 * @since 1.0.0
		 */
		function add_styles( $assets ) {
			$assets['css']['analytica-gravity-forms'] = 'compatibility/gravity-forms';
			return $assets;
		}

	}

endif;

/**
 * Kicking this off by calling 'get_instance()' method
 */
Analytica_Gravity_Forms::get_instance();

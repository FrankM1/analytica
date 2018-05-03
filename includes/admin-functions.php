<?php
/**
 * Admin functions - Functions that add some functionality to WordPress admin panel
 *
 * @package Analytica
 * @since 1.0.0
 */

/**
 * Register menus
 */
if ( ! function_exists( 'analytica_register_menu_locations' ) ) {

	/**
	 * Register menus
	 *
	 * @since 1.0.0
	 */
	function analytica_register_menu_locations() {

		/**
		 * Menus
		 */
		register_nav_menus(
			array(
				'primary'     => __( 'Primary Menu', 'analytica' ),
				'footer_menu' => __( 'Footer Menu', 'analytica' ),
			)
		);
	}
}

add_action( 'init', 'analytica_register_menu_locations' );

<?php

namespace Analytica\Extensions\Qazana;

/**
 * This file is a part of the Analytica core.
 * Please be cautious editing this file,
 *
 * @package  Analytica\Extensions\Page_Builder
 * @subpackage  Analytica
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

/**
 * Header Builder Compatibility
 *
 * @since 1.0.0
 */
class Footers {

	/**
	 * Default actions
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'integrate'], 15 );
	}

	function integrate() {

		if ( ! $this->is_builder_activated() ) {
			return;
		}

		add_filter( 'qazana/footers/get_injection_hook', function () {
			return 'analytica_footer';
		});

		add_filter( 'analytica_site_footer_is_active', '__return_false' );
		add_filter( 'analytica_site_colophon_is_active', '__return_false' );
	}

	/**
	 * Detect if layout qazana is active
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	function is_builder_activated( $retval = false ) {
		if ( analytica_detect_plugin( array( 'classes' => array( 'Qazana\Extensions\Site_Footer' ) ) ) ) {
			return true;
		}
		return $retval;
	}

}

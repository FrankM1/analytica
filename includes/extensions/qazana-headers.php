<?php

namespace Analytica\Extensions;

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
class Qazana_Headers {

	/**
	 * Default actions
	 */
	public function __construct() {

		if ( ! $this->is_builder_activated() ) {
			return;
		}

		add_filter( 'analytica_site_header_is_active', function ($args) {
			return false;
        });

		add_filter( 'qazana_headers_get_header_injection_hook', function () {
			return 'analytica_header';
		});
	}

	/**
	 * Detect if layout qazana is active
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	function is_builder_activated( $retval = false ) {
		if ( analytica_detect_plugin( array( 'classes' => array( 'Qazana\Headers\Plugin' ) ) ) ) {
			return true;
		}
		return $retval;
	}

}

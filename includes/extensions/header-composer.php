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
class Header_Composer {

	/**
	 * Default actions
	 */
	public function __construct() {

		if ( ! $this->is_builder_activated()) {
			return;
		}

		add_filter( 'analytica_site_header_is_active', function ($args) {
			return false;
		});

		add_action('header_composer_init', function () {
			global $pagenow;
			if (is_admin()
				&& 'themes.php' == $pagenow
				&& isset($_GET['activated']) ) {
				header_composer()->css_generator->update_css();
			}
		});

		add_filter('header_composer\builder\assets\localize_data', function ($args) {
			$args['site_logo'] = get_custom_logo();
			return $args;
		});

		add_filter( 'pre_option_header_composer_header_injection_hook', function () {
			return 'analytica_header';
		});

		add_filter('pre_option_header_composer_site_wrapper_class', function () {
			return 'site-container';
		});

		add_filter('pre_option_header_composer_style_accent_color', function () {
			return analytica_get_option('accent-color');
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
		if (analytica_detect_plugin(array('classes' => array('Header_Composer\Plugin')))) {
			return true;
		}
		return $retval;
	}

}

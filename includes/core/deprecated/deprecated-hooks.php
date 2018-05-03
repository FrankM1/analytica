<?php
/**
 * Deprecated Hooks of Analytica Theme.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.23
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'analytica_do_action_deprecated' ) ) {
	/**
	 * Analytica Filter Deprecated
	 *
	 * @since 1.1.1
	 * @param string $tag         The name of the filter hook.
	 * @param array  $args        Array of additional function arguments to be passed to apply_filters().
	 * @param string $version     The version of WordPress that deprecated the hook.
	 * @param string $replacement Optional. The hook that should have been used. Default false.
	 * @param string $message     Optional. A message regarding the change. Default null.
	 */
	function analytica_do_action_deprecated( $tag, $args, $version, $replacement = false, $message = null ) {
		if ( function_exists( 'do_action_deprecated' ) ) { /* WP >= 4.6 */
			do_action_deprecated( $tag, $args, $version, $replacement, $message );
		} else {
			do_action_ref_array( $tag, $args );
		}
	}
}

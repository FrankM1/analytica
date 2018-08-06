<?php

/**
 * Analytica core
 *
 * @package Analytica
 * @since 1.0.0
 */

/**
 * Analytica check PHP version.
 *
 * Check when the site doesn't have the minimum required PHP version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function analytica_is_php_version_compatible() {
	if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
		return false;
	}
	return true;
}

/**
 * Analytica admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function analytica_fail_php_version() {
	/* translators: %s: PHP version */
	$message = sprintf( esc_html__( 'Analytica requires PHP version %s+, theme is currently NOT ACTIVE.', 'analytica' ), '5.4' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Analytica admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @since 1.5.0
 *
 * @return void
 */
function analytica_fail_wp_version() {
	/* translators: %s: WordPress version */
	$message = sprintf( esc_html__( 'Analytica requires WordPress version %s+. Because you are using an earlier version, the theme is currently NOT ACTIVE.', 'analytica' ), '4.7' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

if ( ! analytica_is_php_version_compatible() ) {
    add_action( 'admin_notices', 'analytica_fail_php_version' );
    return;
} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ) {
    add_action( 'admin_notices', 'analytica_fail_wp_version' );
    return;
} else {
    require_once get_theme_file_path( '/includes/classes/core.php' );
}

/**
 * The main function responsible for returning the one true analytica Instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Thanks bbpress :)
 *
 * Example: <?php $core = analytica(); ?>
 *
 * @return The one true analytica Instance
 */
function analytica() {
	if ( ! analytica_is_php_version_compatible() ) {
        return;
    }
    return \Analytica\Core::instance();
}
analytica(); // All systems go

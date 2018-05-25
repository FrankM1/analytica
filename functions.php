<?php

/**
 * Analytica functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Analytica
 * @since 1.0.0
 */
require_once get_theme_file_path( '/includes/classes/core.php' );

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
    return \Analytica\Core::instance();
}
analytica(); // All systems go

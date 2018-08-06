<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

add_action( 'after_setup_theme', 'analytica_register_nav_menus' );
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function analytica_register_nav_menus() {
    $menus = get_theme_support( 'analytica-menus' );
    if ( is_array( $menus[0] ) ) {
        foreach ( $menus[0] as $menu => $title ) {
            register_nav_menu( $menu, $title );
        }
    }
}

add_action( 'analytica_do_primary_nav', 'analytica_do_primary_nav' );
/**
 * Echo the "Primary Navigation" menu.
 *
 * Applies the `analytica_primary_nav` and legacy `analytica_do_nav` filters.
 *
 * @since 1.0.0
 *
 * @uses analytica_nav_menu() Display a navigation menu.
 * @uses analytica_nav_menu_supported() Checks for support of specific nav menu.
 */
function analytica_do_primary_nav( $args = array() ) {

    // Do nothing if menu not supported
    if ( ! analytica_nav_menu_supported( 'primary' ) ) {
        return;
    }

     /* Main menu */
    $defaults = array(
        'container'      => 'nav',
        'menu_class'     => 'analytica_mega menu dl-menu menu-v2',
        'fallback_cb'    => 'analytica_fallback_menu',
        'depth'          => 5,
        'theme_location' => 'primary',
        'echo'           => 0,
    );

    echo wp_nav_menu( wp_parse_args( $args, $defaults ) );
}

add_action( 'analytica_do_primary_right_nav', 'analytica_do_primary_right_nav' );
/**
 * Echo the "Primary Navigation" menu.
 *
 * Applies the `analytica_primary_nav` and legacy `analytica_do_nav` filters.
 *
 * @since 1.0.0
 *
 * @uses analytica_nav_menu() Display a navigation menu.
 * @uses analytica_nav_menu_supported() Checks for support of specific nav menu.
 */
function analytica_do_primary_right_nav( $args = array() ) {

    // Do nothing if menu not supported
    if ( ! analytica_nav_menu_supported( 'primary-right' ) ) {
        return;
    }

     /* Main menu */
    $defaults = array(
        'container'      => 'nav',
        'menu_class'     => 'analytica_mega menu dl-menu menu-v2',
        'fallback_cb'    => 'analytica_fallback_menu',
        'depth'          => 5,
        'theme_location' => 'primary-right',
        'echo'           => 0,
    );

    echo wp_nav_menu( wp_parse_args( $args, $defaults ) );
}

add_action( 'analytica_footer_menu', 'analytica_footer_menu' );
/**
 * Echo the "Footer Navigation" menu.
 *
 * Applies the `analytica_primary_nav` and legacy `analytica_do_nav` filters.
 *
 * @since 1.0.0
 *
 * @uses analytica_nav_menu() Display a navigation menu.
 * @uses analytica_nav_menu_supported() Checks for support of specific nav menu.
 */
function analytica_footer_menu() {

    $args = array(
        'theme_location'  => 'footer-menu',
        'container'       => 'nav',
        'container_class' => 'nav nav--toolbar nav-horizontal',
        'fallback_cb'     => false,
        'menu_class'      => 'menu analytica-nav-menu menu-footer',
        'depth'           => 1,
    );

    wp_nav_menu( $args );
}

<?php
/**
 * This file is a part of the analytica Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

add_filter( 'body_class', 'analytica_site_layout_body_class' );
/**
 * Add site layout classes to the body classes.
 *
 * @since 1.0.0
 *
 * @uses analytica_site_layout() Return the site layout for different contexts.
 *
 * @param array $classes Existing classes.
 *
 * @return array Amended classes.
 */
function analytica_site_layout_body_class( $classes ) {

    if ( analytica_get_option( 'site-detach-containers' ) ) {
        if ( analytica_get_option( 'site-dual-containers' ) ) {
            $classes[] = 'site-dual-containers';
        } else {
            $classes[] = 'site-container-detach';
        }
    } else {
        $classes[] = 'site-mono-container';
    }

    // Current Analytica verion.
    $classes[] = esc_attr( 'analytica-' . wp_get_theme()->version );

    $classes[] = esc_attr( analytica_get_option( 'site-layout' ) );

    return $classes;
}

add_filter( 'body_class', 'analytica_layout_body_classes' );
/**
 * Add site layout classes to the body classes.
 *
 * We can use pseudo-variables in our CSS file, which helps us achieve multiple site layouts with minimal code.
 *
 * @since 1.0.0
 *
 * @uses analytica_site_layout() Return the site layout for different contexts.
 *
 * @param array $classes Existing classes.
 *
 * @return array Amended classes.
 */
function analytica_layout_body_classes( array $classes ) {

    $site_layout = analytica_site_layout();

    if ( $site_layout && ! is_404() ) {
        $classes[] = $site_layout;
    }

    return $classes;
}

/**
 * Retrieve the classes for the header element as an array.
 *
 * @since 1.0.0
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function analytica_get_header_class( $class = '' ) {

    $header_align_option = analytica_get_option( 'site-header-menu-layout' );
    $header_background_color_option = analytica_get_option( 'site-header-background-color' );
    $header_full_width_option = analytica_get_option( 'site-header-width' );
    $header_overlay_option = analytica_get_option( 'site-header-overlay' );
    $header_transparent_option = analytica_get_option( 'site-header-transparent' );

    $classes = array();

    // Add the general site header class
    $classes[] = 'site-header';

    // Primary header class
    $classes[] = 'site-header-primary';

    // Handle overlay / not overlay
    if ( true == $header_overlay_option ) {
        $classes[] = 'site-header-overlay';
        $classes[] = 'site-header-sticky';
    }

    // Handle overlay / not overlay
    if ( true == $header_transparent_option ) {
        $classes[] = 'site-header-transparent';
    }

    // Handle invert if background-color light / dark
    $light_or_dark = analytica_light_or_dark( $header_background_color_option, '#000000' /*dark*/, '#FFFFFF' /*light*/ );

    if ( '#FFFFFF' === $light_or_dark && ! empty( $header_background_color_option ) ) {
        $classes[] = 'site-header-invert';
    }

    // Add width class
    if ( 'layout-fullwidth' != $header_full_width_option ) {
        $classes[] = 'has-container';
    } else {
        $classes[] = 'fullwidth';
    }

    // Add alignment classes
    if ( 'header-logo-left' == $header_align_option ) {
        $classes[] = 'site-header-left';
    } elseif ( 'header-logo-right' == $header_align_option ) {
        $classes[] = 'site-header-right';
    } elseif ( 'header-logo-top' == $header_align_option ) {
        $classes[] = 'nav-clear';
    } elseif ( 'header-logo-center-top' == $header_align_option ) {
        $classes[] = 'site-header-center';
    } elseif ( 'header-logo-center' == $header_align_option ) {
        $classes[] = 'site-header-inline';
    } elseif ( 'header-logo-left-narrow' == $header_align_option ) {
        $classes[] = 'site-header-left-narrow';
    } elseif ( 'header-logo-left-2' == $header_align_option ) {
        $classes[] = 'site-header-left-style-2';
    }

    if ( ! empty( $class ) ) {
       if ( ! is_array( $class ) ) {
           $class = preg_split( '#\s+#', $class );
       }
       $classes[] = array_merge( $classes, $class );
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }

    // Default to Header Left if there are no matches above
    if ( empty( $classes ) ) {
       $classes[] = 'site-header-left';
    }

    return apply_filters( 'analytica_header_class', $classes, $class );
}
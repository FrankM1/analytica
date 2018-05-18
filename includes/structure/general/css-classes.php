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
function analytica_site_layout_body_class( $classes ) {

    if ( analytica_is_bool( analytica_get_option( 'site-detach-containers' ) ) ) {
        $classes[] = 'analytica-separate-container';
    } else {
        $classes[] = 'analytica-plain-container';
    }

    // // Apply separate container class to the body.
    // $content_layout = analytica_get_content_layout();
    // if ( 'content-boxed-container' == $content_layout ) {
    //     $classes[] = 'analytica-separate-container';
    // } elseif ( 'boxed-container' == $content_layout ) {
    //     $classes[] = 'analytica-separate-container analytica-two-container';
    // } elseif ( 'page-builder' == $content_layout ) {
    //     $classes[] = 'analytica-page-builder-template';
    // } elseif ( 'plain-container' == $content_layout ) {
    //     $classes[] = 'analytica-plain-container';
    // }

    // Current Analytica verion.
    $classes[] = esc_attr( 'analytica-' . wp_get_theme()->version );

    $header_overlay_option     = analytica_get_option( 'header-overlay' );
    $header_sticky_option      = analytica_get_option( 'header-sticky' );
    $header_transparent_option = analytica_get_option( 'header-transparent' );
    $site_layout               = analytica_get_option( 'site-layout' );

    $classes[] = $site_layout;

    // Handle sticky / not sticky
    if ( ! wp_is_mobile() && $header_sticky_option ) {
        $classes[] = 'analytica-header-sticky';
    }

    // Handle overlay / not overlay
    if ( ! wp_is_mobile() && $header_overlay_option ) {
        $classes[] = 'analytica-header-overlay';
    }

    // Handle transparent / not transparent
    if ( ! wp_is_mobile() && $header_transparent_option ) {
        $classes[] = 'analytica-header-transparent';
    }

    // Page builder class
    if ( analytica_is_builder_page() ) {
        $classes[] = 'analytica-page-builder';
    }

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

    $header_align_option = analytica_get_option( 'header-menu-layout' );
    $header_background_color_option = analytica_get_option( 'header-background-color' );
    $header_full_width_option = analytica_get_option( 'header-width' );
    $header_overlay_option = analytica_get_option( 'header-overlay' );
    $header_sticky_option = analytica_get_option( 'header-sticky' );
    $header_transparent_option = analytica_get_option( 'header-transparent' );

    $classes = array();

    // Add the general site header class
    $classes[] = 'site-header';

    // Primary header class
    $classes[] = 'header-primary';

    // Handle sticky / not sticky
    if ( true == $header_sticky_option ) {
        $classes[] = 'header-sticky';
    }

    // Handle overlay / not overlay
    if ( true == $header_overlay_option ) {
        $classes[] = 'header-overlay';
    }

    // Handle overlay / not overlay
    if ( true == $header_transparent_option ) {
        $classes[] = 'header-transparent';
    }

    // Handle invert if background-color light / dark
    $light_or_dark = analytica_light_or_dark( $header_background_color_option, '#000000' /*dark*/, '#FFFFFF' /*light*/ );

    if ( '#FFFFFF' === $light_or_dark && ! empty( $header_background_color_option ) ) {
        $classes[] = 'header-invert';
    }

    // Add width class
    if ( 'layout-fullwidth' != $header_full_width_option ) {
        $classes[] = 'has-container';
    } else {
        $classes[] = 'full-width';
    }

    // Add alignment classes
    if ( 'header-logo-left' == $header_align_option ) {
        $classes[] = 'header-left';
    } elseif ( 'header-logo-right' == $header_align_option ) {
        $classes[] = 'header-right';
    } elseif ( 'header-logo-top' == $header_align_option ) {
        $classes[] = 'nav-clear';
    } elseif ( 'header-logo-center-top' == $header_align_option ) {
        $classes[] = 'header-center';
    } elseif ( 'header-logo-center' == $header_align_option ) {
        $classes[] = 'header-inline';
    } elseif ( 'header-logo-left-narrow' == $header_align_option ) {
        $classes[] = 'header-left-narrow';
    } elseif ( 'header-logo-left-2' == $header_align_option ) {
        $classes[] = 'header-left-style-2';
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
       $classes[] = 'header-left';
    }

    $classes = apply_filters( 'analytica_header_class', $classes, $class );

    return $classes;

}
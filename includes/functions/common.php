<?php
/**
 * Functions for Analytica Theme.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Custom callback for custom backgrounds
 *
 * @since 1.0.0
 */
function analytica_custom_background_callback() {
    // $background is the saved custom image, or the default image.
    $background = set_url_scheme( get_background_image() );

    // $color is the saved custom color.
    // A default has to be specified in style.css. It will not be printed here.
    $color = get_background_color();

    if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
        $color = false;
    }

    if ( ! $background && ! $color ) {
        if ( is_customize_preview() ) {
            echo '<style type="text/css" id="custom-background-css"></style>';
        }
        return;
    }

    return; // The background will be compile into the theme's global css file
}

/**
 * Detect if we should use a light or dark colour on a background colour.
 *
 * @param mixed  $color
 * @param string $dark  (default: '#000000')
 * @param string $light (default: '#FFFFFF')
 *
 * @return string
 */
function analytica_light_or_dark( $color, $dark = '#000000', $light = '#FFFFFF' ) {
    $hex = str_replace( '#', '', $color );

    $c_r = hexdec( substr( $hex, 0, 2 ) );
    $c_g = hexdec( substr( $hex, 2, 2 ) );
    $c_b = hexdec( substr( $hex, 4, 2 ) );

    $brightness = (($c_r * 299) + ($c_g * 587) + ($c_b * 114) ) / 1000;

    return $brightness > 155 ? $dark : $light;
}

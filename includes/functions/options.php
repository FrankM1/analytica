<?php
/**
 * Sidebar Manager functions
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

 /**
 * Default color picker palettes
 *
 * @since 1.4.9
 */

function analytica_default_color_palettes() {

    $font_base            = analytica_get_option( 'font-base' );
    $font_secondary       = analytica_get_option( 'font-secondary-base' );
    $accent_color         = analytica_get_option( 'site-accent-color' );
    $link_color           = analytica_get_option( 'site-link-color' );
    $link_highlight_color = analytica_get_option( 'site-link-highlight-color' );
    $text_color           = analytica_get_option( 'site-text-color' );

    $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
    $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

    $palettes = [
        $font_secondary_color, // Title colors
        $font_base_color, // Default color
        $accent_color,  // Accents color, buttons etc
        $text_color,
        $link_color,
        $link_highlight_color,
        '#000000',
        '#ffffff',
    ];

    // Apply filters and return
    return apply_filters( __FUNCTION__, $palettes );
}
    
/**
 * Return option from the options table and cache result.
 *
 * Applies 'analytica_pre_get_option_$key' and 'analytica_options' filters.
 *
 * Values pulled from the database are cached on each request, so a second request for the same value won't cause a
 * second DB interaction.
 *
 * @since 1.0.0
 *
 * @param string  $primary        Option name.
 *
 * @return mixed The value of this $key in the database.
 */
function analytica_get_option( $option_id, $default_value = null, $post_id = null, $post_meta = true, $prefix = '_analytica_' ) {

    $value = null;
    
    // Use analytica_get_post_id() if no $post_id is specified
    $post_id = ( null !== $post_id ? $post_id : analytica_get_post_id() );

    if ( $post_id && $post_meta ) {
        $value = analytica_get_custom_field( $prefix . $option_id, $post_id );
    }
    
    if ( ! $value ) {
        $value = \Analytica\Options::get_option( $option_id, $default_value );
    }

    return apply_filters( __FUNCTION__, $value, $option_id, $default_value, $post_id ); // make meta fields filterable
}

/**
 * Echo options from the options database.
 *
 * @since 1.0.0
 *
 * @uses analytica_get_option() Return option from the options table and cache result.
 *
 * @param string $key Option name.
 */
function analytica_option( $primary, $default_value = false ) {
    echo wp_kses( analytica_get_option( $primary, $default_value ), analytica_get_allowed_tags() ); 
}

/**
 * Echo data from a post or page custom field.
 *
 * Echo only the first value of custom field.
 *
 * Pass in a `printf()` pattern as the second parameter and have that wrap around the value, if the value is not falsy.
 *
 * @since 1.0.0
 *
 * @uses analytica_get_custom_field() Return custom field post meta data.
 *
 * @param string $field         Custom field key.
 * @param string $output_pattern printf() compatible output pattern.
 */
function analytica_custom_field( $field, $output_pattern = '%s', $post_id = null ) {
    if ( $value = analytica_get_custom_field( $field, $post_id ) ) {
        /* Translators: %s: field value */
       echo wp_kses( sprintf( $output_pattern, $value ), analytica_get_allowed_tags() ); 
    }
}

/**
 * Return custom field post meta data.
 *
 * Return only the first value of custom field. Return empty string if field is blank or not set.
 *
 * @since 1.0.0
 *
 * @param string $field   Custom field key.
 * @param int    $post_id Optional. Post ID to use for Post Meta lookup, defaults to analytica_get_post_id()
 *
 * @return string|bool Return value or empty string on failure.
 */
function analytica_get_custom_field( $field, $post_id = null ) {

    // Use analytica_get_post_id() if no $post_id is specified
    $post_id = ( null !== $post_id ? $post_id : analytica_get_post_id() );

    if ( null === $post_id ) {
        return '';
   }

    $value = get_post_meta( $post_id, $field, true );

    if ( ! $value ) {
        return '';
    }

    // Return custom field, slashes stripped, sanitized if string
    $value = is_array( $value ) ? stripslashes_deep( $value ) : stripslashes( wp_kses_decode_entities( $value ) );

    return apply_filters( __FUNCTION__, $value, $field, $post_id ); // make meta fields filterable
}

/**
 * Get post ID.
 *
 * @param  string $post_id_override Get override post ID.
 * @return number                   Post ID.
 */
function analytica_get_post_id( $post_id_override = '' ) {

    if ( null == \Analytica\Options::$post_id ) {
        global $post;

        $post_id = 0;

        if ( is_home() ) {
            $post_id = get_option( 'page_for_posts' );
        } elseif ( is_archive() ) {
            global $wp_query;
            $post_id = $wp_query->get_queried_object_id();
        } elseif ( isset( $post->ID ) && ! is_search() && ! is_category() ) {
            $post_id = $post->ID;
        }

        \Analytica\Options::$post_id = $post_id;
    }

    return apply_filters( __FUNCTION__, \Analytica\Options::$post_id, $post_id_override );
}
 
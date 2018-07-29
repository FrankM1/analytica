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

 /**
 * Register new layouts in the theme.
 *
 * Modifies the global `$_analytica_layouts` variable.
 *
 * The support `$args` keys are:
 *
 *  - label (Internationalized name of the layout),
 *  - img   (URL path to layout image),
 *  - type  (Layout type).
 *
 * Although the 'default' key is also supported, the correct way to change the default is via the
 * `analytica_set_default_layout()` function to ensure only one layout is set as the default at one time.
 *
 * @since 1.0.0
 * @see analytica_set_default_layout() Set a default layout.
 *
 * @uses  analytica() to determine URL path to admin images.
 *
 * @global array $_analytica_layouts Holds all layouts data.
 *
 * @param string $id   ID of layout.
 * @param array  $args Layout data.
 *
 * @return bool|array Return false if ID is missing or is already set. Return merged $args otherwise.
 */
function analytica_register_layout( $id = '', $args = [] ) {
    global $_analytica_layouts;

    if ( ! is_array( $_analytica_layouts ) ) {
        $_analytica_layouts = [];
    }

    // Don't allow empty $id, or double registrations
    if ( ! $id || isset( $_analytica_layouts[ $id ] ) ) {
        return false;
    }

    $defaults = [
        'label' => esc_html__( 'No Label Selected', 'analytica' ),
        'img' => analytica()->theme_url . '/assets/admin/images/layouts/none.gif',
        'type' => 'site',
    ];

    $args = wp_parse_args( $args, $defaults );

    $_analytica_layouts[ $id ] = $args;

    return $args;
}

/**
 * Set a default layout.
 *
 * Allow a user to identify a layout as being the default layout on a new install, as well as serve as the fallback layout.
 *
 * @since 1.0.0
 *
 * @global array $_analytica_layouts Holds all layouts data.
 *
 * @param string $id ID of layout to set as default.
 *
 * @return bool|string Return false if ID is empty or layout is not registered. Return ID otherwise.
 */
function analytica_set_default_layout( $id = '' ) {
    global $_analytica_layouts;

    if ( ! is_array( $_analytica_layouts ) ) {
        $_analytica_layouts = [];
    }

    // Don't allow empty $id, or unregistered layouts
    if ( ! $id || ! isset( $_analytica_layouts[ $id ] ) ) {
        return false;
    }

    // Remove default flag for all other layouts
    foreach ( (array) $_analytica_layouts as $key ) {
        if ( isset( $_analytica_layouts[ $key ]['default'] ) ) {
            unset( $_analytica_layouts[ $key ]['default'] );
        }
    }

    $_analytica_layouts[ $id ]['default'] = true;

    return $id;
}

/**
 * Unregister a layout in.
 *
 * Modifies the global $_analytica_layouts variable.
 *
 * @since 1.0.0
 *
 * @global array $_analytica_layouts Holds all layout data.
 *
 * @param string $id ID of the layout to unregister.
 *
 * @return bool Returns false if ID is empty, or layout is not registered.
 */
function analytica_unregister_layout( $id = '' ) {
    global $_analytica_layouts;

    if ( ! $id || ! isset( $_analytica_layouts[ $id ] ) ) {
        return false;
    }

    unset( $_analytica_layouts[ $id ] );

    return true;
}

/**
 * Output markup conditionally.
 *
 * Supported keys for `$args` are:
 *
 *  - `element` (`sprintf()` pattern markup),
 *  - `context` (name of context),
 *  - `echo` (default is true).
 *
 * This function will output the `element` value, with a call to `analytica_attr()`
 * with the same context added in.
 *
 * Applies a `analytica_markup_{context}` filter early to allow shortcutting the function.
 *
 * Applies a `analytica_markup_{context}_output` filter at the end.
 *
 * @since 1.0.0
 *
 * @uses analytica_attr()  Contextual attributes.
 *
 * @param array $args Array of arguments.
 *
 * @return string Markup.
 */
function analytica_markup( $args = [] ) {
    $defaults = [
        'element' => '',
        'context' => '',
        'echo' => true,
    ];

    $args = wp_parse_args( $args, $defaults );

    if ( ! $args['element'] ) {
        return '';
    }

    $tag = $args['context'] ? sprintf( $args['element'], analytica_attr( $args['context'] ) ) : $args['element'];

    // Contextual filter
    $tag = $args['context'] ? apply_filters( "analytica_markup_{$args['context']}_output", $tag, $args ) : $tag;

    if ( $args['echo'] ) {
        echo $tag;  // escaping not needed here. Output is html and escaped elsewhere
    } else {
        return $tag;
    }
}

/**
 * Potentially echo or return a structural wrap div.
 *
 * A check is made to see if the `$context` is in the `analytica-structural-wraps` theme support data. If so, then the
 * `$output` may be echoed or returned.
 *
 * @since 1.0.0
 *
 * @param string $context The location ID.
 * @param string $output  Optional. The markup to include. Can also be 'open'
 *                        (default) or 'closed' to use pre-determined markup for consistency.
 * @param bool   $echo    Optional. Whether to echo or return. Default is true (echo).
 *
 * @return string Wrap HTML.
 */
function analytica_structural_wrap( $context = '', $output = 'open', $echo = true ) {
    $wraps = get_theme_support( 'analytica-structural-wraps' );

    // If theme doesn't support structural wraps, bail.
    if ( ! $wraps ) {
        return;
    }

    if ( ! in_array( $context, (array) $wraps[0] ) ) {
        return '';
    }

    // Save original output param
    $original_output = $output;

    switch ( $output ) {
        case 'open':
            $output = sprintf( '<div %s>', analytica_attr( 'structural-wrap' ) );
            break;
        case 'close':
            $output = '</div>';
            break;
    }

    $output = apply_filters( "analytica_structural_wrap-{$context}", $output, $original_output );

    if ( $echo ) {
        echo analytica_sanitize_html( $output );
    } else {
        return $output;
    }
}

/**
 * Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * The contextual filter is of the form `analytica_attr_{context}`.
 *
 * @since 1.0.0
 *
 * @param string $context    The context, to build filter name.
 * @param array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return array Merged and filtered attributes.
 */
function analytica_parse_attr( $context, $attributes = [] ) {
    $defaults = [
        'class' => sanitize_html_class( $context ),
    ];

    $attributes = wp_parse_args( $attributes, $defaults );

    // Contextual filter
    return apply_filters( "analytica_attr_{$context}", $attributes, $context );
}

/**
 * Build list of attributes into a string and apply contextual filter on string.
 *
 * The contextual filter is of the form `analytica_attr_{context}_output`.
 *
 * @since 1.0.0
 *
 * @uses analytica_parse_attr() Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * @param string $context    The context, to build filter name.
 * @param array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return string String of HTML attributes and values.
 */
function analytica_attr( $context, $attributes = [] ) {
    $attributes = analytica_parse_attr( $context, $attributes );

    $output = '';

    // Cycle through attributes, build tag attribute string
    foreach ( $attributes as $key => $value ) {
        if ( ! $value ) {
            continue;
        }
        $output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
    }

    $output = apply_filters( 'analytica_attr_' . $context . '_output', $output, $attributes, $context );

    return trim( $output );
}

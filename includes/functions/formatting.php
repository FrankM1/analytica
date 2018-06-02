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

add_filter( 'wp_kses_allowed_html', 'analytica_filter_wp_kses_allowed_theme_attributes' );
/**
 * Ensures the HTML data-* attributes for selective refresh are allowed by kses.
 *
 * @since 1.0.0
 *
 * @param array $allowed_html Allowed HTML.
 * @return array (Maybe) modified allowed HTML.
 */
function analytica_filter_wp_kses_allowed_theme_attributes( $allowed_html ) {

    $tags_seen = [
        'body',
        'div',
        'a'
    ];

    foreach ( array_keys( $tags_seen ) as $tag_name ) {
        if ( ! isset( $allowed_html[ $tag_name ] ) ) {
            $allowed_html[ $tag_name ] = array();
        }
        $allowed_html[ $tag_name ] = array_merge(
            $allowed_html[ $tag_name ],
            array_fill_keys( array(
                'itemscope',
                'itemtype',
                'role',
                'itemprop',
                'aria-label',
                'action',
                'datetime',
                'rel',
                'title',
                'data'
            ), true )
        );
    }

    return $allowed_html;
}

/**
 * Set allowed tags in the admin panel. This works by
 * adding the theme's allowed admin tags to WP's
 * global $allowedtags.
 *
 * @since 1.0.0
 * @uses $allowedposttags
 *
 * @return array $analytica_tags Allowed HTML tags for options sanitation
 */
function analytica_get_allowed_tags() {

    global $allowedposttags;
    
	// Match theme tags with global HTML
	// allowed for standard Posts/Pages.
	$analytica_tags = $allowedposttags;

	// And make any adjustments
	$analytica_tags['iframe'] = array(
		'style'                 => true,
		'width'                 => true,
		'height'                => true,
		'src'                   => true,
		'frameborder'           => true,
		'allowfullscreen'       => true,
		'webkitAllowFullScreen' => true,
		'mozallowfullscreen'    => true
    );
    
	$analytica_tags['script'] = array(
		'type' => true,
		'src'  => true
    );
    
    $analytica_tags['input'] = array(
		'class'       => true,
		'name'        => true,
		'type'        => true,
		'maxlength'   => true,
		'minlength'   => true,
		'readonly'    => true,
		'required'    => true,
		'multiple'    => true,
		'pattern'     => true,
		'min'         => true,
		'max'         => true,
		'step'        => true,
		'list'        => true,
		'placeholder' => true,
        'checked'     => true,
        'autocomplete'=> true,
	);

	return apply_filters( __FUNCTION__, $analytica_tags );
}

/**
 * Sanitize multiple HTML classes in one pass.
 *
 * Accepts either an array of `$classes`, or a space separated string of classes and sanitizes them using the
 * `sanitize_html_class()` WordPress function.
 *
 * @since 1.0.0
 *
 * @param $classes       array|string Classes to be sanitized.
 * @param $return_format string       Optional. The return format, 'input', 'string', or 'array'. Default is 'input'.
 *
 * @return array|string Sanitized classes.
 */
function analytica_sanitize_html_classes( $classes, $return_format = 'input' ) {

    if ( 'input' === $return_format ) {
        $return_format = is_array( $classes ) ? 'array' : 'string';
    }

    $classes = is_array( $classes ) ? $classes : explode( ' ', $classes );

    $sanitized_classes = array_map( 'sanitize_html_class', $classes );

    if ( 'array' === $return_format ) {
        return $sanitized_classes;
    } else {
        return implode( ' ', $sanitized_classes );
    }
}

/**
 * Sanitize with allowed html
 *
 * @param $value
 * @return string
 */
function analytica_sanitize_html( $value ) {
    return wp_kses( $value, analytica_get_allowed_tags() );
}
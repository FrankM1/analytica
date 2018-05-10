<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Radium\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://radiumthemes.com/
 */

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
function analytica_sanitize_allowed_tag( $value ) {
    return wp_kses($value, wp_kses_allowed_html());
}
 
 /**
  * Sanitize output with allowed html
  *
  * @param $value
  * @return string
  */
function analytica_get_sanitized_output( $value ) {
    return $value;
}
 

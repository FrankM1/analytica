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

if ( ! analytica_header_is_active() && empty( get_theme_mod('site-header') ) ) {
    return;
}

add_filter( 'analytica_attr_site-header', 'analytica_attributes_header' );
/**
 * Add attributes for site header element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_header( $attributes ) {
     $attributes['class'] = implode( ' ', analytica_get_header_class() );
     $attributes['itemscope'] = 'itemscope';
     $attributes['itemtype'] = 'https://schema.org/WPHeader';
     return $attributes;
}

add_action( 'analytica_header', 'analytica_header_markup_open', 5 );
/**
 * Echo the opening structural markup for the header.
 *
 * @since 1.0.0
 *
 * @uses analytica_markup()          Apply contextual markup.
 * @uses analytica_structural_wrap() Maybe add opening .wrap div tag with header context.
 */
function analytica_header_markup_open() {
     analytica_markup( array(
         'element'   => '<div %s>',
         'context' => 'site-header',
     ) );
}

add_action( 'analytica_header', 'analytica_header_markup_close', 15 );
/**
 * Echo the opening structural markup for the header.
 *
 * @since 1.0.0
 *
 * @uses analytica_structural_wrap() Maybe add closing .wrap div tag with header context.
 * @uses analytica_markup()          Apply contextual markup.
 */
function analytica_header_markup_close() {
    analytica_markup( array(
         'element' => '</div>',
     ) );
}

add_action( 'analytica_header', 'analytica_do_header', 10 );
/**
 * Echo the default header, including the #title-area div, along with #title and #description, as well as the .widget-area.
 *
 * @since 1.0.0
 */
function analytica_do_header() {

     do_action( 'analytica_do_header_secondary' );

     do_action( 'analytica_before_header_inner' );

     get_template_part( 'template-parts/header/header' , 'standard' );

     do_action( 'analytica_after_header_inner' );

}

add_action( 'wp_enqueue_scripts', 'analytica_header_stylesheet' );
/**
 * Echo the opening structural markup for the header.
 *
 * @since 1.0.0
 *
 * @uses analytica_markup()          Apply contextual markup.
 * @uses analytica_structural_wrap() Maybe add opening .wrap div tag with header context.
 */
function analytica_header_stylesheet() {

     // detect if in developer mode and load appropriate files
     if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ): 
         $css_suffix = '.css';
         $version    = time();
     else:
         $css_suffix = '.min.css';
         $version    = analytica()->theme_version;
     endif;

     $direction_suffix = is_rtl() ? '-rtl' : '';

     wp_enqueue_style(
         'analytica-site-header',
         analytica()->theme_url . '/assets/frontend/css/site-header' . $css_suffix,
         false,
         $version,
         'all'
    );

    wp_enqueue_script(
        'analytica-megamenu-mobile',
        analytica()->theme_url . '/assets/frontend/js/vendor/mobile-menu.js',
        [ 
            'jquery',
            'hoverIntent',
        ],
        $version,
        true
    );
}

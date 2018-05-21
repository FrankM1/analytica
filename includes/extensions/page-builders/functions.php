
<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @package  Radium\Extensions
 * @subpackage  Energia
 * @author   Franklin Gitonga
 * @link     https://analyticathemes.com/
 */

add_filter( 'body_class', 'analytica_page_builder_body_class' );
/**
 * Add site layout classes to the body classes.
 *
 * @since 1.0.0
 *
 * @uses analytica_is_builder_page() Detect page builder page
 *
 * @param array $classes Existing classes.
 *
 * @return array Amended classes.
 */
function analytica_page_builder_body_class( $classes ) {

    // Page builder class
    if ( analytica_is_builder_page() ) {
        $classes[] = 'analytica-page-builder';
    }

    return $classes;
}

add_filter( 'analytica_site_layout_pre', 'analytica_page_builder_site_layout', 10, 4 );
/**
 * Change page builder page layout
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function analytica_page_builder_site_layout( $value ) {
    if ( analytica_is_builder_page() ) {
       return __analytica_return_full_width_content();
    }
}

add_filter( 'analytica_is_site_hero_available', 'analytica_page_builder_is_hero_available' );
/**
 * Detect page builder page
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function analytica_page_builder_is_hero_available( $retval ) {

    if ( analytica_is_builder_page() ) {
        $retval = false;
    }

    return $retval;
}

add_filter( 'analytica_pagination_enabled', 'analytica_page_builder_pagination' );
/**
 * Detect page builder page
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function analytica_page_builder_pagination( $retval ) {

    if ( analytica_is_builder_page() ) {
        $retval = false;
    }

    return $retval;
}

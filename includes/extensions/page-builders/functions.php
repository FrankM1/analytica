
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

add_filter( 'analytica_get_option', 'analytica_page_builder_site_layout', 10, 4 );
/**
 * Change page builder page layout
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function analytica_page_builder_site_layout( $value, $option_id, $default_value, $post_id ) {
    
    if ( analytica_is_builder_page() && $option_id === 'site-layout' ) {
       return 'site-fullwidth';
    }

    return $value;
}

add_filter( 'analytica_is_hero_available', 'analytica_page_builder_is_hero_available' );
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

<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @package  Radium\Extensions\Related-Posts
 * @subpackage  Energia
 * @author   Franklin Gitonga
 * @link     https://analyticathemes.com/
 */

add_filter( 'analytica_builder_is_active', 'analytica_live_qazana_is_active' );
/**
 * Detect if layout qazana is active
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function analytica_live_qazana_is_active( $retval ) {

    $retval = false;

    if ( analytica_detect_plugin( array( 'classes' => array( 'Qazana\Plugin' ) ) ) ) {
        $retval = true;
    }

    return $retval;
}

add_filter( 'analytica_is_builder_page', 'analytica_is_live_qazana_page', 10, 2 );
/**
 * Detect qazana page
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function analytica_is_live_qazana_page( $retval, $post_id ) {

    if ( get_post_meta( $post_id, '_qazana_edit_mode', true ) || 'qazana_library' == get_post_type() ) {
        $retval = true;
    }

    return $retval;
}

add_filter( 'analytica_is_hero_available', 'qazana_analytica_is_hero_available' );
/**
 * Detect qazana page
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function qazana_analytica_is_hero_available( $retval ) {

    if ( analytica_is_builder_page() ) {
        $retval = false;
    }

    return $retval;
}

add_filter( 'analytica_theme_defaults', 'qazana_analytica_site_layout' );
/**
 * Detect qazana page
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function qazana_analytica_site_layout( $options ) {

    if ( analytica_is_builder_page() ) {
        $options['site-layout'] = 'site-fullwidth';
    }

    return $options;
}
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

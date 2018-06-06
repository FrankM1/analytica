<?php
namespace Analytica\Extensions\Page_Builder;
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @package  Radium\Extensions\Related-Posts
 * @subpackage  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */
class Visual_Composer {

    /**
     * Constructor
     */
    public function __construct() {
        if ( ! $this->is_builder_activated() ) {
            return;
        }
        add_filter( 'analytica_is_builder_page', [ $this, 'is_builder_page'], 10, 2 );
        add_filter( 'analytica_builder_is_active', [ $this, 'is_builder_activated'] );
    }

    /**
     * Check is elementor activated.
     *
     * @param int $id Post/Page Id.
     * @return boolean
     */
    function is_builder_activated( $retval = false ) {
        if ( analytica_detect_plugin( array( 'classes' => array( 'Vc_Manager' ) ) ) ) {
            $retval = true;
        }
        return $retval;
    }

    /**
     * Detect elementor page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function is_builder_page( $retval, $post_id ) {
        $post = get_post( $post_id );
        $vc_active = get_post_meta( $post_id, '_wpb_vc_js_status', true );
        if ( 'true' == $vc_active || has_shortcode( $post->post_content, 'vc_row' ) ) {
            $retval = true;
        }
        return $retval;
    }
}


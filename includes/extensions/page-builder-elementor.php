<?php
namespace Analytica\Extensions\Page_Builder;

/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @package  Radium\Extensions\Related-Posts
 * @subpackage  Energia
 * @author   Franklin Gitonga
 * @link     https://analyticathemes.com/
 */

 use Elementor\Plugin;

/**
 * Elementor Compatibility
 *
 * @since 1.0.0
 */
class Elementor {

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

        if ( analytica_detect_plugin( array( 'classes' => array( 'Elementor\Plugin' ) ) ) ) {
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

        if ( version_compare( ELEMENTOR_VERSION, '1.5.0', '<' ) ) {
            return ( 'builder' === Plugin::$instance->db->get_edit_mode( $post_id ) );
        } else {
            return Plugin::$instance->db->is_built_with_elementor( $post_id );
        }

    }
}

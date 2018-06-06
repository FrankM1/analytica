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

 use FLBuilderModel;

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
        add_filter( 'analytica_is_builder_page', [ $this, 'is_live_builder_page'], 10, 2 );
        add_filter( 'analytica_builder_is_active', [ $this, 'is_builder_activated'] );
    }

    /**
     * Check is builder activated.
     *
     * @param int $id Post/Page Id.
     * @return boolean
     */
    function is_builder_activated( $retval = false ) {

        $retval = false;

        if ( analytica_detect_plugin( array( 'classes' => array( 'FLBuilderModel' ) ) ) ) {
            $retval = true;
        }

        return $retval;
    }

    /**
     * Detect builder page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function is_live_builder_page( $retval, $post_id ) {

        $do_render = apply_filters( 'fl_builder_do_render_content', true, FLBuilderModel::get_post_id() );

        $page_builder_flag = get_post_meta( $id, '_astra_content_layout_flag', true );
        if ( isset( $post ) && empty( $page_builder_flag ) && ( is_admin() || is_singular() ) ) {

            if ( empty( $post->post_content ) && $do_render && FLBuilderModel::is_builder_enabled() ) {
                $retval = true;
            }
        
        }

        return $retval;
    }
}

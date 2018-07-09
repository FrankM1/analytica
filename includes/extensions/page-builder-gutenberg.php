<?php
namespace Analytica\Extensions\Page_Builder;
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @package  Radium\Extensions\Gutenberg
 * @subpackage  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */
class Gutenberg {

    /**
     * Constructor
     */
    public function __construct() {
        if ( ! $this->is_builder_activated() ) {
            return;
        }
        add_filter( 'analytica_is_builder_page', [ $this, 'is_builder_page'], 10, 2 );
		add_filter( 'analytica_builder_is_active', [ $this, 'is_builder_activated'] );
		add_filter( 'body_class', [ $this, 'body_class'] );
	}

	/**
     * Detect gutenberg page and add a class
     *
     * @param int $id Post/Page Id.
     * @return boolean
     */
    function body_class( $classes ) {
        if ( gutenberg_post_has_blocks( get_queried_object_id() ) ) {
            $classes[] = 'analytica-page-builder-gutenberg';
        }
        return $classes;
    }

    /**
     * Check is gutenberg activated.
     *
     * @param int $id Post/Page Id.
     * @return boolean
     */
    function is_builder_activated( $retval = false ) {
        if ( is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
            $retval = true;
        }
        return $retval;
    }

    /**
     * Detect gutenberg page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function is_builder_page( $retval, $post_id ) {
        if ( gutenberg_post_has_blocks( $post_id ) ) {
            $retval = true;
        }
        return $retval;
    }
}


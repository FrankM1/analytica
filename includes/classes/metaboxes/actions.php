<?php
namespace Analytica\Metabox;

/**
 * Analytica Meta Box Operations
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

/**
 * Meta Box
 */
class Actions {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'wp', array( $this, 'meta_hooks' ) );
    }

    /**
     * Metabox Hooks
     */
    function meta_hooks() {

        if ( is_singular() ) {
            add_action( 'wp_head', array( $this, 'primary_header' ) );
            add_filter( 'analytica_the_title_enabled', array( $this, 'post_title' ) );
            add_filter( 'body_class', array( $this, 'body_class' ) );
        }
    }

    /**
     * Primary Header
     */
    function primary_header() {

        $display_header = get_post_meta( get_the_ID(), '_analytica_header', true );

        $display_header = apply_filters( 'analytica_main_header_display', $display_header );

        if ( 'disabled' == $display_header ) {
            remove_action( 'analytica_masthead', 'analytica_masthead_primary_template' );
        }
    }

    /**
     * Disable Post / Page Title
     *
     * @param  boolean $defaults Show default post title.
     * @return boolean           Status of default post title.
     */
    function post_title( $defaults ) {

        $title = get_post_meta( get_the_ID(), 'site-post-title', true );
        if ( 'disabled' == $title ) {
            $defaults = false;
        }

        return $defaults;
    }

    /**
     * Add Body Classes
     *
     * @param  array $classes Body Classes Array.
     * @return array
     */
    function body_class( $classes ) {

        $title = get_post_meta( get_the_ID(), 'site-post-title', true );

        if ( 'disabled' != $title ) {
            $classes[] = 'analytica-normal-title-enabled';
        }

        return $classes;
    }
}

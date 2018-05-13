<?php
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
class Analytica_Meta_Box_Operations {

    /**
     * Instance
     *
     * @var $instance
     */
    private static $instance;

    /**
     * Initiator
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

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

        $display_header = get_post_meta( get_the_ID(), 'ast-main-header-display', true );

        $display_header = apply_filters( 'ast_main_header_display', $display_header );

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
            $classes[] = 'ast-normal-title-enabled';
        }

        return $classes;
    }
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Analytica_Meta_Box_Operations::get_instance();

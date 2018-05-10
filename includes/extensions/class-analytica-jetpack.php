<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Analytica
 */

// If plugin - 'Jetpack' not exist then return.
if ( ! class_exists( 'Jetpack' ) ) {
	return;
}

/**
 * Analytica Jetpack Compatibility
 *
 * @since 1.0.0
 */
class Analytica_Jetpack {

    /**
     * Member Variable
     *
     * @var object instance
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
        add_action( 'after_setup_theme', array( $this, 'jetpack_setup' ) );
    }

    /**
     * Add theme support for Infinite Scroll.
     * See: https://jetpack.me/support/infinite-scroll/
     */
    function jetpack_setup() {
        add_theme_support(
            'infinite-scroll', array(
                'container' => 'main',
                'render'    => array( $this, 'infinite_scroll_render' ),
                'footer'    => 'page',
            )
        );
    } // end function jetpack_setup

    /**
     * Custom render function for Infinite Scroll.
     */
    function infinite_scroll_render() {
        while ( have_posts() ) {
            the_post();
            get_template_part( 'template-parts/content', analytica_get_post_format() );
        }
    } // end function infinite_scroll_render

}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Analytica_Jetpack::get_instance();

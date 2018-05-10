<?php
/**
 * Contact Form 7 Compatibility File.
 *
 * @package Analytica
 */

// If plugin - 'Contact Form 7' not exist then return.
if ( ! class_exists( 'WPCF7' ) ) {
	return;
}

/**
 * Analytica Contact Form 7 Compatibility
 *
 * @since 1.0.0
 */
class Analytica_Contact_Form_7 {

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
        add_filter( 'analytica_theme_assets', array( $this, 'add_styles' ) );
    }

    /**
     * Add assets in theme
     *
     * @param array $assets list of theme assets (JS & CSS).
     * @return array List of updated assets.
     * @since 1.0.0
     */
    function add_styles( $assets ) {
        $assets['css']['analytica-contact-form-7'] = 'extensions/contact-form-7';
        return $assets;
    }

}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Analytica_Contact_Form_7::get_instance();

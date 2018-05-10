<?php
/**
 * Site Origin Compatibility File.
 *
 * @package Analytica
 */

// If plugin - 'Site Origin' not exist then return.
if ( ! class_exists( 'SiteOrigin_Panels_Settings' ) ) {
	return;
}

/**
 * Analytica Site Origin Compatibility
 *
 * @since 1.0.0
 */
class Analytica_Site_Origin {

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
        $assets['css']['analytica-site-origin'] = 'extensions/site-origin';
        return $assets;
    }

}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Analytica_Site_Origin::get_instance();

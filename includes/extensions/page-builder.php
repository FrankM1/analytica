<?php

namespace Analytica\Extensions;

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
class Page_Builder {

    /**
     * Default actions
     */
    public function __construct() {
        add_filter( 'body_class', [ $this, 'body_class' ] );
        add_filter( 'analytica_site_layout_pre', [ $this, 'site_layout' ], 10, 4 );
        add_filter( 'analytica_is_site_hero_available', [ $this, 'is_hero_available' ] );
        add_filter( 'analytica_pagination_enabled', [ $this, 'has_pagination' ] );
    }

    /**
     * Add site layout classes to the body classes.
     *
     * @since 1.0.0
     *
     * @uses analytica_is_builder_page() Detect page builder page
     *
     * @param array $classes Existing classes.
     *
     * @return array Amended classes.
     */
    function body_class( $classes ) {

        // Page builder class
        if ( analytica_is_builder_page() ) {
            $classes[] = 'analytica-page-builder';
        }

        return $classes;
    }

    /**
     * Change page builder page layout
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function site_layout( $value ) {
        if ( analytica_is_builder_page() ) {
        return __analytica_return_full_width_content();
        }
        return false;
    }

    /**
     * Detect page builder page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function is_hero_available( $retval ) {

        if ( analytica_is_builder_page() ) {
            $retval = false;
        }

        return $retval;
    }

    /**
     * Detect page builder page
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    function has_pagination( $retval ) {

        if ( analytica_is_builder_page() ) {
            $retval = false;
        }

        return $retval;
    }

}

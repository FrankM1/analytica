<?php

namespace Analytica\Extensions;

/**
 * This file is a part of the Analytica core.
 * Please be cautious editing this file,
 *
 * @package  Analytica\Extensions\Page_Builder
 * @subpackage  Analytica
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

/**
 * Page Builder Compatibility
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
		add_filter( 'post_class', array($this, 'single_page_class') );
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
        if ( analytica_is_builder_page() && ! is_singular('post') && ! is_archive() ) {
            $classes[] = 'analytica-page-builder';
        }
        return $classes;
	}

	/**
     * Adds custom classes to the array of body classes.
     *
     * @since 1.0.0
     * @param array $classes Classes for the body element.
     * @return array
     */
    function single_page_class( $classes ) {

		if ( analytica_is_builder_page() ) {
			$classes = array_diff($classes, array( 'hentry', 'analytica-article-single', 'type-page' ) );
			$classes[] = 'type-page-builder';
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
            return _analytica_return_full_width_content();
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

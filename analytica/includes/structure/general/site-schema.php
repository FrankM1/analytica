<?php
namespace Analytica;
/**
 * This file is a part of the analytica Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     http://qazana.net/
 */

class SchemaORG {

    public function __construct() {

        if ( ! analytica_site_schema_is_active() ) {
            return;
        }

        add_filter( 'analytica_attr_body', array( $this, 'schema_body' ));
        add_filter( 'analytica_attr_site-description', array( $this, 'schema_site_description' ));

        add_filter( 'analytica_attr_nav-primary', array( $this, 'schema_nav' ));
        add_filter( 'analytica_attr_nav-secondary', array( $this, 'schema_nav' ));
        add_filter( 'analytica_attr_nav-header', array( $this, 'schema_nav' ));

        add_filter( 'analytica_attr_breadcrumb', array( $this, 'schema_breadcrumb' ));

        add_filter( 'analytica_attr_site-header', array( $this, 'schema_site_header' ));
        add_filter( 'analytica_attr_site-main', array( $this, 'schema_site_main' ));

        add_filter( 'analytica_attr_article', array( $this, 'schema_article' ));
        add_filter( 'analytica_attr_entry-content', array( $this, 'schema_entry_content' ));

        add_filter( 'analytica_attr_sidebar-primary', array( $this, 'schema_sidebar' ));
        add_filter( 'analytica_attr_sidebar-secondary', array( $this, 'schema_sidebar' ));

        add_filter( 'analytica_attr_site-colophon', array( $this, 'schema_site_colophon' ));
    }

    /**
     * Add attributes for body element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function schema_body( $attributes ) {
        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/WebPage';

        // Search results pages
        if ( is_search() ) {
            $attributes['itemtype'] = 'https://schema.org/SearchResultsPage';
        }

        if ( is_single() || is_archive() || is_home() || is_page_template( 'blog.php' ) ) {
            $attributes['itemtype'] = 'https://schema.org/Blog';
        }

        return $attributes;
    }

    /**
     * Add attributes for site header element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function schema_site_header( $attributes ) {

        if ( ! analytica_site_header_is_active() ) {
            return;
        }

        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/WPHeader';

        return $attributes;
    }

    /**
     * Add typical attributes for navigation elements.
     *
     * Used for primary navigation, secondary navigation, and custom menu widgets in the header right widget area.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function schema_nav( $attributes ) {
        $attributes['role'] = 'navigation';
        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/SiteNavigationElement';
        return $attributes;
    }

     /**
     * Add attributes for breadcrumb wrapper.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Ammended attributes
     */
    function schema_breadcrumb( $attributes ) {
        $attributes['itemprop'] = 'breadcrumb';
        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/BreadcrumbList';
        return $attributes;
    }

    /**
     * Add attributes for main site element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function schema_site_main( $attributes ) {
        if ( ! ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'blog.php' )) ) {
            $attributes['itemprop'] = 'mainContentOfPage';
        }
        return $attributes;
    }

    /**
     * Add attributes for the article element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
     function schema_article( $attributes ) {
        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/CreativeWork';
        return $attributes;
    }

    /**
     * Entry Content Attributes.
     *
     * @param array $attributes default attributes.
     *
     * @return array attributes.
     */
    public function schema_entry_content( $attributes ) {
        $attributes['itemprop'] = 'text';
        return $attributes;
    }

    /**
     * Add attributes for primary sidebar element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function schema_sidebar( $attributes ) {
        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/WPSideBar';
        return $attributes;
    }

    /**
     * Site Identity Description Attributes.
     *
     * @param array $attributes default attributes.
     *
     * @return array attributes.
     */
    public function schema_site_description( $attributes ) {
        $attributes['itemprop'] = 'description';
        return $attributes;
    }

    /**
     * Add attributes for site footer element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function schema_site_colophon( $attributes ) {
        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/WPFooter';
        return $attributes;
    }
}
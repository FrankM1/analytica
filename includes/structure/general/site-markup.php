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

class Markup {

    public function __construct() {
        add_filter( 'analytica_attr_body',                  array( $this, 'attributes_body' ));
        add_filter( 'analytica_attr_structural-wrap',       array( $this, 'attributes_structural_wrap' ));

        add_filter( 'analytica_attr_nav-primary',           array( $this, 'attributes_nav' ));
        add_filter( 'analytica_attr_nav-secondary',         array( $this, 'attributes_nav' ));
        add_filter( 'analytica_attr_nav-header',            array( $this, 'attributes_nav' ));

        add_filter( 'analytica_attr_site',                  array( $this, 'attributes_site' ));
        add_filter( 'analytica_attr_site-header',           array( $this, 'attributes_site_header' ));
        add_filter( 'analytica_attr_site-content',          array( $this, 'attributes_site_content' ));
        add_filter( 'analytica_attr_site-inner',            array( $this, 'attributes_site_inner' ));

        add_filter( 'analytica_attr_article',               array( $this, 'attributes_article' ));

        add_filter( 'analytica_attr_sidebar-primary',       array( $this, 'attributes_sidebar_primary' ));
        add_filter( 'analytica_attr_sidebar-secondary',     array( $this, 'attributes_sidebar_secondary' ));

        add_filter( 'analytica_attr_site-footer',           array( $this, 'attributes_site_footer' ));
        add_filter( 'analytica_attr_site-colophon',         array( $this, 'attributes_site_colophon' ));
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
    function attributes_body( $attributes ) {
        $attributes['class'] = implode( ' ', get_body_class() );
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
    function attributes_site_header( $attributes ) {

        if ( ! analytica_site_header_is_active() ) {
            return;
        }

        $attributes['class'] = implode( ' ', analytica_get_site_header_class() );

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
    function attributes_nav( $attributes ) {
        $attributes['role'] = 'navigation';
        return $attributes;
    }

    /**
     * Add attributes for structural wrap element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function attributes_structural_wrap( $attributes ) {
        $attributes['class'] = 'analytica-container';
        return $attributes;
    }

     /**
     * Add attributes for site element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function attributes_site( $attributes ) {
        $attributes['id'] = 'page';
        $attributes['class'] = 'hfeed site';
        return $attributes;
    }

    /**
     * Add attributes for site element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    public function attributes_site_content( $attributes ) {
        $attributes['id']    = 'content';
        $attributes['class'] = 'site-content';
        return $attributes;
    }

    /**
     * Add attributes for site inner element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function attributes_site_inner( $attributes ) {
        $attributes['class'] = 'site-inner';
        $attributes['class'] = 'site-inner site-inner-has-container';
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
     function attributes_article( $attributes ) {
        $attributes['id'] = 'post-'. get_the_ID();
        $attributes['class'] = join( ' ', get_post_class() );
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
    function attributes_sidebar_primary( $attributes ) {
        $attributes['class'] = 'site-sidebar sidebar-primary widget-area';
        $attributes['aria-label'] = esc_html__( 'Primary Sidebar', 'analytica' );
        return $attributes;
    }

    /**
     * Add attributes for secondary sidebar element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function attributes_sidebar_secondary( $attributes ) {
        $attributes['class'] = 'site-sidebar sidebar-secondary widget-area';
        $attributes['aria-label'] = esc_html__( 'Secondary Sidebar', 'analytica' );
        $attributes['role'] = 'complementary';
        return $attributes;
    }

    /**
     * Add attributes for site footer wrapper element.
     *
     * @since 1.0.0
     *
     * @param array $attributes Existing attributes.
     *
     * @return array Amended attributes.
     */
    function attributes_site_footer( $attributes ) {
        if ( ! analytica_get_option( 'site-footer-width' ) ) {
            $attributes['class'] = 'site-footer site-footer-has-container';
        } else {
            $attributes['class'] = 'site-footer site-footer-fullwidth';
        }

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
    function attributes_site_colophon( $attributes ) {
        if ( ! analytica_get_option( 'site-footer-colophon-width' ) ) {
            $attributes['class'] = 'site-colophon site-colophon-has-container';
        } else {
            $attributes['class'] = 'site-colophon site-colophon-fullwidth';
        }

        return $attributes;
    }
}
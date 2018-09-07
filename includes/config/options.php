<?php
namespace Analytica;

/**
 * Analytica Theme Options
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

/**
 * Theme Options
 */
class Options {

    /**
     * Post id.
     *
     * @var $instance Post id.
     */
    public static $post_id = null;

    /**
     * Set default theme option values
     *
     * @since 1.0.0
     * @return default values of the theme.
     */
    public static function controls() {
        return apply_filters( 'analytica_customizer_controls', [] );
    }

    /**
     * Set default theme option values
     *
     * @since 1.0.0
     * @return default values of the theme.
     */
    public static function defaults() {

        $primary = [
            'color' => '#535353',
            'font-family' => 'Rubik',
        ];

        $secondary = [
            'color' => '#3a3a3a',
            'font-family' => 'Poppins',
        ];

        return apply_filters( 'analytica_theme_defaults', array(

            // General
            'site-css-print-method'     => 'external',
            'site-publisher-uri'        => get_site_url(),
            'site-settings-update-time' => '',

            // Site Layout.
            'site-content-width'  => 840, // full width will be content width + sidebar width
            'site-layout-offset'  => '0',
            'site-layout'         => 'site-wide',
            'site-sidebar-layout' => 'content-sidebar',
            'site-schema'         => true,

            // Colors
            'site-accent-color'             => '#0274be',
            'site-background-color'         => '#fefefe',
            'site-content-background-color' => '#ffffff',
            'site-link-color'               => '#0274be',
            'site-link-highlight-color'     => '#3a3a3a',
            'site-text-color'               => '#3a3a3a',
            'site-border-color'             => '',

            // Forms
            'site-form-inputs-background-color' => '',
            'site-form-inputs-highlight-background-color' => '',
            'site-form-inputs-border-color' => '',
            'site-form-inputs-text-color' => '',

            // Container.
            'site-detach-containers' => true,
            'site-dual-containers'   => false,

            // Sidebars
            'site-sidebar-enable-mobile' => false,
            'site-sidebar-enable-tablet' => true,
            'site-sidebar-enable'        => true,
            'site-sidebar-width'         => 360,
            'site-sidebar-supported'     => [
                'post',
                'page',
            ],
            'site-sidebar-archives-supported' => [
                'categories',
                'tags',
            ],
            'site-sidebar-padding' => [
                'top'    => '',
                'bottom' => '',
                'left'   => '20',
                'right'  => '20',
            ],

            ////// IMPLEMENT
            'sidebar-before-footer-widget' => false,
            'sidebar-after-footer-widget'  => false,
            ////// IMPLEMENT

            // Header
            'site-header'                  => true,
            'site-header-background-color' => '#fff',
            'site-header-menu-layout'      => 'header-logo-left',
            'site-header-overlay'          => false,
            'site-header-transparent'      => false,
            'site-header-width'            => false,

            'site-header-border-color'      => '',
            'site-header-border-style' => '',
            'site-header-padding' => [
                'top'    => '',
                'left'   => '',
                'bottom' => '',
                'right'  => '',
            ],
            'site-header-border' => [
                'top'    => '',
                'bottom' => '',
                'left'   => '',
                'right'  => '',
            ],
            'site-header-overlay-background-color' => '#fff',
            'site-header-overlay-highlight-color' => '',
            'site-header-overlay-link-color' => '',
            'site-header-overlay-color' => '',
            'site-header-link-highlight-color' => '',
            'site-header-link-color' => '',

            // Hero Section
            'site-hero-background-color-base'    => 'light',
            'site-hero-background-image'         => '',
            'site-hero-background-overlay-color' => '',
            'site-hero-background'               => true,
            'site-hero-breadcrumbs'              => true,
            'site-hero-fullheight'               => false,
            'site-hero-height-mobile'            => '',
            'site-hero-height'                   => '',
            'site-hero-show-subtitle'            => true,
            'site-hero-show-title'               => true,
            'site-hero-subtitle'                 => '',
            'site-hero-text-alignment'           => 'text-center',
            'site-hero'                          => true,
            'site-hero-header-font'              => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '52px',
                'line-height'    => '1.5',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => '',
            ],
            'site-hero-subheader-font' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '24px',
                'line-height'    => '1.5',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => '',
            ],
            'site-hero-header-padding' => [
                'top'    => '',
                'bottom' => '',
                'left'   => '',
                'right'  => '',
            ],

            // Breadcrumbs
            'site-breadcrumb-color'            => true,
            'site-breadcrumb-active-color'     => true,
            'site-breadcrumb-background-color' => true,

            // Typography
            'font-base' => [
                'font-family'    => $primary['font-family'],
                'color'          => $primary['color'],
                'font-size'      => '14px',
                'line-height'    => '1.6em',
                'letter-spacing' => '',
                'variant'        => '',
                'text-transform' => '',
            ],

            'font-secondary-base' => [
                'font-family' => $secondary['font-family'],
                'color'       => $secondary['color'],
            ],

            'logo-favicon-typography' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '24px',
                'font-weight'    => 'bold',
                'line-height'    => '1.3',
                'letter-spacing' => '',
                'color'          => '#000',
                'text-transform' => '',
            ],

            'font-h1' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '52px',
                'font-weight'    => 'bold',
                'line-height'    => '1.3',
                'letter-spacing' => '-.05em',
                'color'          => '',
                'text-transform' => '',
            ],

            'font-h2' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '30px',
                'line-height'    => '1.2',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => '',
            ],

            'font-h3' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '24px',
                'line-height'    => '1.5',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => '',
            ],

            'font-h4' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '18px',
                'line-height'    => '1.5',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => '',
            ],

            'font-h5' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '14px',
                'line-height'    => '1.5',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => '',
            ],

            'font-h6' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '12px',
                'line-height'    => '1.5',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => '',
            ],

            'font-em' => [
                'font-family' => 'Playfair Display',
                'variant'     => 'italic',
            ],

            'font-strong' => [
                'font-family' => $primary['font-family'],
                'variant'     => 'bold',
            ],

            'font-form-labels' => [
                'font-family' => $primary['font-family'],
            ],

            'font-form-legend' => [
                'font-family' => $primary['font-family'],
            ],

            'font-widget-title' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '14px',
                'line-height'    => '1.5',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => 'uppercase',
            ],

            // Blog
            'single-featured-image'                   => true,
            'single-post-site-container-width' => '',
            'single-post-site-sidebar-width'   => '',
            'single-post-layout'               => 'content-sidebar',
            'single-post-site-hero'            => true,
            'single-has-post-thumbnail'        => true,
            'single-post-structure'            => array(
                'single-image',
                'single-title-meta',
            ),
            'single-post-meta'      => array(
                'comments',
                'category',
                'author',
            ),

            // Archives
            'archive-featured-image'     => true,
            'archive-post-meta-color'    => '',
            'archive-site-hero'         => true,
            'archive-frontpage-title'   => esc_html__( 'Latest posts', 'analytica' ),
            'archive-sidebar-layout'    => '',
            'archive-post-content' => 'excerpt',
            'archive-content-structure' => array(
                'image',
                'title-meta',
            ),
            'archive-post-meta'    => array(
                'comments',
                'category',
                'author',
            ),
            'archive-heading-typography' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'letter-spacing' => '',
                'color'          => '',
                'text-transform' => '',
            ],

            // Search
            'search-sidebar-layout' => '',

            // Footer
            'site-back-to-top'           => true,
            'site-footer-copyright-text' => esc_html__('Copyright &copy; [year] Qazana. All rights reserved.', 'analytica'),
            'site-footer-layout'         => '4',
            'site-footer-width'          => false,
            'site-footer-widgets'        => true,
            'site-footer'                => true,
            'site-theme-badge'           => true,
            'site-credit-typography'     => [
                'font-family'    => $primary['font-family'],
                'font-size'      => '13px',
                'line-height'    => '23px',
                'letter-spacing' => '',
                'variant'        => '',
                'text-transform' => '',
                'text-align'     => 'center',
            ],
            'site-footer-colophon-background-color' => '#000',
            'site-footer-colophon-links-color'      => '#BCBCBC',
            'site-footer-colophon-color'            => 'rgba(255,255,255,0.5)',
            'site-footer-colophon-width'            => false,
            'site-footer-colophon'                  => true,
            'site-footer-colophon-border-color'     => 'rgba(255,255,255,0.09)',
            'site-footer-colophon-border'           => [
                'top'    => '',
                'bottom' => '',
                'left'   => '',
                'right'  => '',
            ],
            'site-footer-colophon-padding' => [
                'top'    => '',
                'bottom' => '',
                'left'   => '',
                'right'  => '',
            ],
            'footer-background' => [
                'background-color'    => '#000000',
                'background-image'    => '',
                'background-repeat'   => 'no-repeat',
                'background-size'     => 'cover',
                'background-attach'   => 'fixed',
                'background-position' => 'left-top',
            ],
            'footer-accent-color'      => '',
            'footer-text-color'        => 'rgba(255,255,255,0.5)',
            'footer-accent-color'      => '',
            'footer-body-color'        => '',
            'footer-border-color'      => '',
            'footer-headers-color'     => '#fff',
            'footer-link-color'        => '',
            'site-footer-padding'      => [
                'top'    => '',
                'left'   => '',
                'bottom' => '',
                'right'  => '',
            ],
            'site-footer-border'       => [
                'top'    => '',
                'bottom' => '',
                'left'   => '',
                'right'  => '',
            ],

            // Buttons.
            'button-background-color'   => '#0274be',
            'button-background-h-color' => '',
            'button-text-color'      => '',
            'button-radius'     => 2,
            'button-h-color'    => '',
            'button-h-padding'  => 40,
            'button-v-padding'  => 10,
        ));
    }

    /**
     * Get single theme option from static array()
     *
     * @return array    Return array of theme options.
     */
    public static function get_option( $primary, $default_value ) {
        return Customizer::get_option( analytica()->theme_slug, $primary );
    }
}

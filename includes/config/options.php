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
class Options
{

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
    public static function controls()
    {
        return apply_filters( 'analytica_customizer_controls', [] );
    }

    /**
     * Set default theme option values
     *
     * @since 1.0.0
     * @return default values of the theme.
     */
    public static function defaults()
    {

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
            'site-content-width'  => 1200,
            'site-description'    => 0,
            'site-layout-offset'  => '0',
            'site-layout'         => 'site-fullwidth',
            'site-sidebar-layout' => 'content-sidebar',

            // Colors
            'site-accent-color'             => '#0274be',
            'site-background-color'         => '#fefefe',
            'site-content-background-color' => '#ffffff',
            'site-link-color'               => '#0274be',
            'site-link-highlight-color'     => '#3a3a3a',
            'site-text-color'               => '#3a3a3a',

            // Container.
            'site-detach-containers' => false,
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
            'site-header-sticky'           => false,
            'site-header-transparent'      => false,
            'site-header-width'            => 'layout-boxed',

            // Hero Section
            'site-hero-background-color-base'    => 'light',
            'site-hero-background-color'         => '',
            'site-hero-background-fixed'         => '',
            'site-hero-background-image'         => analytica()->theme_url . '/assets/frontend/images/defaults/hero-background.jpg',
            'site-hero-background-inherit'       => true,
            'site-hero-background-overlay-color' => 'rgba(10, 10, 10, 1)',
            'site-hero-background-position'      => 'center center',
            'site-hero-background-repeat'        => 'no-repeat',
            'site-hero-background-size'          => 'cover',
            'site-hero-background'               => true,
            'site-hero-breadcrumbs'              => true,
            'site-hero-fullheight'               => false,
            'site-hero-height-mobile'            => 200,
            'site-hero-height'                   => 350,
            'site-hero-parallax'                 => false,
            'site-hero-show-subtitle'            => true,
            'site-hero-show-title'               => true,
            'site-hero-subtitle'                 => '',
            'site-hero-text-alignment'           => 'text-center',
            'site-hero'                          => true,
            'site-hero-header-font'              => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '52px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => '#ffffff',
                'text-transform' => 'none',
                'variant'        => 'regular',
            ],
            'site-hero-subheader-font' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '24px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => '#ffffff',
                'text-transform' => 'none',
            ],
            'site-hero-header-padding' => [
                'top'    => '',
                'bottom' => '',
                'left'   => '',
                'right'  => '',
            ],

            // Typography
            'font-base' => [
                'font-family'    => $primary['font-family'],
                'color'          => $primary['color'],
                'font-size'      => '14px',
                'line-height'    => '1.6em',
                'letter-spacing' => '0',
                'variant'        => 'regular',
                'text-transform' => 'none',
            ],

            'font-secondary-base' => [
                'font-family' => $secondary['font-family'],
                'color'       => $secondary['color'],
            ],

            'font-h1' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '52px',
                'font-weight'    => 'bold',
                'line-height'    => '1.3',
                'letter-spacing' => '-.05em',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h2' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '30px',
                'line-height'    => '1.2',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h3' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '24px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h4' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '18px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h5' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '14px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h6' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '12px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
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

            // Blog
            'featured-image'                   => true,
            'single-post-site-container-width' => '',
            'single-post-site-sidebar-width'   => '',
            'single-post-layout'               => 'content-sidebar',
            'single-post-site-hero'            => true,
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
            'archive-site-hero'         => true,
            'archive-frontpage-title'   => esc_html__( 'Latest posts', 'analytica' ),
            'archive-sidebar-layout'    => '',
            'archive-content-structure' => array(
                'image',
                'title-meta',
            ),
            'archive-post-content' => 'excerpt',
            'archive-post-meta'    => array(
                'comments',
                'category',
                'author',
            ),

            // Footer
            'site-back-to-top'           => true,
            'site-footer-copyright-text' => esc_html__('Copyright &copy; [year] Radium Themes. All rights reserved.', 'analytica'),
            'site-footer-layout'         => '4',
            'site-footer-width'          => true,
            'site-footer'                => true,
            'site-theme-badge'           => true,
            'site-credit-typography'     => [
                'font-family'    => $primary['font-family'],
                'font-size'      => '13px',
                'line-height'    => '23px',
                'letter-spacing' => '0',
                'variant'        => 'regular',
                'text-transform' => 'none',
                'text-align'     => 'center',
            ],

            'footer-accent-color'          => '',
            'footer-body-color'            => '',
            'footer-border-color'          => '',
            'footer-colophon-border-color' => 'rgba(255,255,255,0.09)',
            'footer-headers-color'         => '',
            'footer-link-color'            => '',
            'footer-background'            => [
                'color'    => 'rgba(0,0,0,1)',
                'image'    => '',
                'repeat'   => 'no-repeat',
                'size'     => 'cover',
                'attach'   => 'fixed',
                'position' => 'left-top',
            ],
            /////////////////////////////////////////////////////////
          
            // Buttons.
            'button-bg-color'   => '',
            'button-bg-h-color' => '',
            'button-color'      => '',
            'button-h-color'    => '',
            'button-h-padding'  => 40,
            'button-radius'     => 2,
            'button-v-padding'  => 10,
        ));
    }

    /**
     * Get single theme option from static array()
     *
     * @return array    Return array of theme options.
     */
    public static function get_option($primary, $default_value)
    {
        return Customizer::get_option(Core::instance()->theme_slug, $primary);
    }
}

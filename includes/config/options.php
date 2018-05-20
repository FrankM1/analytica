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
            'font-family' => 'Rubik',
            'color' => '#535353',
        ];

        $secondary = [
            'font-family' => 'Poppins',
            'color' => '#000',
        ];

        return apply_filters( 'analytica_theme_defaults', array(
            
            // General
            'site-settings-update-time' => '',
            'site-css-print-method'     => 'external',
            'site-publisher-uri'        => get_site_url(),

            // Site Layout.
            'site-description'    => 0,
            'site-layout'         => 'site-fullwidth',
            'site-layout-offset'  => '0',
            'site-content-width'  => 1200,
            'site-sidebar-layout' => 'content-sidebar',

            // Colors
            'site-text-color'   => '#3a3a3a',
            'site-accent-color' => '#4f02b3',
            'site-background-color' => '#fff',
            'site-accent-color'  => '#0274be',
            'site-link-color'   => '#0274be',
            'site-link-highlight-color' => '#3a3a3a',

            // Container.
            'site-detach-containers' => true,
            'site-dual-containers'   => false,

            // Sidebars
            'site-sidebar-width'         => 360,
            'site-sidebar-enable'        => true,
            'site-sidebar-enable-tablet' => true,
            'site-sidebar-enable-mobile' => false,
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
            'header'                  => true,
            'header-background-color' => '#fff',
            'header-menu-layout'      => 'header-logo-left',
            'header-overlay'          => false,
            'header-overlay'          => false,
            'header-scripts'          => '',
            'header-sticky'           => false,
            'header-sticky'           => false,
            'header-transparent'      => false,
            'header-width'            => 'layout-boxed',

            // Hero Section
            'hero'                   => true,
            'hero-background-size'          => 'cover',
            'hero-background-color-base'    => 'light',
            'hero-background-color'         => '',
            'hero-background-fixed'         => '',
            'hero-background'               => true,
            'hero-background-inherit'       => true,
            'hero-background-position'      => 'center center',
            'hero-background-image'         => analytica()->theme_url . '/assets/frontend/images/defaults/hero-background.jpg',
            'hero-background-overlay-color' => 'rgba(10, 10, 10, 1)',
            'hero-background-repeat'        => 'no-repeat',
            'hero-height'                   => 350,
            'hero-height-mobile'            => 200,
            'hero-fullheight'               => false,
            'hero-show-subtitle'            => true,
            'hero-show-title'               => true,
            'hero-subtitle'                 => '',
            'hero-parallax'                 => false,
            'hero-breadcrumbs'              => true,

            'hero-text-alignment'           => 'text-center',
            'hero-header-font'              => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '52px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => '#ffffff',
                'text-transform' => 'none',
                'variant'        => 'regular',
            ],
            'hero-subheader-font' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '24px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => '#ffffff',
                'text-transform' => 'none',
            ],
            'hero-header-padding' => [
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

            'site-credit-typography' => [
                'font-family'    => $primary['font-family'],
                'font-size'      => '13px',
                'line-height'    => '23px',
                'letter-spacing' => '0',
                'variant'        => 'regular',
                'text-transform' => 'none',
                'text-align'     => 'center',
            ],

            // Blog
            'featured-image'                   => true,
            'single-post-site-container-width' => '',
            'single-post-site-sidebar-width'   => '',
            'single-post-layout'               => 'content-sidebar',
            'single-post-hero'                 => true,
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
            'archives-hero'             => true,
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
            'site-footer'                => true,
            'site-footer-width'          => true,
            'site-footer-layout'         => '4',
            'site-footer-copyright-text' => esc_html__('Copyright &copy; [year] Radium Themes. All rights reserved.', 'analytica'),
            'site-theme-badge'           => true,
            'site-back-to-top'           => true,

            'footer-accent-color'          => '',
            'footer-body-color'            => '',
            'footer-link-color'            => '',
            'footer-headers-color'         => '',
            'footer-border-color'          => '',
            'footer-colophon-border-color' => 'rgba(255,255,255,0.09)',
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
            'button-color'      => '',
            'button-h-color'    => '',
            'button-bg-color'   => '',
            'button-bg-h-color' => '',
            'button-radius'     => 2,
            'button-v-padding'  => 10,
            'button-h-padding'  => 40,
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

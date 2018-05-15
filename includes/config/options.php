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
        return apply_filters('analytica_customizer_controls', []);
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

        return apply_filters('analytica_theme_defaults', array(
            // General
            'css-print-method' => 'external',
            'settings-update-time' => '',
            'site-layout' => 'site-wide',
            // Site Layout.
            'site-layout' => 'ast-full-width-layout',
            'site-content-width' => 1200,
            'site-layout-outside-bg-obj' => array(
                'background-color' => '',
                'background-image' => '',
                'background-repeat' => 'repeat',
                'background-position' => 'center center',
                'background-size' => 'auto',
                'background-attachment' => 'scroll',
            ),
            // Container.
            'site-content-layout' => 'content-boxed-container',
            'single-page-content-layout' => 'default',
            'single-post-content-layout' => 'default',
            'archive-post-content-layout' => 'default',

            // Sidebars
            'site-sidebar-width' => 360,
            'site_sidebar_enable' => true,
            'site_sidebar_enable_tablet' => true,
            'site_sidebar_enable_mobile' => false,
            'site_sidebar_supported' => [
                'post',
                'page',
            ],
            'site_sidebar_archives_supported' => [
                'categories',
                'tags',
            ],
            'site-sidebar-padding' => [
                'top' => '',
                'bottom' => '',
                'left' => '20',
                'right' => '20',
            ],

            ////// IMPLEMENT
            'sidebar_before_footer_widget' => false,
            'sidebar_after_footer_widget' => false,
            ////// IMPLEMENT

            // Header
            'header' => true,
            'header-background-color' => '#fff',
            'header-sticky' => false,
            'header-overlay' => false,
            'header-transparent' => false,
            'header-overlay' => false,
            'header-sticky' => false,
            'header-width' => 'layout-boxed',
            'header-menu-layout' => 'header-logo-left',
            'header-scripts' => '',

            // General
            'site_layout_offset' => '0',
            'site-description' => 0,
            'accent-color' => '#3452ff',

            // Typography
            'font-base' => [
                'font-family' => $primary['font-family'],
                'color' => $primary['color'],
                'font-size' => '14px',
                'line-height' => '1.6em',
                'letter-spacing' => '0',
                'variant' => 'regular',
                'text-transform' => 'none',
            ],

            'font-secondary-base' => [
                'font-family' => $secondary['font-family'],
                'color' => $secondary['color'],
            ],

            'font-h1' => [
                'font-family' => $secondary['font-family'],
                'variant' => 'regular',
                'font-size' => '52px',
                'font-weight' => 'bold',
                'line-height' => '1.3',
                'letter-spacing' => '-.05em',
                'color' => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h2' => [
                'font-family' => $secondary['font-family'],
                'variant' => 'regular',
                'font-size' => '30px',
                'line-height' => '1.2',
                'letter-spacing' => '0',
                'color' => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h3' => [
                'font-family' => $secondary['font-family'],
                'variant' => 'regular',
                'font-size' => '24px',
                'line-height' => '1.5',
                'letter-spacing' => '0',
                'color' => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h4' => [
                'font-family' => $secondary['font-family'],
                'variant' => 'regular',
                'font-size' => '18px',
                'line-height' => '1.5',
                'letter-spacing' => '0',
                'color' => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h5' => [
                'font-family' => $secondary['font-family'],
                'variant' => 'regular',
                'font-size' => '14px',
                'line-height' => '1.5',
                'letter-spacing' => '0',
                'color' => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-h6' => [
                'font-family' => $secondary['font-family'],
                'variant' => 'regular',
                'font-size' => '12px',
                'line-height' => '1.5',
                'letter-spacing' => '0',
                'color' => $secondary['color'],
                'text-transform' => 'none',
            ],

            'font-em' => [
                'font-family' => 'Playfair Display',
                'variant' => 'italic',
            ],

            'font-strong' => [
                'font-family' => $primary['font-family'],
                'variant' => 'bold',
            ],

            'font-form-labels' => [
                'font-family' => $primary['font-family'],
            ],

            'font-form-legend' => [
                'font-family' => $primary['font-family'],
            ],

            'site-credit-typography' => [
                'font-family' => $primary['font-family'],
                'font-size' => '13px',
                'line-height' => '23px',
                'letter-spacing' => '0',
                'variant' => 'regular',
                'text-transform' => 'none',
                'text-align' => 'center',
            ],

            // Blog
            'featured-image' => true,
            'publisher-uri' => get_site_url(),
            'single-post-site-container-width' => '',
            'single-post-site-sidebar-width' => '',

            // Footer
            'footer' => 1,
            'footer-width' => 1,
            'site-footer-layout' => '4',
            'footer-copyright-text' => esc_html__('Copyright &copy; [year] Radium Themes. All rights reserved.', 'energia'),
            'show-theme-badge' => 1,
            'footer-back-to-top' => 1,
            'footer-accent-color' => '',
            'footer-body-color' => '',
            'footer-link-color' => '',
            'footer-background' => [
                'color' => 'rgba(0,0,0,1)',
                'image' => '',
                'repeat' => 'no-repeat',
                'size' => 'cover',
                'attach' => 'fixed',
                'position' => 'left-top',
            ],
            'footer-headers-color' => '',
            'site-footer-border-color' => '',
            'footer-colophon-border-color' => 'rgba(255,255,255,0.09)',
            'footer-custom-scripts' => '',

            /////////////////////////////////////////////////////////
            // Blog Single.
            'blog-single-post-structure' => array(
                'single-image',
                'single-title-meta',
            ),

            'blog-single-width' => 'default',
            'blog-single-max-width' => 1200,
            'blog-single-meta' => array(
                'comments',
                'category',
                'author',
            ),
            // Blog.
            'blog-post-structure' => array(
                'image',
                'title-meta',
            ),
            'blog-width' => 'default',
            'blog-max-width' => 1200,
            'blog-post-content' => 'excerpt',
            'blog-meta' => array(
                'comments',
                'category',
                'author',
            ),
            // Colors.
            'text-color' => '#3a3a3a',
            'link-color' => '#0274be',
            'theme-color' => '#0274be',
            'link-h-color' => '#3a3a3a',

            // Buttons.
            'button-color' => '',
            'button-h-color' => '',
            'button-bg-color' => '',
            'button-bg-h-color' => '',
            'button-radius' => 2,
            'button-v-padding' => 10,
            'button-h-padding' => 40,
        )
        );
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

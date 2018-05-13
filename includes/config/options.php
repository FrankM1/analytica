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
            'font-family' => 'Rubik',
            'color'       => '#535353',
        ];
    
        $secondary = [
            'font-family' => 'Rubik',
            'color'       => '#000',
        ];

        return apply_filters( 'analytica_theme_defaults', array(
            // General
            'css_print_method' => 'external',
            'settings_update_time' => '',
            'site-layout'                => 'site-wide',
            // Site Layout.
            'site-layout'                      => 'ast-full-width-layout',
            'site-content-width'               => 1200,
            'site-layout-outside-bg-obj'       => array(
                'background-color'      => '',
                'background-image'      => '',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'auto',
                'background-attachment' => 'scroll',
            ),
            // Container.
            'site-content-layout'              => 'content-boxed-container',
            'single-page-content-layout'       => 'default',
            'single-post-content-layout'       => 'default',
            'archive-post-content-layout'      => 'default',

            // Sidebars
            'site_sidebar_width'         => 360,
            'site_sidebar_enable'        => true,
            'site_sidebar_enable_tablet' => true,
            'site_sidebar_enable_mobile' => false,
            'site_sidebar_supported'     => [
                'post',
                'page',
            ],
            'site_sidebar_archives_supported' => [
                'categories',
                'tags',
            ],
            'site-sidebar-padding' => [
                'top'    => '',
                'bottom' => '',
                'left'   => '20',
                'right'  => '20',
            ],

            // Header
            'header-sticky'       => true,
            'header-overlay'      => true,
            'header-transparent'  => true,
            'default_style'       => 'default',
            'site_sidebar_style'  => 'default',
            'main_bg'             => array(
                'background-color'      => '',
                'background-image'      => '',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'scroll',
            ),
            'main_bg_overlay_color' => '',
            'site_description'      => 0,
            'login_logo'            => analytica()->theme_url . '/assets/frontend/images/defaults/login-logo.png',
            'accent_color'          => '#3452ff',
            'site_inner_bg'         => array(
                'background-color'      => 'rgba(255,255,255,1)',
                'background-image'      => '',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'scroll',
            ),
      
            // Typography
            'font_base' => [
                'font-family'    => $primary['font-family'],
                'color'          => $primary['color'],
                'font-size'      => '14px',
                'line-height'    => '1.6em',
                'letter-spacing' => '0',
                'variant'        => 'regular',
                'text-transform' => 'none',
            ],
    
            'font_secondary_base' => [
                'font-family' => $secondary['font-family'],
                'color'       => $secondary['color'],
            ],
    
            'font_h1' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '52px',
                'font-weight'    => 'bold',
                'line-height'    => '1.3',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],
    
            'font_h2' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '30px',
                'line-height'    => '1.2',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],
    
            'font_h3' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '24px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],
    
            'font_h4' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '18px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],
    
            'font_h5' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '14px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],
    
            'font_h6' => [
                'font-family'    => $secondary['font-family'],
                'variant'        => 'regular',
                'font-size'      => '12px',
                'line-height'    => '1.5',
                'letter-spacing' => '0',
                'color'          => $secondary['color'],
                'text-transform' => 'none',
            ],
    
            'font_em' => [
                'font-family' => 'Playfair Display',
                'variant'     => 'italic',
            ],
    
            'font_strong' => [
                'font-family' => $primary['font-family'],
                'variant'     => 'bold',
            ],
    
            'font_form_labels' => [
                'font-family' => $primary['font-family'],
            ],
    
            'font_form_legend' => [
                'font-family' => $primary['font-family'],
            ],
    
            'site_credit_typography' => [
                'font-family'    => $primary['font-family'],
                'font-size'      => '13px',
                'line-height'    => '23px',
                'letter-spacing' => '0',
                'variant'        => 'regular',
                'text-transform' => 'none',
                'text-align'     => 'center',
            ],

            // Footer
            'footer'                => 1,
            'footer-width'          => 1,
            'site_footer_layout'    => '4',
            'footer-copyright-text' => esc_html__( 'Copyright &copy; [year] Radium Themes. All rights reserved.', 'energia' ),
            'show-theme-badge'      => 1,
            'footer-back-to-top'    => 1,
            'footer-accent-color'   => '',
            'footer-body-color'     => '',
            'footer-link-color'     => '',
            'footer-background'     => [
                'color'    => 'rgba(0,0,0,1)',
                'image'    => '',
                'repeat'   => 'no-repeat',
                'size'     => 'cover',
                'attach'   => 'fixed',
                'position' => 'left-top',
            ],
            'footer-headers-color'         => '',
            'footer-colophon-border-color' => 'rgba(255,255,255,0.09)',
 
                /////////////////////////////////////////////////////////
                // Blog Single.
                'blog-single-post-structure'       => array(
                    'single-image',
                    'single-title-meta',
                ),

                'blog-single-width'                => 'default',
                'blog-single-max-width'            => 1200,
                'blog-single-meta'                 => array(
                    'comments',
                    'category',
                    'author',
                ),
                // Blog.
                'blog-post-structure'              => array(
                    'image',
                    'title-meta',
                ),
                'blog-width'                       => 'default',
                'blog-max-width'                   => 1200,
                'blog-post-content'                => 'excerpt',
                'blog-meta'                        => array(
                    'comments',
                    'category',
                    'author',
                ),
                // Colors.
                'text-color'                       => '#3a3a3a',
                'link-color'                       => '#0274be',
                'theme-color'                      => '#0274be',
                'link-h-color'                     => '#3a3a3a',

                // Buttons.
                'button-color'                     => '',
                'button-h-color'                   => '',
                'button-bg-color'                  => '',
                'button-bg-h-color'                => '',
                'button-radius'                    => 2,
                'button-v-padding'                 => 10,
                'button-h-padding'                 => 40,
        
                // Sidebar.
                'site-sidebar-layout'              => 'right-sidebar',
                'site-sidebar-width'               => 30,
                'single-page-sidebar-layout'       => 'default',
                'single-post-sidebar-layout'       => 'default',
                'archive-post-sidebar-layout'      => 'default',
            )
        );
    }

    /**
     * Get single theme option from static array()
     *
     * @return array    Return array of theme options.
     */
    public static function get_option( $primary, $default_value ) {
       return Customizer::get_option( Core::instance()->theme_slug, $primary );
    }
}
<?php
/**
 * This file is a part of the Energia Framework core.
 * Please be cautious editing this file,
 *
 * @category Energia\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://radiumthemes.com/
 */

function analytica_get_customizer_default_profile() {

    $primary = [
        'font-family' => 'Roboto',
        'color'       => '#86939E',
    ];

    $secondary = [
        'font-family' => 'Roboto',
        'color'       => '#282828',
    ];

    $defaults = [

        // General
        'site_container_width'       => 1170,
        'site_layout_offset'         => 0,
        'site_layout_offset_color'   => '#fff',
        'site_layout'                => 'site-wide',
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
        'header-sticky'       => true,
        'header-overlay'      => true,
        'header-transparent'  => true,
        'default_style'       => 'default',
        'site_sidebar_style'  => 'default',
        'sticky-widget-areas' => false,
        'date_format'         => 'traditional',
        'main_bg'             => array(
            'background-color'      => '',
            'background-image'      => '',
            'background-repeat'     => 'repeat',
            'background-position'   => 'center center',
            'background-size'       => 'cover',
            'background-attachment' => 'scroll',
        ),
        'main_bg_overlay_color' => '',
        'scroll_reveal'         => 1,
        'site_description'      => 0,
        'login_logo'            => Analytica\Core::instance()->theme_url . '/assets/frontend/images/defaults/login-logo.png',
        'accent_color'          => '#3452ff',
        'site_inner_bg'         => array(
            'background-color'      => 'rgba(255,255,255,1)',
            'background-image'      => '',
            'background-repeat'     => 'repeat',
            'background-position'   => 'center center',
            'background-size'       => 'cover',
            'background-attachment' => 'scroll',
        ),
        'page_loader'       => 'none',
        'page_loader_css'   => '13',
        'page_loader_image' => '',

        // BreadCrumbs
        'breadcrumb_color'        => '#A5A5A5',
        'breadcrumb_active_color' => '#ffffff',
        'breadcrumb_bg_color'     => 'rgba(255,255,255,0)',

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

        // Page Header
        'page_header_enable'               => 'on',
        'page_header_custom_height'        => 350,
        'page_header_custom_mobile_height' => 200,
        'page_header_text_alignment'       => 'text-center',
        'page_header_bg_color'             => '',
        'page_header_bg_color_base'        => 'light',
        'page_header_bg_overlay_color'     => 'rgba(10, 10, 10, 1)',
        'page_header_bg_img'               => Analytica\Core::instance()->theme_url . '/assets/frontend/images/defaults/page-header-bg-purple.jpg',
        'page_header_bg_img_enable'        => 'on',
        'page_header_bg_img_inherit'       => true,
        'page_header_bg_img_position'      => 'center center',
        'page_header_background_size'      => 'cover',
        'page_header_bg_fixed'             => '',
        'page_header_bg_repeat'            => 'no-repeat',
        'page_header_font_h1'              => [
            'font-family'    => $secondary['font-family'],
            'variant'        => 'regular',
            'font-size'      => '52px',
            'line-height'    => '1.5',
            'letter-spacing' => '0',
            'color'          => '#ffffff',
            'text-transform' => 'none',
            'variant'        => 'regular',
        ],

        'page_header_font_h3' => [
            'font-family'    => $secondary['font-family'],
            'variant'        => 'regular',
            'font-size'      => '24px',
            'line-height'    => '1.5',
            'letter-spacing' => '0',
            'color'          => '#ffffff',
            'text-transform' => 'none',
        ],

        'show_page_header_on_posts'         => true,
        'show_page_header_on_post_archives' => true,

        // Content
        'content-background-color' => '',

        // Single Post
        'single_post_site_container_width' => 900,
        'single_post_site_sidebar_width'   => 360,
        'single_post_style'                => 'single-post-classic',
        'single_post_image_captions'       => true,
        'single_post_layout'               => 'content-sidebar',
        'single_post_badges'               => [
            'taxonomy',
            'featured',
        ],
        'single_post_meta'           => [
            'date',
            'author',
            'comments',
            'categories',
            'tags',
            'source',
            'reading_time',
        ],
        'show_source'         => true,
        'show_author_details' => true,
        'post_auto_load_next' => false,

        // Social Sharing 
        'show_sharing_links'                 => true,
        'sharing_links_supported_post_types' => [
            'posts',
            'portfolio',
            'video',
        ],
        'sharing_links_style'      => 'simple',
        'sharing_links_location'   => 'after_content',
        'sharing_links_number'     => 'all',
        'sharing_links_show_empty' => false,
        'show_sharing_total'       => true,
        'sharing_links'            => [
            'facebook',
            'twitter',
            'gplus',
            'linkedin',
            'reddit',
            'whatsapp',
            'email',
        ],

        // Related Post
        'show_related_posts'    => true,
        'related_posts_modules' => [
            'taxonomy',
            'author',
        ],

        'related_posts_badges' => [
            'taxonomy',
            'featured',
            'ratings',
            'editors-pick',
        ],

        'related_posts_meta' => [
            'date',
            'author',
            'comments',
            'categories',
            'tags',
            'source',
            'views',
            'reading_time',
        ],

        'related_posts_tab_label'                 => esc_html__( 'Author Posts', 'energia' ),
        'related_posts_tab_label'                 => esc_html__( 'Related Posts', 'energia' ),
        'related_posts_author_tab_label'          => esc_html__( 'More Posts by [author]', 'energia' ),
        'related_posts_author_archive_link_label' => esc_html__( 'All posts by [author]', 'energia' ),
        'related_posts_style'                     => 6,
        'related_posts_number'                    => 2,
        'related_posts_columns'                   => 2,
        'related_posts_grid_gutter'               => [
            'left'   => '10px',
            'right'  => '10px',
            'bottom' => '20px',
        ],
        'related_posts_list_row_gap' => [
            'bottom' => '40px',
        ],

        'related_posts_show_image' => true,
        'related_posts_image_size' => [
            'width'  => 322,
            'height' => 193,
        ],
        'related_posts_image_size_full_width' => [
            'width'  => 450,
            'height' => 310,
        ],

        'single_post_show_image' => true,

        'single_post_image_size' => [
            'width'  => 875,
            'height' => 400,
        ],
        'single_post_image_size_full_width' => [
            'width'  => 1355,
            'height' => 700,
        ],

        // Post Archives
        'posts_layout'               => 'card-1',
        'posts_color'                => 'none',
        'content_archive_image_size' => [
            'width'  => 420,
            'height' => 300,
        ],
        'content_archive_image_size_full_width' => [
            'width'  => 600,
            'height' => 400,
        ],
        'content_archive_grid_gutter' => [
            'left'   => '10px',
            'right'  => '10px',
            'bottom' => '20px',
        ],

        'content_archive_list_row_gap' => [
            'bottom' => '40px',
        ],

        'content_archive_badges' => [
            'taxonomy',
            'featured',
            'ratings',
            'editors-pick',
        ],

        'content_archive_meta' => [
            'date',
            'author',
            'comments',
            'categories',
            'tags',
            'source',
            'views',
            'reading_time',
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
    ];

    return $defaults;
}

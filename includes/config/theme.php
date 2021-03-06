<?php
namespace Analytica;

/**
 * This file is a part of the analytica Framework core.
 * Please be cautious editing this file,
 *
 * @package analytica Framework
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

/**
 * Analytica_After_Setup_Theme initial setup
 */
class Theme {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'after_setup_theme', array( $this, 'setup_theme' ), 2 );
    }

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     */
    function setup_theme() {

        /**
         * Add support for widgets inside the customizer
         */
        add_theme_support( 'widget-customizer' );

        /**
         * Add custom headers
         */
        $defaults = array(
            'default-image'          => analytica_get_option( 'site-hero-background-image' ),
            'width'                  => 1200,
            'height'                 => 400,
            'flex-height'            => false,
            'flex-width'             => false,
            'uploads'                => true,
            'random-default'         => false,
            'header-text'            => true,
            'default-text-color'     => '',
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
        );

        add_theme_support( 'custom-header', $defaults );

        $defaults = array(
            'default-color'          => preg_replace( "/#[a-f0-9]{6}/i", "", analytica_get_option( 'site-background-color' ) ),
            'wp-head-callback'       => 'analytica_custom_background_callback',
        );

        add_theme_support( 'custom-background', $defaults );

        /**
         * Enable support for Post Formats
         */
        add_theme_support( 'post-formats', array( 'gallery', 'image', 'link', 'quote', 'video', 'audio', 'status', 'aside',) );

        // Turn on HTML5, responsive viewport
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

        // Custom Site Logo
        add_theme_support( 'site-logo', array(
            'header-text' => array(
                'site-title',
                'tagline',
            ),
            'size' => 'medium',
        ) );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // Add theme support for Custom Logo.
        add_theme_support(
            'custom-logo', array(
                'width'       => 180,
                'height'      => 60,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        // Customize Selective Refresh Widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        $font_base = analytica_get_option( 'font-base' );
        $font_secondary = analytica_get_option( 'font-secondary-base' );
        $accent_color = analytica_get_option( 'site-accent-color' );
        $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
        $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

		/**
		 * Gutenberg support
		 */
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-color-palette', [
			array(
				'name' => __( 'Black', 'analytica' ),
				'slug' => 'black',
				'color' => '#000000',
			),
			array(
				'name' => __( 'White', 'analytica' ),
				'slug' => 'white',
				'color' => '#ffffff',
			),
			array(
				'name' => __( 'Base text color', 'analytica' ),
				'slug' => 'font-base-color',
				'color' => $font_base_color,
			),
			array(
				'name' => __( 'Secondary text color', 'analytica' ),
				'slug' => 'font-secondary-color',
				'color' => $font_secondary_color,
			),
			array(
				'name' => __( 'Accent color', 'analytica' ),
				'slug' => 'accent-color',
				'color' => $accent_color
			),
		]);

        /**
         * Theme specific features
         */

		add_theme_support( 'analytica-browser-theme-color' );
        add_theme_support( 'analytica-responsive-viewport' );
        add_theme_support( 'analytica-breadcrumbs' );

        // Maybe add support for structural wraps
        if ( ! current_theme_supports( 'analytica-structural-wraps' ) ) {
            add_theme_support( 'analytica-structural-wraps', array( 'site-header', 'site-hero', 'site-inner', 'site-content', 'menu-primary', 'menu-secondary', 'site-footer' ) );
        }

        /**
         * Maybe add support for sidebars
         */
        if ( ! current_theme_supports( 'analytica-sidebars' ) ) {

            $sidebars = array(
                'sidebar'       => array(
                    'name'          => esc_html__( 'Primary Widget Area', 'analytica' ),
                    'description'   => esc_html__( 'This is the primary sidebar.', 'analytica' ),
                ),
                'secondary-alt'       => array(
                    'name'          => esc_html__( 'Secondary Widget Area', 'analytica' ),
                    'description'   => esc_html__( 'This is the secondary sidebar if you are using a two or three column page layout option.', 'analytica' ),
                ),
                'after-entry'   => array(
                    'name'          => esc_html__( 'After Entry', 'analytica' ),
                    'description'   => esc_html__( 'This is the content widget area. Displayed after the post content', 'analytica' ),
                ),
            );

            add_theme_support( 'analytica-sidebars', $sidebars );
        }

         // Maybe add support for menus
        if ( ! current_theme_supports( 'analytica-menus' ) ) {
            add_theme_support( 'analytica-menus', array(
                'primary'   		=> esc_html__( 'Primary Navigation', 'analytica' ),
            ) );
        }

        /**
         * Customize image sizes
         */
        set_post_thumbnail_size( 140, 140, true );

        /**
         * Add add image size
         */
        add_image_size( 'blog-featured', analytica_get_option( 'site-content-width' ), 504, true );

        /**
         * Post type support for features.
         */
        $post_types = [
            'post',
            'page',
        ];

        $site_sidebars = analytica_get_option( 'site-sidebar-supported' ) ? analytica_get_option( 'site-sidebar-supported' ) : [];

        foreach ( $post_types as $post_type ) {

            if ( in_array( $post_type, $site_sidebars ) ) {
                $supported[$post_type][] = 'analytica-layouts';
            }

            add_post_type_support( $post_type, $supported[$post_type] );
        }

        /**
         * Content Width
         */
        if ( ! isset( $content_width ) ) {
            $content_width = apply_filters( 'analytica_content_width', analytica_get_option( 'site-content-width' ) );
        }

        /**
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        $dir_name    = ( SCRIPT_DEBUG ) ? 'unminified' : 'minified';
        $file_prefix = ( SCRIPT_DEBUG ) ? '' : '.min';
        add_editor_style( 'assets/frontend/css/' . $dir_name . '/analytica-editor-style' . $file_prefix . '.css' );

        if ( apply_filters( 'analytica_fullwidth_oembed', true ) ) {
            // Filters the oEmbed process to run the responsive_oembed_wrapper() function.
            add_filter( 'embed_oembed_html', array( $this, 'responsive_oembed_wrapper' ), 10, 3 );
            add_filter( 'oembed_result', array( $this, 'responsive_oembed_wrapper' ), 10, 3 );
        }

        /**
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
        load_theme_textdomain( 'analytica', analytica()->theme_dir . '/languages' );
    }

    /**
     * Adds a responsive embed wrapper around oEmbed content
     *
     * @param  string $html The oEmbed markup.
     * @param  string $url The URL being embedded.
     * @param  array  $attr An array of attributes.
     *
     * @return string       Updated embed markup.
     */
    function responsive_oembed_wrapper( $html, $url, $attr ) {

        $add_analytica_oembed_wrapper = apply_filters( 'analytica_responsive_oembed_wrapper_enable', true );

        $allowed_providers = apply_filters(
            'analytica_allowed_fullwidth_oembed_providers', array(
                'vimeo.com',
                'youtube.com',
                'youtu.be',
                'wistia.com',
                'wistia.net',
            )
        );

        if ( $this->strposa( $url, $allowed_providers ) ) {
            if ( $add_analytica_oembed_wrapper ) {
                $html = ( '' !== $html ) ? '<div class="analytica-oembed-container">' . $html . '</div>' : '';
            }
        }

        return $html;
    }

    /**
     * Strpos over an array.
     *
     * @since  1.0.0
     * @param  String  $haystack The string to search in.
     * @param  Array   $needles  Array of needles to be passed to strpos().
     * @param  integer $offset   If specified, search will start this number of characters counted from the beginning of the string. If the offset is negative, the search will start this number of characters counted from the end of the string.
     *
     * @return bool            True if haystack if part of any of the $needles.
     */
    function strposa( $haystack, $needles, $offset = 0 ) {

        if ( ! is_array( $needles ) ) {
            $needles = array( $needles );
        }

        foreach ( $needles as $query ) {

            if ( strpos( $haystack, $query, $offset ) !== false ) {
                // stop on first true result.
                return true;
            }
        }

        return false;
    }
}

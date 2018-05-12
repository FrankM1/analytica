<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Radium\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     http://qazana.net/
 */
namespace Analytica;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Frontend {

    /**
     * Class styles.
     *
     * @access public
     * @var $styles Enqueued styles.
     */
    public static $styles;

    /**
     * Class scripts.
     *
     * @access public
     * @var $scripts Enqueued scripts.
     */
    public static $scripts;

    public function __construct() {
        $this->framework = analytica();
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 5 );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'analytica_get_fonts', array( $this, 'add_fonts' ), 1 );
    }

    /**
     * Add front end libary scripts
     *
     * @since 1.0.0
     */
    function register_scripts() {

        // detect if in developer mode and load appropriate files
        if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) :

            $js_suffix = '.js';
            $version = time();

            else :

            $js_suffix = '.min.js';
            $version = $this->framework->theme_version;

        endif;

    }

    /**
     * Add front end scripts
     *
     * @since 1.0.0
     */
    function enqueue_scripts() {

        // detect if in developer mode and load appropriate files
        if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) :
            $js_suffix = '.js';
            $version = time();
        else :
            $js_suffix = '.min.js';
            $version = $this->framework->theme_version;
        endif;

        // The analytica_globals object contains information and settings about the framework
        $json_data = [
            'break_point' => analytica_header_break_point(),                         // Header Break Point.
            'i18n'        => [
            ],
        ]; // create globals for front-end AJAX calls;

        $dependencies = [
        ];

        wp_register_script(
            'analytica-frontend',
            $this->framework->theme_url . '/assets/frontend/js/main' . $js_suffix,
            $dependencies,
            $version,
            true
        );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        $json_data = apply_filters( 'analytica-theme-plugin-json-data', $json_data );

        wp_localize_script( 'analytica-frontend', 'analytica', $json_data );

        wp_enqueue_script( 'analytica-frontend' );
    }

    /**
     * Add front end scripts
     *
     * @since 1.0.0
     */
    function enqueue_styles() {

        // detect if in developer mode and load appropriate files
        if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) :

            $css_suffix = '.css';
            $version = time();

        else :

            $css_suffix = '.min.css';
            $version = $this->framework->theme_version;

        endif;

        wp_enqueue_style( 'analytica-frontend', $this->framework->theme_url . '/assets/frontend/css/style' . $css_suffix, '', $version, 'all' );

        $this->parse_global_css_code();

        // Fonts - Render Fonts.
        Fonts::render_fonts();
    }

    protected function parse_global_css_code() {
        $global_css_file = new Global_CSS_File();
        $global_css_file->enqueue();
    }

    /**
     * Add Fonts
     */
    public function add_fonts() {
        Fonts::add_font( analytica_get_option( 'body-font-family' ), analytica_get_option( 'body-font-weight' ) );
        Fonts::add_font( analytica_get_option( 'headings-font-family' ), analytica_get_option( 'headings-font-weight' ) );
    }

}

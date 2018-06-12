<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
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
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 5 );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_customizer_styles' ], 99 );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
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
            $version = analytica()->theme_version;

        endif;

        wp_register_script(
            'jquery-smartresize',
            analytica()->theme_url . '/assets/frontend/js/vendor/smartresize.js',
            ['jquery'],
            $version,
            true
        );

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
            $version = analytica()->theme_version;
        endif;

        // The analytica_globals object contains information and settings about the framework
        $json_data = [
            'i18n'        => [
            ],
        ]; // create globals for front-end AJAX calls;

        $dependencies = [
            'jquery-smartresize'
        ];

        wp_register_script(
            'analytica-frontend',
            analytica()->theme_url . '/assets/frontend/js/main' . $js_suffix,
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
            $version = analytica()->theme_version;

        endif;

        wp_enqueue_style( 'analytica-frontend', analytica()->theme_url . '/assets/frontend/css/style' . $css_suffix, '', $version, 'all' );
    }

    public function enqueue_customizer_styles() {
        $global_css_file = new Global_CSS_File();
        $global_css_file->enqueue();
    }

}

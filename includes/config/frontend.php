<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Radium\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     http://radiumthemes.com/
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
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );

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

        wp_register_script(
            'modernizr-custom',
            $this->framework->theme_url . '/assets/frontend/js/vendor/modernizr-custom.js',
            [],
            $version,
            false
        );

        wp_register_script(
            'flexibility',
            $this->framework->theme_url . '/assets/vendor/js/flexibility.js',
            [],
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
            $version = $this->framework->theme_version;
        endif;

        // The analytica_globals object contains information and settings about the framework
        $json_data = [
            'ajaxurl'                                 => admin_url( 'admin-ajax.php' ),
            'js_dir'                                  => $this->framework->theme_url . '/assets/frontend/js/',
            'rtl'                                     => false,
            'theme_url'                               => get_stylesheet_directory_uri(),
            'i18n' => [
                'no_more_posts'                           => esc_html__( 'No more posts', 'analytica' ),
                'ajax_error_quick_view'                   => esc_html__( 'Sorry, unable to load this product. Redirecting...', 'analytica' ),
            ],
        ]; // create globals for front-end AJAX calls;

        $dependencies = [
        ];

        wp_register_script(
            'analytica-frontend',
            $this->framework->theme_url . '/assets/frontend/js/ext-general' . $js_suffix,
            $dependencies,
            $version,
            true
        );


        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        $json_data = apply_filters( 'radium-theme-plugin-json-data', $json_data );

        wp_localize_script( 'analytica-frontend', 'analytica_globals', $json_data );

        wp_enqueue_script( 'analytica-frontend' );


        $analytica_enqueue = apply_filters( 'analytica_enqueue_theme_assets', true );

        if ( ! $analytica_enqueue ) {
            return;
        }

        /* Directory and Extension */
        $file_prefix = ( SCRIPT_DEBUG ) ? '' : '.min';
        $dir_name    = ( SCRIPT_DEBUG ) ? 'unminified' : 'minified';

        $js_uri  = analytica()->theme_url . '/assets/frontend/js/' . $dir_name . '/';
        $css_uri = analytica()->theme_url . '/assets/frontend/css/' . $dir_name . '/';

        // All assets.
        $all_assets = self::theme_assets();
        $styles     = $all_assets['css'];
        $scripts    = $all_assets['js'];

        if ( is_array( $styles ) && ! empty( $styles ) ) {
            // Register & Enqueue Styles.
            foreach ( $styles as $key => $style ) {

                // Generate CSS URL.
                $css_file = $css_uri . $style . $file_prefix . '.css';

                // Register.
                wp_register_style( $key, $css_file, array(), analytica()->theme_version, 'all' );

                // Enqueue.
                wp_enqueue_style( $key );

                // RTL support.
                wp_style_add_data( $key, 'rtl', 'replace' );
            }
        }

        if ( is_array( $scripts ) && ! empty( $scripts ) ) {
            // Register & Enqueue Scripts.
            foreach ( $scripts as $key => $script ) {

                // Register.
                wp_register_script( $key, $js_uri . $script . $file_prefix . '.js', array(), analytica()->theme_version, true );

                // Enqueue.
                wp_enqueue_script( $key );
            }
        }

        // Fonts - Render Fonts.
        Fonts::render_fonts();

        /**
         * Inline styles
         */
        wp_add_inline_style( 'analytica-theme-css', Dynamic_CSS::return_output() );
        wp_add_inline_style( 'analytica-theme-css', Dynamic_CSS::return_meta_output( true ) );

        $analytica_localize = array(
            'break_point' => analytica_header_break_point(),    // Header Break Point.
        );

        wp_localize_script( 'analytica-theme-js', 'analytica', apply_filters( 'analytica_theme_js_localize', $analytica_localize ) );

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

        wp_enqueue_style( 'analytica-frontend',   $this->framework->theme_url . '/assets/frontend/css/frontend' . $css_suffix, ['font-awesome'], $version, 'all' );

        $this->parse_global_css_code();

        $analytica_enqueue = apply_filters( 'analytica_enqueue_theme_assets', true );

        if ( ! $analytica_enqueue ) {
            return;
        }

        /* Directory and Extension */
        $file_prefix = ( SCRIPT_DEBUG ) ? '' : '.min';
        $dir_name    = ( SCRIPT_DEBUG ) ? 'unminified' : 'minified';

        $js_uri  = analytica()->theme_url . '/assets/frontend/js/' . $dir_name . '/';
        $css_uri = analytica()->theme_url . '/assets/frontend/css/' . $dir_name . '/';

        // All assets.
        $all_assets = self::theme_assets();
        $styles     = $all_assets['css'];
        $scripts    = $all_assets['js'];

        if ( is_array( $styles ) && ! empty( $styles ) ) {
            // Register & Enqueue Styles.
            foreach ( $styles as $key => $style ) {

                // Generate CSS URL.
                $css_file = $css_uri . $style . $file_prefix . '.css';

                // Register.
                wp_register_style( $key, $css_file, array(), analytica()->theme_version, 'all' );

                // Enqueue.
                wp_enqueue_style( $key );

                // RTL support.
                wp_style_add_data( $key, 'rtl', 'replace' );
            }
        }

        if ( is_array( $scripts ) && ! empty( $scripts ) ) {
            // Register & Enqueue Scripts.
            foreach ( $scripts as $key => $script ) {

                // Register.
                wp_register_script( $key, $js_uri . $script . $file_prefix . '.js', array(), analytica()->theme_version, true );

                // Enqueue.
                wp_enqueue_script( $key );
            }
        }

        // Fonts - Render Fonts.
        Fonts::render_fonts();

        /**
         * Inline styles
         */
        wp_add_inline_style( 'analytica-theme-css', Dynamic_CSS::return_output() );
        wp_add_inline_style( 'analytica-theme-css', Dynamic_CSS::return_meta_output( true ) );

        $analytica_localize = array(
            'break_point' => analytica_header_break_point(),    // Header Break Point.
        );

        wp_localize_script( 'analytica-theme-js', 'analytica', apply_filters( 'analytica_theme_js_localize', $analytica_localize ) );

    }

    protected function parse_global_css_code() {
        $global_css_file = new Global_CSS_File();
        $global_css_file->enqueue();
    }


 
    /**
     * List of all assets.
     *
     * @return array assets array.
     */
    public static function theme_assets() {

        $default_assets = array(

            // handle => location ( in /assets/js/ ) ( without .js ext).
            'js'  => array(
                'analytica-theme-js' => 'style',
            ),

            // handle => location ( in /assets/css/ ) ( without .css ext).
            'css' => array(
                'analytica-theme-css' => 'style',
            ),
        );

        return apply_filters( 'analytica_theme_assets', $default_assets );
    }

    /**
     * Add Fonts
     */
    public function add_fonts() {

        $font_family = analytica_get_option( 'body-font-family' );
        $font_weight = analytica_get_option( 'body-font-weight' );

        Fonts::add_font( $font_family, $font_weight );

        // Render headings font.
        $font_family = analytica_get_option( 'headings-font-family' );
        $font_weight = analytica_get_option( 'headings-font-weight' );

        Fonts::add_font( $font_family, $font_weight );
    }

    /**
     * Trim CSS
     *
     * @since 1.0.0
     * @param string $css CSS content to trim.
     * @return string
     */
    static public function trim_css( $css = '' ) {

        // Trim white space for faster page loading.
        if ( ! empty( $css ) ) {
            $css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
            $css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
            $css = str_replace( ', ', ',', $css );
        }

        return $css;
    }

}

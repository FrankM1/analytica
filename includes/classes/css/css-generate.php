<?php
namespace Analytica;
/**
 * Header Composer Core - A WordPress theme development framework.
 *
 * This file is a part of the Header Composer Core.
 * Please be cautious editing this file.
 * Modifying the contents of this file can be a poor life decision if you don't know what you're doing.
 *
 * NOTE: Theme data (options, global variables etc ) can be accessed anywhere in the theme by calling  <?php $core = analytica(); ?>
 *
 * @category Header Composer
 * @package  Header Composer WP
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class CSS_Generate {

    public $fonts;

    public function __construct() {

        // Create the css directory if it's not exist
		$wp_upload_dir = wp_upload_dir( null, false );

		$css_path = $wp_upload_dir['basedir'] . CSS_File::FILE_BASE_DIR;

		if ( ! is_dir( $css_path ) ) {
			wp_mkdir_p( $css_path );
		}

        add_action( 'analytica/global-css-file/parse',      [ $this, 'add_css' ] );

        add_action( 'analytica_after_theme_is_activated',   [ $this, 'update_css' ], 90 );
        add_action( 'customize_save_after',                 [ $this, 'update_css' ], 100 );
		add_action( 'analytica_style_switcher_import_after',  [ $this, 'update_css' ], 100 );
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
    }

    public function add_css( $global_css_file ) {
        $global_css_file->add_css( $this->generated_css() );
        $global_css_file->fonts = $this->fonts;
    }

    public function update_css() {
        $global_css_file = new Global_CSS_File();
        $global_css_file->update();
    }

    public function regenerate_css() {
        $this->update_css();
    }

	public function clear_cache() {
		$errors = [];

		// Delete post meta
		global $wpdb;

		$wpdb->delete( $wpdb->options, [ 'option_name' => Global_CSS_File::META_KEY ] );

		// Delete files
		$wp_upload_dir = wp_upload_dir( null, false );

		$path = sprintf( '%s%s%s*', $wp_upload_dir['basedir'], CSS_File::FILE_BASE_DIR, '/' );

		foreach ( glob( $path ) as $file ) {
			$deleted = unlink( $file );

			if ( ! $deleted ) {
				$errors['files'] = esc_html__( 'Cannot delete files cache', 'analytica' );
			}
		}

		return $errors;
    }

    /**
     * Generate theme css file
     *
     * @return string css
     */
    function generated_css() {

        $output_styles = null;

        if ( class_exists( 'Kirki' ) ) {
            // Echo the styles.
            $configs = \Kirki::$config;

            foreach ( $configs as $config_id => $args ) {

                $styles = \Kirki_Modules_CSS::loop_controls( $config_id );
                $styles = apply_filters( 'kirki/' . $config_id . '/dynamic_css', $styles );

                // Some people put weird stuff in their CSS, KSES tends to be greedy.
                $styles = str_replace( '<=', '&lt;=', $styles );

                $styles = wp_kses_post( $styles );

                // @codingStandardsIgnoreStart

                // Why both KSES and strip_tags? Because we just added some '>'.
                // kses replaces lone '>' with &gt;.
                $output_styles = strip_tags( str_replace( '&gt;', '>', $styles ) );
                // @codingStandardsIgnoreStop
            }
        }

        $output_styles .= $this->dynamic_css();

        return $output_styles;
    }

    /**
     * Returns the dynamic CSS.
     * If possible, it also caches the CSS using WordPress transients
     *
     * @since 1.4.0
     *
     * @return  string  the dynamically-generated CSS.
     */
    function dynamic_css() {

        /**
         * Append the user-entered dynamic CSS
         */
        $dynamic_css = strip_tags( wp_get_custom_css() );

        /**
         * If we're compiling to file, then do not use transients for caching.
         */
        /**
         * Check if we're using file mode or inline mode.
         * This simply checks the dynamic_css_compiler options.
         */
        $dynamic_css = apply_filters( 'analytica_dynamic_css_cached', $dynamic_css );

        return $dynamic_css;
    }
}


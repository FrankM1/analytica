<?php
namespace Analytica;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Analytica autoloader.
 *
 * Analytica autoloader handler class is responsible for loading different
 * classes needed to run the theme.
 *
 * @since 1.0.7
 */
class Autoloader {

	/**
	 * Classes map.
	 *
	 * Maps Analytica classes to file names.
	 *
	 * @since 1.0.7
	 * @access private
	 * @static
	 *
	 * @var array Classes used by Analytica.
	 */
	private static $classes_map = [
		'Breadcrumb' => 'includes/classes/nav/breadcrumb.php',
        'CSS_File' => 'includes/classes/css/css-base.php' ,
        'Global_CSS_File' => 'includes/classes/css/global-css-file.php' ,
		'CSS_Generate' => 'includes/classes/css/css-generate.php',
		'Customizer' => 'includes/classes/customizer/customizer.php',
		'Metabox\Actions' =>  'includes/classes/metaboxes/actions.php',
		'Options' => 'includes/config/options.php',
        'Theme' => 'includes/config/theme.php',
        'Frontend' => 'includes/config/frontend.php',
        'Dynamic_CSS' => 'includes/config/skin-css.php',
        'MetaBoxes\Options' => 'includes/config/metabox/meta-boxes.php',
		'Extensions\Page_Builder' => 'includes/extensions/page-builder.php',
		'Extensions\Page_Builder\Beaver_Builder' => 'includes/extensions/page-builder-beaver-builder.php',
        'Extensions\Page_Builder\Elementor_Pro' => 'includes/extensions/page-builder-gutenberg.php',
		'Extensions\Page_Builder\Elementor' => 'includes/extensions/page-builder-elementor.php',
		'Extensions\Page_Builder\Gutenberg' => 'includes/extensions/page-builder-elementor-pro.php',
		'Extensions\Page_Builder\Qazana' => 'includes/extensions/page-builder-qazana.php',
        'Extensions\Page_Builder\Visual_Composer' => 'includes/extensions/page-builder-visual-composer.php',
	];

	/**
	 * Run autoloader.
	 *
	 * Register a function as `__autoload()` implementation.
	 *
	 * @since 1.0.7
	 * @access public
	 * @static
	 */
	public static function init() {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	/**
	 * Load class.
	 *
	 * For a given class name, require the class file.
	 *
	 * @since 1.0.7
	 * @access private
	 * @static
	 *
	 * @param string $relative_class_name Class name.
	 */
	private static function load_class( $relative_class_name ) {
		if ( isset( self::$classes_map[ $relative_class_name ] ) ) {
			$filename = get_theme_file_path( self::$classes_map[ $relative_class_name ] );
		} else {
			$filename = strtolower(
				preg_replace(
					[ '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$relative_class_name
				)
			);

			$filename = get_theme_file_path( $filename . '.php' );
		}

		if ( is_readable( $filename ) ) {
			require $filename;
		}
	}

	/**
	 * Autoload.
	 *
	 * For a given class, check if it exist and load it.
	 *
	 * @since 1.0.7
	 * @access private
	 * @static
	 *
	 * @param string $class Class name.
	 */
	private static function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ . '\\' ) ) {
			return;
		}

		$relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class );

		$final_class_name = __NAMESPACE__ . '\\' . $relative_class_name;

		if ( ! class_exists( $final_class_name ) ) {
			self::load_class( $relative_class_name );
		}
	}
}

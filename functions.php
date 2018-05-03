<?php
/**
 * Analytica functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Analytica
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'ANALYTICA_THEME_VERSION', '1.3.1' );
define( 'ANALYTICA_THEME_SETTINGS', 'analytica-settings' );
define( 'ANALYTICA_THEME_DIR', get_template_directory() . '/' );
define( 'ANALYTICA_THEME_URI', get_template_directory_uri() . '/' );

/**
 * Load theme hooks
 */
require_once ANALYTICA_THEME_DIR . 'includes/core/class-analytica-theme-options.php';
require_once ANALYTICA_THEME_DIR . 'includes/core/class-theme-strings.php';

/**
 * Fonts Files
 */
require_once ANALYTICA_THEME_DIR . 'includes/customizer/class-analytica-font-families.php';
if ( is_admin() ) {
	require_once ANALYTICA_THEME_DIR . 'includes/customizer/class-analytica-fonts-data.php';
}

require_once ANALYTICA_THEME_DIR . 'includes/customizer/class-analytica-fonts.php';

require_once ANALYTICA_THEME_DIR . 'includes/core/common-functions.php';
require_once ANALYTICA_THEME_DIR . 'includes/core/class-analytica-enqueue-scripts.php';
require_once ANALYTICA_THEME_DIR . 'includes/class-analytica-dynamic-css.php';

/**
 * Custom template tags for this theme.
 */
require_once ANALYTICA_THEME_DIR . 'includes/template-tags.php';

require_once ANALYTICA_THEME_DIR . 'includes/widgets.php';
require_once ANALYTICA_THEME_DIR . 'includes/core/theme-hooks.php';
require_once ANALYTICA_THEME_DIR . 'includes/admin-functions.php';
require_once ANALYTICA_THEME_DIR . 'includes/core/sidebar-manager.php';

/**
 * Markup Functions
 */
require_once ANALYTICA_THEME_DIR . 'includes/extras.php';
require_once ANALYTICA_THEME_DIR . 'includes/blog/blog-config.php';
require_once ANALYTICA_THEME_DIR . 'includes/blog/blog.php';
require_once ANALYTICA_THEME_DIR . 'includes/blog/single-blog.php';
/**
 * Markup Files
 */
require_once ANALYTICA_THEME_DIR . 'includes/template-parts.php';
require_once ANALYTICA_THEME_DIR . 'includes/class-analytica-loop.php';

/**
 * Functions and definitions.
 */
require_once ANALYTICA_THEME_DIR . 'includes/class-analytica-after-setup-theme.php';

// Required files.
require_once ANALYTICA_THEME_DIR . 'includes/core/class-analytica-admin-helper.php';

if ( is_admin() ) {

	/**
	 * Admin Menu Settings
	 */
	require_once ANALYTICA_THEME_DIR . 'includes/core/class-analytica-admin-settings.php';

	/**
	 * Metabox additions.
	 */
	require_once ANALYTICA_THEME_DIR . 'includes/metabox/class-analytica-meta-boxes.php';
}

require_once ANALYTICA_THEME_DIR . 'includes/metabox/class-analytica-meta-box-operations.php';


/**
 * Customizer additions.
 */
require_once ANALYTICA_THEME_DIR . 'includes/customizer/class-analytica-customizer.php';


/**
 * Compatibility
 */
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-jetpack.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/woocommerce/class-analytica-woocommerce.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/lifterlms/class-analytica-lifterlms.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/learndash/class-analytica-learndash.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-beaver-builder.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-bb-ultimate-addon.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-contact-form-7.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-visual-composer.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-site-origin.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-gravity-forms.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-bne-flyout.php';
require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-ubermeu.php';

// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-elementor.php';
	require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-elementor-pro.php';
}

// Beaver Themer compatibility requires PHP 5.3 for anonymus functions.
if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	require_once ANALYTICA_THEME_DIR . 'includes/compatibility/class-analytica-beaver-themer.php';
}

/**
 * Load deprecated functions
 */
require_once ANALYTICA_THEME_DIR . 'includes/core/deprecated/deprecated-filters.php';
require_once ANALYTICA_THEME_DIR . 'includes/core/deprecated/deprecated-hooks.php';
require_once ANALYTICA_THEME_DIR . 'includes/core/deprecated/deprecated-functions.php';

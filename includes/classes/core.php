<?php

namespace Analytica;
/**
 * Analytica functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Analytica
 * @since 1.0.0
 */

use WP_Error;
use stdClass;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main Theme Framework Class
 *
 * @since 1.0.0
 */
class Core {

      /**
     * framework version, used for cache-busting of style and script file references.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $version = '1.0.6';

    /**
     * @var array Overloads get_option()
     */
    public $options = array();

    /** Radium *************************************************************/

    /**
     * @var analytica The one true instance
     */
    protected static $instance;

    /**
     * Arguments for later use
     *
     * @var $args
     *
     * @since 1.0.0
     */
    public $args = [];

    /**
     * [__construct description]
     */
    private function __construct() {}

    /**
     * Main radium Instance
     *
     * Please load it only one time
     * For this, we thank you
     *
     * Insures that only one instance of the analytica exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     *
     * @since  1.0.0
     *
     * @static var array $instance
     * @uses   analytica::setup_globals() Setup the globals needed
     * @uses   analytica::includes() Include the required files
     * @uses   analytica::setup_actions() Setup the hooks and actions
     * @see    analytica()
     * @return The one true analytica
     */
    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
            self::$instance->pre();
            self::$instance->setup_globals();
            self::$instance->includes();
            self::$instance->init();
        }

        return self::$instance;
    }

   /**
     * Run the analytica_pre Hook
     *
     * @since 1.0.0
     */
    public function pre() { do_action( 'analytica_pre_init', array( &$this ) ); }

     /**
     * Setup the default hooks and actions
     *
     * @since 1.0.0
     * @access private
     * @todo Not use analytica_is_deactivation()
     * @uses register_activation_hook() To register the activation hook
     * @uses register_deactivation_hook() To register the deactivation hook
     * @uses add_action() To add various actions
     */
    private function setup_actions() {

        // Add actions to plugin activation and deactivation hooks
        add_action( 'activate_'   . $this->theme_slug, 'analytica_activation' );
        add_action( 'deactivate_' . $this->theme_slug, 'analytica_deactivation' );

        // If theme is being deactivated, do not add any actions

        /** Run the analytica_pre_framework Hook */
        do_action( 'analytica_pre_framework' );

        do_action_ref_array( 'analytica_after_setup_actions', array( &$this ) );

        /** Run the analytica_init hook */
        do_action( 'analytica_init', array( &$this ) );

        /** Run the analytica_setup hook */
        do_action( 'analytica_setup', array( &$this ) );

    }

    /**
     * Set some smart defaults to class variables. Allow some of them to be
     * filtered to allow for early overriding.
     *
     * @since  1.0.0
     *
     * @access private
     * @uses   get_theme_file_path() To generate theme path
     * @uses   get_theme_file_path_uri() To generate bbPress theme url
     * @uses   apply_filters() calls various filters
     */
    public function setup_globals() {
        $this->theme            = wp_get_theme();         // Get Theme data (WP 3.4+)
        $this->theme_version    = $this->theme->version;  // Theme version

        // Setup some base path, name and URL information
        $this->theme_title = apply_filters( 'analytica_theme_title',      $this->theme->name );                          // or $this->theme->title
        $this->theme_slug  = apply_filters( 'analytica_theme_slug',       get_stylesheet() );
        $this->theme_dir   = apply_filters( 'analytica_theme_dir_path',   strtolower( get_template_directory() ) );
        $this->theme_url   = apply_filters( 'analytica_theme_dir_url',    strtolower( get_template_directory_uri() ) );

        // Setup theme Options name - it's not recommended that you change this, if you do you will looses theme option settings and you will need to resave them
        $this->option_name = $this->theme_slug . '_options';  // Theme_options name
        $this->options = get_option( $this->option_name );  // get theme options so we don't run it all the time
        $this->hero = new stdClass();  // get theme options so we don't run it all the time
    }

    /**
     * Initialize classes
     *
     * @return void
     */
    public function init() {
        $this->css_generator                           = new CSS_Generate();
        $this->customizer                              = new Customizer();
        $this->dynamic_css                             = new Dynamic_CSS();
        $this->frontend                                = new Frontend();
		$this->markup                                  = new Markup();
		if ( is_admin() ) {
			$this->metaboxes                           = new MetaBoxes();
		}
        $this->metabox_actions                         = new Metabox\Actions();
        $this->options_instance                        = new Options();
        $this->schema                                  = new SchemaORG();
		$this->theme                                   = new Theme();

        $this->loop_base                               = new Content\Loop\Base();
        $this->loop_archives                           = new Content\Loop\Archives();
        $this->loop_post                               = new Content\Loop\Post();
        $this->loop_404                                = new Content\Loop\Page_Not_Found();
        $this->loop_page                               = new Content\Loop\Page();

		$this->extensions_page_builders                = new Extensions\Page_Builder();
		$this->extensions_page_builders_beaver_builder = new Extensions\Page_Builder\Beaver_Builder();
		$this->extensions_page_builders_gutenberg 	   = new Extensions\Page_Builder\Gutenberg();
        $this->extensions_page_builders_qazana         = new Extensions\Page_Builder\Qazana();
        $this->extensions_page_builders_elementor      = new Extensions\Page_Builder\Elementor();
        $this->extensions_page_builders_elementorpro   = new Extensions\Page_Builder\Elementor_Pro();
    }

    /**
     * Loads all the framework files and features.
     *
     * The analytica_pre_framework action hook is called before any of the files are
     * required().
     *
     * All files can be overriden from a child theme by copying the file into the child theme while maintaining the same path structure
     *
     * @since 1.0.0
     */
    public function includes() {

        // Base Files
        $this->_include_config();
        $this->_include_classes();
        $this->_include_function();

        $this->_include_options();
        $this->_include_admin();
        $this->_include_structure_base();
        // End base files

        $this->_include_structure_post_archives();
        $this->_include_menus();
        $this->_include_extensions();
    }

    function _include_config() {
        require_once get_theme_file_path( '/includes/config/options.php' );
        require_once get_theme_file_path( '/includes/config/theme.php' );
        require_once get_theme_file_path( '/includes/config/frontend.php' );
        require_once get_theme_file_path( '/includes/config/skin-css.php' );

        if ( is_admin() ) {
            require_once get_theme_file_path( '/includes/config/metabox/meta-boxes.php' );
        }

        require_once get_theme_file_path( '/includes/config/strings.php' );
    }

    function _include_classes() {
        require_once get_theme_file_path( '/includes/classes/nav/breadcrumb.php' );
        require_once get_theme_file_path( '/includes/classes/css/css-base.php' );
        require_once get_theme_file_path( '/includes/classes/css/global-css-file.php' );
        require_once get_theme_file_path( '/includes/classes/css/css-generate.php' );

        require_once get_theme_file_path( '/includes/classes/customizer/customizer.php' );
        require_once get_theme_file_path( '/includes/classes/customizer/controls.php' );
        require_once get_theme_file_path( '/includes/classes/metaboxes/actions.php' );
    }

    function _include_function() {
        require_once get_theme_file_path( '/includes/functions/common.php' );
        require_once get_theme_file_path( '/includes/functions/options.php' );
        require_once get_theme_file_path( '/includes/functions/markup.php' );
        require_once get_theme_file_path( '/includes/functions/formatting.php' );
        require_once get_theme_file_path( '/includes/functions/conditionals.php' );
        require_once get_theme_file_path( '/includes/functions/menu.php' );
        require_once get_theme_file_path( '/includes/functions/layout.php' );
        require_once get_theme_file_path( '/includes/functions/breadcrumb.php' );

        require_once get_theme_file_path( '/includes/structure/general/general-header.php' );
        require_once get_theme_file_path( '/includes/structure/general/css-classes.php' );
        require_once get_theme_file_path( '/includes/structure/general/template-tags.php' );

        require_once get_theme_file_path( '/includes/functions/widgets.php' );

        // Used by both front and admin
        require_once get_theme_file_path( '/includes/functions/conditionals.php' );
    }

    function _include_options() {

        require_once get_theme_file_path( '/includes/config/customizer/01-general.php' );
        require_once get_theme_file_path( '/includes/config/customizer/02-site-header.php' );
        require_once get_theme_file_path( '/includes/config/customizer/03-site-hero.php' );
        require_once get_theme_file_path( '/includes/config/customizer/04-site-footer.php' );
        require_once get_theme_file_path( '/includes/config/customizer/05-typography.php' );
        require_once get_theme_file_path( '/includes/config/customizer/06-blog.php' );
        require_once get_theme_file_path( '/includes/config/customizer/07-blog-single.php' );
        require_once get_theme_file_path( '/includes/config/customizer/08-breadcrumbs.php' );
        require_once get_theme_file_path( '/includes/config/customizer/90-utilities.php' );
    }

    function _include_admin() {
        if ( ! is_admin() ) {
            return;
        }
        require_once get_template_directory() . '/includes/admin/about-page.php';
    }

    function _include_structure_base() {
        require_once get_theme_file_path( '/includes/structure/general/site-markup.php' );
        require_once get_theme_file_path( '/includes/structure/general/site-schema.php' );
        require_once get_theme_file_path( '/includes/structure/general/site-loop.php' );
        require_once get_theme_file_path( '/includes/structure/general/site-footer.php' );
        require_once get_theme_file_path( '/includes/structure/general/site-header.php' );
        require_once get_theme_file_path( '/includes/structure/general/site-layout.php' );
        require_once get_theme_file_path( '/includes/structure/general/site-sidebar.php' );
        require_once get_theme_file_path( '/includes/structure/general/site-hero.php' );
        require_once get_theme_file_path( '/includes/structure/general/site-comments.php' );
    }

    function _include_menus() {
        require_once get_theme_file_path( '/includes/classes/nav/menu.php' );
        require_once get_theme_file_path( '/includes/functions/menu.php' );
        require_once get_theme_file_path( '/includes/structure/navigation/menu.php' );
    }

    function _include_structure_post_archives() {
        require_once get_theme_file_path( '/includes/structure/archives/blog/functions.php' );
        require_once get_theme_file_path( '/includes/structure/archives/blog/actions.php' );
        require_once get_theme_file_path( '/includes/structure/archives/blog/loop.php' );

        require_once get_theme_file_path( '/includes/structure/single/404/loop.php' );

        require_once get_theme_file_path( '/includes/structure/single/page/loop.php' );

        require_once get_theme_file_path( '/includes/structure/single/post/loop.php' );
        require_once get_theme_file_path( '/includes/structure/single/post/related-posts.php' );
     }

    function _include_extensions() {
		require_once get_theme_file_path( '/includes/extensions/page-builder.php' );
		require_once get_theme_file_path( '/includes/extensions/page-builder-beaver-builder.php' );
        require_once get_theme_file_path( '/includes/extensions/page-builder-gutenberg.php' );
		require_once get_theme_file_path( '/includes/extensions/page-builder-elementor.php' );
		require_once get_theme_file_path( '/includes/extensions/page-builder-elementor-pro.php' );
		require_once get_theme_file_path( '/includes/extensions/page-builder-qazana.php' );
        require_once get_theme_file_path( '/includes/extensions/page-builder-visual-composer.php' );
    }

}

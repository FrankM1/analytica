<?php
/**
 * Elementor Compatibility File.
 *
 * @package Analytica
 */

namespace Elementor;

// If plugin - 'Elementor' not exist then return.
if ( ! class_exists( '\Elementor\Plugin' ) || ! class_exists( 'ElementorPro\Modules\ThemeBuilder\Module' ) ) {
	return;
}

namespace ElementorPro\Modules\ThemeBuilder\ThemeSupport;

use Elementor\TemplateLibrary\Source_Local;
use ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager;
use ElementorPro\Modules\ThemeBuilder\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Analytica Elementor Compatibility
 */
if ( ! class_exists( 'Analytica_Elementor_Pro' ) ) :

	/**
	 * Analytica Elementor Compatibility
	 *
	 * @since 1.2.7
	 */
	class Analytica_Elementor_Pro {

		/**
		 * Member Variable
		 *
		 * @var object instance
		 */
		private static $instance;

		/**
		 * Initiator
		 *
		 * @since 1.2.7
		 * @return object Class object.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.2.7
		 */
		public function __construct() {
			// Add locations.
			add_action( 'elementor/theme/register_locations', array( $this, 'register_locations' ) );

			// Override theme templates.
			add_action( 'analytica_header', array( $this, 'do_header' ), 0 );
			add_action( 'analytica_footer', array( $this, 'do_footer' ), 0 );
			add_action( 'analytica_template_parts_content_top', array( $this, 'do_template_parts' ), 0 );

			add_action( 'analytica_entry_content_404_page', array( $this, 'do_template_part_404' ), 0 );

			// Override post meta.
			add_action( 'wp', array( $this, 'override_meta' ), 0 );
		}

		/**
		 * Register Locations
		 *
		 * @since 1.2.7
		 * @param object $manager Location manager.
		 * @return void
		 */
		public function register_locations( $manager ) {
			$manager->register_all_core_location();
		}

		/**
		 * Template Parts Support
		 *
		 * @since 1.2.7
		 * @return void
		 */
		function do_template_parts() {
			// Is Archive?
			$did_location = Module::instance()->get_locations_manager()->do_location( 'archive' );
			if ( $did_location ) {
				// Search and default.
				remove_action( 'analytica_template_parts_content', array( \Analytica_Loop::get_instance(), 'template_parts_search' ) );
				remove_action( 'analytica_template_parts_content', array( \Analytica_Loop::get_instance(), 'template_parts_default' ) );

				// Remove pagination.
				remove_action( 'analytica_pagination', 'analytica_number_pagination' );
				remove_action( 'analytica_entry_after', 'analytica_single_post_navigation_markup' );

				// Content.
				remove_action( 'analytica_entry_content_single', 'analytica_entry_content_single_template' );
			}

			// IS Single?
			$did_location = Module::instance()->get_locations_manager()->do_location( 'single' );
			if ( $did_location ) {
				remove_action( 'analytica_template_parts_content', array( \Analytica_Loop::get_instance(), 'template_parts_page' ) );
				remove_action( 'analytica_template_parts_content', array( \Analytica_Loop::get_instance(), 'template_parts_post' ) );
				remove_action( 'analytica_template_parts_content', array( \Analytica_Loop::get_instance(), 'template_parts_comments' ), 15 );
			}
		}

		/**
		 * Override 404 page
		 *
		 * @since 1.2.7
		 * @return void
		 */
		function do_template_part_404() {
			if ( is_404() ) {

				// Is Single?
				$did_location = Module::instance()->get_locations_manager()->do_location( 'single' );
				if ( $did_location ) {
					remove_action( 'analytica_entry_content_404_page', 'analytica_entry_content_404_page_template' );
				}
			}
		}

		/**
		 * Override sidebar, title etc with post meta
		 *
		 * @since 1.2.7
		 * @return void
		 */
		function override_meta() {
			// Override post meta for single pages.
			$documents_single = Module::instance()->get_conditions_manager()->get_documents_for_location( 'single' );
			if ( $documents_single ) {
				foreach ( $documents_single as $document ) {
					$this->override_with_post_meta( $document->get_post()->ID );
				}
			}

			// Override post meta for archive pages.
			$documents_archive = Module::instance()->get_conditions_manager()->get_documents_for_location( 'archive' );
			if ( $documents_archive ) {
				foreach ( $documents_archive as $document ) {
					$this->override_with_post_meta( $document->get_post()->ID );
				}
			}
		}

		/**
		 * Override sidebar, title etc with post meta
		 *
		 * @since 1.2.7
		 * @param  integer $post_id  Post ID.
		 * @return void
		 */
		function override_with_post_meta( $post_id = 0 ) {
			// Override! Page Title.
			$title = get_post_meta( $post_id, 'site-post-title', true );
			if ( 'disabled' === $title ) {

				// Archive page.
				add_filter( 'analytica_the_title_enabled', '__return_false', 99 );

				// Single page.
				add_filter( 'analytica_the_title_enabled', '__return_false' );
				remove_action( 'analytica_archive_header', 'analytica_archive_page_info' );
			}

			// Override! Sidebar.
			$sidebar = get_post_meta( $post_id, 'site-sidebar-layout', true );
			if ( 'default' !== $sidebar ) {
				add_filter(
					'analytica_page_layout', function( $page_layout ) use ( $sidebar ) {
						return $sidebar;
					}
				);
			}

			// Override! Content Layout.
			$content_layout = get_post_meta( $post_id, 'site-content-layout', true );
			if ( 'default' !== $content_layout ) {
				add_filter(
					'analytica_get_content_layout', function( $layout ) use ( $content_layout ) {
						return $content_layout;
					}
				);
			}

			// Override! Footer Bar.
			$footer_layout = get_post_meta( $post_id, 'footer-sml-layout', true );
			if ( 'disabled' === $footer_layout ) {
				add_filter(
					'ast_footer_sml_layout', function( $is_footer ) {
						return 'disabled';
					}
				);
			}

			// Override! Footer Widgets.
			$footer_widgets = get_post_meta( $post_id, 'footer-adv-display', true );
			if ( 'disabled' === $footer_widgets ) {
				add_filter(
					'analytica_advanced_footer_disable', function() {
						return true;
					}
				);
			}

			// Override! Header.
			$main_header_display = get_post_meta( $post_id, 'ast-main-header-display', true );
			if ( 'disabled' === $main_header_display ) {
				remove_action( 'analytica_masthead', 'analytica_masthead_primary_template' );
				add_filter(
					'ast_main_header_display', function( $display_header ) {
						return 'disabled';
					}
				);
			}
		}

		/**
		 * Header Support
		 *
		 * @since 1.2.7
		 * @return void
		 */
		public function do_header() {
			$did_location = Module::instance()->get_locations_manager()->do_location( 'header' );
			if ( $did_location ) {
				remove_action( 'analytica_header', 'analytica_header_markup' );
			}
		}

		/**
		 * Footer Support
		 *
		 * @since 1.2.7
		 * @return void
		 */
		public function do_footer() {
			$did_location = Module::instance()->get_locations_manager()->do_location( 'footer' );
			if ( $did_location ) {
				remove_action( 'analytica_footer', 'analytica_footer_markup' );
			}
		}

	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Analytica_Elementor_Pro::get_instance();

endif;


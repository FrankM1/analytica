<?php
namespace Analytica\Extensions\Page_Builder;

/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @package  Radium\Extensions\Related-Posts
 * @subpackage  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

use Elementor\Plugin;
use ElementorPro\Modules\ThemeBuilder\Module;

/**
 * Elementor Pro Compatibility
 *
 * @since 1.0.0
 */
class Elementor_Pro {

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        if ( ! $this->is_builder_activated() ) {
            return;
        }

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
     * Check is elementor activated.
     *
     * @param int $id Post/Page Id.
     * @return boolean
     */
    function is_builder_activated( $retval = false ) {

        if ( analytica_detect_plugin( array( 'classes' => array( 'ElementorPro\Plugin' ) ) ) ) {
            $retval = true;
        }

        return $retval;
    }

    /**
     * Register Locations
     *
     * @since 1.0.0
     * @param object $manager Location manager.
     * @return void
     */
    public function register_locations( $manager ) {
        $manager->register_all_core_location();
    }

    /**
     * Template Parts Support
     *
     * @since 1.0.0
     * @return void
     */
    function do_template_parts() {
        // Is Archive?
        $did_location = Module::instance()->get_locations_manager()->do_location( 'archive' );
        if ( $did_location ) {
            // Search and default.
            remove_action( 'analytica_template_parts_content', array( analytica()->loop_archives, 'template_parts' ) );

            // Remove pagination.
            remove_action( 'analytica_pagination', array( analytica()->loop_archives, 'number_pagination' ) );
            remove_action( 'analytica_entry_after', array( analytica()->loop_post, 'navigation_markup' ) );

            // Content.
            remove_action( 'analytica_entry_content_single', array( analytica()->loop_post, 'analytica_entry_content_single_template' ) );
        }

        // IS Single?
        $did_location = Module::instance()->get_locations_manager()->do_location( 'single' );
        if ( $did_location ) {
            remove_action( 'analytica_template_parts_content', array( analytica()->loop_page, 'template_parts_page' ) );
            remove_action( 'analytica_template_parts_content', array( analytica()->loop_post, 'template_parts_post' ) );
            remove_action( 'analytica_template_parts_content', array( analytica()->loop_page, 'template_parts_comments' ), 15 );
            remove_action( 'analytica_template_parts_content', array( analytica()->loop_post, 'template_parts_comments' ), 15 );
        }
    }

    /**
     * Override 404 page
     *
     * @since 1.0.0
     * @return void
     */
    function do_template_part_404() {
        if ( is_404() ) {

            // Is Single?
            $did_location = Module::instance()->get_locations_manager()->do_location( 'single' );
            if ( $did_location ) {
                remove_action( 'analytica_entry_content_404_page', array( analytica()->loop_404, 'entry_content_404_page_template' ) );
            }
        }
    }

    /**
     * Override sidebar, title etc with post meta
     *
     * @since 1.0.0
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
     * @since 1.0.0
     * @param  integer $post_id  Post ID.
     * @return void
     */
    function override_with_post_meta( $post_id = 0 ) {
       
    }

    /**
     * Header Support
     *
     * @since 1.0.0
     * @return void
     */
    public function do_header() {
        $did_location = Module::instance()->get_locations_manager()->do_location( 'header' );
        if ( $did_location ) {
            add_filter( 'analytica_site_header_is_active', [ $this, 'site_header_is_active' ] );
        }
    }

    /**
     * Header Conditions
     *
     * @since 1.0.0
     * @return void
     */
    public function site_header_is_active( $retval ) {
        return false;
    }

    /**
     * Footer Support
     *
     * @since 1.0.0
     * @return void
     */
    public function do_footer() {
        $did_location = Module::instance()->get_locations_manager()->do_location( 'footer' );
        if ( $did_location ) {
            add_filter( 'analytica_site_footer_is_active', [ $this, 'site_footer_is_active' ] );
        }
    }

    /**
     * Header Conditions
     *
     * @since 1.0.0
     * @return void
     */
    public function site_footer_is_active( $retval ) {
        return false;
    }

}
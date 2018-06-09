<?php
/**
 * Radium Framework Core - A WordPress theme development framework.
 *
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file.
 * Modifying the contents of this file can be a poor life decision if you don't know what you're doing.
 *
 * NOTE: Theme data (options, global variables etc ) can be accessed anywhere in the theme by calling  <?php $framework = radium_framework(); ?>
 *
 * @category Radium\Framework
 * @package  Energia WP
 * @author   Franklin Gitonga
 * @link     https://radiumthemes.com/
 */
namespace Analytica\Content\Loop;

/**
 * Analytica Archives Loop
 *
 * @package Analytica
 * @since 1.0.0
 */
class Archives extends Base {

    /**
     * Constructor
     *
     * @since 1.0.0
     */
     public function __construct() {
        if ( analytica_is_post_archive_page() ) {

            // Template parts
            add_action( 'analytica_template_parts_content', array( $this, 'template_parts' ) );
            add_action( 'analytica_template_parts_content_none', array( $this, 'template_parts_none' ) );

            // Content top and bottom.
            add_action( 'analytica_template_parts_content_top', array( $this, 'template_parts_content_top' ) );
            add_action( 'analytica_template_parts_content_bottom', array( $this, 'template_parts_content_bottom' ) );

            // Add closing and ending div 'entry-archives'.
            add_action( 'analytica_template_parts_content_top', array( $this, 'analytica_templat_part_wrap_open' ), 25 );
            add_action( 'analytica_template_parts_content_bottom', array( $this, 'analytica_templat_part_wrap_close' ), 5 );
        }
    }

    /**
	 * Get post format
	 *
	 * @param  string $post_format_override Override post formate.
	 * @return string                       Return post format.
	 */
	function get_post_format( $post_format_override = '' ) {
		return apply_filters( 'analytica_get_post_format', 'blog', $post_format_override );
	}

    /**
     * Template parts
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts() {
        get_template_part( 'template-parts/content', $this->get_post_format() );
    }

    /**
     * Template part none
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_none() {
        get_template_part( 'template-parts/content', 'none' );
    }

    /**
     * Template part content top
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_content_top() {
        do_action( 'analytica_loop_archives_while_before' );
    }

    /**
     * Template part content bottom
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_content_bottom() {
        do_action( 'analytica_loop_archives_while_after' );
    }

    /**
     * Add wrapper div 'entry-archives' for Analytica template part.
     *
     * @since  1.0.0
     * @return void
     */
    public function analytica_templat_part_wrap_open() {
        echo '<div class="entry-archives">';
    }

    /**
     * Add closing wrapper div for 'entry-archives' after Analytica template part.
     *
     * @since  1.0.0
     * @return void
     */
    public function analytica_templat_part_wrap_close() {
        echo '</div>';
    }
}
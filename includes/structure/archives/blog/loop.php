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
  
        // Template Parts.
        add_action( 'analytica_template_parts_content', array( $this, 'template_parts_search' ) );
        add_action( 'analytica_template_parts_content', array( $this, 'template_parts_blog' ) );

        // Content top and bottom.
        add_action( 'analytica_template_parts_content_top', array( $this, 'template_parts_content_top' ) );
        add_action( 'analytica_template_parts_content_bottom', array( $this, 'template_parts_content_bottom' ) );

        // Add closing and ending div 'entry-page'.
        add_action( 'analytica_template_parts_content_top', array( $this, 'analytica_templat_part_wrap_open' ), 25 );
        add_action( 'analytica_template_parts_content_bottom', array( $this, 'analytica_templat_part_wrap_close' ), 5 );
    }

    /**
     * Template part search
     *
     * @since 1.0.0
     * @return void
     */
     public function template_parts_search() {
        if ( is_search() ) {
            get_template_part( 'template-parts/content', 'blog' );
        }
    }

    /**
     * Template part default
     *
     * @since 1.0.0
     * @return void
     */
     public function template_parts_blog() {
        if ( ! is_page() && ! is_single() && ! is_search() ) {
            /*
                * Include the Post-Format-specific template for the content.
                * If you want to override this in a child theme, then include a file
                * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                */
            get_template_part( 'template-parts/content', $this->get_post_format() );
        }
    }

    /**
     * Template part content top
     *
     * @since 1.0.0
     * @return void
     */
     public function template_parts_content_top() {
        if ( is_archive() ) {
            do_action( 'analytica_content_while_before' );
        }
    }

    /**
     * Template part content bottom
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_content_bottom() {
        if ( is_archive() ) {
            do_action( 'analytica_content_while_after' );
        }
    }

    /**
     * Add wrapper div 'entry-page' for Analytica template part.
     *
     * @since  1.0.0
     * @return void
     */
    public function analytica_templat_part_wrap_open() {
        if ( is_archive() || is_search() || is_home() ) {
            echo '<div class="entry-page">';
        }
    }

    /**
     * Add closing wrapper div for 'entry-page' after Analytica template part.
     *
     * @since  1.0.0
     * @return void
     */
    public function analytica_templat_part_wrap_close() {
        if ( is_archive() || is_search() || is_home() ) {
            echo '</div>';
        }
    }

}
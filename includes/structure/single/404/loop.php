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
class Page_Not_Found {

    /**
     * Constructor
     *
     * @since 1.0.0
     */
     public function __construct() {
        // Template None.
        add_action( 'analytica_template_parts_content_none', array( $this, 'template_parts_none' ) );
        add_action( 'analytica_template_parts_content_none', array( $this, 'template_parts_404' ) );
    }

    /**
     * Template part none
     *
     * @since 1.0.0
     * @return void
     */
     public function template_parts_none() {
        if ( is_archive() || is_search() ) {
            get_template_part( 'template-parts/content', 'none' );
        }
    }

    /**
     * Template part 404
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_404() {
        if ( is_404() ) {
            get_template_part( 'template-parts/content', '404' );
        }
    }


}
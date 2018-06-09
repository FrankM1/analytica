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
 * Analytica Loop
 *
 * @package Analytica
 * @since 1.0.0
 */
class Page extends Base {

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'analytica_content_page_loop', array( $this, 'loop_markup_page' ) );

        // Template Parts.
        add_action( 'analytica_page_template_parts_content', array( $this, 'template_parts_page' ) );
    }

    /**
     * Loop Markup for content page
     *
     * @since 1.0.0
     */
     public function loop_markup_page() {
        $this->loop_markup( true );
    }

    /**
     * Template part page
     *
     * @since 1.0.0
     * @return void
     */
     public function template_parts_page() {
        get_template_part( 'template-parts/content', 'page' );
    }


}

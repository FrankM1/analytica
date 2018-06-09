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
class Post {

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Template Parts.
        add_action( 'analytica_template_parts_content', array( $this, 'template_parts_post' ) );
        add_action( 'analytica_template_parts_content', array( $this, 'template_parts_comments' ), 15 );
    }

    /**
     * Template part single
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_post() {
        get_template_part( 'template-parts/content', 'single' );
    }

    /**
     * Template part comments
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_comments() {
        if ( is_single() || is_page() ) {
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        }
    }
}

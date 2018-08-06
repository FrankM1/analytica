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
        add_filter( 'body_class', array( $this, 'single_body_class' ) );
        add_filter( 'post_class', array( $this, 'single_page_class' ) );

        add_action( 'analytica_loop_template_part', array( $this, 'template_parts_page' ) );
        add_action( 'analytica_loop_template_part', array( $this, 'template_parts_comments' ), 15 );
    }

    /**
     * Adds custom classes to the array of body classes.
     *
     * @since 1.0.0
     * @param array $classes Classes for the body element.
     * @return array
     */
    function single_body_class( $classes ) {
        if ( ! is_page() ) { 
            return $classes;
        }

        if ( is_singular() ) {
            $classes[] = 'analytica-single-post';
        }

        return $classes;
    }


     /**
     * Adds custom classes to the array of body classes.
     *
     * @since 1.0.0
     * @param array $classes Classes for the body element.
     * @return array
     */
    function single_page_class( $classes ) {
        if ( ! is_page() ) { 
            return $classes;
        }
      
        $classes[] = 'analytica-article-single';
        $classes = array_diff( $classes, array( 'hentry' ) );

        return $classes;
    }


    /**
     * Template part page
     *
     * @since 1.0.0
     * @return void
     */
     public function template_parts_page() {
        if ( ! is_page() ) { 
            return;
        }
        get_template_part( 'template-parts/content', 'page' );
    }

    /**
     * Template part comments
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_comments() {
        if ( ! is_page() || analytica_is_builder_page() ) { 
            return;
        }
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    }
}

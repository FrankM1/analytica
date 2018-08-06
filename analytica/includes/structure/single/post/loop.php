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
        add_filter( 'body_class', array( $this, 'single_body_class' ) );
        add_filter( 'post_class', array( $this, 'single_post_class' ) );
    
        // Template Parts.
        add_action( 'analytica_loop_template_part', array( $this, 'template_parts_post' ) );
        add_action( 'analytica_loop_template_part', array( $this, 'template_parts_comments' ), 15 );

        add_action( 'analytica_entry_content_single', array( $this, 'entry_content_single_template' ) );
        add_action( 'analytica_entry_after',  array( $this, 'navigation_markup' ) );
    }

    /**
     * Adds custom classes to the array of body classes.
     *
     * @since 1.0.0
     * @param array $classes Classes for the body element.
     * @return array
     */
    function single_body_class( $classes ) {
        if ( ! is_single() ) { 
            return $classes;
        }

        $classes[] = 'analytica-blog-single-style-1';
        $classes[] = 'analytica-single-post';

        return $classes;
    }

    /**
     * Adds custom classes to the array of body classes.
     *
     * @since 1.0.0
     * @param array $classes Classes for the body element.
     * @return array
     */
    function single_post_class( $classes ) {
        if ( ! is_single() ) { 
            return $classes;
        }
       
        $classes[] = 'analytica-article-single';

        return $classes;
    }

    /**
     * Template part single
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_post() {
        if ( ! is_single() ) { 
            return;
        }         
        get_template_part( 'template-parts/content', 'single' );
    }

    /**
     * Single post markup
     *
     * => Used in files:
     *
     * /template-parts/content-single.php
     *
     * @since 1.0.0
     */
    function entry_content_single_template() {
        if ( ! is_single() ) { 
            return;
        }
        get_template_part( 'template-parts/single/single-layout' );
    }

    /**
     * Template part comments
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_comments() {
        if ( ! is_single() ) { 
            return;
        }
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    }

    /**
     * Get Post Navigation
     *
     * Checks post navigation, if exists return as button.
     *
     * @return mixed Post Navigation Buttons
     */
    function navigation_markup() {

        $single_post_navigation_enabled = apply_filters( 'analytica_single_post_navigation_enabled', true );

        if ( ! is_single() || ! $single_post_navigation_enabled ) {
            return;
        }

        $post_obj = get_post_type_object( get_post_type() );

        $next_text = sprintf(
            analytica_default_strings( 'string-single-navigation-next', false ),
            $post_obj->labels->singular_name
        );

        $prev_text = sprintf(
            analytica_default_strings( 'string-single-navigation-previous', false ),
            $post_obj->labels->singular_name
        );

        /**
         * Filter the post pagination markup
         */
        the_post_navigation(
            apply_filters( 'analytica_single_post_navigation', array(
                    'next_text' => $next_text,
                    'prev_text' => $prev_text,
                )
            )
        );
    }
}

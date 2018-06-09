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

add_filter( 'body_class', 'analytica_single_body_class' );
/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 * @param array $classes Classes for the body element.
 * @return array
 */
function analytica_single_body_class( $classes ) {

    // Blog layout.
    if ( is_single() ) {
        $classes[] = 'analytica-blog-single-style-1';

        if ( 'post' != get_post_type() ) {
            $classes[] = 'analytica-custom-post-type';
        }
    }

    if ( is_singular() ) {
        $classes[] = 'analytica-single-post';
    }

    return $classes;
}

add_filter( 'post_class', 'analytica_single_post_class' );
/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 * @param array $classes Classes for the body element.
 * @return array
 */
function analytica_single_post_class( $classes ) {

    // Blog layout.
    if ( is_singular() ) {
        $classes[] = 'analytica-article-single';

        // Remove hentry from page.
        if ( 'page' == get_post_type() ) {
            $classes = array_diff( $classes, array( 'hentry' ) );
        }
    }

    return $classes;
}

add_action( 'analytica_entry_after', 'analytica_single_post_navigation_markup' );
/**
 * Get Post Navigation
 *
 * Checks post navigation, if exists return as button.
 *
 * @return mixed Post Navigation Buttons
 */
function analytica_single_post_navigation_markup() {

    $single_post_navigation_enabled = apply_filters( 'analytica_single_post_navigation_enabled', true );

    if ( is_single() && $single_post_navigation_enabled ) {

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
            apply_filters(
                'analytica_single_post_navigation', array(
                    'next_text' => $next_text,
                    'prev_text' => $prev_text,
                )
            )
        );

    }
}
<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Analytica
 * @since 1.0.0
 */

get_header();

do_action( 'analytica_left_sidebar' );

do_action( 'analytica_primary_content_top' );

do_action( 'analytica_content_loop' );

do_action( 'analytica_primary_content_bottom' );

do_action( 'analytica_right_sidebar' );

get_footer();

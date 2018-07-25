<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

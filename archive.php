<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Analytica
 * @since 1.0.0
 */

get_header(); ?>

<?php do_action( 'analytica_left_sidebar' ); ?>

    <?php do_action( 'analytica_primary_content_top' ); ?>

    <?php do_action( 'analytica_content_loop' ); ?>

    <?php do_action( 'analytica_primary_content_bottom' ); ?>

<?php do_action( 'analytica_right_sidebar' ); ?>

<?php get_footer(); ?>

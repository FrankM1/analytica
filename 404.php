<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Analytica
 * @since 1.0.0
 */

get_header(); ?>

<?php do_action( 'analytica_left_sidebar' ); ?>

<div id="primary" <?php analytica_primary_class(); ?>>

    <?php do_action( 'analytica_primary_content_top' ); ?>

    <?php do_action( 'analytica_content_loop' ); ?>		

    <?php do_action( 'analytica_primary_content_bottom' ); ?>

</div><!-- #primary -->

<?php do_action( 'analytica_right_sidebar' ); ?>

<?php get_footer(); ?>

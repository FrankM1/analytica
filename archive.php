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

<div id="primary" <?php analytica_primary_class(); ?>>

    <?php do_action( 'analytica_primary_content_top' ); ?>

    <?php do_action( 'analytica_archive_header' ); ?>

    <?php do_action( 'analytica_content_loop' ); ?>

    <?php do_action( 'analytica_pagination' ); ?>

    <?php do_action( 'analytica_primary_content_bottom' ); ?>

</div><!-- #primary -->

<?php do_action( 'analytica_right_sidebar' ); ?>

<?php get_footer(); ?>

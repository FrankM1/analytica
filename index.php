<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

    <?php do_action( 'analytica_content_loop' ); ?>

    <?php do_action( 'analytica_pagination' ); ?>

    <?php do_action( 'analytica_primary_content_bottom' ); ?>

</div><!-- #primary -->

<?php do_action( 'analytica_right_sidebar' ); ?>

<?php get_footer(); ?>

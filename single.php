<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Analytica
 * @since 1.0.0
 */

get_header(); ?>

<?php if ( analytica_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php analytica_primary_class(); ?>>

		<?php do_action( 'analytica_primary_content_top' ); ?>

		<?php do_action( 'analytica_content_loop' ); ?>

		<?php do_action( 'analytica_primary_content_bottom' ); ?>

	</div><!-- #primary -->

<?php if ( analytica_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>

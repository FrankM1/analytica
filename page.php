<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

		<?php do_action( 'analytica_content_page_loop' ); ?>

		<?php do_action( 'analytica_primary_content_bottom' ); ?>

	</div><!-- #primary -->

<?php if ( analytica_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>

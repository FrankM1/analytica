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

<?php if ( analytica_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php analytica_primary_class(); ?>>

		<?php analytica_primary_content_top(); ?>

		<?php analytica_archive_header(); ?>

		<?php analytica_content_loop(); ?>

		<?php analytica_pagination(); ?>

		<?php analytica_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( analytica_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>

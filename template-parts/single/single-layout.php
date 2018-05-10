<?php
/**
 * Template for Single post
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

?>

<div <?php analytica_blog_layout_class( 'single-layout-1' ); ?>>

	<?php do_action( 'analytica_single_header_before' ); ?>

	<header class="entry-header <?php analytica_entry_header_class(); ?>">

		<?php do_action( 'analytica_single_header_top' ); ?>

		<?php analytica_blog_post_thumbnai_and_title_order(); ?>

		<?php do_action( 'analytica_single_header_bottom' ); ?>

	</header><!-- .entry-header -->

	<?php do_action( 'analytica_single_header_after' ); ?>

	<div class="entry-content clear" itemprop="text">

		<?php do_action( 'analytica_entry_content_before' ); ?>

		<?php the_content(); ?>

		<?php
			analytica_edit_post_link(

				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'analytica' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>

		<?php do_action( 'analytica_entry_content_after' ); ?>

		<?php
			wp_link_pages(
				array(
					'before'      => '<div class="page-links">' . esc_html( analytica_default_strings( 'string-single-page-links-before', false ) ),
					'after'       => '</div>',
					'link_before' => '<span class="page-link">',
					'link_after'  => '</span>',
				)
			);
		?>
	</div><!-- .entry-content .clear -->
</div>

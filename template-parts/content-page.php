<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Analytica
 * @since 1.0.0
 */

?>

<?php do_action( 'analytica_entry_before' ); ?>

<article itemtype="https://schema.org/CreativeWork" itemscope="itemscope" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'analytica_entry_top' ); ?>

	<div class="entry-content clear" itemprop="text">

		<?php do_action( 'analytica_entry_content_before' ); ?>

		<?php the_content(); ?>

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

	<?php
		analytica_edit_post_link(

			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'analytica' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer><!-- .entry-footer -->'
		);
	?>

	<?php do_action( 'analytica_entry_bottom' ); ?>

</article><!-- #post-## -->

<?php do_action( 'analytica_entry_after' ); ?>

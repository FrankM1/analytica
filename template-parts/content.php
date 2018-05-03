<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Analytica
 * @since 1.0.0
 */

?>

<?php analytica_entry_before(); ?>

<article itemtype="https://schema.org/CreativeWork" itemscope="itemscope" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php analytica_entry_top(); ?>

	<header class="entry-header <?php analytica_entry_header_class(); ?>">

		<?php analytica_the_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content clear" itemprop="text">

		<?php analytica_entry_content_before(); ?>

		<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. */
						__( 'Continue reading %s', 'analytica' ) . ' <span class="meta-nav">&rarr;</span>', array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				)
			);
		?>

		<?php analytica_entry_content_after(); ?>

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

	<footer class="entry-footer">
		<?php analytica_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php analytica_entry_bottom(); ?>

</article><!-- #post-## -->

<?php analytica_entry_after(); ?>

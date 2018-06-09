<?php
/**
 * Template for Blog
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

?>
<div <?php analytica_blog_layout_class( 'blog-layout-1' ); ?>>

	<div class="post-content">

		<?php analytica_blog_post_thumbnail_and_title_order(); ?>

		<div class="entry-summary" itemprop="text">

			<?php do_action( 'analytica_entry_content_before' ); ?>

			<?php analytica_the_excerpt(); ?>

			<?php do_action( 'analytica_entry_content_after' ); ?>

			<?php
				wp_link_pages(
					array(
						'before'      => '<div class="page-links">' . esc_html( analytica_default_strings( 'string-blog-page-links-before', false ) ),
						'after'       => '</div>',
						'link_before' => '<span class="page-link">',
						'link_after'  => '</span>',
					)
				);
			?>
		</div><!-- .entry-summary -->
	</div><!-- .post-content -->

</div> <!-- .blog-layout-1 -->

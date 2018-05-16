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

	<div class="post-content analytica-col-md-12">

		<?php analytica_blog_post_thumbnai_and_title_order(); ?>

		<div class="entry-content clear" itemprop="text">

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
		</div><!-- .entry-content .clear -->
	</div><!-- .post-content -->

</div> <!-- .blog-layout-1 -->

<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Analytica
 */

if ( ! function_exists( 'analytica_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function analytica_entry_footer() {

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';

			/**
			 * Get default strings.
			 *
			 * @see analytica_default_strings
			 */
			comments_popup_link( analytica_default_strings( 'string-blog-meta-leave-a-comment', false ), analytica_default_strings( 'string-blog-meta-one-comment', false ), analytica_default_strings( 'string-blog-meta-multiple-comment', false ) );
			echo '</span>';
		}

		analytica_edit_post_link(

			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'analytica' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

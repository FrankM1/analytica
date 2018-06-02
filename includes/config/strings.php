<?php
/**
 * Analytica Theme Strings
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

/**
 * Default Strings
 */
if ( ! function_exists( 'analytica_default_strings' ) ) {

	/**
	 * Default Strings
	 *
	 * @since 1.0.0
	 * @param  string  $key  String key.
	 * @param  boolean $echo Print string.
	 * @return mixed        Return string or nothing.
	 */
	function analytica_default_strings( $key, $echo = true ) {

		$defaults = apply_filters(
			'analytica_default_strings', array(

				// Header.
				'string-header-skip-link'                => __( 'Skip to content', 'analytica' ),

				// 404 Page Strings.
				'string-404-sub-title'                   => __( 'It looks like the link pointing here was faulty. Maybe try searching?', 'analytica' ),

				// Search Page Strings.
				'string-search-nothing-found'            => __( 'Nothing Found', 'analytica' ),
				'string-search-nothing-found-message'    => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'analytica' ),
				'string-full-width-search-message'       => __( 'Start typing and press enter to search', 'analytica' ),
				'string-full-width-search-placeholder'   => __( 'Start Typing&hellip;', 'analytica' ),
				'string-header-cover-search-placeholder' => __( 'Start Typing&hellip;', 'analytica' ),
				'string-search-input-placeholder'        => __( 'Search &hellip;', 'analytica' ),

				// Comment Template Strings.
				'string-comment-reply-link'              => __( 'Reply', 'analytica' ),
				'string-comment-edit-link'               => __( 'Edit', 'analytica' ),
				'string-comment-awaiting-moderation'     => __( 'Your comment is awaiting moderation.', 'analytica' ),
				'string-comment-title-reply'             => __( 'Leave a Comment', 'analytica' ),
				'string-comment-cancel-reply-link'       => __( 'Cancel Reply', 'analytica' ),
				'string-comment-label-submit'            => __( 'Post Comment &raquo;', 'analytica' ),
				'string-comment-label-message'           => __( 'Type here..', 'analytica' ),
				'string-comment-label-name'              => __( 'Name*', 'analytica' ),
				'string-comment-label-email'             => __( 'Email*', 'analytica' ),
				'string-comment-label-website'           => __( 'Website', 'analytica' ),
				'string-comment-closed'                  => __( 'Comments are closed.', 'analytica' ),
				'string-comment-navigation-title'        => __( 'Comment navigation', 'analytica' ),
				'string-comment-navigation-next'         => __( 'Newer Comments', 'analytica' ),
				'string-comment-navigation-previous'     => __( 'Older Comments', 'analytica' ),

				// Blog Default Strings.
				'string-blog-page-links-before'          => __( 'Pages:', 'analytica' ),
				'string-blog-meta-author-by'             => __( 'By ', 'analytica' ),
				'string-blog-meta-leave-a-comment'       => __( 'Leave a Comment', 'analytica' ),
				'string-blog-meta-one-comment'           => __( '1 Comment', 'analytica' ),
				'string-blog-meta-multiple-comment'      => __( '% Comments', 'analytica' ),
				'string-blog-navigation-next'            => __( 'Next Page', 'analytica' ) . ' <span class="analytica-right-arrow">&rarr;</span>',
				'string-blog-navigation-previous'        => '<span class="analytica-left-arrow">&larr;</span> ' . __( 'Previous Page', 'analytica' ),

				// Single Post Default Strings.
				'string-single-page-links-before'        => __( 'Pages:', 'analytica' ),
				/* translators: 1: Post type label */
				'string-single-navigation-next'          => __( 'Next %s', 'analytica' ) . ' <span class="analytica-right-arrow">&rarr;</span>',
				/* translators: 1: Post type label */
				'string-single-navigation-previous'      => '<span class="analytica-left-arrow">&larr;</span> ' . __( 'Previous %s', 'analytica' ),

				// Content None.
				'string-content-nothing-found-message'   => __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'analytica' ),

			)
		);

		if ( is_rtl() ) {
			$defaults['string-blog-navigation-next']     = __( 'Next Page', 'analytica' ) . ' <span class="analytica-left-arrow">&larr;</span>';
			$defaults['string-blog-navigation-previous'] = '<span class="analytica-right-arrow">&rarr;</span> ' . __( 'Previous Page', 'analytica' );

			/* translators: 1: Post type label */
			$defaults['string-single-navigation-next'] = __( 'Next %s', 'analytica' ) . ' <span class="analytica-left-arrow">&larr;</span>';
			/* translators: 1: Post type label */
			$defaults['string-single-navigation-previous'] = '<span class="analytica-right-arrow">&rarr;</span> ' . __( 'Previous %s', 'analytica' );
		}

		$output = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

		/**
		 * Print or return
		 */
		if ( $echo ) {
			echo wp_kses( $output, analytica_get_allowed_tags() );
		} else {
			return $output;
		}
	}
}

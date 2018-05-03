<?php
/**
 * Theme Hook Alliance hook stub list.
 *
 * @see  https://github.com/zamoose/themehookalliance
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

/**
 * Themes and Plugins can check for analytica_hooks using current_theme_supports( 'analytica_hooks', $hook )
 * to determine whether a theme declares itself to support this specific hook type.
 *
 * Example:
 * <code>
 *      // Declare support for all hook types
 *      add_theme_support( 'analytica_hooks', array( 'all' ) );
 *
 *      // Declare support for certain hook types only
 *      add_theme_support( 'analytica_hooks', array( 'header', 'content', 'footer' ) );
 * </code>
 */
add_theme_support(
	'analytica_hooks', array(

		/**
		 * As a Theme developer, use the 'all' parameter, to declare support for all
		 * hook types.
		 * Please make sure you then actually reference all the hooks in this file,
		 * Plugin developers depend on it!
		 */
		'all',

		/**
		 * Themes can also choose to only support certain hook types.
		 * Please make sure you then actually reference all the hooks in this type
		 * family.
		 *
		 * When the 'all' parameter was set, specific hook types do not need to be
		 * added explicitly.
		 */
		'html',
		'body',
		'head',
		'header',
		'content',
		'entry',
		'comments',
		'sidebars',
		'sidebar',
		'footer',

	/**
	 * If/when WordPress Core implements similar methodology, Themes and Plugins
	 * will be able to check whether the version of THA supplied by the theme
	 * supports Core hooks.
	 */
	)
);

/**
 * Determines, whether the specific hook type is actually supported.
 *
 * Plugin developers should always check for the support of a <strong>specific</strong>
 * hook type before hooking a callback function to a hook of this type.
 *
 * Example:
 * <code>
 *      if ( current_theme_supports( 'analytica_hooks', 'header' ) )
 *          add_action( 'analytica_head_top', 'prefix_header_top' );
 * </code>
 *
 * @param bool  $bool true.
 * @param array $args The hook type being checked.
 * @param array $registered All registered hook types.
 *
 * @return bool
 */
function analytica_current_theme_supports( $bool, $args, $registered ) {
	return in_array( $args[0], $registered[0] ) || in_array( 'all', $registered[0] );
}
add_filter( 'current_theme_supports-analytica_hooks', 'analytica_current_theme_supports', 10, 3 );

/**
 * HTML <html> hook
 * Special case, useful for <DOCTYPE>, etc.
 * $analytica_supports[] = 'html;
 */
function analytica_html_before() {
	do_action( 'analytica_html_before' );
}
/**
 * HTML <body> hooks
 * $analytica_supports[] = 'body';
 */
function analytica_body_top() {
	do_action( 'analytica_body_top' );
}

/**
 * Body Bottom
 */
function analytica_body_bottom() {
	do_action( 'analytica_body_bottom' );
}

/**
 * HTML <head> hooks
 *
 * $analytica_supports[] = 'head';
 */
function analytica_head_top() {
	do_action( 'analytica_head_top' );
}

/**
 * Head Bottom
 */
function analytica_head_bottom() {
	do_action( 'analytica_head_bottom' );
}

/**
 * Semantic <header> hooks
 *
 * $analytica_supports[] = 'header';
 */
function analytica_header_before() {
	do_action( 'analytica_header_before' );
}

/**
 * Site Header
 */
function analytica_header() {
	do_action( 'analytica_header' );
}

/**
 * Masthead Top
 */
function analytica_masthead_top() {
	do_action( 'analytica_masthead_top' );
}

/**
 * Masthead
 */
function analytica_masthead() {
	do_action( 'analytica_masthead' );
}

/**
 * Masthead Bottom
 */
function analytica_masthead_bottom() {
	do_action( 'analytica_masthead_bottom' );
}

/**
 * Header After
 */
function analytica_header_after() {
	do_action( 'analytica_header_after' );
}

/**
 * Main Header bar top
 */
function analytica_main_header_bar_top() {
	do_action( 'analytica_main_header_bar_top' );
}

/**
 * Main Header bar bottom
 */
function analytica_main_header_bar_bottom() {
	do_action( 'analytica_main_header_bar_bottom' );
}

/**
 * Main Header Content
 */
function analytica_masthead_content() {
	do_action( 'analytica_masthead_content' );
}
/**
 * Main toggle button before
 */
function analytica_masthead_toggle_buttons_before() {
	do_action( 'analytica_masthead_toggle_buttons_before' );
}

/**
 * Main toggle buttons
 */
function analytica_masthead_toggle_buttons() {
	do_action( 'analytica_masthead_toggle_buttons' );
}

/**
 * Main toggle button after
 */
function analytica_masthead_toggle_buttons_after() {
	do_action( 'analytica_masthead_toggle_buttons_after' );
}

/**
 * Semantic <content> hooks
 *
 * $analytica_supports[] = 'content';
 */
function analytica_content_before() {
	do_action( 'analytica_content_before' );
}

/**
 * Content after
 */
function analytica_content_after() {
	do_action( 'analytica_content_after' );
}

/**
 * Content top
 */
function analytica_content_top() {
	do_action( 'analytica_content_top' );
}

/**
 * Content bottom
 */
function analytica_content_bottom() {
	do_action( 'analytica_content_bottom' );
}

/**
 * Content while before
 */
function analytica_content_while_before() {
	do_action( 'analytica_content_while_before' );
}

/**
 * Content loop
 */
function analytica_content_loop() {
	do_action( 'analytica_content_loop' );
}

/**
 * Conten Page Loop.
 *
 * Called from page.php
 */
function analytica_content_page_loop() {
	do_action( 'analytica_content_page_loop' );
}

/**
 * Content while after
 */
function analytica_content_while_after() {
	do_action( 'analytica_content_while_after' );
}

/**
 * Semantic <entry> hooks
 *
 * $analytica_supports[] = 'entry';
 */
function analytica_entry_before() {
	do_action( 'analytica_entry_before' );
}

/**
 * Entry after
 */
function analytica_entry_after() {
	do_action( 'analytica_entry_after' );
}

/**
 * Entry content before
 */
function analytica_entry_content_before() {
	do_action( 'analytica_entry_content_before' );
}

/**
 * Entry content after
 */
function analytica_entry_content_after() {
	do_action( 'analytica_entry_content_after' );
}

/**
 * Entry Top
 */
function analytica_entry_top() {
	do_action( 'analytica_entry_top' );
}

/**
 * Entry bottom
 */
function analytica_entry_bottom() {
	do_action( 'analytica_entry_bottom' );
}

/**
 * Single Post Header Before
 */
function analytica_single_header_before() {
	do_action( 'analytica_single_header_before' );
}

/**
 * Single Post Header After
 */
function analytica_single_header_after() {
	do_action( 'analytica_single_header_after' );
}

/**
 * Single Post Header Top
 */
function analytica_single_header_top() {
	do_action( 'analytica_single_header_top' );
}

/**
 * Single Post Header Bottom
 */
function analytica_single_header_bottom() {
	do_action( 'analytica_single_header_bottom' );
}

/**
 * Comments block hooks
 *
 * $analytica_supports[] = 'comments';
 */
function analytica_comments_before() {
	do_action( 'analytica_comments_before' );
}

/**
 * Comments after.
 */
function analytica_comments_after() {
	do_action( 'analytica_comments_after' );
}

/**
 * Semantic <sidebar> hooks
 *
 * $analytica_supports[] = 'sidebar';
 */
function analytica_sidebars_before() {
	do_action( 'analytica_sidebars_before' );
}

/**
 * Sidebars after
 */
function analytica_sidebars_after() {
	do_action( 'analytica_sidebars_after' );
}

/**
 * Semantic <footer> hooks
 *
 * $analytica_supports[] = 'footer';
 */
function analytica_footer() {
	do_action( 'analytica_footer' );
}

/**
 * Footer before
 */
function analytica_footer_before() {
	do_action( 'analytica_footer_before' );
}

/**
 * Footer after
 */
function analytica_footer_after() {
	do_action( 'analytica_footer_after' );
}

/**
 * Footer top
 */
function analytica_footer_content_top() {
	do_action( 'analytica_footer_content_top' );
}

/**
 * Footer
 */
function analytica_footer_content() {
	do_action( 'analytica_footer_content' );
}

/**
 * Footer bottom
 */
function analytica_footer_content_bottom() {
	do_action( 'analytica_footer_content_bottom' );
}

/**
 * Archive header
 */
function analytica_archive_header() {
	do_action( 'analytica_archive_header' );
}

/**
 * Pagination
 */
function analytica_pagination() {
	do_action( 'analytica_pagination' );
}

/**
 * Entry content single
 */
function analytica_entry_content_single() {
	do_action( 'analytica_entry_content_single' );
}

/**
 * 404
 */
function analytica_entry_content_404_page() {
	do_action( 'analytica_entry_content_404_page' );
}

/**
 * Entry content blog
 */
function analytica_entry_content_blog() {
	do_action( 'analytica_entry_content_blog' );
}

/**
 * Blog featured post section
 */
function analytica_blog_post_featured_format() {
	do_action( 'analytica_blog_post_featured_format' );
}

/**
 * Primary Content Top
 */
function analytica_primary_content_top() {
	do_action( 'analytica_primary_content_top' );
}

/**
 * Primary Content Bottom
 */
function analytica_primary_content_bottom() {
	do_action( 'analytica_primary_content_bottom' );
}

<?php
/**
 * Template parts
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

add_action( 'analytica_entry_content_single', 'analytica_entry_content_single_template' );
/**
 * Single post markup
 *
 * => Used in files:
 *
 * /template-parts/content-single.php
 *
 * @since 1.0.0
 */
function analytica_entry_content_single_template() {
    get_template_part( 'template-parts/single/single-layout' );
}

add_action( 'analytica_entry_content_blog', 'analytica_entry_content_blog_template' );
/**
 * Blog post list markup for blog & search page
 *
 * => Used in files:
 *
 * /template-parts/content-blog.php
 * /template-parts/content-search.php
 *
 * @since 1.0.0
 */
function analytica_entry_content_blog_template() {
    get_template_part( 'template-parts/blog/blog-layout' );
}

add_action( 'analytica_entry_content_404_page', 'analytica_entry_content_404_page_template' );
/**
 * 404 markup
 *
 * => Used in files:
 *
 * /template-parts/content-404.php
 *
 * @since 1.0.0
 */
function analytica_entry_content_404_page_template() {

    $layout_404 = analytica_get_option( 'ast-404-layout' );
    $layout_404 = str_replace( '404-layout-', '', $layout_404 );

    // Default 404 is nothing but the 404 layout 1.
    if ( '1' == $layout_404 ) {
        $layout_404 = '';
    }

    get_template_part( 'template-parts/404/404-layout', $layout_404 );
}
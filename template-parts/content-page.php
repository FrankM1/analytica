<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Analytica
 * @since 1.0.0
 */

do_action( 'analytica_entry_before' );

analytica_markup( array( 'element' => '<article %s>', 'context' => 'article' ));

    do_action( 'analytica_entry_top' );
    
    analytica_markup( array( 'element' => '<div %s>', 'context' => 'entry-content' ));

		do_action( 'analytica_entry_content_before' );

		the_content();

		do_action( 'analytica_entry_content_after' );

        wp_link_pages(
            array(
                'before'      => '<div class="page-links">' . esc_html( analytica_default_strings( 'string-single-page-links-before', false ) ),
                'after'       => '</div>',
                'link_before' => '<span class="page-link">',
                'link_after'  => '</span>',
            )
        );
            
    analytica_markup( array( 'element' => '</div><!-- .entry-content -->' ));

    analytica_edit_post_link(
        sprintf(
            /* translators: %s: Name of current post */
            esc_html__( 'Edit %s', 'analytica' ),
            the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ),
        '<footer class="entry-footer"><span class="edit-link">',
        '</span></footer><!-- .entry-footer -->'
    );
        
	do_action( 'analytica_entry_bottom' );

analytica_markup( array( 'element' => '</article>' ));

do_action( 'analytica_entry_after' );

?>

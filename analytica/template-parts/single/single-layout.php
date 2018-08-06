<?php
/**
 * Template for Single post
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */
?>

<div <?php analytica_blog_layout_class( 'single-layout-1' ); ?>><?php
        do_action( 'analytica_single_before' );

        do_action( 'analytica_single_header_before' );
    
		do_action( 'analytica_single_header_top' );

		analytica_blog_post_thumbnail_and_title_order();

		do_action( 'analytica_single_header_bottom' );
    
        do_action( 'analytica_single_header_after' );

        analytica_markup( array( 'element' => '<div %s>', 'context' => 'entry-content' ));
    
        do_action( 'analytica_entry_content_before' );

		the_content();

        analytica_edit_post_link(

            sprintf(
                /* translators: %s: Name of current post */
                esc_html__( 'Edit %s', 'analytica' ),
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ),
            '<span class="edit-link">',
            '</span>'
        );
        
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

    do_action( 'analytica_single_after' );

?></div>

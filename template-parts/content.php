<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Analytica
 * @since 1.0.0
 */

do_action( 'analytica_entry_before' );

analytica_markup( array( 'element' => '<article %s>', 'context' => 'article' ));

    do_action( 'analytica_entry_top' );
    
    ?><header class="entry-header <?php analytica_entry_header_class(); ?>">
		<?php analytica_the_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header --><?php

    analytica_markup( array( 'element' => '<div %s>', 'context' => 'entry-content' ));

        do_action( 'analytica_entry_content_before' );

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

	?><footer class="entry-footer">
		<?php analytica_entry_footer(); ?>
    </footer><!-- .entry-footer --><?php
    
    do_action( 'analytica_entry_bottom' );

analytica_markup( array( 'element' => '</article>' ));

do_action( 'analytica_entry_after' ); ?>

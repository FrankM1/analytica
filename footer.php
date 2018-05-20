<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Analytica
 * @since 1.0.0
 */

            analytica_structural_wrap( 'site-inner', 'close' );

            echo '</div>'; // end .site-inner or #inner

            do_action( 'analytica_content_bottom' ); 
            
        ?></div><!-- #content --><?php

        do_action( 'analytica_content_after' );

        do_action( 'analytica_footer_before' );

        do_action( 'analytica_footer' );

        do_action( 'analytica_footer_after' );

        ?></div><!-- #page --><?php

    do_action( 'analytica_body_bottom' ); 
    
    ?></div><!-- .site-container --><?php

    do_action( 'analytica_after' );

    wp_footer(); 
    
    ?></body>
</html>

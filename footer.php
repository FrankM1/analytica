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

            /**
             * The template for displaying the footer.
             *
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

        echo '</div><!-- #page -->'; // end .site-container or #wrap

    do_action( 'analytica_body_bottom' ); 
    
    echo '</div>'; // end .site-container or #wrap

    do_action( 'analytica_after' );

    wp_footer(); 
    
    ?></body>
</html>

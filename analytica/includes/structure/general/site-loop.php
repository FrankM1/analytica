<?php
namespace Analytica\Content\Loop;

/**
 * Analytica Loop
 *
 * @package Analytica
 * @since 1.0.0
 */
class Base {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'analytica_content_loop', array( $this, 'loop_markup' ) );
    }

    /**
     * Template part loop
     * 
     * @return void
     */
    public function loop_markup() {

        do_action( 'analytica_before_content' );

        analytica_markup( array(
            'element'   => '<main %s>',
            'context' => 'site-main',
        ) );

            analytica_markup( array(
                'element'   => '<div %s>',
                'context' => 'site-main-inner',
            ) );
    
                if ( have_posts() ) :
                    
                    do_action( 'analytica_before_loop' );

                    while ( have_posts() ) : the_post();
                        do_action( 'analytica_loop_template_part' );
                    endwhile;

                    do_action( 'analytica_after_loop' );

                else :

                    do_action( 'analytica_loop_template_part_none' );

                endif; 

            analytica_markup( array(
                'element' => '</div>', // end .site-main-inner
            ) );

        analytica_markup( array(
            'element' => '</main>', // end .site-main
        ) );

        do_action( 'analytica_after_content' );
    }

}

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
        
        ?><main class="site-main" role="main">
            <div class="site-main-inner"><?php
    
            if ( have_posts() ) :
                
                do_action( 'analytica_template_parts_content_top' );

                while ( have_posts() ) : the_post();

                    do_action( 'analytica_template_parts_content' );

                endwhile;

                do_action( 'analytica_template_parts_content_bottom' );

            else :

                do_action( 'analytica_template_parts_content_none' );

           endif; 
            
            ?></div>
        </main><!-- #main --><?php
    }

}

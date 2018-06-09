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
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'analytica_content_loop', array( $this, 'loop_markup' ) );
    }

    /**
     * Template part loop
     *
     * @param  boolean $is_page Loop outputs different content action for content page and default content.
     *         if is_page is set to true - do_action( 'analytica_page_template_parts_content' ); is added
     *         if is_page is false - do_action( 'analytica_template_parts_content' ); is added.
     * @since 1.0.0
     * @return void
     */
    public function loop_markup( $is_page = false ) {
        
        ?><main class="site-main" role="main">
            <div class="site-main-inner"><?php
    
            if ( have_posts() ) :
                
                do_action( 'analytica_template_parts_content_top' );

                while ( have_posts() ) :
                    the_post();

                    if ( true == $is_page ) {
                        do_action( 'analytica_page_template_parts_content' );
                    } else {
                        do_action( 'analytica_template_parts_content' );
                    }

                   endwhile;

                do_action( 'analytica_template_parts_content_bottom' );

            else :

            do_action( 'analytica_template_parts_content_none' );

           endif; 
            
            ?></div>
        </main><!-- #main --><?php
    }

}

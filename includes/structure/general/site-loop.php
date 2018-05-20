<?php
namespace Analytica\Content;

/**
 * Analytica Loop
 *
 * @package Analytica
 * @since 1.0.0
 */
class Loop {

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Loop.
        add_action( 'analytica_content_loop', array( $this, 'loop_markup' ) );
        add_action( 'analytica_content_page_loop', array( $this, 'loop_markup_page' ) );

        // Template Parts.
        add_action( 'analytica_page_template_parts_content', array( $this, 'template_parts_page' ) );
        add_action( 'analytica_template_parts_content', array( $this, 'template_parts_post' ) );
        add_action( 'analytica_template_parts_content', array( $this, 'template_parts_search' ) );
        add_action( 'analytica_template_parts_content', array( $this, 'template_parts_default' ) );
        add_action( 'analytica_template_parts_content', array( $this, 'template_parts_comments' ), 15 );

        // Template None.
        add_action( 'analytica_template_parts_content_none', array( $this, 'template_parts_none' ) );
        add_action( 'analytica_template_parts_content_none', array( $this, 'template_parts_404' ) );

        // Content top and bottom.
        add_action( 'analytica_template_parts_content_top', array( $this, 'template_parts_content_top' ) );
        add_action( 'analytica_template_parts_content_bottom', array( $this, 'template_parts_content_bottom' ) );

        // Add closing and ending div 'entry-page'.
        add_action( 'analytica_template_parts_content_top', array( $this, 'analytica_templat_part_wrap_open' ), 25 );
        add_action( 'analytica_template_parts_content_bottom', array( $this, 'analytica_templat_part_wrap_close' ), 5 );
    }

    /**
	 * Get post format
	 *
	 * @param  string $post_format_override Override post formate.
	 * @return string                       Return post format.
	 */
	function get_post_format( $post_format_override = '' ) {

		if ( ( is_home() ) || is_archive() ) {
			$post_format = 'blog';
		} else {
			$post_format = get_post_format();
		}

		return apply_filters( 'analytica_get_post_format', $post_format, $post_format_override );
	}

    /**
     * Template part none
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_none() {
        if ( is_archive() || is_search() ) {
            get_template_part( 'template-parts/content', 'none' );
        }
    }

    /**
     * Template part 404
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_404() {
        if ( is_404() ) {
            get_template_part( 'template-parts/content', '404' );
        }
    }

    /**
     * Template part page
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_page() {
        get_template_part( 'template-parts/content', 'page' );
    }

    /**
     * Template part single
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_post() {
        if ( is_single() ) {
            get_template_part( 'template-parts/content', 'single' );
        }
    }

    /**
     * Template part search
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_search() {
        if ( is_search() ) {
            get_template_part( 'template-parts/content', 'blog' );
        }
    }

    /**
     * Template part comments
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_comments() {
        if ( is_single() || is_page() ) {
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        }
    }

    /**
     * Template part default
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_default() {
        if ( ! is_page() && ! is_single() && ! is_search() ) {
            /*
                * Include the Post-Format-specific template for the content.
                * If you want to override this in a child theme, then include a file
                * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                */
            get_template_part( 'template-parts/content', $this->get_post_format() );
        }
    }

    /**
     * Loop Markup for content page
     *
     * @since 1.3.1
     */
    public function loop_markup_page() {
        $this->loop_markup( true );
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
        
        ?><main class="site-main" role="main"><?php
        
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
            
        ?></main><!-- #main --><?php
    }

    /**
     * Template part content top
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_content_top() {
        if ( is_archive() ) {
            do_action( 'analytica_content_while_before' );
        }
    }

    /**
     * Template part content bottom
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_content_bottom() {
        if ( is_archive() ) {
            do_action( 'analytica_content_while_after' );
        }
    }

    /**
     * Add wrapper div 'entry-page' for Analytica template part.
     *
     * @since  1.0.0
     * @return void
     */
    public function analytica_templat_part_wrap_open() {
        if ( is_archive() || is_search() || is_home() ) {
            echo '<div class="entry-page">';
        }
    }

    /**
     * Add closing wrapper div for 'entry-page' after Analytica template part.
     *
     * @since  1.0.0
     * @return void
     */
    public function analytica_templat_part_wrap_close() {
        if ( is_archive() || is_search() || is_home() ) {
            echo '</div>';
        }
    }

}

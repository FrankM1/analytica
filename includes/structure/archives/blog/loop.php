<?php
/**
 * Radium Framework Core - A WordPress theme development framework.
 *
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file.
 * Modifying the contents of this file can be a poor life decision if you don't know what you're doing.
 *
 * NOTE: Theme data (options, global variables etc ) can be accessed anywhere in the theme by calling  <?php $framework = radium_framework(); ?>
 *
 * @category Radium\Framework
 * @package  Energia WP
 * @author   Franklin Gitonga
 * @link     https://radiumthemes.com/
 */
namespace Analytica\Content\Loop;

/**
 * Analytica Archives Loop
 *
 * @package Analytica
 * @since 1.0.0
 */
class Archives extends Base {

    /**
     * Constructor
     */
     public function __construct() {

        // Template parts
        add_action( 'analytica_loop_template_part', array( $this, 'template_parts' ) );
        add_action( 'analytica_loop_template_part_none', array( $this, 'template_parts_none' ) );

        // Content top and bottom.
        add_action( 'analytica_before_loop', array( $this, 'template_parts_content_top' ) );
        add_action( 'analytica_after_loop', array( $this, 'template_parts_content_bottom' ) );

        // Add closing and ending div 'entry-archives'.
        add_action( 'analytica_before_loop', array( $this, 'templat_part_wrap_open' ), 25 );
        add_action( 'analytica_after_loop', array( $this, 'templat_part_wrap_close' ), 5 );

        // Template Parts
        add_action( 'analytica_entry_content_blog', array( $this, 'entry_content_blog_template' ) );
        add_action( 'analytica_after_loop', array( $this, 'number_pagination' ) );
    }

    /**
	 * Get post format
	 *
	 * @param  string $post_format_override Override post formate.
	 * @return string                       Return post format.
	 */
	function get_post_format( $post_format_override = '' ) {
		return apply_filters( 'analytica_get_post_format', 'blog', $post_format_override );
	}

    /**
     * Template parts
     *
     * @return void
     */
    public function template_parts() {
        if ( ! analytica_is_post_archive_page() ) { 
            return;
        }

        get_template_part( 'template-parts/content', $this->get_post_format() );
    }

    /**
     * Template part none
     *
     * @return void
     */
    public function template_parts_none() {
        if ( ! analytica_is_post_archive_page() ) { 
            return;
        }
        get_template_part( 'template-parts/content', 'none' );
    }

    /**
     * Template part content top
     *
     * @return void
     */
    public function template_parts_content_top() {
        if ( ! analytica_is_post_archive_page() ) { 
            return;
        }
        do_action( 'analytica_loop_archives_while_before' );
    }

    /**
     * Template part content bottom
     *
     * @return void
     */
    public function template_parts_content_bottom() {
        if ( ! analytica_is_post_archive_page() ) { 
            return;
        }
        do_action( 'analytica_loop_archives_while_after' );
    }

    /**
     * Add wrapper div 'entry-archives' for Analytica template part.
     *
     * @return void
     */
    public function templat_part_wrap_open() {
        if ( ! analytica_is_post_archive_page() ) { 
            return;
        }
        echo '<div class="entry-archives">';
    }

    /**
     * Add closing wrapper div for 'entry-archives' after Analytica template part.
     *
     * @return void
     */
    public function templat_part_wrap_close() {
        if ( ! analytica_is_post_archive_page() ) { 
            return;
        }
        echo '</div>';
    }

    /**
     * Blog post list markup for blog & search page
     *
     * => Used in files:
     *
     * /template-parts/content-blog.php
     * /template-parts/content-search.php
     */
    function entry_content_blog_template() {
        if ( ! analytica_is_post_archive_page() ) { 
            return;
        }
        get_template_part( 'template-parts/blog/blog-layout' );
    }

    /**
     * Analytica Pagination
     *
     * @return void            Generate & echo pagination markup.
     */
    function number_pagination() {
        
        global $numpages;
        
        $enabled = apply_filters( 'analytica_pagination_enabled', true );

        if ( ! isset( $numpages ) || ! $enabled || ! analytica_is_post_archive_page() ) {
            return;
        }

        ob_start();
        
        echo "<div class='analytica-pagination'>";
        
        the_posts_pagination(
            array(
                'prev_text'    => analytica_default_strings( 'string-blog-navigation-previous', false ),
                'next_text'    => analytica_default_strings( 'string-blog-navigation-next', false ),
                'taxonomy'     => 'category',
                'in_same_term' => true,
            )
        );

        echo '</div>';

        $output = ob_get_clean();

        echo apply_filters( 'analytica_pagination_markup', $output ); // WPCS: XSS OK.
    }
}
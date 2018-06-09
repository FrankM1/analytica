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
class Page_Not_Found {

    /**
     * Constructor
     *
     * @since 1.0.0
     */
     public function __construct() {
        add_action( 'analytica_template_parts_content_none', array( $this, 'template_parts_404' ) ); 
        add_action( 'analytica_entry_content_404_page', array( $this, 'entry_content_404_page_template' ) );
    }

    /**
     * Template part 404
     *
     * @since 1.0.0
     * @return void
     */
    public function template_parts_404() {
        if ( ! is_404() ) { 
            return;
        }
        get_template_part( 'template-parts/content', '404' );
    }

    /**
     * 404 markup
     *
     * => Used in files:
     *
     * /template-parts/content-404.php
     *
     * @since 1.0.0
     */
    function entry_content_404_page_template() {
        
        $layout_404 = analytica_get_option( 'analytica-404-layout' );
        $layout_404 = str_replace( '404-layout-', '', $layout_404 );

        // Default 404 is nothing but the 404 layout 1.
        if ( '1' == $layout_404 ) {
            $layout_404 = '';
        }

        get_template_part( 'template-parts/404/404-layout', $layout_404 );
    }

}
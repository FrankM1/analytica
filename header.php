<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     http://radiumthemes.com/
 */

/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up until <div class="site-inner">
 *
 * @since 1.0.0
 */
do_action( 'analytica_doctype' );
do_action( 'analytica_meta' );
do_action( 'analytica_title' );

wp_head(); // we need this for plugins

?></head><?php 

analytica_markup( array(
    'element' => '<body %s>',
    'context' => 'body',
) );

do_action( 'analytica_before' );

analytica_markup( array(
    'element' => '<div %s>',
    'context' => 'site-container',
) );

do_action( 'analytica_body_top' ); 

?><div id="page" class="hfeed site">
    <a class="skip-link screen-reader-text" href="#content"><?php echo esc_html( analytica_default_strings( 'string-header-skip-link', false ) ); ?></a><?php

    do_action( 'analytica_header_before' );

    do_action( 'analytica_header' );

    do_action( 'analytica_header_after' );

    do_action( 'analytica_content_before' ); 
    
    ?><div id="content" class="site-content has-container"><?php
            
            do_action( 'analytica_content_top' );

                analytica_markup( array(
                    'element' => '<div %s>',
                    'context' => 'site-inner',
                ) );

                analytica_structural_wrap( 'site-inner', 'open' );

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
if ( ! analytica_is_php_version_compatible() ) {
    return;
}

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

analytica_markup( array(
    'element' => '<div %s>',
    'context' => 'site',
) );

    do_action( 'analytica_header_before' );

    do_action( 'analytica_header' );

    do_action( 'analytica_header_after' );

    do_action( 'analytica_content_before' ); 

        analytica_markup( array(
            'element' => '<div %s>',
            'context' => 'site-content',
        ) );
                
            do_action( 'analytica_content_top' );

                analytica_markup( array(
                    'element' => '<div %s>',
                    'context' => 'site-inner',
                ) );

                analytica_structural_wrap( 'site-inner', 'open' );

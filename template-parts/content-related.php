<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Analytica
 * @since 1.0.0
 */

do_action( 'analytica_entry_related_before' );

analytica_markup( array( 'element' => '<article %s>', 'context' => 'article' ));

    do_action( 'analytica_entry_related_top' );

    do_action( 'analytica_entry_related_content_blog' );

    do_action( 'analytica_entry_related_bottom' );

analytica_markup( array( 'element' => '</article>' ));

do_action( 'analytica_entry_related_after' );

?>

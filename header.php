<?php
/**
 * The header for Analytica Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Analytica
 * @since 1.0.0
 */

?><!DOCTYPE html>
<?php do_action( 'analytica_html_before' ); ?>
<html <?php language_attributes(); ?>>
<head>
<?php do_action( 'analytica_head_top' );; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php do_action( 'analytica_head_bottom' ); ?>
<?php wp_head(); ?>
</head>

<body <?php analytica_schema_body(); ?> <?php body_class(); ?>>
    <div class="site-container"><?php

        do_action( 'analytica_body_top' ); 

        ?><div id="page" class="hfeed site">

            <a class="skip-link screen-reader-text" href="#content"><?php echo esc_html( analytica_default_strings( 'string-header-skip-link', false ) ); ?></a><?php

            do_action( 'analytica_header_before' );

            do_action( 'analytica_header' );

            do_action( 'analytica_header_after' );

            do_action( 'analytica_content_before' ); 
            
            ?><div id="content" class="site-content">

                <div class="ast-container">

                    <?php do_action( 'analytica_content_top' );

                        analytica_markup( array(
                            'html5' => '<div %s>',
                            'context' => 'site-inner',
                        ) );

                        analytica_structural_wrap( 'site-inner', 'open' );

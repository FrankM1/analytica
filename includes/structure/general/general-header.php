<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

add_action( 'analytica_doctype', 'analytica_do_doctype' );
/**
 * Echo the doctype and opening markup.
 *
 * The default doctype is HTML5
 *
 * @since 1.0.0
 */
function analytica_do_doctype() {
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head><?php
}

add_filter( 'wp_title', 'analytica_wp_title', 10, 2 );
/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since 1.0.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function analytica_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() ) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo( 'name', 'display' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
        /* translators: %s: page number */
        $title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'analytica' ), max( $paged, $page ) );
    }

    return $title;
}

add_action( 'analytica_meta', 'analytica_browser_theme_color' );
/**
 * Optionally output the theme color tag.
 *
 * Child theme needs to support 'analytica-responsive-viewport'.
 *
 * Applies `analytica_viewport_value` filter on content attribute.
 *
 * @since 1.0.6
 *
 * @return null Return early if child theme does not support theme color tag.
 */
function analytica_browser_theme_color() {

    if ( ! current_theme_supports( 'analytica-browser-theme-color' ) ) { return; }

    /**
     * Filter the viewport meta tag value.
     *
     * @param string $viewport_default Default value of the theme color meta tag.
     */
    $value = apply_filters( 'analytica_browser_theme_color_value', analytica_get_option('site-accent-color') );

    printf( '<meta name="theme-color" content="%s" />' . "\n", esc_attr( $value ) );

}

add_action( 'analytica_meta', 'analytica_responsive_viewport' );
/**
 * Optionally output the responsive CSS viewport tag.
 *
 * Child theme needs to support 'analytica-responsive-viewport'.
 *
 * Applies `analytica_viewport_value` filter on content attribute.
 *
 * @since 1.0.0
 *
 * @return null Return early if child theme does not support viewport.
 */
function analytica_responsive_viewport() {

    if ( ! current_theme_supports( 'analytica-responsive-viewport' ) ) { return; }

    /**
     * Filter the viewport meta tag value.
     *
     * @param string $viewport_default Default value of the viewport meta tag.
     */
    $viewport_value = apply_filters( 'analytica_viewport_value', 'width=device-width, initial-scale=1' );

    printf( '<meta name="viewport" content="%s" />' . "\n", esc_attr( $viewport_value ) );

}

add_action( 'wp_head', 'analytica_do_meta_pingback' );
/**
 * Adds the pingback meta tag to the head so that other sites can know how to send a pingback to our site.
 *
 * @since 1.0.0
 */
function analytica_do_meta_pingback() {

    if ( 'open' === get_option( 'default_ping_status' ) ) {
        echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '" />' . "\n";
    }

}

add_action( 'analytica_site_title', 'analytica_site_title' );
/**
 * Echo the site title in the header.
 *
 * Applies the 'analytica_title' filter before echoing.
 *
 * @since 1.0.0
 */
function analytica_site_title() {

    // Build the title
    $output = '<div class="site-title-wrapper" itemprop="headline">';

    if ( is_front_page() ) {
        $output .= '<h1 class="site-title">';
    } else {
        $output .= '<div class="site-title">';
    }

    if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {

        $output .= get_custom_logo();

    } else {

        $output .= '<a href="' . trailingslashit( esc_url( home_url() ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home">';
        $output .= get_bloginfo( 'name' );
        $output .= '</a>';

    }

    if ( is_front_page() ) {
        $output .= '</h1>';
    } else {
        $output .= '</div>';
    }

    $output .= '</div>';

    echo analytica_sanitize_html( $output );
}

add_action( 'analytica_site_description', 'analytica_site_description' );
/**
 * Echo the site description in the header.
 *
 * Depending on the SEO option set by the user, this will either be wrapped in an 'h1' or 'p' element.
 *
 * Applies the 'analytica_seo_description' filter before echoing.
 *
 * @since 1.0.0
 */
function analytica_site_description() {

    if ( ! display_header_text() ) {
        return;
    }

    analytica_markup( array(
        'element' => '<p %s>',
        'context' => 'site-description',
    ));

    echo esc_html( get_bloginfo( 'description' ) );

    analytica_markup( array(
        'element' => '</p>',
    ));

}

add_action( 'analytica_header_before', 'analytica_site_skip_link', 5 );
/**
 * Echo the site skip link in the header.
 *
 * @since 1.0.0
 */
function analytica_site_skip_link () {
    ?><a class="skip-link screen-reader-text" href="#content"><?php echo esc_html( analytica_default_strings( 'string-header-skip-link', false ) ); ?></a><?php
}

add_action( 'template_redirect', 'analytica_site_hero_support' );
/**
 * Page header support.
 *
 * @since 1.0.0
 */
function analytica_site_hero_support() {
    analytica()->site_hero = new \Analytica\Site_Hero();
}

add_action( 'analytica_content_top', 'analytica_do_site_hero', 2 );
/**
 * Echo the default header, including the #title-area div, along with #title and #description, as well as the .widget-area.
 *
 * Added at prioriy 11 incase we want to insert something before the page headers
 *
 * @since 1.0.0
 */
function analytica_do_site_hero() {
    if ( ! analytica_is_site_hero_available() ) {
        return;
    }

    analytica()->site_hero->do_header();
}

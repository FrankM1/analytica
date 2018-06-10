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
    <!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
    <!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head><?php
}

add_action( 'analytica_meta', 'analytica_do_meta' );
/**
 * Header markup
 *
 * @since 1.0.0
 */
function analytica_do_meta() {

global $is_IE;

?><meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php if ( $is_IE ) { ?><meta http-equiv="X-UA-Compatible" content="IE=edge"><?php }

if ( class_exists('All_in_One_SEO_Pack') || class_exists('WPSEO_Frontend') || class_exists( 'Platinum_SEO_Pack' ) || class_exists( 'SEO_Ultimate' ) ) return;

?><meta name="description" content="<?php
    if ( is_single() ) {

        $the_post = get_post( get_the_ID() ); // Gets post by ID
        $the_excerpt = $the_post->post_content; // Gets post_content to be used as a basis for the excerpt
        $the_excerpt = strip_tags( strip_shortcodes( $the_excerpt ) ); // Strips tags and images
        echo wp_kses( trim( substr( $the_excerpt, 0, 145 ) ), analytica_get_allowed_tags() );

    } else {
        bloginfo( 'name' ); echo ' - '; bloginfo( 'description' );
    }
    ?>" /><?php
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
     * @since 1.5.4
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

add_action( 'wp_head', 'analytica_site_author' );
/**
 * Echo custom rel="author" link tag.
 *
 * If the appropriate information has been entered, either for the homepage author, or for an individual post/page
 * author, echo a custom rel="author" link.
 *
 * @since 1.0.0
 *
 * @uses analytica_get_option() Get SEO setting value.
 *
 * @return null Return null on failure.
 */
function analytica_site_author() {

    $post = get_post();

    if ( is_singular() && post_type_supports( $post->post_type, 'analytica-rel-author' ) && isset( $post->post_author ) && $gplus_url = get_user_option( 'googleplus', $post->post_author ) ) {
        printf( '<link rel="author" href="%s" />' . "\n", esc_url( $gplus_url ) );
        return;
    }

    if ( is_author() && get_query_var( 'author' ) && $gplus_url = get_user_option( 'googleplus', get_query_var( 'author' ) ) ) {
        printf( '<link rel="author" href="%s" />' . "\n", esc_url( $gplus_url ) );
        return;
    }

}

add_action( 'wp_head', 'analytica_wpmu_signup_stylesheet', 1 );
/**
 * Remove Inline Style added by Multisite in the Signup Form
 *
 * @since 1.0.0
 */
function analytica_wpmu_signup_stylesheet() {
    remove_action( 'wp_head', 'wpmu_signup_stylesheet' );
}

add_action( 'wp_head', 'analytica_site_publisher' );
/**
 * Echo custom rel="publisher" link tag.
 *
 * If the appropriate information has been entered and we are viewing the front page, echo a custom rel="publisher" link.
 *
 * @since 1.0.0
 *
 * @uses analytica_get_option() Get SEO setting value.
 */
function analytica_site_publisher() {

    if ( is_front_page() && $publisher_url = analytica_get_option( 'site-publisher-uri' ) ) {
        printf( '<link rel="publisher" href="%s" />', esc_url( $publisher_url ) );
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

        $output .= '<a href="' . esc_url( trailingslashit( home_url() ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home">';
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

    if ( ! analytica_get_option( 'site-description' ) && get_bloginfo( 'description' ) ) {
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

add_action( 'template_redirect', 'analytica_hero_support' );
/**
 * Page header support.
 *
 * @since 1.0.0
 */
function analytica_hero_support() {
    analytica()->hero = new \Analytica\Site_Hero();
}

add_action( 'analytica_content_top', 'analytica_do_hero', 2 );
/**
 * Echo the default header, including the #title-area div, along with #title and #description, as well as the .widget-area.
 *
 * Added at prioriy 11 incase we want to insert something before the page headers
 *
 * @since 1.0.0
 */
function analytica_do_hero() {
    if ( ! analytica_is_site_hero_available() ) {
        return;
    }

    analytica()->hero->do_header();
}

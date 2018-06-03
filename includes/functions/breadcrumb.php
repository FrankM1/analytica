<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Radium\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://radiumthemes.com/
 */

/**
 * Helper function for the Radium Breadcrumb Class.
 *
 * @since 1.0.0
 *
 * @global \Analytica\Breadcrumb $_analytica_breadcrumb
 *
 * @param array $args Breadcrumb arguments.
 */
function analytica_breadcrumb( $args = array() ) {

    global $_analytica_breadcrumb;

    if ( ! $_analytica_breadcrumb ) {
        $_analytica_breadcrumb = new \Analytica\Breadcrumb();
    }

    $_analytica_breadcrumb->output( $args );

}

add_action( 'analytica_do_breadcrumbs', 'analytica_do_breadcrumbs' );
/**
 * Display Breadcrumbs above the Loop. Concedes priority to popular breadcrumb
 * plugins.
 *
 * @since 1.0.0
 *
 * @return null Return null if a popular breadcrumb plugin is active
 */
function analytica_do_breadcrumbs() {

    if (
        ( ( 'posts' === get_option( 'show_on_front' ) && is_home() ) && ! analytica_get_option( 'breadcrumb_home' ) ) ||
        ( ( 'page' === get_option( 'show_on_front' ) && is_front_page() ) && ! analytica_get_option( 'breadcrumb_front_page' ) ) ||
        ( ( 'page' === get_option( 'show_on_front' ) && is_home() ) && ! analytica_get_option( 'breadcrumb_posts_page' ) ) ||
        ( is_single() && ! analytica_get_option( 'breadcrumb_single' ) ) ||
        ( is_page() && ! analytica_get_option( 'breadcrumb_page' ) ) ||
        ( ( is_archive() || is_search() ) && ! analytica_get_option( 'breadcrumb_archive' ) ) ||
        ( is_404() && ! analytica_get_option( 'breadcrumb_404' ) ) ||
        ( is_attachment() && ! analytica_get_option( 'breadcrumb_attachment' ) )
    ) {
        return;
    }

    $breadcrumb_markup_open = sprintf( '<div %s>', analytica_attr( 'breadcrumb' ) );

    if ( function_exists( 'bcn_display' ) ) {
        echo analytica_get_sanitized_output( $breadcrumb_markup_open ); // WPCS: XSS ok.
        bcn_display();
        echo '</div>';
    } elseif ( function_exists( 'breadcrumbs' ) ) {
        breadcrumbs();
    } elseif ( function_exists( 'crumbs' ) ) {
        crumbs();
    } elseif ( class_exists( 'WPSEO_Breadcrumbs' ) && analytica_get_option( 'breadcrumbs-enable', 'wpseo_internallinks' ) ) {
        yoast_breadcrumb( $breadcrumb_markup_open, '</div>' );
    } elseif ( function_exists( 'yoast_breadcrumb' ) && ! class_exists( 'WPSEO_Breadcrumbs' ) ) {
        yoast_breadcrumb( $breadcrumb_markup_open, '</div>' );
    } else {
        $args = array(
            'home'   => analytica_get_option( 'breadcrumb_home_label' ),
            'sep'    => analytica_get_option( 'breadcrumb_sep' ),
            'labels' => array(
                'prefix' => trim( analytica_get_option( 'breadcrumb_prefix' ) ) . ' ',
                'author'    => esc_html__( 'Archives for ', 'analytica' ),
                'category'  => esc_html__( 'Archives for ', 'analytica' ),
                'tag'       => esc_html__( 'Archives for ', 'analytica' ),
                'date'      => esc_html__( 'Archives for ', 'analytica' ),
                'search'    => esc_html__( 'Search for ', 'analytica' ),
                'tax'       => esc_html__( 'Archives for ', 'analytica' ),
                'post_type' => esc_html__( 'Archives for ', 'analytica' ),
                '404'       => esc_html__( 'Not found: ', 'analytica' ),
            ),
        );
        analytica_breadcrumb( $args );
    }
}

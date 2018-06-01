<?php
/**
 * This file is a part of the analytica Framework core.
 * Please be cautious editing this file,
 *
 * @category analytica\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://analyticathemes.com/
 */

add_filter( 'content_width', 'analytica_content_width', 10, 3 );
/**
 * Filter the content width based on the user selected layout.
 *
 * @since 1.0.0
 *
 * @uses analytica_site_layout() Get the site layout for current context.
 *
 * @param integer $default Default width.
 * @param integer $small   Small width.
 * @param integer $large   Large width.
 *
 * @return integer Content width.
 */
function analytica_content_width( $default, $small, $large ) {

    switch ( analytica_site_layout( 0 ) ) {
        case _analytica_return_full_width_content():
            $width = $large;
            break;
        case _analytica_return_content_sidebar_sidebar():
        case _analytica_return_sidebar_content_sidebar():
        case _analytica_return_sidebar_sidebar_content():
            $width = $small;
            break;
        default:
            $width = $default;
    }

    return $width;

}

add_action( 'analytica_left_sidebar', 'analytica_get_sidebar' );
/**
 * Output the sidebar.php file if layout allows for it.
 *
 * @since 1.0.0
 *
 * @uses analytica_site_layout() Return the site layout for different contexts.
 */
function analytica_get_sidebar() {

    $site_layout = analytica_site_layout();

    // Don't load sidebar on pages that don't need it
    if ( _analytica_return_full_width_content() === $site_layout ) {
        return;
    }

    get_sidebar();

}

add_action( 'analytica_right_sidebar', 'analytica_get_sidebar_alt' );
/**
 * Output the sidebar_alt.php file if layout allows for it.
 *
 * @since 1.0.0
 *
 * @uses analytica_site_layout() Return the site layout for different contexts.
 */
function analytica_get_sidebar_alt() {

    $site_layout = analytica_site_layout();

    // Don't load sidebar-alt on pages that don't need it
    if ( in_array( $site_layout, array( _analytica_return_content_sidebar(), _analytica_return_sidebar_content(), _analytica_return_full_width_content() ) ) ) {
        return;
    }

    get_sidebar( 'alt' );

}

add_filter( 'the_password_form', 'analytica_get_custom_password_form' );
/**
 * Modify the WordPress post password form
 *
 * @param  [type] $output [description]
 * @return [type]         [description]
 */
function analytica_get_custom_password_form( $output ) {

    global $post;

    $label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );

    $output = '<form class="protected-post-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '/wp-pass.php" method="post">';
        $output .= '<div class="ricon ricon-lock"></div>';
        $output .= '<p>' . esc_html__( 'This content is password protected. To view it please enter your password below.', 'analytica' ) . '</p>';
        $output .= '<label class="pass-label" for="' . $label . '">' . esc_html__( 'Password:', 'analytica' ) . ' </label>';
        $output .= '<div class="password-form-group">';
            $output .= '<input name="post_password" id="' . $label . '" type="password" size="20" />';
            $output .= '<input type="submit" name="Submit" class="button" value="' . esc_attr__( 'Submit', 'analytica' ) . '" />';
        $output .= '</div>';

    $output .= '</form>';

    return $output;
}

add_filter( 'the_excerpt', 'analytica_excerpt_class' );
add_filter( 'get_the_excerpt', 'analytica_excerpt_class' );
/**
 * Make sure that all excerpts have class="excerpt".
 *
 * @since 1.0.0
 *
 * return string with new class added
 */
function analytica_excerpt_class( $excerpt ) {
    return str_replace( '<p', '<p class="excerpt"', $excerpt );
}

//add_filter( 'wp_link_pages_link', 'analytica_post_pagination_link' );
/**
 * Add <li> element to post pagination links.
 *
 * @since 1.0.0
 *
 * @return string
 */
function analytica_post_pagination_link( $link ) {
    return '<li>'. $link .'</li>';
}

add_filter( 'the_category', 'analytica_add_nofollow_cat' );
/**
 * Fix for catgeogry rel tag (Produces invalid html5 code).
 *
 * @since 1.0.0
 */
function analytica_add_nofollow_cat( $text ) {
    $text = str_replace( 'rel="category tag"', '', $text );

    return apply_filters( __FUNCTION__, $text );
}

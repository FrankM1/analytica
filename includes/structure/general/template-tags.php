<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Analytica
 */

/**
 * Wrapper function for get_the_title() for blog post.
 *
 * Displays title only if the page title bar is disabled.
 *
 * @since 1.0.15
 * @param string $before Optional. Content to prepend to the title.
 * @param string $after  Optional. Content to append to the title.
 * @param int    $post_id Optional, default to 0. Post id.
 * @param bool   $echo   Optional, default to true.Whether to display or return.
 * @return string|void String if $echo parameter is false.
 */
function analytica_the_post_title( $before = '', $after = '', $post_id = 0, $echo = true ) {

    $enabled = apply_filters( 'analytica_the_post_title_enabled', true );
    if ( $enabled ) {

        $title  = analytica_get_the_title( $post_id );
        $before = apply_filters( 'analytica_the_post_title_before', $before );
        $after  = apply_filters( 'analytica_the_post_title_after', $after );

        // This will work same as `the_title` function but with Custom Title if exits.
        if ( $echo ) {
            echo $before . $title . $after; // WPCS: XSS OK.
        } else {
            return $before . $title . $after;
        }
    }
}

/**
 * Wrapper function for the_title()
 *
 * Displays title only if the page title bar is disabled.
 *
 * @param string $before Optional. Content to prepend to the title.
 * @param string $after  Optional. Content to append to the title.
 * @param int    $post_id Optional, default to 0. Post id.
 * @param bool   $echo   Optional, default to true.Whether to display or return.
 * @return string|void String if $echo parameter is false.
 */
function analytica_the_title( $before = '', $after = '', $post_id = 0, $echo = true ) {

    $title             = '';
    $blog_post_title   = analytica_get_option( 'archive-content-structure'            , [] );
    $single_post_title = analytica_get_option( 'single-post-structure', [] );

    if ( ( ( ! is_singular() && in_array( 'title-meta', $blog_post_title ) ) || ( is_single() && in_array( 'single-title-meta', $single_post_title ) ) || is_page() ) ) {
        if ( apply_filters( 'analytica_the_title_enabled', true ) ) {

            $title  = analytica_get_the_title( $post_id );
            $before = apply_filters( 'analytica_the_title_before', $before );
            $after  = apply_filters( 'analytica_the_title_after', $after );

            $title = $before . $title . $after;
        }
    }

    // This will work same as `the_title` function but with Custom Title if exits.
    if ( $echo ) {
        echo wp_kses( $title, analytica_get_allowed_tags() ); 
    } else {
        return $title;
    }
}

/**
 * Wrapper function for get_the_title()
 *
 * Return title for Title Bar and Normal Title.
 *
 * @param int  $post_id Optional, default to 0. Post id.
 * @param bool $echo   Optional, default to false. Whether to display or return.
 * @return string|void String if $echo parameter is false.
 */
function analytica_get_the_title( $post_id = 0, $echo = false ) {

    $title = '';
    if ( $post_id || is_singular() ) {
        $title = get_the_title( $post_id );
    } else {
        if ( is_front_page() && is_home() ) {
            // Default homepage.
            $title = apply_filters( 'analytica_the_default_home_page_title', esc_html__( 'Home', 'analytica' ) );
        } elseif ( is_home() ) {
            // blog page.
            $title = apply_filters( 'analytica_the_blog_home_page_title', get_the_title( get_option( 'page_for_posts', true ) ) );
        } elseif ( is_404() ) {
            // for 404 page - title always display.
            $title = apply_filters( 'analytica_the_404_page_title', esc_html__( 'This page doesn\'t seem to exist.', 'analytica' ) );

            // for search page - title always display.
        } elseif ( is_search() ) {

            /* translators: 1: search string */
            $title = apply_filters( 'analytica_the_search_page_title', sprintf( __( 'Search Results for: %s', 'analytica' ), '<span>' . get_search_query() . '</span>' ) );

        } elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {

            $title = woocommerce_page_title( false );

        } elseif ( is_archive() ) {

            $title = get_the_archive_title();

        }
    }

    // This will work same as `get_the_title` function but with Custom Title if exits.
    if ( $echo ) {
        echo wp_kses( $title, analytica_get_allowed_tags() ); 
    } else {
        return $title;
    }
}

 /**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function analytica_entry_footer() {

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

        /**
         * Get default strings.
         *
         * @see analytica_default_strings
         */
        echo '<span class="comments-link">';
        comments_popup_link( analytica_default_strings( 'string-blog-meta-leave-a-comment', false ), analytica_default_strings( 'string-blog-meta-one-comment', false ), analytica_default_strings( 'string-blog-meta-multiple-comment', false ) );
        echo '</span>';
    }

    analytica_edit_post_link(
        sprintf(
            /* translators: %s: Name of current post */
            esc_html__( 'Edit %s', 'analytica' ),
            the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ),
        '<span class="edit-link">',
        '</span>'
    );
}

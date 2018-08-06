<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Analytica
 */

/**
 * Function to get Edit Post Link
 *
 * @since 1.0.0
 * @param string $text      Anchor Text.
 * @param string $before    Anchor Text.
 * @param string $after     Anchor Text.
 * @param int    $id           Anchor Text.
 * @param string $class     Anchor Text.
 * @return void
 */
function analytica_edit_post_link( $text, $before = '', $after = '', $id = 0, $class = 'post-edit-link' ) {

    if ( apply_filters( 'analytica_edit_post_link', false ) ) {
        edit_post_link( $text, $before, $after, $id, $class );
    }
}

/**
 * Display Blog Post Excerpt
 *
 * @since 1.0.0
 */
function analytica_the_excerpt() {

    $excerpt_type = analytica_get_option( 'archive-post-content'             );

    do_action( 'analytica_the_excerpt_before', $excerpt_type );

    if ( 'full-content' == $excerpt_type ) {
        the_content();
    } else {
        the_excerpt();
    }

    do_action( 'analytica_the_excerpt_after', $excerpt_type );
}

/**
 * Analytica entry header class
 *
 * @since 1.0.15
 */
function analytica_entry_header_class() {

    $post_id          = analytica_get_post_id();
    $classes          = array();
    $title_markup     = analytica_the_title( '', '', $post_id, false );
    $thumb_markup     = analytica_get_post_thumbnail( '', '', false );
    $post_meta_markup = analytica_single_get_post_meta( '', '', false );

    if ( empty( $title_markup ) && empty( $thumb_markup ) && ( is_page() || empty( $post_meta_markup ) ) ) {
        $classes[] = 'analytica-header-without-markup';
    } else {

        if ( empty( $title_markup ) ) {
            $classes[] = 'analytica-no-title';
        }

        if ( empty( $thumb_markup ) ) {
            $classes[] = 'analytica-no-thumbnail';
        }

        if ( is_page() || empty( $post_meta_markup ) ) {
            $classes[] = 'analytica-no-meta';
        }
    }

    $classes = array_unique( apply_filters( 'analytica_entry_header_class', $classes ) );
    $classes = array_map( 'sanitize_html_class', $classes );

    echo esc_attr( join( ' ', $classes ) );
}

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
            echo wp_kses( $before . $title . $after, analytica_get_allowed_tags() ); 
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

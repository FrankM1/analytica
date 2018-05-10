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
 * Output markup conditionally.
 *
 * Supported keys for `$args` are:
 *
 *  - `html5` (`sprintf()` pattern markup),
 *  - `context` (name of context),
 *  - `echo` (default is true).
 *
 * This function will output the `html5` value, with a call to `analytica_attr()`
 * with the same context added in.
 *
 * Applies a `analytica_markup_{context}` filter early to allow shortcutting the function.
 *
 * Applies a `analytica_markup_{context}_output` filter at the end.
 *
 * @since 1.0.0
 *
 * @uses analytica_attr()  Contextual attributes.
 *
 * @param array $args Array of arguments.
 *
 * @return string Markup.
 */
function analytica_markup( $args = [] ) {
    $defaults = [
        'html5' => '',
        'context' => '',
        'echo' => true,
    ];

    $args = wp_parse_args( $args, $defaults );

    if ( ! $args['html5'] ) {
        return '';
    }

    $tag = $args['context'] ? sprintf( $args['html5'], analytica_attr( $args['context'] ) ) : $args['html5'];

    // Contextual filter
    $tag = $args['context'] ? apply_filters( "analytica_markup_{$args['context']}_output", $tag, $args ) : $tag;

    if ( $args['echo'] ) {
        echo analytica_sanitize_allowed_tag( $tag ); // WPCS: XSS ok.
    } else {
        return $tag;
    }
}

/**
 * Potentially echo or return a structural wrap div.
 *
 * A check is made to see if the `$context` is in the `analytica-structural-wraps` theme support data. If so, then the
 * `$output` may be echoed or returned.
 *
 * @since 1.0.0
 *
 * @param string $context The location ID.
 * @param string $output  Optional. The markup to include. Can also be 'open'
 *                        (default) or 'closed' to use pre-determined markup for consistency.
 * @param bool   $echo    Optional. Whether to echo or return. Default is true (echo).
 *
 * @return string Wrap HTML.
 */
function analytica_structural_wrap( $context = '', $output = 'open', $echo = true ) {
    $wraps = get_theme_support( 'analytica-structural-wraps' );

    // If theme doesn't support structural wraps, bail.
    if ( ! $wraps ) {
        return;
    }

    if ( ! in_array( $context, (array) $wraps[0] ) ) {
        return '';
    }

    // Save original output param
    $original_output = $output;

    switch ( $output ) {
        case 'open':
            $output = sprintf( '<div %s>', analytica_attr( 'structural-wrap' ) );
            break;
        case 'close':
            $output = '</div>';
            break;
    }

    $output = apply_filters( "analytica_structural_wrap-{$context}", $output, $original_output );

    if ( $echo ) {
        echo analytica_sanitize_allowed_tag( $output );  // WPCS: XSS ok.
    } else {
        return $output;
    }
}

/**
 * Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * The contextual filter is of the form `analytica_attr_{context}`.
 *
 * @since 1.0.0
 *
 * @param string $context    The context, to build filter name.
 * @param array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return array Merged and filtered attributes.
 */
function analytica_parse_attr( $context, $attributes = [] ) {
    $defaults = [
        'class' => sanitize_html_class( $context ),
    ];

    $attributes = wp_parse_args( $attributes, $defaults );

    // Contextual filter
    return apply_filters( "analytica_attr_{$context}", $attributes, $context );
}

/**
 * Build list of attributes into a string and apply contextual filter on string.
 *
 * The contextual filter is of the form `analytica_attr_{context}_output`.
 *
 * @since 1.0.0
 *
 * @uses analytica_parse_attr() Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * @param string $context    The context, to build filter name.
 * @param array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return string String of HTML attributes and values.
 */
function analytica_attr( $context, $attributes = [] ) {
    $attributes = analytica_parse_attr( $context, $attributes );

    $output = '';

    // Cycle through attributes, build tag attribute string
    foreach ( $attributes as $key => $value ) {
        if ( !$value ) {
            continue;
        }
        $output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
    }

    $output = apply_filters( 'analytica_attr_' . $context . '_output', $output, $attributes, $context );

    return trim( $output );
}

add_filter( 'analytica_attr_body', 'analytica_attributes_body' );
/**
 * Add attributes for body element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_body( $attributes ) {
    $attributes['class'] = implode( ' ', get_body_class() );
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/WebPage';

    // Search results pages
    if ( is_search() ) {
        $attributes['itemtype'] = 'https://schema.org/SearchResultsPage';
    }

    if ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'blog.php' ) ) {
        $attributes['itemtype'] = 'https://schema.org/Blog';
    }

    return $attributes;
}

add_filter( 'analytica_attr_nav-primary', 'analytica_attributes_nav' );
add_filter( 'analytica_attr_nav-secondary', 'analytica_attributes_nav' );
add_filter( 'analytica_attr_nav-header', 'analytica_attributes_nav' );
/**
 * Add typical attributes for navigation elements.
 *
 * Used for primary navigation, secondary navigation, and custom menu widgets in the header right widget area.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_nav( $attributes ) {
    $attributes['role'] = 'navigation';
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/SiteNavigationElement';

    return $attributes;
}

add_filter( 'analytica_attr_breadcrumb', 'analytica_attributes_breadcrumb' );
/**
 * Add attributes for breadcrumb wrapper.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Ammended attributes
 */
function analytica_attributes_breadcrumb( $attributes ) {
    $attributes['itemprop'] = 'breadcrumb';
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/BreadcrumbList';

    return $attributes;
}

add_filter( 'analytica_attr_search-form', 'analytica_attributes_search_form' );
/**
 * Add attributes for search form.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_search_form( $attributes ) {
    $attributes['itemprop'] = 'potentialAction';
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/SearchAction';
    $attributes['method'] = 'get';
    $attributes['action'] = home_url( '/' );
    $attributes['role'] = 'search';

    return $attributes;
}

add_filter( 'analytica_attr_structural-wrap', 'analytica_attributes_structural_wrap' );
/**
 * Add attributes for structural wrap element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_structural_wrap( $attributes ) {
    $attributes['class'] = 'container';

    return $attributes;
}

add_filter( 'analytica_attr_content', 'analytica_attributes_content' );
/**
 * Add attributes for main content element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_content( $attributes ) {
    if ( !( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'blog.php' ) ) ) {
        $attributes['itemprop'] = 'mainContentOfPage';
    }

    return $attributes;
}

add_filter( 'analytica_attr_content-sidebar-wrap', 'analytica_attributes_content_sidebar_wrap' );
/**
 * Add attributes for content sidebar wrap element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_content_sidebar_wrap( $attributes ) {
    if ( !analytica_is_builder_page()  ) {
        $attributes['class'] .= ' container';
    }

    return $attributes;
}

add_filter( 'analytica_attr_entry', 'analytica_attributes_entry' );
/**
 * Add attributes for entry element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry( $attributes ) {
    $attributes['class'] = implode( ' ', get_post_class() );

    if ( !is_main_query() ) {
        return $attributes;
    }

    if ( !is_page_template( 'blog.php' ) ) {
        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/CreativeWork';
    }

    // Blog posts microdata
    if ( 'post' === get_post_type() ) {
        $attributes['itemscope'] = 'itemscope';
        $attributes['itemtype'] = 'https://schema.org/BlogPosting';

        // If main query,
        if ( !is_search() ) {
            $attributes['itemprop'] = 'blogPost';
        }
    }

    return $attributes;
}

add_filter( 'analytica_attr_entry-image', 'analytica_attributes_entry_image' );
/**
 * Add attributes for entry image element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_image( $attributes ) {
    $attributes['class'] = 'post-image entry-image';
    $attributes['itemprop'] = 'image';

    return $attributes;
}

add_filter( 'analytica_attr_entry-image-widget', 'analytica_attributes_entry_image_widget' );
/**
 * Add attributes for entry image element shown in a widget.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_image_widget( $attributes ) {
    $attributes['class'] = 'entry-image attachment-' . get_post_type();
    $attributes['itemprop'] = 'image';

    return $attributes;
}

add_filter( 'analytica_attr_entry-image-grid-loop', 'analytica_attributes_entry_image_grid_loop' );
/**
 * Add attributes for entry image element shown in a grid loop.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_image_grid_loop( $attributes ) {
    $attributes['itemprop'] = 'image';

    return $attributes;
}

add_filter( 'analytica_attr_entry-author', 'analytica_attributes_entry_author' );
/**
 * Add attributes for author element for an entry.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_author( $attributes ) {
    $attributes['itemprop'] = 'author';
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/Person';

    return $attributes;
}

add_filter( 'analytica_attr_entry-author-link', 'analytica_attributes_entry_author_link' );
/**
 * Add attributes for entry author link element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_author_link( $attributes ) {
    $attributes['itemprop'] = 'url';
    $attributes['rel'] = 'author';

    return $attributes;
}

add_filter( 'analytica_attr_entry-author-name', 'analytica_attributes_entry_author_name' );
/**
 * Add attributes for entry author name element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_author_name( $attributes ) {
    $attributes['itemprop'] = 'name';

    return $attributes;
}

add_filter( 'analytica_attr_entry-time', 'analytica_attributes_entry_time' );
/**
 * Add attributes for time element for an entry.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_time( $attributes ) {
    $attributes['itemprop'] = 'datePublished';
    $attributes['datetime'] = get_the_time( 'c' );

    return $attributes;
}

add_filter( 'analytica_attr_entry-modified-time', 'analytica_attributes_entry_modified_time' );
/**
 * Add attributes for modified time element for an entry.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_modified_time( $attributes ) {
    $attributes['itemprop'] = 'dateModified';
    $attributes['datetime'] = get_the_modified_time( 'c' );

    return $attributes;
}

add_filter( 'analytica_attr_entry-title', 'analytica_attributes_entry_title' );
/**
 * Add attributes for entry title element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_title( $attributes ) {
    $attributes['itemprop'] = 'headline';

    return $attributes;
}

add_filter( 'analytica_attr_entry-content', 'analytica_attributes_entry_content' );
/**
 * Add attributes for entry content element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_content( $attributes ) {
    if ( !is_single() && 'post' === get_post_type() ) {
        $attributes['class'] = 'entry-summary';
    } else {
        $attributes['class'] = 'entry-content';
    }

    $attributes['itemprop'] = 'text';

    return $attributes;
}

add_filter( 'analytica_attr_entry-excerpt', 'analytica_attributes_entry_excerpt' );
/**
 * Add attributes for entry excerpt element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_excerpt( $attributes ) {
    $attributes['itemprop'] = 'description';

    return $attributes;
}

add_filter( 'analytica_attr_entry-meta-before-post-header', 'analytica_attributes_entry_meta_post_header' );
/**
 * Add attributes for entry meta post header elements.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_meta_post_header( $attributes ) {
    $attributes['class'] = 'entry-meta entry-categories';

    return $attributes;
}

add_filter( 'analytica_attr_entry-meta-before-content', 'analytica_attributes_entry_meta' );
add_filter( 'analytica_attr_entry-meta-after-content', 'analytica_attributes_entry_meta' );
/**
 * Add attributes for entry meta elements.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_meta( $attributes ) {
    $attributes['class'] = 'entry-meta';

    return $attributes;
}

add_filter( 'analytica_attr_archive-pagination', 'analytica_attributes_pagination' );
add_filter( 'analytica_attr_entry-pagination', 'analytica_attributes_pagination' );
add_filter( 'analytica_attr_adjacent-entry-pagination', 'analytica_attributes_pagination' );
add_filter( 'analytica_attr_comments-pagination', 'analytica_attributes_pagination' );
/**
 * Add attributes for pagination.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_pagination( $attributes ) {
    $attributes['class'] .= ' pagination';

    return $attributes;
}

add_filter( 'analytica_attr_entry-comments', 'analytica_attributes_entry_comments' );
/**
 * Add attributes for entry comments element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_entry_comments( $attributes ) {
    $attributes['id'] = 'comments';

    return $attributes;
}

add_filter( 'analytica_attr_comment', 'analytica_attributes_comment' );
/**
 * Add attributes for single comment element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_comment( $attributes ) {
    $attributes['class'] = '';
    $attributes['itemprop'] = 'comment';
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/UserComments';

    return $attributes;
}

add_filter( 'analytica_attr_comment-author', 'analytica_attributes_comment_author' );
/**
 * Add attributes for comment author element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_comment_author( $attributes ) {
    $attributes['itemprop'] = 'creator';
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/Person';

    return $attributes;
}

add_filter( 'analytica_attr_comment-author-link', 'analytica_attributes_comment_author_link' );
/**
 * Add attributes for comment author link element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_comment_author_link( $attributes ) {
    $attributes['rel'] = 'external nofollow';
    $attributes['itemprop'] = 'url';

    return $attributes;
}

add_filter( 'analytica_attr_comment-time', 'analytica_attributes_comment_time' );
/**
 * Add attributes for comment time element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_comment_time( $attributes ) {
    $attributes['datetime'] = esc_attr( get_comment_time( 'c' ) );
    $attributes['itemprop'] = 'commentTime';

    return $attributes;
}

add_filter( 'analytica_attr_comment-time-link', 'analytica_attributes_comment_time_link' );
/**
 * Add attributes for comment time link element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_comment_time_link( $attributes ) {
    $attributes['itemprop'] = 'url';

    return $attributes;
}

add_filter( 'analytica_attr_comment-content', 'analytica_attributes_comment_content' );
/**
 * Add attributes for comment content container.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_comment_content( $attributes ) {
    $attributes['itemprop'] = 'commentText';

    return $attributes;
}

add_filter( 'analytica_attr_author-box', 'analytica_attributes_author_box' );
/**
 * Add attributes for author box element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_author_box( $attributes ) {
    $attributes['itemprop'] = 'author';
    $attributes['itemscope'] = true;
    $attributes['itemtype'] = 'https://schema.org/Person';

    return $attributes;
}

add_filter( 'analytica_attr_sidebar-primary', 'analytica_attributes_sidebar_primary' );
/**
 * Add attributes for primary sidebar element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_sidebar_primary( $attributes ) {
    $attributes['class'] = 'sidebar sidebar-primary widget-area';
    $attributes['aria-label'] = esc_html__( 'Primary Sidebar', 'analytica' );
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/WPSideBar';

    return $attributes;
}

add_filter( 'analytica_attr_sidebar-secondary', 'analytica_attributes_sidebar_secondary' );
/**
 * Add attributes for secondary sidebar element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_sidebar_secondary( $attributes ) {
    $attributes['class'] = 'sidebar sidebar-secondary widget-area';
    $attributes['aria-label'] = esc_html__( 'Secondary Sidebar', 'analytica' );
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/WPSideBar';

    return $attributes;
}

add_filter( 'analytica_attr_site-footer', 'analytica_attributes_site_footer' );
/**
 * Add attributes for site footer wrapper element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_site_footer( $attributes ) {
    if ( 'layout-fullwidth' != analytica_get_option( 'footer-width' ) ) {
        $attributes['class'] = 'site-footer has-container';
    } else {
        $attributes['class'] = 'site-footer full-width';
    }

    if ( analytica_footer_is_parallax() && !analytica_is_fullpage_scroll() ) {
        $attributes['class'] .= ' footer-parallax';
    }

    return $attributes;
}

add_filter( 'analytica_attr_footer-widgets', 'analytica_attributes_site_footer_widgets' );
/**
 * Add attributes for site footer element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_site_footer_widgets( $attributes ) {

    if ( 'layout-fullwidth' != analytica_get_option( 'footer-width' ) ) {
        $attributes['class'] .= ' has-container';
    } else {
        $attributes['class'] .= ' full-width';
    }

    return $attributes;
}

add_filter( 'analytica_attr_site-colophon', 'analytica_attributes_site_colophon' );
/**
 * Add attributes for site footer element.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function analytica_attributes_site_colophon( $attributes ) {
    $attributes['itemscope'] = 'itemscope';
    $attributes['itemtype'] = 'https://schema.org/WPFooter';

    if ( 'layout-fullwidth' != analytica_get_option( 'footer-colophon-width' ) ) {
        $attributes['class'] = 'site-colophon has-container';
    } else {
        $attributes['class'] = 'site-colophon full-width';
    }

    return $attributes;
}

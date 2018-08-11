
 <?php
/**
 * This file is a part of the analytica Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

add_action( 'init', 'analytica_create_initial_layouts', 0 );
/**
 * Register default layouts.
 *
 * This theme comes with six layouts registered by default. These are:
 *
 *  - content-sidebar (default)
 *  - sidebar-content
 *  - content-sidebar-sidebar
 *  - sidebar-sidebar-content
 *  - sidebar-content-sidebar
 *  - full-width-content
 *
 * @since 1.0.0
 *
 * @uses analytica_register_layout() Register a layout.
 * @uses analytica() to determine URL path to admin images.
 */
function analytica_create_initial_layouts() {

    // Common path to default layout images
    $url = analytica()->theme_url . '/assets/admin/images/layouts/';

    $layouts = apply_filters( 'analytica_initial_layouts', [
        _analytica_return_content_sidebar() => [
            'label' => esc_html__( 'Content, Primary Sidebar', 'analytica' ),
            'img' => $url . 'cs.gif',
            'default' => is_rtl() ? false : true,
        ],
        _analytica_return_sidebar_content() => [
            'label' => esc_html__( 'Primary Sidebar, Content', 'analytica' ),
            'img' => $url . 'sc.gif',
            'default' => is_rtl() ? true : false,
        ],
        _analytica_return_full_width_content() => [
            'label' => esc_html__( 'Full Width Content', 'analytica' ),
            'img' => $url . 'c.gif',
        ],
    ], $url );

    foreach ( (array) $layouts as $layout_id => $layout_args ) {
        analytica_register_layout( $layout_id, $layout_args );
    }
}

/**
 * Return the layout that is set to default.
 *
 * @since 1.0.0
 *
 * @global array $_analytica_layouts Holds all layout data.
 *
 * @return string Return ID of the layout, or 'nolayout'.
 */
function analytica_get_default_layout() {
    global $_analytica_layouts;

    $default = _analytica_return_content_sidebar();

    foreach ( (array) $_analytica_layouts as $key => $value ) {
        if ( isset( $value['default'] ) && $value['default'] ) {
            $default = $key;
            break;
        }
    }

    return $default;
}


/**
 * Return registered layouts in a format the WordPress Customizer accepts.
 *
 * @since 1.0.0
 *
 * @return array Registered layouts.
 */
function analytica_get_layouts_for_options() {
    // Common path to default layout images
    $url = analytica()->theme_url . '/assets/admin/images/layouts/';

    return [
        _analytica_return_content_sidebar() => $url . 'cs.gif',
        _analytica_return_sidebar_content() => $url . 'sc.gif',
        _analytica_return_full_width_content() => $url . 'c.gif',
    ];
}


 /**
 * Return all registered  layouts.
 *
 * @since 1.0.0
 *
 * @global array $_analytica_layouts Holds all layout data.
 *
 * @param string $type Layout type to return. Leave empty to return all types.
 *
 * @return array Registered layouts.
 */
function analytica_get_layouts( $type = '' ) {
    global $_analytica_layouts;

    // If no layouts exists, return empty array
    if ( !is_array( $_analytica_layouts ) ) {
        $_analytica_layouts = [];

        return $_analytica_layouts;
    }

    // Return all layouts, if no type specified
    if ( '' === $type ) {
        return $_analytica_layouts;
    }

    $layouts = [];

    // Cycle through looking for layouts of $type
    foreach ( (array) $_analytica_layouts as $id => $data ) {
        if ( $data['type'] === $type ) {
            $layouts[ $id ] = $data;
        }
    }

    return $layouts;
}

 /**
 * Return the data from a single layout, specified by the $id passed to it.
 *
 * @since 1.0.0
 *
 * @uses analytica_get_layouts() Return all registered layouts.
 *
 * @param string $id ID of the layout to return data for.
 *
 * @return null|array Returns null if ID is not set, or layout is not registered. Returns array of layout data
 *                    otherwise, with 'label' and 'image' (and possibly 'default') sub-keys.
 */
function analytica_get_layout( $id ) {
    $layouts = analytica_get_layouts();

    if ( ! $id || ! isset( $layouts[ $id ] ) ) {
        return;
    }

    return $layouts[ $id ];
}

 /**
 * Return the site layout for different contexts.
 *
 * Checks both the custom field and the theme option to find the user-selected site layout, and returns it.
 *
 * Applies `analytica_site_layout` filter early to allow shortcutting of function.
 *
 * @since 1.0.0
 *
 * @uses analytica_get_custom_field()              Get per-post layout value.
 * @uses analytica_get_option()                    Get theme setting layout value.
 * @uses analytica_get_default_layout()            Get default from registered layouts.
 * @uses analytica_has_post_type_archive_support() Check if a post type supports an archive setting page.
 *
 * @param bool $use_cache Conditional to use cache or get fresh.
 *
 * @return string Key of layout.
 */
function analytica_site_layout( $use_cache = false ) {
    /**
     * Filter the value before it is retrieved.
     *
     * Passing a truthy value to the filter will short-circuit retrieving
     * the option value, returning the passed value instead.
     *
     * @since 1.0.0
     *
     * @param bool|mixed $pre_option Value to return instead of the option value.
     *                               Default false to skip it.
     * @param string     $layout     Option name.
     */
    $pre = apply_filters( 'analytica_site_layout_pre', false );

    if ( false !== $pre ) {
        return $pre;
    }

    // If we're supposed to use the cache, setup cache. Use if value exists.
    if ( $use_cache ) {
        // Setup cache
        static $layout_cache = '';

        // If cache is populated, return value
        if ( '' !== $layout_cache ) {
            return esc_attr( $layout_cache );
        }
    }

    // Else pull the theme option
    $site_layout = analytica_get_option( 'site-sidebar-layout' );

    // Exit early if all sidebars disabled on mobile
    if ( is_404() ||
        ( wp_is_mobile() && ! analytica_get_option( 'site-sidebar-enable-mobile' ) ) ||
        ! analytica_get_option( 'site-sidebar-enable' )
    ) {
        return apply_filters( 'analytica_site_layout', _analytica_return_full_width_content() );
    }

    if ( is_singular( 'post' ) ) {
        $site_layout = analytica_get_option( 'single-post-layout' );
    }

    // If viewing a singular page or post
    if ( is_singular() ) {
        $custom_field = analytica_get_custom_field( '_analytica-layout' );
        $site_layout = $custom_field ? $custom_field : $site_layout;
        if ( ! post_type_supports( get_post_type(), 'analytica-layouts' ) ) {
			return apply_filters('analytica_site_layout', _analytica_return_full_width_content());
        }
    } elseif ( is_category() || is_tag() || is_tax() ) {
        // If viewing a taxonomy archive
        $term_id = get_queried_object()->term_id;
        $custom_field = get_term_meta( $term_id, 'layout', true );
        $site_layout = $custom_field ? $custom_field : analytica_get_option( 'archive-sidebar-layout' );
    } elseif ( is_post_type_archive() && analytica_has_post_type_archive_support() ) {
    } elseif ( is_author() ) {
        // If viewing an author archive
        $site_layout = get_the_author_meta( 'layout', (int) get_query_var( 'author' ) ) ? get_the_author_meta( 'layout', (int) get_query_var( 'author' ) ) : $site_layout;
    } elseif ( is_search() ) {
        // If viewing search template
        $site_layout = analytica_get_option( 'search-sidebar-layout' );
    } elseif ( is_home() ) {
        $custom_field = analytica_get_custom_field( '_analytica-layout', get_option( 'page_for_posts' ) );
        $site_layout = $custom_field ? $custom_field : $site_layout;
    }

    // Use default layout as a fallback, if necessary
    if ( ! analytica_get_layout( $site_layout ) ) {
        $site_layout = analytica_get_default_layout();
    }

    // Push layout into cache, if caching turned on
    if ( $use_cache ) {
        $layout_cache = $site_layout;
    }

    $site_layout = apply_filters( 'analytica_site_layout', $site_layout );

    // Return site layout
    return esc_attr( $site_layout );
}

/**
 * Return layout key 'content-sidebar'.
 *
 * Used as shortcut second parameter for `add_filter()`.
 *
 * @since 1.0.0
 *
 * @return string 'content-sidebar'
 */
function _analytica_return_content_sidebar() {
    return 'content-sidebar';
}

/**
 * Return layout key 'sidebar-content'.
 *
 * Used as shortcut second parameter for `add_filter()`.
 *
 * @since 1.0.0
 *
 * @return string 'sidebar-content'
 */
function _analytica_return_sidebar_content() {
    return 'sidebar-content';
}

/**
 * Return layout key 'content-sidebar-sidebar'.
 *
 * Used as shortcut second parameter for `add_filter()`.
 *
 * @since 1.0.0
 *
 * @return string 'content-sidebar-sidebar'
 */
function _analytica_return_content_sidebar_sidebar() {
    return 'content-sidebar-sidebar';
}

/**
 * Return layout key 'sidebar-sidebar-content'.
 *
 * Used as shortcut second parameter for `add_filter()`.
 *
 * @since 1.0.0
 *
 * @return string 'sidebar-sidebar-content'
 */
function _analytica_return_sidebar_sidebar_content() {
    return 'sidebar-sidebar-content';
}

/**
 * Return layout key 'sidebar-content-sidebar'.
 *
 * Used as shortcut second parameter for `add_filter()`.
 *
 * @since 1.0.0
 *
 * @return string 'sidebar-content-sidebar'
 */
function _analytica_return_sidebar_content_sidebar() {
    return 'sidebar-content-sidebar';
}

/**
 * Return layout key 'full-width-content'.
 *
 * Used as shortcut second parameter for `add_filter()`.
 *
 * @since 1.0.0
 *
 * @return string 'full-width-content'
 */
function _analytica_return_full_width_content() {
    return 'full-width-content';
}

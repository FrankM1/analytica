<?php
/**
 * Widget and sidebars related functions
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

add_filter( 'widget_tag_cloud_args', 'analytica_widget_tag_cloud_args', 90 );
/**
 * WordPress filter - Widget Tags
 *
 * @param  array $args Tag arguments.
 * @return array       Modified tag arguments.
 */
function analytica_widget_tag_cloud_args( $args = array() ) {

    $sidebar_link_font_size            = analytica_get_option( 'font-size-body' );
    $sidebar_link_font_size['desktop'] = ( '' != $sidebar_link_font_size['desktop'] ) ? $sidebar_link_font_size['desktop'] : 15;

    $args['smallest'] = intval( $sidebar_link_font_size['desktop'] ) - 2;
    $args['largest']  = intval( $sidebar_link_font_size['desktop'] ) + 3;
    $args['unit']     = 'px';

    return apply_filters( 'analytica_widget_tag_cloud_args', $args );
}

add_filter( 'wp_generate_tag_cloud_data', 'analytica_filter_widget_tag_cloud' );
/**
 * WordPress filter - Widget Categories
 *
 * @param  array $tags_data Tags data.
 * @return array            Modified tags data.
 */
function analytica_filter_widget_tag_cloud( $tags_data ) {

    if ( is_tag() ) {
        foreach ( $tags_data as $key => $tag ) {
            if ( get_queried_object_id() === (int) $tags_data[ $key ]['id'] ) {
                $tags_data[ $key ]['class'] = $tags_data[ $key ]['class'] . ' current-item';
            }
        }
    }

    return apply_filters( 'analytica_filter_widget_tag_cloud', $tags_data );
}

add_action( 'analytica_left_sidebar', 'analytica_left_sidebar' );
/**
 * Add left sidebar.
 */
function analytica_left_sidebar() {
    if ( analytica_page_layout() == 'left-sidebar' ) :
	    get_sidebar();
    endif;
}

add_action( 'analytica_right_sidebar', 'analytica_right_sidebar' );
/**
 * Add right sidebar.
 */
function analytica_right_sidebar() {
    if ( analytica_page_layout() == 'right-sidebar' ) :
	    get_sidebar();
    endif;
}

/**
 * Expedites the widget area registration process by taking common things, before / after_widget, before / after_title,
 * and doing them automatically.
 *
 * See the WP function `register_sidebar()` for the list of supports $args keys.
 *
 * A typical usage is:
 *
 * ~~~
 * analytica_register_widget_area(
 *     array(
 *         'id'          => 'my-sidebar',
 *         'name'        => esc_html__( 'My Sidebar', 'energia' ),
 *         'description' => esc_html__( 'A description of the intended purpose or location', 'energia' ),
 *     )
 * );
 * ~~~
 *
 * @since 1.0.0
 *
 * @uses analytica_markup() Contextual markup.
 *
 * @param string|array $args Name, ID, description and other widget area arguments.
 *
 * @return string The sidebar ID that was added.
 */
function analytica_register_widget_area( $args ) {

    $defaults = array(
        'before_widget' => analytica_markup( array(
            'html5' => '<div id="%1$s" class="analytica-qazana-widget clearfix widget %2$s"><div class="widget-wrap">',
            'echo'  => false,
        ) ),
        'after_widget'  => analytica_markup( array(
            'html5' => '</div></div>' . "\n",
            'echo'  => false,
        ) ),
        'before_title'  => '<div class="section-title clearfix"><h5 class="widget-title"><span>',
        'after_title'   => "</span></h5></div>\n",
    );

    /**
     * A filter on the default parameters used by `analytica_register_widget_area()`.
     *
     * @since 1.0.0
     */
    $defaults = apply_filters( 'analytica_register_widget_area_defaults', $defaults, $args );

    $args = wp_parse_args( $args, $defaults );

    return register_sidebar( $args );
}

add_action( 'after_setup_theme', '_analytica_builtin_sidebar_params' );
/**
 * Alters the widget area params array for HTML5 compatibility.
 *
 * @since 1.0.0
 *
 * @uses analytica_html5() Check if HTML5 is supported.
 *
 * @global $wp_registered_sidebars Holds all of the registered sidebars.
 */
function _analytica_builtin_sidebar_params() {

    global $wp_registered_sidebars;

    foreach ( $wp_registered_sidebars as $id => $params ) {

        if ( ! isset( $params['_analytica_builtin'] ) ) {
            continue;
        }

        $wp_registered_sidebars[ $id ]['before_widget'] = '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">';
        $wp_registered_sidebars[ $id ]['after_widget']  = '</div></div>';

    }

}

add_action( 'after_setup_theme', 'analytica_register_default_widget_areas' );
/**
 * Register the default analytica widget areas.
 *
 * @since 1.0.0
 *
 * @uses analytica_register_widget_area() Register widget areas.
 */
function analytica_register_default_widget_areas() {

    // hack to register more widget areas (useful for ordering widgets)
    do_action( 'analytica_register_before_default_widget_areas' );

    $sidebars = get_theme_support( 'analytica-sidebars' );

    if ( is_array( $sidebars[0] ) ) {

        foreach ( $sidebars[0] as $menu => $data ) {

            analytica_register_widget_area(
                array(
                    'id'               => $menu,
                    'name'             => $data['name'],
                    'description'      => $data['description'],
                    '_analytica_builtin'  => isset( $data['builtin'] ) ? $data['builtin'] : true,
                )
            );
        }
    }

    // hack to register more widget areas (useful for ordering widgets)
    do_action( 'analytica_register_after_default_widget_areas' );

}

add_action( 'after_setup_theme', 'analytica_register_footer_widget_areas' );
/**
 * Register ast-small-footer footer-sml-layout-1 widget areas based on the number of widget areas the user wishes to create with `add_theme_support()`.
 *
 * @since 1.0.0
 *
 * @uses analytica_register_widget_area() Register footer widget areas.
 */
function analytica_register_footer_widget_areas() {

    $layout = analytica_get_option( 'site-footer-layout' );

    switch ( $layout ) {

        case 'layout-1':
            $footer_widgets = 1;
            break;

        case 'layout-2':
        case 'layout-5':
        case 'layout-8':
            $footer_widgets = 2;
            break;

        case 'layout-3':
        case 'layout-6':
        case 'layout-7':
        case 'layout-9':
            $footer_widgets = 3;
            break;

        case 'layout-10':
            $footer_widgets = 5;
            break;

        default:
            $footer_widgets = 4;
            break;
    }

    $counter = 1;

    while ( $counter <= $footer_widgets ) {
        analytica_register_widget_area(
            array(
                'id'                => sprintf( 'footer-%d', $counter ),
                'name'              => sprintf( esc_html__( 'Footer %d', 'energia' ), $counter ),
                'description'       => sprintf( esc_html__( 'Footer %d widget area.', 'energia' ), $counter ),
                '_analytica_builtin'   => true,
            )
        );

        $counter++;
    }

}

add_action( 'after_setup_theme', 'analytica_register_after_entry_widget_area' );
/**
 * Register after-entry widget area if user specifies in the child theme.
 *
 * @since 1.0.0
 *
 * @uses analytica_register_widget_area() Register widget area.
 *
 * @return null Return early if there's no theme support.
 */
function analytica_register_after_entry_widget_area() {

    if ( ! current_theme_supports( 'analytica-after-entry-widget-area' ) ) {
        return;
    }

    analytica_register_widget_area(
        array(
            'id'          => 'after-entry',
            'name'        => esc_html__( 'After Entry', 'energia' ),
            'description' => esc_html__( 'Widgets in this widget area will display after single entries.', 'energia' ),
            '_builtin'    => true,
        )
    );

}

/**
 * Conditionally display a sidebar, wrapped in a div by default.
 *
 * The $args array accepts the following keys:
 *
 *  - `before` (markup to be displayed before the widget area output),
 *  - `after` (markup to be displayed after the widget area output),
 *  - `default` (fallback text if the sidebar is not found, or has no widgets, default is an empty string),
 *  - `show_inactive` (flag to show inactive sidebars, default is false),
 *  - `before_sidebar_hook` (hook that fires before the widget area output),
 *  - `after_sidebar_hook` (hook that fires after the widget area output).
 *
 * Return false early if the sidebar is not active and the `show_inactive` argument is false.
 *
 * @since 1.0.0
 *
 * @param string $id   Sidebar ID, as per when it was registered.
 * @param array  $args Arguments.
 *
 * @return boolean False if $args['show_inactive'] set to false and sidebar is not currently being used. True otherwise.
 */
function analytica_widget_area( $id, $args = array() ) {

    if ( ! $id ) {
        return false;
    }

    $args = wp_parse_args(
        $args,
        array(
            'before'              => '<aside class="widget-area"><div class="widget-area-inner">',
            'after'               => '</div></aside>',
            'default'             => '',
            'show_inactive'       => 0,
            'before_sidebar_hook' => 'analytica_before_' . $id . '_widget_area',
            'after_sidebar_hook'  => 'analytica_after_' . $id . '_widget_area',
        )
    );

    if ( ! is_active_sidebar( $id ) && ! $args['show_inactive'] ) {
        return false;
    }

    // Opening markup
    echo analytica_sanitize_html( $args['before'] ); // WPCS: XSS ok.

    // Before hook
    if ( $args['before_sidebar_hook'] ) {
        do_action( $args['before_sidebar_hook'] );
    }

    if ( ! dynamic_sidebar( $id ) ) {
        echo analytica_sanitize_html( $args['default'] ); // WPCS: XSS ok.
    }

    // After hook
    if ( $args['after_sidebar_hook'] ) {
        do_action( $args['after_sidebar_hook'] );
    }

    // Closing markup
    echo analytica_sanitize_html( $args['after'] ); // WPCS: XSS ok.

    return true;
}

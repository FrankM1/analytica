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

/**
 * Determine if a child theme supports a particular nav menu.
 *
 * @since 1.0.0
 *
 * @param string $menu Name of the menu to check support for.
 *
 * @return boolean True if menu supported, false otherwise.
 */
function analytica_nav_menu_supported( $menu ) {

    if ( ! current_theme_supports( 'analytica-menus' ) ) {
        return false;
    }

    $menus = get_theme_support( 'analytica-menus' );

    if ( array_key_exists( $menu, (array) $menus[0] ) ) {
        return true;
    }

    return false;

}

/**
 * Radium_mega_menu cache the megamenu for performance boost
 *
 * @param array $args nav menu arguments
 *
 * @return string       return cached menu
 */
function analytica_mega_menu( $args ) {
    return apply_filters( __FUNCTION__, wp_nav_menu( $args ) );
}

/**
 * Create a navigation out of pages if the user didn't create a menu in the backend
 */
function analytica_fallback_menu() {
    echo '<div id="main-menu" class="main_menu fallback_menu nav-primary">';
        echo '<ul id="menu-main-menu" class="analytica_mega menu dl-menu">';

        $args = array(
            'title_li'    => null,
            'depth'       => 3,
            'sort_column' => 'menu_order',
            'child_of'    => 0,
            'walker'      => new Analytica\Fallback_Menu_Walker(),
        );

        wp_list_pages( $args );
    echo '</ul></div>';
}

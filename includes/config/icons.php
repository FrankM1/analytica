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
 * Retrun preset icon loaders
 *
 * @param  integer $style 1,2,3 etc.
 *
 * @return string icon.
 */
function analytica_get_loading_indicator( $style = 1, $classes = '', $size = '', $color = '' ) {
    switch ( $style ) {
        case 2:
            $icon = '<span class="loader loading-indicator-pulse"><span></span><span></span><span></span></span>';
        break;

        case 3:
            $icon = '<span class="loader-color-spinner"><span class="spinner"></span></span>';
        break;

        default:
            $icon = '<span class="loader loader-spinner loading-indicator"></span>';
            break;
    }

    return apply_filters( __FUNCTION__, $icon, $style );
}

/**
 * Svg Icons
 *
 * @param  integer $style   [description]
 * @param  string  $classes [description]
 * @param  string  $size    [description]
 * @param  string  $color   [description]
 * @return [type]           [description]
 */
function analytica_get_ui_icons( $icon, $style = 1 ) {
    $icon = '<span class="ricon ricon-' . $icon . ' style-' . $style . '"></span>';
    return apply_filters( __FUNCTION__, $icon, $style );
}

/**
 * Svg Icons
 *
 * @param  integer $style   [description]
 * @param  string  $classes [description]
 * @param  string  $size    [description]
 * @param  string  $color   [description]
 * @return [type]           [description]
 */
function analytica_ui_icons( $icon, $style = 1 ) {
    echo analytica_get_ui_icons( $icon, $style );
}

<?php
namespace Analytica\Fonts;

/**
 * Helper class for font settings.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Fonts Data
 */
final class Data {

    /**
     * Localize Fonts
     */
    static public function js() {

        $system = json_encode( Families::get_system_fonts() );
        $google = json_encode( Families::get_google_fonts() );
        $custom = json_encode( Families::get_custom_fonts() );
        if ( ! empty( $custom ) ) {
            return 'var AstFontFamilies = { system: ' . $system . ', custom: ' . $custom . ', google: ' . $google . ' };';
        } else {
            return 'var AstFontFamilies = { system: ' . $system . ', google: ' . $google . ' };';
        }
    }
}

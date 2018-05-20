<?php
/**
 * Functions for Analytica Theme.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Helper function for writing to log file.
 *
 * @since 1.0.0
 *
 * @param log data to log
 * @param type log or export
 */
function analytica_write_log( $log, $type = '1' ) {
    if ( true === WP_DEBUG ) {
        if ( is_array( $log ) || is_object( $log ) ) {
            if ( $type === '1' ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( var_export( $log, true ) );
            }
        } else {
            error_log( $log );
        }
    }
}

/**
 * Retrieve Post Thumbnail ID.
 *
 * @since 1.0.0
 *
 * @param int|null $post_id Optional. Post ID.
 * @return mixed
 */
function analytica_get_post_thumbnail_id( $post_id = null ) {

    $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
    $post_thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

    /**
     * Filter the image id result.
     *
     * @since 1.0.0
     *
     * @param int  $post_thumbnail_id     The featured image id
     * @param int  $post_id         the parent id
     */
    return apply_filters( __FUNCTION__, $post_thumbnail_id, $post_id );
}

/**
 * Get an attachment ID given a URL.
 *
 * @param string $url
 *
 * @return int Attachment ID on success, 0 on failure
 */
function analytica_get_attachment_id_from_url( $url ) {
	$attachment_id = 0;
	$dir = wp_upload_dir();
	if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
		$file = basename( $url );
		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			)
		);
		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post_id ) {
				$meta = wp_get_attachment_metadata( $post_id );
				$original_file       = basename( $meta['file'] );
				$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
				if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
					$attachment_id = $post_id;
					break;
				}
			}
		}
	}
	return $attachment_id;
}


/**
 * Foreground Color
 *
 * @param  string $hex Color code in HEX format.
 * @return string      Return foreground color depend on input HEX color.
 */
function analytica_get_foreground_color( $hex ) {

    if ( 'transparent' == $hex || 'false' == $hex || '#' == $hex || empty( $hex ) ) {
        return 'transparent';

    } else {

        // Get clean hex code.
        $hex = str_replace( '#', '', $hex );

        if ( 3 == strlen( $hex ) ) {
            $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
        }

        // Get r, g & b codes from hex code.
        $r   = hexdec( substr( $hex, 0, 2 ) );
        $g   = hexdec( substr( $hex, 2, 2 ) );
        $b   = hexdec( substr( $hex, 4, 2 ) );
        $hex = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;

        return 128 <= $hex ? '#000000' : '#ffffff';
    }
}

/**
 * Detect if we should use a light or dark colour on a background colour.
 *
 * @param mixed  $color
 * @param string $dark  (default: '#000000')
 * @param string $light (default: '#FFFFFF')
 *
 * @return string
 */
function analytica_light_or_dark( $color, $dark = '#000000', $light = '#FFFFFF' ) {
    $hex = str_replace( '#', '', $color );

    $c_r = hexdec( substr( $hex, 0, 2 ) );
    $c_g = hexdec( substr( $hex, 2, 2 ) );
    $c_b = hexdec( substr( $hex, 4, 2 ) );

    $brightness = (($c_r * 299) + ($c_g * 587) + ($c_b * 114) ) / 1000;

    return $brightness > 155 ? $dark : $light;
}

/**
 * Get Font CSS value
 *
 * @param  array  $font    CSS value.
 * @param  string $device  CSS device.
 * @param  string $default Default value.
 * @return mixed
 */
function analytica_responsive_font( $font, $device = 'desktop', $default = '' ) {

    $css_val = '';

    if ( isset( $font[ $device ] ) && isset( $font[ $device . '-unit' ] ) ) {
        if ( '' != $default ) {
            $font_size = analytica_get_css_value( $font[ $device ], $font[ $device . '-unit' ], $default );
        } else {
            $font_size = analytica_get_font_css_value( $font[ $device ], $font[ $device . '-unit' ] );
        }
    } elseif ( is_numeric( $font ) ) {
        $font_size = analytica_get_css_value( $font );
    } else {
        $font_size = ( ! is_array( $font ) ) ? $font : '';
    }

    return $font_size;
}

/**
 * Get Font CSS value
 *
 * Syntax:
 *
 *  analytica_get_font_css_value( VALUE, DEVICE, UNIT );
 *
 * E.g.
 *
 *  analytica_get_css_value( VALUE, 'desktop', '%' );
 *  analytica_get_css_value( VALUE, 'tablet' );
 *  analytica_get_css_value( VALUE, 'mobile' );
 *
 * @param  string $value        CSS value.
 * @param  string $unit         CSS unit.
 * @param  string $device       CSS device.
 * @return mixed                CSS value depends on $unit & $device
 */
function analytica_get_font_css_value( $value, $unit = 'px', $device = 'desktop' ) {

    // If value is empty or 0 then return blank.
    if ( '' == $value || 0 == $value ) {
        return '';
    }

    $css_val = '';

    switch ( $unit ) {
        case 'em':
        case '%':
                    $css_val = esc_attr( $value ) . $unit;
            break;

        case 'px':
            if ( is_numeric( $value ) || strpos( $value, 'px' ) ) {
                $value            = intval( $value );
                $fonts            = array();
                $body_font_size   = analytica_get_option( 'font-size-body' );
                $fonts['desktop'] = ( isset( $body_font_size['desktop'] ) && '' != $body_font_size['desktop'] ) ? $body_font_size['desktop'] : 15;
                $fonts['tablet']  = ( isset( $body_font_size['tablet'] ) && '' != $body_font_size['tablet'] ) ? $body_font_size['tablet'] : $fonts['desktop'];
                $fonts['mobile']  = ( isset( $body_font_size['mobile'] ) && '' != $body_font_size['mobile'] ) ? $body_font_size['mobile'] : $fonts['tablet'];

                if ( $fonts[ $device ] ) {
                    $css_val = esc_attr( $value ) . 'px;font-size:' . ( esc_attr( $value ) / esc_attr( $fonts[ $device ] ) ) . 'rem';
                }
            } else {
                $css_val = esc_attr( $value );
            }
    }

    return $css_val;
}

/**
 * Get Font family
 *
 * Syntax:
 *
 *  analytica_get_font_family( VALUE, DEFAULT );
 *
 * E.g.
 *  analytica_get_font_family( VALUE, '' );
 *
 * @since  1.0.19
 *
 * @param  string $value       CSS value.
 * @return mixed               CSS value depends on $unit
 */
function analytica_get_font_family( $value = '' ) {
    $system_fonts = Analytica\Fonts\Families::get_system_fonts();
    if ( isset( $system_fonts[ $value ] ) && isset( $system_fonts[ $value ]['fallback'] ) ) {
        $value .= ',' . $system_fonts[ $value ]['fallback'];
    }

    return $value;
}

/**
 * Get CSS value
 *
 * Syntax:
 *
 *  analytica_get_css_value( VALUE, UNIT );
 *
 * E.g.
 *
 *  analytica_get_css_value( VALUE, 'url' );
 *  analytica_get_css_value( VALUE, 'px' );
 *  analytica_get_css_value( VALUE, 'em' );
 *
 * @param  string $value        CSS value.
 * @param  string $unit         CSS unit.
 * @param  string $default      CSS default font.
 * @return mixed               CSS value depends on $unit
 */
function analytica_get_css_value( $value = '', $unit = 'px', $default = '' ) {

    if ( '' == $value && '' == $default ) {
        return $value;
    }

    $css_val = '';

    switch ( $unit ) {

        case 'font':
            if ( 'inherit' != $value ) {
                $value   = analytica_get_font_family( $value );
                $css_val = $value;
            } elseif ( '' != $default ) {
                $css_val = $default;
            }
            break;

        case 'px':
        case '%':
                    $value   = ( '' != $value ) ? $value : $default;
                    $css_val = esc_attr( $value ) . $unit;
            break;

        case 'url':
                    $css_val = $unit . '(' . esc_url( $value ) . ')';
            break;

        case 'rem':
            if ( is_numeric( $value ) || strpos( $value, 'px' ) ) {
                $value          = intval( $value );
                $body_font_size = analytica_get_option( 'font-size-body' );
                if ( is_array( $body_font_size ) ) {
                    $body_font_size_desktop = ( isset( $body_font_size['desktop'] ) && '' != $body_font_size['desktop'] ) ? $body_font_size['desktop'] : 15;
                } else {
                    $body_font_size_desktop = ( '' != $body_font_size ) ? $body_font_size : 15;
                }

                if ( $body_font_size_desktop ) {
                    $css_val = esc_attr( $value ) . 'px;font-size:' . ( esc_attr( $value ) / esc_attr( $body_font_size_desktop ) ) . $unit;
                }
            } else {
                $css_val = esc_attr( $value );
            }

            break;

        default:
            $value = ( '' != $value ) ? $value : $default;
            if ( '' != $value ) {
                $css_val = esc_attr( $value ) . $unit;
            }
    }

    return $css_val;
}

/**
 * Adjust Brightness
 *
 * @param  array $bg_obj   Color code in HEX.
 *
 * @return array         Color code in HEX.
 */
function analytica_get_background_obj( $bg_obj ) {

    $gen_bg_css = array();

    $bg_img   = isset( $bg_obj['background-image'] ) ? $bg_obj['background-image'] : '';
    $bg_color = isset( $bg_obj['background-color'] ) ? $bg_obj['background-color'] : '';

    if ( '' !== $bg_img && '' !== $bg_color ) {
        $gen_bg_css = array(
            'background-color' => 'unset',
            'background-image' => 'linear-gradient(to right, ' . esc_attr( $bg_color ) . ', ' . esc_attr( $bg_color ) . '), url(' . esc_url( $bg_img ) . ')',
        );
    } elseif ( '' !== $bg_img ) {
        $gen_bg_css = array( 'background-image' => 'url(' . esc_url( $bg_img ) . ')' );
    } elseif ( '' !== $bg_color ) {
        $gen_bg_css = array( 'background-color' => esc_attr( $bg_color ) );
    }

    if ( '' !== $bg_img ) {
        if ( isset( $bg_obj['background-repeat'] ) ) {
            $gen_bg_css['background-repeat'] = esc_attr( $bg_obj['background-repeat'] );
        }

        if ( isset( $bg_obj['background-position'] ) ) {
            $gen_bg_css['background-position'] = esc_attr( $bg_obj['background-position'] );
        }

        if ( isset( $bg_obj['background-size'] ) ) {
            $gen_bg_css['background-size'] = esc_attr( $bg_obj['background-size'] );
        }

        if ( isset( $bg_obj['background-attachment'] ) ) {
            $gen_bg_css['background-attachment'] = esc_attr( $bg_obj['background-attachment'] );
        }
    }

    return $gen_bg_css;
}

/**
 * Adjust Brightness
 *
 * @param  string $hex   Color code in HEX.
 * @param  number $steps brightness value.
 * @param  string $type  brightness is reverse or default.
 * @return string        Color code in HEX.
 */
function analytica_adjust_brightness( $hex, $steps, $type ) {

    // Get rgb vars.
    $hex = str_replace( '#', '', $hex );

    $shortcode_atts = array(
        'r' => hexdec( substr( $hex, 0, 2 ) ),
        'g' => hexdec( substr( $hex, 2, 2 ) ),
        'b' => hexdec( substr( $hex, 4, 2 ) ),
    );

    // Should we darken the color?
    if ( 'reverse' == $type && $shortcode_atts['r'] + $shortcode_atts['g'] + $shortcode_atts['b'] > 382 ) {
        $steps = -$steps;
    } elseif ( 'darken' == $type ) {
        $steps = -$steps;
    }

    // Build the new color.
    $steps = max( -255, min( 255, $steps ) );

    $shortcode_atts['r'] = max( 0, min( 255, $shortcode_atts['r'] + $steps ) );
    $shortcode_atts['g'] = max( 0, min( 255, $shortcode_atts['g'] + $steps ) );
    $shortcode_atts['b'] = max( 0, min( 255, $shortcode_atts['b'] + $steps ) );

    $r_hex = str_pad( dechex( $shortcode_atts['r'] ), 2, '0', STR_PAD_LEFT );
    $g_hex = str_pad( dechex( $shortcode_atts['g'] ), 2, '0', STR_PAD_LEFT );
    $b_hex = str_pad( dechex( $shortcode_atts['b'] ), 2, '0', STR_PAD_LEFT );

    return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Convert colors from HEX to RGBA
 *
 * @param  string  $color   Color code in HEX.
 * @param  boolean $opacity Color code opacity.
 * @return string           Color code in RGB or RGBA.
 */
function analytica_hex_to_rgba( $color, $opacity = false ) {

    $default = 'rgb(0,0,0)';

    // Return default if no color provided.
    if ( empty( $color ) ) {
        return $default;
    }

    // Sanitize $color if "#" is provided.
    if ( '#' == $color[0] ) {
        $color = substr( $color, 1 );
    }

    // Check if color has 6 or 3 characters and get values.
    if ( 6 == strlen( $color ) ) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( 3 == strlen( $color ) ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    // Convert HEX to RGB.
    $rgb = array_map( 'hexdec', $hex );

    // Check if opacity is set(RGBA or RGB).
    if ( $opacity ) {
        if ( 1 < abs( $opacity ) ) {
            $opacity = 1.0;
        }
        $output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode( ',', $rgb ) . ')';
    }

    // Return RGB(a) color string.
    return $output;
}

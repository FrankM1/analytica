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
 * Generate CSS
 *
 * @param  mixed  $value         CSS value.
 * @param  string $css_property CSS property.
 * @param  string $selector     CSS selector.
 * @param  string $unit         CSS property unit.
 * @return void               Echo generated CSS.
 */
function analytica_css( $value = '', $css_property = '', $selector = '', $unit = '' ) {

    if ( $selector ) {
        if ( $css_property && $value ) {

            if ( '' != $unit ) {
                $value .= $unit;
            }

            $css  = $selector;
            $css .= '{';
            $css .= '	' . $css_property . ': ' . $value . ';';
            $css .= '}';

            echo $css;
        }
    }
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
 * Display classes for primary div
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return void        Echo classes.
 */
function analytica_primary_class( $class = '' ) {

    // Separates classes with a single space, collates classes for body element.
    echo 'class="' . esc_attr( join( ' ', analytica_get_primary_class( $class ) ) ) . '"';
}

/**
 * Retrieve the classes for the primary element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return array        Return array of classes.
 */
function analytica_get_primary_class( $class = '' ) {

    // array of class names.
    $classes = array();

    // default class for content area.
    $classes[] = 'content-area';

    // primary base class.
    $classes[] = 'primary';

    if ( ! empty( $class ) ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_merge( $classes, $class );
    } else {

        // Ensure that we always coerce class to being an array.
        $class = array();
    }

    // Filter primary div class names.
    $classes = apply_filters( 'analytica_primary_class', $classes, $class );

    $classes = array_map( 'sanitize_html_class', $classes );

    return array_unique( $classes );
}

/**
 * Retrieve the classes for the secondary element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return void        echo classes.
 */
function analytica_secondary_class( $class = '' ) {

    // Separates classes with a single space, collates classes for body element.
    echo 'class="' . esc_attr( join( ' ', get_analytica_secondary_class( $class ) ) ) . '"';
}

/**
 * Retrieve the classes for the secondary element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return array        Return array of classes.
 */
function get_analytica_secondary_class( $class = '' ) {

    // array of class names.
    $classes = array();

    // default class from widget area.
    $classes[] = 'widget-area';

    // secondary base class.
    $classes[] = 'secondary';

    if ( ! empty( $class ) ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_merge( $classes, $class );
    } else {

        // Ensure that we always coerce class to being an array.
        $class = array();
    }

    // Filter secondary div class names.
    $classes = apply_filters( 'analytica_secondary_class', $classes, $class );

    $classes = array_map( 'sanitize_html_class', $classes );

    return array_unique( $classes );
}

/**
 * Get post format
 *
 * @param  string $post_format_override Override post formate.
 * @return string                       Return post format.
 */
function analytica_get_post_format( $post_format_override = '' ) {

    if ( ( is_home() ) || is_archive() ) {
        $post_format = 'blog';
    } else {
        $post_format = get_post_format();
    }

    return apply_filters( 'analytica_get_post_format', $post_format, $post_format_override );
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
    $blog_post_title   = analytica_get_option( 'blog-post-structure', [] );
    $single_post_title = analytica_get_option( 'blog-single-post-structure', [] );

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
        echo $title;
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
        echo $title;
    } else {
        return $title;
    }
}

add_action( 'analytica_archive_header', 'analytica_archive_page_info' );
/**
 * Wrapper function for the_title()
 *
 * Displays title only if the page title bar is disabled.
 */
function analytica_archive_page_info() {

    if ( apply_filters( 'analytica_the_title_enabled', true ) ) {

        // Author.
        if ( is_author() ) { ?>

            <section class="ast-author-box ast-archive-description">
                <div class="ast-author-bio">
                    <h1 class='page-title ast-archive-title'><?php echo get_the_author(); ?></h1>
                    <p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
                </div>
                <div class="ast-author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'email' ), 120 ); ?>
                </div>
            </section>

        <?php

        // Category.
        } elseif ( is_category() ) {
        ?>

            <section class="ast-archive-description">
                <h1 class="page-title ast-archive-title"><?php echo single_cat_title(); ?></h1>
                <?php the_archive_description(); ?>
            </section>

        <?php

        // Tag.
        } elseif ( is_tag() ) {
        ?>

            <section class="ast-archive-description">
                <h1 class="page-title ast-archive-title"><?php echo single_tag_title(); ?></h1>
                <?php the_archive_description(); ?>
            </section>

        <?php

        // Search.
        } elseif ( is_search() ) {
        ?>

            <section class="ast-archive-description">
                <?php
                    /* translators: 1: search string */
                    $title = apply_filters( 'analytica_the_search_page_title', sprintf( __( 'Search Results for: %s', 'analytica' ), '<span>' . get_search_query() . '</span>' ) );
                ?>
                <h1 class="page-title ast-archive-title"> <?php echo $title; ?> </h1>
            </section>

        <?php

        // Other.
        } else {
        ?>

            <section class="ast-archive-description">
                <?php the_archive_title( '<h1 class="page-title ast-archive-title">', '</h1>' ); ?>
                <?php the_archive_description(); ?>
            </section>

    <?php
        }
    }
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

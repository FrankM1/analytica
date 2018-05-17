<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @package  Radium\Extensions\Related-Posts
 * @subpackage  Energia
 * @author   Franklin Gitonga
 * @link     https://analyticathemes.com/
 */

add_filter( 'qazana/widgets/black_list', 'analytica_qazana_wp_widget_black_list' );
/**
 * Clean up qazana widgets
 * 
 * @method analytica_qazana_hero
 * @return [type]                    [description]
 */
function analytica_qazana_wp_widget_black_list( $widgets ){

    $widgets[] = 'WP_Widget_Media_Audio';
    $widgets[] = 'WP_Widget_Media_Image';
    $widgets[] = 'WP_Widget_Media_Video';
    $widgets[] = 'WP_Widget_Meta';
    $widgets[] = 'WP_Widget_Search';
    $widgets[] = 'WP_Widget_Categories';
    $widgets[] = 'WP_Widget_Recent_Posts';
    $widgets[] = 'WP_Widget_Recent_Comments';
    $widgets[] = 'WP_Widget_Tag_Cloud';
    $widgets[] = 'WP_Widget_Custom_HTML';
    $widgets[] = 'Qazana\Extensions\Library\WP_Widgets\Qazana_Library';

    return $widgets;
}

add_filter( 'pre_option_qazana_page_title_selector', 'analytica_qazana_page_title_selector' );
/**
 * [analytica_qazana_hero description]
 * @method analytica_qazana_hero
 * @return [type]                    [description]
 */
function analytica_qazana_page_title_selector(){
    return '.hero h1.heading';
}

add_filter( 'qazana/schemes/default_fonts', 'analytica_live_qazana_reset_default_font' );
/**
 * Detect qazana page
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function analytica_live_qazana_reset_default_font( $locations ) {

    $font_base = analytica_get_option( 'font-base' );

    $fonts = array(
        '1' => array(
            'font_family' => '',
            'font_weight' => '',
        ),
        '2' => array(
            'font_family' => '',
            'font_weight' => '',
        ),
        '3' => array(
            'font_family' => '',
            'font_weight' => '',
        ),
        '4' => array(
            'font_family' => '',
            'font_weight' => '',
        ),
    );

     return $fonts;
}

add_filter( 'qazana/schemes/default_color_schemes', 'analytica_live_qazana_default_colors' );
 /**
  * Detect qazana page
  *
  * @since 1.0.0
  *
  * @return boolean
  */
function analytica_live_qazana_default_colors( $locations ) {

     $font_base = analytica_get_option( 'font-base' );
     $font_secondary = analytica_get_option( 'font-secondary-base' );
     $accent_color = analytica_get_option( 'accent-color' );

     $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
     $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

     $colors = [
         '1' => $font_secondary_color, // Title colors
         '2' => $font_base_color, // Meta color
         '3' => $font_base_color,
         '4' => $accent_color, // Accents color, buttons etc
     ];

    return $colors;
}

add_filter( 'qazana/schemes/system_color_schemes', 'analytica_live_qazana_system_color_schemes' );
 /**
  * Detect qazana page
  *
  * @since 1.0.0
  *
  * @return boolean
  */
function analytica_live_qazana_system_color_schemes( $locations ) {

     $font_base = analytica_get_option( 'font-base' );
     $font_secondary = analytica_get_option( 'font-secondary-base' );
     $accent_color = analytica_get_option( 'accent-color' );

     $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
     $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

     $schemes = [
         'energia' => [
             'title' => 'Energia',
             'items' => [
                 '1' => $font_secondary_color, // Title colors
                 '2' => $font_base_color, // Meta color
                 '3' => $font_base_color,
                 '4' => $accent_color, // Accents color, buttons etc
            ],
        ],
     ];

    return $schemes;
}

add_filter( 'qazana/schemes/default_color_picker_schemes', 'analytica_live_qazana_default_color_picker_schemes' );
 /**
  * Detect qazana page
  *
  * @since 1.0.0
  *
  * @return boolean
  */
function analytica_live_qazana_default_color_picker_schemes( $schemes ) {

     $font_base = analytica_get_option( 'font-base' );
     $font_secondary = analytica_get_option( 'font-secondary-base' );
     $accent_color = analytica_get_option( 'accent-color' );

     $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
     $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

     $schemes = [
         'energia' => [
            'title' => wp_get_theme()->get( 'Name' ),
            'items' => [
                 '1' => $font_secondary_color, // Title colors
                 '2' => $font_base_color, // Meta color
                 '3' => $accent_color,  // Accents color, buttons etc
                 '4' => '#4CD964',
                 '5' => '#007AFF',
                 '6' => '#FF2D55',
                 '7' => '#000',
                 '8' => '#fff',
             ],
         ],
     ];

    return $schemes;
}

add_action( 'customize_save_after', 'analytica_live_qazana_reset_schemes', 100 );
 /**
  * Reset the qazana preset schemes to make layouts more theme friendly
  *
  * @since 1.0.0
  *
  * @return boolean
  */
function analytica_live_qazana_reset_schemes( $locations ) {

    foreach ( qazana()->schemes_manager->get_registered_schemes() as $scheme ) {

        if ( $scheme::get_type() === 'typography' ) {

            update_option( 'qazana_scheme_typography', array() );

        } elseif ( $scheme::get_type() === 'color' ) {

            $font_base = analytica_get_option( 'font-base' );
            $font_secondary = analytica_get_option( 'font-secondary-base' );
            $accent_color = analytica_get_option( 'accent-color' );

            $font_secondary_color = ! empty( $font_secondary['color'] ) ? $font_secondary['color'] : '';
            $font_base_color = ! empty( $font_base['color'] ) ? $font_base['color'] : '';

            update_option( 'qazana_scheme_color', [
                '1' => $font_secondary_color, // Title colors
                '2' => $font_base_color, // Meta color
                '3' => $font_base_color,
                '4' => $accent_color, // Accents color, buttons etc
            ] );

        }
    }

}

add_filter( 'qazana/extensions/location', 'analytica_live_qazana_extensions_locations' );
 /**
  * Detect qazana page
  *
  * @since 1.0.0
  *
  * @return boolean
  */
 function analytica_live_qazana_extensions_locations( $locations ) {

    $locations[] = apply_filters( 'qazana/extensions/paths', 'includes/extensions/qazana/extensions' );

    return $locations;
}

add_filter( 'analytica_site_layout_pre', 'analytica_live_qazana_page_sidebar' );
/**
 * Manage page layout for the Qazana page
 *
 * Set the layout in the Radium layouts metabox in the Page Editor
 *
 * @since 1.0.0
 *
 * @param str $layout Radium layout, eg 'content-sidebar', etc.
 */
function analytica_live_qazana_page_sidebar( $layout ) {

    if ( analytica_is_builder_page() ) {
        return 'full-width-content';
    }

    return $layout;
}

/**
 * [qazana_inline_button_control_blackist description]
 * @return bool
 */
function qazana_remove_global_controls( $control_name, $custom_exclusions = array() ) {

    $exclude = [
        '_animation_animated',
        '_animation_delay',
        '_animation_duration',
        '_animation_in',
        '_animation_out',
        '_background_animated',
        '_background_animation',
        '_background_animation_duration',
        '_background_attachment',
        '_background_background',
        '_background_color',
        '_background_color_b',
        '_background_color_b_stop',
        '_background_color_stop',
        '_background_custom_position',
        '_background_custom_position_values',
        '_background_custom_size',
        '_background_custom_size_values',
        '_background_gradient_angle',
        '_background_gradient_position',
        '_background_gradient_type',
        '_background_hover_attachment',
        '_background_hover_background',
        '_background_hover_color',
        '_background_hover_color_b',
        '_background_hover_color_b_stop',
        '_background_hover_color_stop',
        '_background_hover_custom_position',
        '_background_hover_custom_position_values',
        '_background_hover_custom_size',
        '_background_hover_custom_size_values',
        '_background_hover_gradient_angle',
        '_background_hover_gradient_position',
        '_background_hover_gradient_type',
        '_background_hover_image',
        '_background_hover_position',
        '_background_hover_repeat',
        '_background_hover_size',
        '_background_hover_transition',
        '_background_hover_video_fallback',
        '_background_hover_video_link',
        '_background_hover_video_source',
        '_background_hover_youtube_video_link',
        '_background_image',
        '_background_position',
        '_background_repeat',
        '_background_size',
        '_background_video_fallback',
        '_background_video_link',
        '_background_video_source',
        '_background_youtube_video_link',
        '_border_border',
        '_border_color',
        '_border_hover_border',
        '_border_hover_color',
        '_border_hover_transition',
        '_border_hover_width',
        '_border_radius',
        '_border_radius_hover',
        '_border_width',
        '_box_shadow_box_shadow',
        '_box_shadow_box_shadow_position',
        '_box_shadow_box_shadow_type',
        '_box_shadow_hover_box_shadow',
        '_box_shadow_hover_box_shadow_position',
        '_box_shadow_hover_box_shadow_type',
        '_css_classes',
        '_custom_css_description',
        '_element_id',
        '_element_left',
        '_element_left_mobile',
        '_element_left_tablet',
        '_element_overflow',
        '_element_parallax',
        '_element_parallax_axis',
        '_element_parallax_mobile',
        '_element_parallax_momentum',
        '_element_parallax_tablet',
        '_element_position',
        '_element_position_mobile',
        '_element_position_tablet',
        '_element_rotate',
        '_element_rotate_degrees',
        '_element_top',
        '_element_top_mobile',
        '_element_top_tablet',
        '_element_transform_origin',
        '_hide_desktop',
        '_hide_mobile',
        '_hide_tablet',
        '_hover_animation',
        '_inline_element',
        '_margin',
        '_margin_mobile',
        '_margin_tablet',
        '_padding',
        '_padding_mobile',
        '_padding_tablet',
        '_responsive_description',
        '_section_background',
        '_section_border',
        '_section_custom_css',
        '_section_element_position',
        '_section_parallax',
        '_section_responsive',
        '_section_style',
        '_tab_background_hover',
        '_tab_background_normal',
        '_tab_border_hover',
        '_tab_border_normal',
        '_tabs_background',
        '_tabs_border',
        '_z_index',
        'custom_css',
    ];

    $exclude = array_merge( $exclude, $custom_exclusions );

    $exclude = apply_filters( __FUNCTION__, $exclude );

    if ( in_array( $control_name, $exclude ) ) {
        return true;
    }

    return false;
}

/**
 * Add prefix to control.
 *
 * @return string
 */
function qazana_inline_button_control_add_prefix( $control ) {

    if ( 0 === strpos( $control, 'button' ) || 0 === strpos( $control, '_' ) || 0 === strpos( $control, 'section' ) || 0 === strpos( $control, 'tab' ) ) {

        $new_control = $control;

    } elseif ( 0 === strpos( $control, '_' ) ) {
        $new_control = '_button' . $control;
    } else {
        $new_control = 'button_' . $control;
    }

    return $new_control;
}


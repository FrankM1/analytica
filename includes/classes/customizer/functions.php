<?php
/*
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @package  Radium\Extensions\Live-Search
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

 /**
  * Add the theme configuration
  */
\Analytica\Customizer::add_config( analytica()->theme_slug, array(
    'option_type'    => 'theme_mod',
    'capability'     => 'edit_theme_options',
    'disable_output' => true,
) );

add_filter( 'kirki_config', 'analytica_kirki_configuration_styling' );
 /**
  * Configuration sample for the Kirki Customizer.
  * The function's argument is an array of existing config values
  * The function returns the array with the addition of our own arguments
  * and then that result is used in the kirki_config filter
  *
  * @param $config the configuration array
  *
  * @return array
  */
function analytica_kirki_configuration_styling( $config ) {
    return wp_parse_args( array( 'description' => wp_get_theme()->get( 'Description' ) ), $config );
}

add_action( 'customize_save_after', 'analytica_customizer_single_post_defaults' );
/**
 * Set default values for single post settings
 *
 * @param WP_Customize_Manager $wp_customize
 */
function analytica_customizer_single_post_defaults( \WP_Customize_Manager $wp_customize ) {
    $controls = \Analytica\Options::controls();

    if ( is_array( $controls ) && ! empty( $controls ) ) {
		$mods = get_theme_mods();

        foreach ( $controls as $control ) {
            $setting = $wp_customize->get_setting( $control['id'] );
            if (
                ! is_object( $setting )
                || empty( $setting->id )
                || empty( $setting->default )
                || ! empty( $mods[ $setting->id ] )
                || $control['type'] === 'checkbox' || $control['type'] === 'switch' ) {
                    continue;
            }

            set_theme_mod( $setting->id, $setting->default );
        }
	}
}

add_action( 'after_setup_theme', 'analytica_theme_defaults' );
/**
 * Register the customizer controls
 *
 * @param array $controls [description]
 */
function analytica_theme_defaults() {

    $new_controls = \Analytica\Options::controls();

    if ( ! empty( $new_controls ) ) {
        foreach ( $new_controls as $control => $value ) {

            $default     = ! empty( $value['default'] ) ? $value['default'] : '';
            $description = ! empty( $value['desc'] ) ? $value['desc'] : '';
            $priority    = ! empty( $value['priority'] ) ? $value['priority'] : 10;
            $label       = ! empty( $value['title'] ) ? $value['title'] : $value['label'];
            $section     = ! empty( $value['section'] ) ? $value['section'] : 'general';

            $args = array(
                'type'        => $value['type'],
                'section'     => $section,
                'default'     => $default,
                'label'       => $label,
                'description' => $description,
                'priority'    => $priority,
            );

            if ( ! empty( $value['options'] ) ) {
                $args['choices'] = $value['options'];
            }

            if ( ! empty( $value['choices'] ) ) {
                $args['choices'] = $value['choices'];
            }

            if ( ! empty( $value['options'] ) ) {
                $args['choices'] = $value['options'];
            }

            if ( ! empty( $value['settings'] ) ) {
                $args['settings'] = $value['settings'];
            } else {
                $args['settings'] = $value['id'];
            }

            if ( ! empty( $value['controls'] ) ) {
                $args['controls'] = $value['controls'];
            }

            if ( ! empty( $value['output'] ) ) {
                $args['output'] = $value['output'];
            }

			if ( ! empty( $value['transport'] ) ) {
                $args['transport'] = $value['transport'];
            }

			if ( ! empty( $value['js_vars'] ) ) {
                $args['js_vars'] = $value['js_vars'];
            }

			if ( ! empty( $value['active_callback'] ) ) {
                $args['active_callback'] = $value['active_callback'];
            }

            if ( ! empty( $value['conditions'] ) ) {
                $args['active_callback'] = $value['conditions'];
            }

            if ( ! empty( $value['required'] ) ) {
                $args['required'] = $value['required'];
            }

			if ( ! empty( $value['fields'] ) ) {
                $args['fields'] = $value['fields'];
            }

			if ( ! empty( $value['multiple'] ) ) {
                $args['multiple'] = $value['multiple'];
            }

			if ( ! empty( $value['partial_refresh'] ) ) {
                $args['partial_refresh'] = $value['partial_refresh'];
            }

			if ( ! empty( $value['sanitize_callback'] ) ) {
                $args['sanitize_callback'] = $value['sanitize_callback'];
            }

			if ( ! empty( $value['tooltip'] ) ) {
                $args['tooltip'] = $value['tooltip'];
            }

			if ( ! empty( $value['variables'] ) ) {
                $args['variables'] = $value['variables'];
            }
            if ( ! empty( $value['media_query'] ) ) {
                $args['media_query'] = $value['media_query'];
            }

            if ( ! empty( $value['input_attrs'] ) ) {
                $args['input_attrs'] = $value['input_attrs'];
            }

            $args['device'] = 'all';

            \Analytica\Customizer::add_field( analytica()->theme_slug, $args );

            if ( ! empty( $value['responsive'] ) && $value['responsive'] ) {

                $mobile_args = $args;
                $mobile_args['settings'] = $args['settings'] . '_mobile';
                $mobile_args['label'] = '';
                $mobile_args['description'] = '';
                $tablet_args['device'] = 'mobile';

                \Analytica\Customizer::add_field( analytica()->theme_slug, $mobile_args );

                $tablet_args = $args;
                $tablet_args['settings'] = $args['settings'] . '_tablet';
                $tablet_args['label'] = '';
                $tablet_args['description'] = '';
                $tablet_args['device'] = 'tablet';

                \Analytica\Customizer::add_field( analytica()->theme_slug, $tablet_args ); 
            }
        }
    }
   
}

add_action( 'customize_register', 'analytica_customizer_reorder_fields', 9999 );
/**
 * Here we organize the fields into one "Theme Options" section
 * @param $wp_customize
 */
function analytica_customizer_reorder_fields( $wp_customize ) {

    $wp_customize->get_control( 'custom_logo' )->section  = 'logo-favicon';
    $wp_customize->get_control( 'custom_logo' )->priority = '1';

    $wp_customize->get_control( 'blogdescription' )->section  = 'logo-favicon';
    $wp_customize->get_control( 'blogdescription' )->priority = '2';

    $wp_customize->get_control( 'blogname' )->section  = 'logo-favicon';
    $wp_customize->get_control( 'blogname' )->priority = '3';

    $wp_customize->get_control( 'site_icon' )->section  = 'logo-favicon';
    $wp_customize->get_control( 'site_icon' )->priority = '4';

    $wp_customize->get_control( 'display_header_text' )->section  = 'logo-favicon';
    $wp_customize->get_control( 'display_header_text' )->priority = '5';

    $site_logo_header_text = $wp_customize->get_control( 'site_logo_header_text' );

    // this field may be missing, so we need a check
    if ( ! empty( $site_logo_header_text ) ) {
        $site_logo_header_text->section = 'general';
    }

    // Add postMessage support for site title and tagline and title color.
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    // Rename the label to "Display Site Title & Tagline" in order to make this option clearer.
    $wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display Site Title &amp; Tagline', 'analytica' );

    if ( class_exists( 'Kirki' ) ) {
        $wp_customize->get_control( 'header_image' )->panel  = 'site-hero';
        $wp_customize->get_control( 'header_image' )->section  = 'site-hero-background';
        $wp_customize->get_control( 'header_image' )->priority = '1';

        $wp_customize->get_control( 'background_image' )->panel  = 'general';
        $wp_customize->get_control( 'background_image' )->section  = 'container-style';
        $wp_customize->get_control( 'background_image' )->priority = '1';

        $wp_customize->get_control( 'background_preset' )->panel  = 'general';
        $wp_customize->get_control( 'background_preset' )->section  = 'container-style';
        $wp_customize->get_control( 'background_preset' )->priority = '2';
    }
}

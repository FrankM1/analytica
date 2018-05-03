<?php
/**
 * Buttons for Analytica Theme.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Option: Button Color
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[button-color]', array(
			'default'           => '',
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_hex_color' ),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[button-color]', array(
				'section' => 'section-buttons',
				'label'   => __( 'Button Text Color', 'analytica' ),
			)
		)
	);

	/**
	 * Option: Button Hover Color
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[button-h-color]', array(
			'default'           => '',
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_hex_color' ),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[button-h-color]', array(
				'section' => 'section-buttons',
				'label'   => __( 'Button Text Hover Color', 'analytica' ),
			)
		)
	);

	/**
	 * Option: Button Background Color
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[button-bg-color]', array(
			'default'           => '',
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_hex_color' ),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[button-bg-color]', array(
				'section' => 'section-buttons',
				'label'   => __( 'Button Background Color', 'analytica' ),
			)
		)
	);

	/**
	 * Option: Button Background Hover Color
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[button-bg-h-color]', array(
			'default'           => '',
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_hex_color' ),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[button-bg-h-color]', array(
				'section' => 'section-buttons',
				'label'   => __( 'Button Background Hover Color', 'analytica' ),
			)
		)
	);

	/**
	 * Option: Button Radius
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[button-radius]', array(
			'default'           => analytica_get_option( 'button-radius' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[button-radius]', array(
			'section'     => 'section-buttons',
			'label'       => __( 'Button Radius', 'analytica' ),
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'step' => 1,
				'max'  => 200,
			),
		)
	);

	/**
	 * Option: Vertical Padding
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[button-v-padding]', array(
			'default'           => analytica_get_option( 'button-v-padding' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[button-v-padding]', array(
			'section'     => 'section-buttons',
			'label'       => __( 'Vertical Padding', 'analytica' ),
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 1,
				'step' => 1,
				'max'  => 200,
			),
		)
	);

	/**
	 * Option: Horizontal Padding
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[button-h-padding]', array(
			'default'           => analytica_get_option( 'button-h-padding' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[button-h-padding]', array(
			'section'     => 'section-buttons',
			'label'       => __( 'Horizontal Padding', 'analytica' ),
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 1,
				'step' => 1,
				'max'  => 200,
			),
		)
	);

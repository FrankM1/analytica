<?php
/**
 * Styling Options for Analytica Theme.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.15
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Option: Color
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-color]', array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_hex_color' ),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[footer-color]', array(
				'label'   => __( 'Text Color', 'analytica' ),
				'section' => 'section-colors-footer',
			)
		)
	);

	/**
	 * Option: Link Color
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-link-color]', array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_hex_color' ),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[footer-link-color]', array(
				'label'   => __( 'Link Color', 'analytica' ),
				'section' => 'section-colors-footer',
			)
		)
	);

	/**
	 * Option: Link Hover Color
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-link-h-color]', array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_hex_color' ),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[footer-link-h-color]', array(
				'label'   => __( 'Link Hover Color', 'analytica' ),
				'section' => 'section-colors-footer',
			)
		)
	);

	/**
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-footer-image]', array(
				'section'  => 'section-colors-footer',
				'type'     => 'ast-divider',
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Footer Background
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-bg-obj]', array(
			'default'           => analytica_get_option( 'footer-bg-obj' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_background_obj' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Background(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[footer-bg-obj]', array(
				'type'    => 'ast-background',
				'section' => 'section-colors-footer',
				'label'   => __( 'Background', 'analytica' ),
			)
		)
	);

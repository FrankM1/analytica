<?php
/**
 * Body Typography Options for Analytica Theme.
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
	 * Option: Body & Content Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-base-typo]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-body-typo',
				'priority' => 4,
				'label'    => __( 'Body & Content', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Font Family
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[body-font-family]', array(
			'default'           => analytica_get_option( 'body-font-family' ),
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new Analytica_Control_Typography(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[body-font-family]', array(
				'type'        => 'ast-font-family',
				'ast_inherit' => __( 'Default System Font', 'analytica' ),
				'section'     => 'section-body-typo',
				'priority'    => 5,
				'label'       => __( 'Font Family', 'analytica' ),
				'connect'     => ANALYTICA_THEME_SETTINGS . '[body-font-weight]',
			)
		)
	);

	/**
	 * Option: Font Weight
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[body-font-weight]', array(
			'default'           => analytica_get_option( 'body-font-weight' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_font_weight' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Typography(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[body-font-weight]', array(
				'type'        => 'ast-font-weight',
				'ast_inherit' => __( 'Default', 'analytica' ),
				'section'     => 'section-body-typo',
				'priority'    => 10,
				'label'       => __( 'Font Weight', 'analytica' ),
				'connect'     => ANALYTICA_THEME_SETTINGS . '[body-font-family]',
			)
		)
	);

	/**
	 * Option: Body Text Transform
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[body-text-transform]', array(
			'default'           => analytica_get_option( 'body-text-transform' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[body-text-transform]', array(
			'type'     => 'select',
			'section'  => 'section-body-typo',
			'priority' => 15,
			'label'    => __( 'Text Transform', 'analytica' ),
			'choices'  => array(
				''           => __( 'Default', 'analytica' ),
				'none'       => __( 'None', 'analytica' ),
				'capitalize' => __( 'Capitalize', 'analytica' ),
				'uppercase'  => __( 'Uppercase', 'analytica' ),
				'lowercase'  => __( 'Lowercase', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Body Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-body]', array(
			'default'           => analytica_get_option( 'font-size-body' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-body]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-body-typo',
				'priority'    => 20,
				'label'       => __( 'Font Size', 'analytica' ),
				'input_attrs' => array(
					'min' => 0,
				),
				'units'       => array(
					'px' => 'px',
				),
			)
		)
	);

	/**
	 * Option: Body Line Height
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[body-line-height]', array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number_n_blank' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Slider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[body-line-height]', array(
				'type'        => 'ast-slider',
				'section'     => 'section-body-typo',
				'priority'    => 25,
				'label'       => __( 'Line Height', 'analytica' ),
				'suffix'      => '',
				'input_attrs' => array(
					'min'  => 1,
					'step' => 0.01,
					'max'  => 5,
				),
			)
		)
	);

	/**
	 * Option: Paragraph Margin Bottom
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[para-margin-bottom]', array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number_n_blank' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Slider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[para-margin-bottom]', array(
				'type'        => 'ast-slider',
				'section'     => 'section-body-typo',
				'priority'    => 25,
				'label'       => __( 'Paragraph Margin Bottom', 'analytica' ),
				'suffix'      => '',
				'input_attrs' => array(
					'min'  => 0.5,
					'step' => 0.01,
					'max'  => 5,
				),
			)
		)
	);

	/**
	 * Option: Body & Content Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-headings-typo]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-body-typo',
				'priority' => 30,
				'label'    => __( 'Headings', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Headings Font Family
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[headings-font-family]', array(
			'default'           => analytica_get_option( 'headings-font-family' ),
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Typography(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[headings-font-family]', array(
				'type'     => 'ast-font-family',
				'label'    => __( 'Font Family', 'analytica' ),
				'section'  => 'section-body-typo',
				'priority' => 35,
				'connect'  => ANALYTICA_THEME_SETTINGS . '[headings-font-weight]',
			)
		)
	);

	/**
	 * Option: Headings Font Weight
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[headings-font-weight]', array(
			'default'           => analytica_get_option( 'headings-font-weight' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_font_weight' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Typography(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[headings-font-weight]', array(
				'type'     => 'ast-font-weight',
				'label'    => __( 'Font Weight', 'analytica' ),
				'section'  => 'section-body-typo',
				'priority' => 40,
				'connect'  => ANALYTICA_THEME_SETTINGS . '[headings-font-family]',
			)
		)
	);

	/**
	 * Option: Headings Text Transform
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[headings-text-transform]', array(
			'default'           => analytica_get_option( 'headings-text-transform' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[headings-text-transform]', array(
			'section'  => 'section-body-typo',
			'label'    => __( 'Text Transform', 'analytica' ),
			'type'     => 'select',
			'priority' => 45,
			'choices'  => array(
				''           => __( 'Inherit', 'analytica' ),
				'none'       => __( 'None', 'analytica' ),
				'capitalize' => __( 'Capitalize', 'analytica' ),
				'uppercase'  => __( 'Uppercase', 'analytica' ),
				'lowercase'  => __( 'Lowercase', 'analytica' ),
			),
		)
	);

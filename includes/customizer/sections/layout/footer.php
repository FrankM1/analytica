<?php
/**
 * Bottom Footer Options for Analytica Theme.
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
	 * Option: Footer Bar Layout
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-layout]', array(
			'default'           => analytica_get_option( 'footer-sml-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Radio_Image(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[footer-sml-layout]', array(
				'type'     => 'ast-radio-image',
				'section'  => 'section-footer-small',
				'priority' => 5,
				'label'    => __( 'Footer Bar Layout', 'analytica' ),
				'choices'  => array(
					'disabled'            => array(
						'label' => __( 'Disabled', 'analytica' ),
						'path'  => ANALYTICA_THEME_URI . 'assets/images/disabled-footer-76x48.png',
					),
					'footer-sml-layout-1' => array(
						'label' => __( 'Footer Bar Layout 1', 'analytica' ),
						'path'  => ANALYTICA_THEME_URI . 'assets/images/footer-layout-1-76x48.png',
					),
					'footer-sml-layout-2' => array(
						'label' => __( 'Footer Bar Layout 2', 'analytica' ),
						'path'  => ANALYTICA_THEME_URI . 'assets/images/footer-layout-2-76x48.png',
					),
				),
			)
		)
	);

	/**
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[section-ast-small-footer-layout-info]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-footer-small',
				'priority' => 10,
				'settings' => array(),
			)
		)
	);


	/**
	 *  Section: Section 1
	 */
	/**
	 * Option: Section 1
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-section-1]', array(
			'default'           => analytica_get_option( 'footer-sml-section-1' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-section-1]', array(
			'type'     => 'select',
			'section'  => 'section-footer-small',
			'priority' => 15,
			'label'    => __( 'Section 1', 'analytica' ),
			'choices'  => array(
				''       => __( 'None', 'analytica' ),
				'menu'   => __( 'Footer Menu', 'analytica' ),
				'custom' => __( 'Custom Text', 'analytica' ),
				'widget' => __( 'Widget', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Section 1 Custom Text
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-section-1-credit]', array(
			'default'           => analytica_get_option( 'footer-sml-section-1-credit' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_html' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-section-1-credit]', array(
			'type'     => 'textarea',
			'section'  => 'section-footer-small',
			'priority' => 20,
			'label'    => __( 'Section 1 Custom Text', 'analytica' ),
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			ANALYTICA_THEME_SETTINGS . '[footer-sml-section-1-credit]', array(
				'selector'            => '.ast-small-footer-section-1',
				'container_inclusive' => false,
				'render_callback'     => array( 'Analytica_Customizer_Partials', '_render_footer_sml_section_1_credit' ),
			)
		);
	}

	/**
	 * Option: Section 2
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-section-2]', array(
			'default'           => analytica_get_option( 'footer-sml-section-2' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-section-2]', array(
			'type'     => 'select',
			'section'  => 'section-footer-small',
			'priority' => 25,
			'label'    => __( 'Section 2', 'analytica' ),
			'choices'  => array(
				''       => __( 'None', 'analytica' ),
				'menu'   => __( 'Footer Menu', 'analytica' ),
				'custom' => __( 'Custom Text', 'analytica' ),
				'widget' => __( 'Widget', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Section 2 Custom Text
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-section-2-credit]', array(
			'default'           => analytica_get_option( 'footer-sml-section-2-credit' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_html' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-section-2-credit]', array(
			'type'     => 'textarea',
			'section'  => 'section-footer-small',
			'priority' => 30,
			'label'    => __( 'Section 2 Custom Text', 'analytica' ),
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			ANALYTICA_THEME_SETTINGS . '[footer-sml-section-2-credit]', array(
				'selector'            => '.ast-small-footer-section-2',
				'container_inclusive' => false,
				'render_callback'     => array( 'Analytica_Customizer_Partials', '_render_footer_sml_section_2_credit' ),
			)
		);
	}

	/**
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[section-ast-small-footer-typography]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-footer-small',
				'priority' => 35,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Footer Top Border
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-divider]', array(
			'default'           => analytica_get_option( 'footer-sml-divider' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-divider]', array(
			'type'        => 'number',
			'section'     => 'section-footer-small',
			'priority'    => 40,
			'label'       => __( 'Footer Bar Top Border', 'analytica' ),
			'input_attrs' => array(
				'min'  => 0,
				'step' => 1,
				'max'  => 600,
			),
		)
	);

	/**
	 * Option: Footer Top Border Color
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-sml-divider-color]', array(
			'default'           => '#7a7a7a',
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_hex_color' ),
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[footer-sml-divider-color]', array(
				'section'  => 'section-footer-small',
				'priority' => 45,
				'label'    => __( 'Footer Bar Top Border Color', 'analytica' ),
			)
		)
	);

	/**
	 * Option: Header Width
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-layout-width]', array(
			'default'           => analytica_get_option( 'footer-layout-width' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[footer-layout-width]', array(
			'type'     => 'select',
			'section'  => 'section-footer-small',
			'priority' => 35,
			'label'    => __( 'Footer Bar Width', 'analytica' ),
			'choices'  => array(
				'full'    => __( 'Full Width', 'analytica' ),
				'content' => __( 'Content Width', 'analytica' ),
			),
		)
	);

<?php
/**
 * Typography Options for Analytica Theme.
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
	 * Option: Heading 1 (H1) Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-h1]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-content-typo',
				'priority' => 4,
				'label'    => __( 'Heading 1 (H1)', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Heading 1 (H1) Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-h1]', array(
			'default'           => analytica_get_option( 'font-size-h1' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-h1]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-content-typo',
				'priority'    => 5,
				'label'       => __( 'Font Size', 'analytica' ),
				'input_attrs' => array(
					'min' => 0,
				),
				'units'       => array(
					'px' => 'px',
					'em' => 'em',
				),
			)
		)
	);

	/**
	 * Option: Heading 2 (H2) Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-h2]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-content-typo',
				'priority' => 9,
				'label'    => __( 'Heading 2 (H2)', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Heading 2 (H2) Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-h2]', array(
			'default'           => analytica_get_option( 'font-size-h2' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-h2]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-content-typo',
				'priority'    => 10,
				'label'       => __( 'Font Size', 'analytica' ),
				'input_attrs' => array(
					'min' => 0,
				),
				'units'       => array(
					'px' => 'px',
					'em' => 'em',
				),
			)
		)
	);

	/**
	 * Option: Heading 3 (H3) Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-h3]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-content-typo',
				'priority' => 14,
				'label'    => __( 'Heading 3 (H3)', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Heading 3 (H3) Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-h3]', array(
			'default'           => analytica_get_option( 'font-size-h3' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-h3]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-content-typo',
				'priority'    => 15,
				'label'       => __( 'Font Size', 'analytica' ),
				'input_attrs' => array(
					'min' => 0,
				),
				'units'       => array(
					'px' => 'px',
					'em' => 'em',
				),
			)
		)
	);

	/**
	 * Option: Heading 4 (H4) Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-h4]', array(
				'label'    => __( 'Heading 4 (H4)', 'analytica' ),
				'section'  => 'section-content-typo',
				'type'     => 'ast-divider',
				'priority' => 19,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Heading 4 (H4) Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-h4]', array(
			'default'           => analytica_get_option( 'font-size-h4' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-h4]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-content-typo',
				'priority'    => 20,
				'label'       => __( 'Font Size', 'analytica' ),
				'input_attrs' => array(
					'min' => 0,
				),
				'units'       => array(
					'px' => 'px',
					'em' => 'em',
				),
			)
		)
	);

	/**
	 * Option: Heading 5 (H5) Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-h5]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-content-typo',
				'priority' => 24,
				'label'    => __( 'Heading 5 (H5)', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Heading 5 (H5) Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-h5]', array(
			'default'           => analytica_get_option( 'font-size-h5' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-h5]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-content-typo',
				'priority'    => 25,
				'label'       => __( 'Font Size', 'analytica' ),
				'input_attrs' => array(
					'min' => 0,
				),
				'units'       => array(
					'px' => 'px',
					'em' => 'em',
				),
			)
		)
	);

	/**
	 * Option: Heading 6 (H6) Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-h6]', array(
				'label'    => __( 'Heading 6 (H6)', 'analytica' ),
				'section'  => 'section-content-typo',
				'type'     => 'ast-divider',
				'priority' => 29,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Heading 6 (H6) Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-h6]', array(
			'default'           => analytica_get_option( 'font-size-h6' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-h6]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-content-typo',
				'priority'    => 30,
				'label'       => __( 'Font Size', 'analytica' ),
				'input_attrs' => array(
					'min' => 0,
				),
				'units'       => array(
					'px' => 'px',
					'em' => 'em',
				),
			)
		)
	);

	// Learn More link if Analytica Pro is not activated.
	if ( ! defined( 'ANALYTICA_EXT_VER' ) ) {

		/**
		 * Option: Divider
		 */
		$wp_customize->add_control(
			new Analytica_Control_Divider(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-content-typography-more-feature-divider]', array(
					'type'     => 'ast-divider',
					'section'  => 'section-content-typo',
					'priority' => 35,
					'settings' => array(),
				)
			)
		);
		/**
		 * Option: Learn More about Contant Typography
		 */
		$wp_customize->add_control(
			new Analytica_Control_Description(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-content-typography-more-feature-description]', array(
					'type'     => 'ast-description',
					'section'  => 'section-content-typo',
					'priority' => 35,
					'label'    => '',
					'help'     => '<p>' . __( 'More Options Available for Typography in Analytica Pro!', 'analytica' ) . '</p><a href="' . analytica_get_pro_url( 'https://wpanalytica.com/docs/typography-module/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'analytica' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}

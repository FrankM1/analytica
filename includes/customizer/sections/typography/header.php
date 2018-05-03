<?php
/**
 * Site Identity Typography Options for Analytica Theme.
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
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-header-typo-title]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-header-typo',
				'priority' => 5,
				'label'    => __( 'Site Title', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Site Title Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-site-title]', array(
			'default'           => analytica_get_option( 'font-size-site-title' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-site-title]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-header-typo',
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
	 * Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-header-typo-tagline]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-header-typo',
				'priority' => 15,
				'label'    => __( 'Site Tagline', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Site Tagline Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-site-tagline]', array(
			'default'           => analytica_get_option( 'font-size-site-tagline' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-site-tagline]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-header-typo',
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

	// Learn More link if Analytica Pro is not activated.
	if ( ! defined( 'ANALYTICA_EXT_VER' ) ) {

		/**
		 * Option: Divider
		 */
		$wp_customize->add_control(
			new Analytica_Control_Divider(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-header-typography-more-feature-divider]', array(
					'type'     => 'ast-divider',
					'section'  => 'section-header-typo',
					'priority' => 25,
					'settings' => array(),
				)
			)
		);
		/**
		 * Option: Learn More about Typography
		 */
		$wp_customize->add_control(
			new Analytica_Control_Description(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-header-typography-more-feature-description]', array(
					'type'     => 'ast-description',
					'section'  => 'section-header-typo',
					'priority' => 25,
					'label'    => '',
					'help'     => '<p>' . __( 'More Options Available for Typography in Analytica Pro!', 'analytica' ) . '</p><a href="' . analytica_get_pro_url( 'https://wpanalytica.com/docs/typography-module/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'analytica' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}


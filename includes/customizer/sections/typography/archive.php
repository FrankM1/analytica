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
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-archive-summary-box-typo]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-archive-typo',
				'priority' => 0,
				'label'    => __( 'Archive Summary Box Title', 'analytica' ),
				'settings' => array(),
			)
		)
	);
	/**
	 * Option: Archive Summary Box Title Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-archive-summary-title]', array(
			'default'           => analytica_get_option( 'font-size-archive-summary-title' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-archive-summary-title]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-archive-typo',
				'priority'    => 4,
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
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[divider-section-archive-typo-archive-title]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-archive-typo',
				'priority' => 5,
				'label'    => __( 'Blog Post Title', 'analytica' ),
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Blog - Post Title Font Size
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[font-size-page-title]', array(
			'default'           => analytica_get_option( 'font-size-page-title' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_typo' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[font-size-page-title]', array(
				'type'        => 'ast-responsive',
				'section'     => 'section-archive-typo',
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

	// Learn More link if Analytica Pro is not activated.
	if ( ! defined( 'ANALYTICA_EXT_VER' ) ) {

		/**
		 * Option: Divider
		 */
		$wp_customize->add_control(
			new Analytica_Control_Divider(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-blog-typography-more-feature-divider]', array(
					'type'     => 'ast-divider',
					'section'  => 'section-archive-typo',
					'priority' => 15,
					'settings' => array(),
				)
			)
		);
		/**
		 * Option: Learn More about Contant Typography
		 */
		$wp_customize->add_control(
			new Analytica_Control_Description(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-blog-typography-more-feature-description]', array(
					'type'     => 'ast-description',
					'section'  => 'section-archive-typo',
					'priority' => 15,
					'label'    => '',
					'help'     => '<p>' . __( 'More Options Available for Typography in Analytica Pro!', 'analytica' ) . '</p><a href="' . analytica_get_pro_url( 'https://wpanalytica.com/docs/typography-module/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'analytica' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}

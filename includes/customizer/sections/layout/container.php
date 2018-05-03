<?php
/**
 * General Options for Analytica Theme.
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
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[site-content-layout-divider]', array(
				'type'     => 'ast-divider',
				'priority' => 50,
				'section'  => 'section-container-layout',
				'settings' => array(),
			)
		)
	);
	/**
	 * Option: Site Content Layout
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[site-content-layout]', array(
			'default'           => analytica_get_option( 'site-content-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[site-content-layout]', array(
			'type'     => 'select',
			'section'  => 'section-container-layout',
			'priority' => 50,
			'label'    => __( 'Default Container', 'analytica' ),
			'choices'  => array(
				'boxed-container'         => __( 'Boxed', 'analytica' ),
				'content-boxed-container' => __( 'Content Boxed', 'analytica' ),
				'plain-container'         => __( 'Full Width / Contained', 'analytica' ),
				'page-builder'            => __( 'Full Width / Stretched', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Single Page Content Layout
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[single-page-content-layout]', array(
			'default'           => analytica_get_option( 'single-page-content-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[single-page-content-layout]', array(
			'type'     => 'select',
			'section'  => 'section-container-layout',
			'label'    => __( 'Container for Pages', 'analytica' ),
			'priority' => 55,
			'choices'  => array(
				'default'                 => __( 'Default', 'analytica' ),
				'boxed-container'         => __( 'Boxed', 'analytica' ),
				'content-boxed-container' => __( 'Content Boxed', 'analytica' ),
				'plain-container'         => __( 'Full Width / Contained', 'analytica' ),
				'page-builder'            => __( 'Full Width / Stretched', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Single Post Content Layout
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[single-post-content-layout]', array(
			'default'           => analytica_get_option( 'single-post-content-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[single-post-content-layout]', array(
			'type'     => 'select',
			'section'  => 'section-container-layout',
			'priority' => 60,
			'label'    => __( 'Container for Blog Posts', 'analytica' ),
			'choices'  => array(
				'default'                 => __( 'Default', 'analytica' ),
				'boxed-container'         => __( 'Boxed', 'analytica' ),
				'content-boxed-container' => __( 'Content Boxed', 'analytica' ),
				'plain-container'         => __( 'Full Width / Contained', 'analytica' ),
				'page-builder'            => __( 'Full Width / Stretched', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Archive Post Content Layout
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[archive-post-content-layout]', array(
			'default'           => analytica_get_option( 'archive-post-content-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[archive-post-content-layout]', array(
			'type'     => 'select',
			'section'  => 'section-container-layout',
			'priority' => 65,
			'label'    => __( 'Container for Blog Archives', 'analytica' ),
			'choices'  => array(
				'default'                 => __( 'Default', 'analytica' ),
				'boxed-container'         => __( 'Boxed', 'analytica' ),
				'content-boxed-container' => __( 'Content Boxed', 'analytica' ),
				'plain-container'         => __( 'Full Width / Contained', 'analytica' ),
				'page-builder'            => __( 'Full Width / Stretched', 'analytica' ),
			),
		)
	);

	// Learn More link if Analytica Pro is not activated.
	if ( ! defined( 'ANALYTICA_EXT_VER' ) ) {

		/**
		 * Option: Divider
		 */
		$wp_customize->add_control(
			new Analytica_Control_Divider(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-container-more-feature-divider]', array(
					'type'     => 'ast-divider',
					'section'  => 'section-container-layout',
					'priority' => 70,
					'settings' => array(),
				)
			)
		);
		/**
		 * Option: Learn More about Container
		 */
		$wp_customize->add_control(
			new Analytica_Control_Description(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-container-more-feature-description]', array(
					'type'     => 'ast-description',
					'section'  => 'section-container-layout',
					'priority' => 70,
					'label'    => '',
					'help'     => '<p>' . __( 'More Options Available for Container in Analytica Pro!', 'analytica' ) . '</p><a href="' . analytica_get_pro_url( 'https://wpanalytica.com/docs/site-layout-overview/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'analytica' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}

	/**
	 * Option: Body Background
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[site-layout-outside-bg-obj]', array(
			'default'           => analytica_get_option( 'site-layout-outside-bg-obj' ),
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_background_obj' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Background(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[site-layout-outside-bg-obj]', array(
				'type'     => 'ast-background',
				'section'  => 'section-colors-body',
				'priority' => 25,
				'label'    => __( 'Background', 'analytica' ),
			)
		)
	);

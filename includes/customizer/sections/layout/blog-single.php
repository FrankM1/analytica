<?php
/**
 * Single Post Options for Analytica Theme.
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
	 * Option: Display Post Structure
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[blog-single-post-structure]', array(
			'default'           => analytica_get_option( 'blog-single-post-structure' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Sortable(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[blog-single-post-structure]', array(
				'type'     => 'ast-sortable',
				'section'  => 'section-blog-single',
				'priority' => 5,
				'label'    => __( 'Single Post Structure', 'analytica' ),
				'choices'  => array(
					'single-image'      => __( 'Featured Image', 'analytica' ),
					'single-title-meta' => __( 'Title & Blog Meta', 'analytica' ),
				),
			)
		)
	);

	/**
	 * Option: Single Post Meta
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[blog-single-meta]', array(
			'default'           => analytica_get_option( 'blog-single-meta' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Sortable(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[blog-single-meta]', array(
				'type'     => 'ast-sortable',
				'section'  => 'section-blog-single',
				'priority' => 5,
				'label'    => __( 'Single Post Meta', 'analytica' ),
				'choices'  => array(
					'comments' => __( 'Comments', 'analytica' ),
					'category' => __( 'Category', 'analytica' ),
					'author'   => __( 'Author', 'analytica' ),
					'date'     => __( 'Publish Date', 'analytica' ),
					'tag'      => __( 'Tag', 'analytica' ),
				),
			)
		)
	);

	/**
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-styling-section-single-blog-layouts]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-blog-single',
				'priority' => 10,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Single Post Content Width
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[blog-single-width]', array(
			'default'           => analytica_get_option( 'blog-single-width' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[blog-single-width]', array(
			'type'     => 'select',
			'section'  => 'section-blog-single',
			'priority' => 15,
			'label'    => __( 'Single Post Content Width', 'analytica' ),
			'choices'  => array(
				'default' => __( 'Default', 'analytica' ),
				'custom'  => __( 'Custom', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Enter Width
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[blog-single-max-width]', array(
			'default'           => 1200,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Slider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[blog-single-max-width]', array(
				'type'        => 'ast-slider',
				'section'     => 'section-blog-single',
				'priority'    => 20,
				'label'       => __( 'Enter Width', 'analytica' ),
				'suffix'      => '',
				'input_attrs' => array(
					'min'  => 768,
					'step' => 1,
					'max'  => 1920,
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
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-blog-single-more-feature-divider]', array(
					'type'     => 'ast-divider',
					'section'  => 'section-blog-single',
					'priority' => 25,
					'settings' => array(),
				)
			)
		);
		/**
		 * Option: Learn More about Single Blog Pro
		 */
		$wp_customize->add_control(
			new Analytica_Control_Description(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-blog-single-more-feature-description]', array(
					'type'     => 'ast-description',
					'section'  => 'section-blog-single',
					'priority' => 25,
					'label'    => '',
					'help'     => '<p>' . __( 'More Options Available for Single Post in Analytica Pro!', 'analytica' ) . '</p><a href="' . analytica_get_pro_url( 'https://wpanalytica.com/docs/single-post-blog-pro/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'analytica' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}

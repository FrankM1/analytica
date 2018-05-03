<?php
/**
 * Blog Options for Analytica Theme.
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
	 * Option: Blog Post Content
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[blog-post-content]', array(
			'default'           => analytica_get_option( 'blog-post-content' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[blog-post-content]', array(
			'section'  => 'section-blog',
			'label'    => __( 'Blog Post Content', 'analytica' ),
			'type'     => 'select',
			'priority' => 50,
			'choices'  => array(
				'full-content' => __( 'Full Content', 'analytica' ),
				'excerpt'      => __( 'Excerpt', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Display Post Structure
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[blog-post-structure]', array(
			'default'           => analytica_get_option( 'blog-post-structure' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Sortable(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[blog-post-structure]', array(
				'type'     => 'ast-sortable',
				'section'  => 'section-blog',
				'priority' => 100,
				'label'    => __( 'Blog Post Structure', 'analytica' ),
				'choices'  => array(
					'image'      => __( 'Featured Image', 'analytica' ),
					'title-meta' => __( 'Title & Blog Meta', 'analytica' ),
				),
			)
		)
	);

	/**
	 * Option: Display Post Meta
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[blog-meta]', array(
			'default'           => analytica_get_option( 'blog-meta' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Sortable(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[blog-meta]', array(
				'type'     => 'ast-sortable',
				'section'  => 'section-blog',
				'priority' => 105,
				'label'    => __( 'Blog Meta', 'analytica' ),
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
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-styling-section-blog-width]', array(
				'type'     => 'ast-divider',
				'section'  => 'section-blog',
				'priority' => 110,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Blog Content Width
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[blog-width]', array(
			'default'           => analytica_get_option( 'blog-width' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[blog-width]', array(
			'type'     => 'select',
			'section'  => 'section-blog',
			'priority' => 115,
			'label'    => __( 'Blog Content Width', 'analytica' ),
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
		ANALYTICA_THEME_SETTINGS . '[blog-max-width]', array(
			'default'           => 1200,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Slider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[blog-max-width]', array(
				'type'        => 'ast-slider',
				'section'     => 'section-blog',
				'priority'    => 120,
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
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-blog-more-feature-divider]', array(
					'type'     => 'ast-divider',
					'section'  => 'section-blog',
					'priority' => 125,
					'settings' => array(),
				)
			)
		);
		/**
		 * Option: Learn More about Blog Pro
		 */
		$wp_customize->add_control(
			new Analytica_Control_Description(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-blog-more-feature-description]', array(
					'type'     => 'ast-description',
					'section'  => 'section-blog',
					'priority' => 125,
					'label'    => '',
					'help'     => __( 'More Options Available for Blog in Analytica Pro!', 'analytica' ) . '<a href="' . analytica_get_pro_url( 'https://wpanalytica.com/docs/blog-archive-blog-pro/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'analytica' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}

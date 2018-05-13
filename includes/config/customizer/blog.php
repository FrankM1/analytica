<?php
/**
 * Blog Options for Astra Theme.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2018, Astra
 * @link        http://wpastra.com/
 * @since       Astra 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_customize;

	/**
	 * Option: Blog Post Content
	 */
	$wp_customize->add_setting(
		\Analytica\Core::instance()->theme_slug . '[blog-post-content]', array(
			'default'           => analytica_get_option( 'blog-post-content' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		\Analytica\Core::instance()->theme_slug . '[blog-post-content]', array(
			'section'  => 'blog',
			'label'    => __( 'Blog Post Content', 'astra' ),
			'type'     => 'select',
			'priority' => 50,
			'choices'  => array(
				'full-content' => __( 'Full Content', 'astra' ),
				'excerpt'      => __( 'Excerpt', 'astra' ),
			),
		)
	);

	/**
	 * Option: Display Post Structure
	 */
	$wp_customize->add_setting(
		\Analytica\Core::instance()->theme_slug . '[blog-post-structure]', array(
			'default'           => analytica_get_option( 'blog-post-structure' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
    
    /* $wp_customize->add_control(
		new Kirki_Sortable(
			$wp_customize, \Analytica\Core::instance()->theme_slug . '[blog-post-structure]', array(
				'type'     => 'ast-sortable',
				'section'  => 'blog',
				'priority' => 100,
				'label'    => __( 'Blog Post Structure', 'astra' ),
				'choices'  => array(
					'image'      => __( 'Featured Image', 'astra' ),
					'title-meta' => __( 'Title & Blog Meta', 'astra' ),
				),
			)
		)
	); */

	/**
	 * Option: Display Post Meta
	 */
	$wp_customize->add_setting(
		\Analytica\Core::instance()->theme_slug . '[blog-meta]', array(
			'default'           => analytica_get_option( 'blog-meta' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
	// $wp_customize->add_control(
	// 	new Kirki_Sortable(
	// 		$wp_customize, \Analytica\Core::instance()->theme_slug . '[blog-meta]', array(
	// 			'type'     => 'ast-sortable',
	// 			'section'  => 'blog',
	// 			'priority' => 105,
	// 			'label'    => __( 'Blog Meta', 'astra' ),
	// 			'choices'  => array(
	// 				'comments' => __( 'Comments', 'astra' ),
	// 				'category' => __( 'Category', 'astra' ),
	// 				'author'   => __( 'Author', 'astra' ),
	// 				'date'     => __( 'Publish Date', 'astra' ),
	// 				'tag'      => __( 'Tag', 'astra' ),
	// 			),
	// 		)
	// 	)
	// );

	/**
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Kirki_Divider(
			$wp_customize, \Analytica\Core::instance()->theme_slug . '[ast-styling-blog-width]', array(
				'type'     => 'ast-divider',
				'section'  => 'blog',
				'priority' => 110,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Blog Content Width
	 */
	$wp_customize->add_setting(
		\Analytica\Core::instance()->theme_slug . '[blog-width]', array(
			'default'           => analytica_get_option( 'blog-width' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		\Analytica\Core::instance()->theme_slug . '[blog-width]', array(
			'type'     => 'select',
			'section'  => 'blog',
			'priority' => 115,
			'label'    => __( 'Blog Content Width', 'astra' ),
			'choices'  => array(
				'default' => __( 'Default', 'astra' ),
				'custom'  => __( 'Custom', 'astra' ),
			),
		)
	);

	/**
	 * Option: Enter Width
	 */
	$wp_customize->add_setting(
		\Analytica\Core::instance()->theme_slug . '[blog-max-width]', array(
			'default'           => 1200,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		new Kirki_Slider(
			$wp_customize, \Analytica\Core::instance()->theme_slug . '[blog-max-width]', array(
				'type'        => 'ast-slider',
				'section'     => 'blog',
				'priority'    => 120,
				'label'       => __( 'Enter Width', 'astra' ),
				'suffix'      => '',
				'input_attrs' => array(
					'min'  => 768,
					'step' => 1,
					'max'  => 1920,
				),
			)
		)
	);

	// Learn More link if Astra Pro is not activated.
	if ( ! defined( 'ASTRA_EXT_VER' ) ) {

		/**
		 * Option: Divider
		 */
		$wp_customize->add_control(
			new Kirki_Divider(
				$wp_customize, \Analytica\Core::instance()->theme_slug . '[ast-blog-more-feature-divider]', array(
					'type'     => 'ast-divider',
					'section'  => 'blog',
					'priority' => 125,
					'settings' => array(),
				)
			)
		);
		/**
		 * Option: Learn More about Blog Pro
		 */
		$wp_customize->add_control(
			new Kirki_Description(
				$wp_customize, \Analytica\Core::instance()->theme_slug . '[ast-blog-more-feature-description]', array(
					'type'     => 'ast-description',
					'section'  => 'blog',
					'priority' => 125,
					'label'    => '',
					'help'     => __( 'More Options Available for Blog in Astra Pro!', 'astra' ) . '<a href="' . analytica_get_pro_url( 'https://wpastra.com/docs/blog-archive-blog-pro/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'astra' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}

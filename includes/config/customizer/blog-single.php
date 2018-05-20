<?php
/**
 * Single Post Options for Astra Theme.
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
	 * Option: Display Post Structure
	 */
	$wp_customize->add_setting(
		\Analytica\Core::instance()->theme_slug . '[blog-single-post-structure]', array(
			'default'           => analytica_get_option( 'blog-single-post-structure' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
	// $wp_customize->add_control(
	// 	new Kirki_Sortable(
	// 		$wp_customize, \Analytica\Core::instance()->theme_slug . '[blog-single-post-structure]', array(
	// 			'type'     => 'analytica-sortable',
	// 			'section'  => 'section-blog-single',
	// 			'priority' => 5,
	// 			'label'    => __( 'Single Post Structure', 'analytica' ),
	// 			'choices'  => array(
	// 				'single-image'      => __( 'Featured Image', 'analytica' ),
	// 				'single-title-meta' => __( 'Title & Blog Meta', 'analytica' ),
	// 			),
	// 		)
	// 	)
	// );

	/**
	 * Option: Single Post Meta
	 */
	$wp_customize->add_setting(
		\Analytica\Core::instance()->theme_slug . '[blog-single-meta]', array(
			'default'           => analytica_get_option( 'blog-single-meta' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
	// $wp_customize->add_control(
	// 	new Kirki_Sortable(
	// 		$wp_customize, \Analytica\Core::instance()->theme_slug . '[blog-single-meta]', array(
	// 			'type'     => 'analytica-sortable',
	// 			'section'  => 'section-blog-single',
	// 			'priority' => 5,
	// 			'label'    => __( 'Single Post Meta', 'analytica' ),
	// 			'choices'  => array(
	// 				'comments' => __( 'Comments', 'analytica' ),
	// 				'category' => __( 'Category', 'analytica' ),
	// 				'author'   => __( 'Author', 'analytica' ),
	// 				'date'     => __( 'Publish Date', 'analytica' ),
	// 				'tag'      => __( 'Tag', 'analytica' ),
	// 			),
	// 		)
	// 	)
	// );

	// /**
	//  * Option: Divider
	//  */
	// $wp_customize->add_control(
	// 	new Kirki_Divider(
	// 		$wp_customize, \Analytica\Core::instance()->theme_slug . '[analytica-styling-section-single-blog-layouts]', array(
	// 			'type'     => 'analytica-divider',
	// 			'section'  => 'section-blog-single',
	// 			'priority' => 10,
	// 			'settings' => array(),
	// 		)
	// 	)
	// );

	/**
	 * Option: Single Post Content Width
	 */
	$wp_customize->add_setting(
		\Analytica\Core::instance()->theme_slug . '[blog-single-width]', array(
			'default'           => analytica_get_option( 'blog-single-width' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		\Analytica\Core::instance()->theme_slug . '[blog-single-width]', array(
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
		\Analytica\Core::instance()->theme_slug . '[blog-single-max-width]', array(
			'default'           => 1200,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	// $wp_customize->add_control(
	// 	new Kirki_Slider(
	// 		$wp_customize, \Analytica\Core::instance()->theme_slug . '[blog-single-max-width]', array(
	// 			'type'        => 'analytica-slider',
	// 			'section'     => 'section-blog-single',
	// 			'priority'    => 20,
	// 			'label'       => __( 'Enter Width', 'analytica' ),
	// 			'suffix'      => '',
	// 			'input_attrs' => array(
	// 				'min'  => 768,
	// 				'step' => 1,
	// 				'max'  => 1920,
	// 			),
	// 		)
	// 	)
	// );

	// Learn More link if Astra Pro is not activated.
	if ( ! defined( 'ASTRA_EXT_VER' ) ) {

		// /**
		//  * Option: Divider
		//  */
		// $wp_customize->add_control(
		// 	new Kirki_Divider(
		// 		$wp_customize, \Analytica\Core::instance()->theme_slug . '[analytica-blog-single-more-feature-divider]', array(
		// 			'type'     => 'analytica-divider',
		// 			'section'  => 'section-blog-single',
		// 			'priority' => 25,
		// 			'settings' => array(),
		// 		)
		// 	)
		// );
		/**
		 * Option: Learn More about Single Blog Pro
		 */
		$wp_customize->add_control(
			new Kirki_Description(
				$wp_customize, \Analytica\Core::instance()->theme_slug . '[analytica-blog-single-more-feature-description]', array(
					'type'     => 'analytica-description',
					'section'  => 'section-blog-single',
					'priority' => 25,
					'label'    => '',
					'help'     => '<p>' . __( 'More Options Available for Single Post in Astra Pro!', 'analytica' ) . '</p><a href="' . analytica_get_pro_url( 'https://wpastra.com/docs/single-post-blog-pro/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'analytica' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}

<?php
/**
 * Container Options for Analytica theme.
 *
 * @package     Analytica
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2018, Brainstorm Force
 * @link        http://www.brainstormforce.com
 * @since       Analytica 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, analytica()->theme_option_name . '[lifterlms-content-divider]', array(
				'section'  => 'section-container-layout',
				'type'     => 'ast-divider',
				'priority' => 66,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Shop Page
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[lifterlms-content-layout]', array(
			'default'           => analytica_get_option( 'lifterlms-content-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		analytica()->theme_option_name . '[lifterlms-content-layout]', array(
			'type'     => 'select',
			'section'  => 'section-container-layout',
			'priority' => 66,
			'label'    => __( 'Container for LifterLMS', 'analytica' ),
			'choices'  => array(
				'default'                 => __( 'Default', 'analytica' ),
				'boxed-container'         => __( 'Boxed', 'analytica' ),
				'content-boxed-container' => __( 'Content Boxed', 'analytica' ),
				'plain-container'         => __( 'Full Width / Contained', 'analytica' ),
				'page-builder'            => __( 'Full Width / Stretched', 'analytica' ),
			),
		)
	);

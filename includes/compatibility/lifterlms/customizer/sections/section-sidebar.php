<?php
/**
 * Content Spacing Options for our theme.
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
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[lifterlms-course-lesson-sidebar-layout-divider]', array(
				'section'  => 'section-sidebars',
				'type'     => 'ast-divider',
				'priority' => 5,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Shop Page
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[lifterlms-sidebar-layout]', array(
			'default'           => analytica_get_option( 'lifterlms-sidebar-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[lifterlms-sidebar-layout]', array(
			'type'     => 'select',
			'section'  => 'section-sidebars',
			'priority' => 5,
			'label'    => __( 'LifterLMS', 'analytica' ),
			'choices'  => array(
				'default'       => __( 'Default', 'analytica' ),
				'no-sidebar'    => __( 'No Sidebar', 'analytica' ),
				'left-sidebar'  => __( 'Left Sidebar', 'analytica' ),
				'right-sidebar' => __( 'Right Sidebar', 'analytica' ),
			),
		)
	);

	/**
	 * Option: LifterLMS Course/Lesson
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[lifterlms-course-lesson-sidebar-layout]', array(
			'default'           => analytica_get_option( 'lifterlms-course-lesson-sidebar-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[lifterlms-course-lesson-sidebar-layout]', array(
			'type'     => 'select',
			'section'  => 'section-sidebars',
			'priority' => 5,
			'label'    => __( 'LifterLMS Course/Lesson', 'analytica' ),
			'choices'  => array(
				'default'       => __( 'Default', 'analytica' ),
				'no-sidebar'    => __( 'No Sidebar', 'analytica' ),
				'left-sidebar'  => __( 'Left Sidebar', 'analytica' ),
				'right-sidebar' => __( 'Right Sidebar', 'analytica' ),
			),
		)
	);


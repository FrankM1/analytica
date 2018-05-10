<?php
/**
 * Container Options for Analytica theme.
 *
 * @package     Analytica
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2018, Brainstorm Force
 * @link        http://www.brainstormforce.com
 * @since       1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Option: Divider
 */
$wp_customize->add_control(
	new Analytica_Control_Divider(
		$wp_customize, analytica()->theme_option_name . '[learndash-content-divider]', array(
			'section'  => 'section-container-layout',
			'type'     => 'ast-divider',
			'priority' => 68,
			'settings' => array(),
		)
	)
);

/**
 * Option: Shop Page
 */
$wp_customize->add_setting(
	analytica()->theme_option_name . '[learndash-content-layout]', array(
		'default'           => analytica_get_option( 'learndash-content-layout' ),
		'type'              => 'option',
		'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
	)
);
$wp_customize->add_control(
	analytica()->theme_option_name . '[learndash-content-layout]', array(
		'type'        => 'select',
		'section'     => 'section-container-layout',
		'priority'    => 68,
		'label'       => __( 'Container for LearnDash', 'analytica' ),
		'description' => __( 'Will be applied to All Single Courses, Topics, Lessons and Quizzes. Does not work on pages created with LearnDash shortcodes.', 'analytica' ),
		'choices'     => array(
			'default'                 => __( 'Default', 'analytica' ),
			'boxed-container'         => __( 'Boxed', 'analytica' ),
			'content-boxed-container' => __( 'Content Boxed', 'analytica' ),
			'plain-container'         => __( 'Full Width / Contained', 'analytica' ),
			'page-builder'            => __( 'Full Width / Stretched', 'analytica' ),
		),
	)
);

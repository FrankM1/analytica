<?php
/**
 * LifterLMS General Options for our theme.
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
		$wp_customize, analytica()->theme_option_name . '[learndash-lesson-content]', array(
			'label'    => __( 'Course Content Table', 'analytica' ),
			'section'  => 'section-learndash',
			'type'     => 'ast-divider',
			'priority' => 20,
			'settings' => array(),
		)
	)
);
/**
 * Option: Display Serial Number
 */
$wp_customize->add_setting(
	analytica()->theme_option_name . '[learndash-lesson-serial-number]', array(
		'default'           => analytica_get_option( 'learndash-lesson-serial-number' ),
		'type'              => 'option',
		'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_checkbox' ),
	)
);
$wp_customize->add_control(
	analytica()->theme_option_name . '[learndash-lesson-serial-number]', array(
		'section'  => 'section-learndash',
		'label'    => __( 'Display Serial Number', 'analytica' ),
		'priority' => 25,
		'type'     => 'checkbox',
	)
);

/**
 * Option: Differentiate Rows
 */
$wp_customize->add_setting(
	analytica()->theme_option_name . '[learndash-differentiate-rows]', array(
		'default'           => analytica_get_option( 'learndash-differentiate-rows' ),
		'type'              => 'option',
		'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_checkbox' ),
	)
);
$wp_customize->add_control(
	analytica()->theme_option_name . '[learndash-differentiate-rows]', array(
		'section'  => 'section-learndash',
		'label'    => __( 'Differentiate Rows', 'analytica' ),
		'priority' => 30,
		'type'     => 'checkbox',
	)
);

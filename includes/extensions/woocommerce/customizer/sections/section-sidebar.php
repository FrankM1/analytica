<?php
/**
 * Content Spacing Options for our theme.
 *
 * @package     Analytica
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2018, Brainstorm Force
 * @link        http://www.brainstormforce.com
 * @since       Analytica 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Option: Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, analytica()->theme_option_name . '[single-product-sidebar-layout-divider]', array(
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
		analytica()->theme_option_name . '[woocommerce-sidebar-layout]', array(
			'default'           => analytica_get_option( 'woocommerce-sidebar-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		analytica()->theme_option_name . '[woocommerce-sidebar-layout]', array(
			'type'     => 'select',
			'section'  => 'section-sidebars',
			'priority' => 5,
			'label'    => __( 'WooCommerce', 'analytica' ),
			'choices'  => array(
				'default'       => __( 'Default', 'analytica' ),
				'no-sidebar'    => __( 'No Sidebar', 'analytica' ),
				'left-sidebar'  => __( 'Left Sidebar', 'analytica' ),
				'right-sidebar' => __( 'Right Sidebar', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Single Product
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[single-product-sidebar-layout]', array(
			'default'           => analytica_get_option( 'single-product-sidebar-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		analytica()->theme_option_name . '[single-product-sidebar-layout]', array(
			'type'     => 'select',
			'section'  => 'section-sidebars',
			'priority' => 5,
			'label'    => __( 'Single Product', 'analytica' ),
			'choices'  => array(
				'default'       => __( 'Default', 'analytica' ),
				'no-sidebar'    => __( 'No Sidebar', 'analytica' ),
				'left-sidebar'  => __( 'Left Sidebar', 'analytica' ),
				'right-sidebar' => __( 'Right Sidebar', 'analytica' ),
			),
		)
	);


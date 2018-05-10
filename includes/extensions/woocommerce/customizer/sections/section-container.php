<?php
/**
 * Container Options for Analytica theme.
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
	 * Option: Shop Page
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[woocommerce-content-layout]', array(
			'default'           => analytica_get_option( 'woocommerce-content-layout' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		analytica()->theme_option_name . '[woocommerce-content-layout]', array(
			'type'     => 'select',
			'section'  => 'section-container-layout',
			'priority' => 85,
			'label'    => __( 'Container for WooCommerce', 'analytica' ),
			'choices'  => array(
				'default'                 => __( 'Default', 'analytica' ),
				'boxed-container'         => __( 'Boxed', 'analytica' ),
				'content-boxed-container' => __( 'Content Boxed', 'analytica' ),
				'plain-container'         => __( 'Full Width / Contained', 'analytica' ),
				'page-builder'            => __( 'Full Width / Stretched', 'analytica' ),
			),
		)
	);

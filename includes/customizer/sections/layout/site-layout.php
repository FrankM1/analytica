<?php
/**
 * Site Layout Option for Analytica Theme.
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
	 * Option: Container Width
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[site-content-width]', array(
			'default'           => 1200,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'validate_site_width' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Slider(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[site-content-width]', array(
				'type'        => 'ast-slider',
				'section'     => 'section-container-layout',
				'priority'    => 10,
				'label'       => __( 'Container Width', 'analytica' ),
				'suffix'      => '',
				'input_attrs' => array(
					'min'  => 768,
					'step' => 1,
					'max'  => 1920,
				),
			)
		)
	);

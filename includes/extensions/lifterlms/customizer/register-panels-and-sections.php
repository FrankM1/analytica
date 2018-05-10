<?php
/**
 * Register customizer panels & sections.
 *
 * @package     Analytica
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2018, Brainstorm Force
 * @link        http://www.brainstormforce.com
 * @since       Analytica 1.2.0
 */

	/**
	 * Section
	 */
	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-lifterlms',
			array(
				'priority' => 65,
				'title'    => __( 'LifterLMS', 'analytica' ),
				'panel'    => 'panel-layout',
			)
		)
	);

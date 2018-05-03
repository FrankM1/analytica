<?php
/**
 * Register customizer Aspra Pro Section.
 *
 * @package   Analytica
 * @author    Analytica
 * @copyright Copyright (c) 2018, Analytica
 * @link      http://wpanalytica.com/
 * @since     Analytica 1.0.10
 */

// Register custom section types.
$wp_customize->register_section_type( 'Analytica_Pro_Customizer' );

// Register sections.
$wp_customize->add_section(
	new Analytica_Pro_Customizer(
		$wp_customize, 'analytica-pro', array(
			'title'    => esc_html__( 'More Options Available in Analytica Pro!', 'analytica' ),
			'pro_url'  => htmlspecialchars_decode( analytica_get_pro_url( 'https://wpanalytica.com/pricing/', 'customizer', 'upgrade-link', 'upgrade-to-pro' ) ),
			'priority' => 1,
		)
	)
);

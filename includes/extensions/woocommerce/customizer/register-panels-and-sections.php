<?php
/**
 * Register customizer panels & sections fro Woocommerce.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

/**
 * WooCommerce
 */
$wp_customize->add_section(
	new Analytica_WP_Customize_Section(
		$wp_customize, 'section-woo-group',
		array(
			'title'    => __( 'WooCommerce', 'analytica' ),
			'panel'    => 'panel-layout',
			'priority' => 60,
		)
	)
);

$wp_customize->add_section(
	new Analytica_WP_Customize_Section(
		$wp_customize, 'section-woo-general',
		array(
			'title'    => __( 'General', 'analytica' ),
			'panel'    => 'panel-layout',
			'section'  => 'section-woo-group',
			'priority' => 5,
		)
	)
);
$wp_customize->add_section(
	new Analytica_WP_Customize_Section(
		$wp_customize, 'section-woo-shop',
		array(
			'title'    => __( 'Shop', 'analytica' ),
			'panel'    => 'panel-layout',
			'section'  => 'section-woo-group',
			'priority' => 10,
		)
	)
);

$wp_customize->add_section(
	new Analytica_WP_Customize_Section(
		$wp_customize, 'section-woo-shop-single',
		array(
			'title'    => __( 'Single Product', 'analytica' ),
			'panel'    => 'panel-layout',
			'section'  => 'section-woo-group',
			'priority' => 15,
		)
	)
);

$wp_customize->add_section(
	new Analytica_WP_Customize_Section(
		$wp_customize, 'section-woo-shop-cart',
		array(
			'title'    => __( 'Cart Page', 'analytica' ),
			'panel'    => 'panel-layout',
			'section'  => 'section-woo-group',
			'priority' => 20,
		)
	)
);

<?php
/**
 * WooCommerce Options for Analytica Theme.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Option: Disable Breadcrumb
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[enable-cart-upsells]', array(
			'default'           => analytica_get_option( 'enable-cart-upsells' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_checkbox' ),
		)
	);
	$wp_customize->add_control(
		ANALYTICA_THEME_SETTINGS . '[enable-cart-upsells]', array(
			'section'  => 'section-woo-shop-cart',
			'label'    => __( 'Enable Upsells', 'analytica' ),
			'priority' => 10,
			'type'     => 'checkbox',
		)
	);

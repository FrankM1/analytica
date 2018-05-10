<?php
/**
 * WooCommerce Options for Analytica Theme.
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
	 * Option: Shop Columns
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[shop-grids]', array(
			'default'           => array(
				'desktop' => 4,
				'tablet'  => 3,
				'mobile'  => 2,
			),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_responsive_slider' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Responsive_Slider(
			$wp_customize, analytica()->theme_option_name . '[shop-grids]', array(
				'type'        => 'ast-responsive-slider',
				'section'     => 'section-woo-shop',
				'priority'    => 10,
				'label'       => __( 'Shop Columns', 'analytica' ),
				'input_attrs' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 6,
				),
			)
		)
	);

	/**
	 * Option: Products Per Page
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[shop-no-of-products]', array(
			'default'           => analytica_get_option( 'shop-no-of-products' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		analytica()->theme_option_name . '[shop-no-of-products]', array(
			'section'     => 'section-woo-shop',
			'label'       => __( 'Products Per Page', 'analytica' ),
			'type'        => 'number',
			'priority'    => 15,
			'input_attrs' => array(
				'min'  => 1,
				'step' => 1,
				'max'  => 50,
			),
		)
	);

	/**
	 * Option: Product Hover Style
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[shop-hover-style]', array(
			'default'           => analytica_get_option( 'shop-hover-style' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);

	$wp_customize->add_control(
		analytica()->theme_option_name . '[shop-hover-style]', array(
			'type'     => 'select',
			'section'  => 'section-woo-shop',
			'priority' => 20,
			'label'    => __( 'Product Image Hover Style', 'analytica' ),
			'choices'  => apply_filters(
				'analytica_woo_shop_hover_style',
				array(
					''     => __( 'None', 'analytica' ),
					'swap' => __( 'Swap Images', 'analytica' ),
				)
			),
		)
	);

	/**
	 * Option: Single Post Meta
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[shop-product-structure]', array(
			'default'           => analytica_get_option( 'shop-product-structure' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_multi_choices' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Sortable(
			$wp_customize, analytica()->theme_option_name . '[shop-product-structure]', array(
				'type'     => 'ast-sortable',
				'section'  => 'section-woo-shop',
				'priority' => 30,
				'label'    => __( 'Shop Product Structure', 'analytica' ),
				'choices'  => array(
					'title'      => __( 'Title', 'analytica' ),
					'price'      => __( 'Price', 'analytica' ),
					'ratings'    => __( 'Ratings', 'analytica' ),
					'short_desc' => __( 'Short Description', 'analytica' ),
					'add_cart'   => __( 'Add To Cart', 'analytica' ),
					'category'   => __( 'Category', 'analytica' ),
				),
			)
		)
	);

	/**
	 * Option: Woocommerce Shop Archive Content Divider
	 */
	$wp_customize->add_control(
		new Analytica_Control_Divider(
			$wp_customize, analytica()->theme_option_name . '[shop-archive-width-divider]', array(
				'section'  => 'section-woo-shop',
				'type'     => 'ast-divider',
				'priority' => 220,
				'settings' => array(),
			)
		)
	);

	/**
	 * Option: Shop Archive Content Width
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[shop-archive-width]', array(
			'default'           => analytica_get_option( 'shop-archive-width' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);
	$wp_customize->add_control(
		analytica()->theme_option_name . '[shop-archive-width]', array(
			'type'     => 'select',
			'section'  => 'section-woo-shop',
			'priority' => 220,
			'label'    => __( 'Shop Archive Content Width', 'analytica' ),
			'choices'  => array(
				'default' => __( 'Default', 'analytica' ),
				'custom'  => __( 'Custom', 'analytica' ),
			),
		)
	);

	/**
	 * Option: Enter Width
	 */
	$wp_customize->add_setting(
		analytica()->theme_option_name . '[shop-archive-max-width]', array(
			'default'           => 1200,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_number' ),
		)
	);
	$wp_customize->add_control(
		new Analytica_Control_Slider(
			$wp_customize, analytica()->theme_option_name . '[shop-archive-max-width]', array(
				'type'        => 'ast-slider',
				'section'     => 'section-woo-shop',
				'priority'    => 225,
				'label'       => __( 'Enter Width', 'analytica' ),
				'suffix'      => '',
				'input_attrs' => array(
					'min'  => 768,
					'step' => 1,
					'max'  => 1920,
				),
			)
		)
	);

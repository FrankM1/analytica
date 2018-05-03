<?php
/**
 * Register customizer panels & sections.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

	/**
	 * Layout Panel
	 */
	$wp_customize->add_panel(
		new Analytica_WP_Customize_Panel(
			$wp_customize, 'panel-layout',
			array(
				'priority' => 10,
				'title'    => __( 'Layout', 'analytica' ),
			)
		)
	);

	$wp_customize->add_section(
		'section-site-layout', array(
			'priority' => 5,
			'panel'    => 'panel-layout',
			'title'    => __( 'Site Layout', 'analytica' ),
		)
	);

	$wp_customize->add_section(
		'section-container-layout', array(
			'priority' => 10,
			'panel'    => 'panel-layout',
			'title'    => __( 'Container', 'analytica' ),
		)
	);

	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-header',
			apply_filters(
				'analytica_customizer_primary_header_layout',
				array(
					'title'    => __( 'Primary Header', 'analytica' ),
					'panel'    => 'panel-layout',
					'priority' => 20,
				)
			)
		)
	);

	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-footer-group',
			array(
				'title'    => __( 'Footer', 'analytica' ),
				'panel'    => 'panel-layout',
				'priority' => 55,
			)
		)
	);

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

	/**
	 * Footer Widgets Section
	 */
	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-footer-adv',
			array(
				'title'    => __( 'Footer Widgets', 'analytica' ),
				'panel'    => 'panel-layout',
				'section'  => 'section-footer-group',
				'priority' => 5,
			)
		)
	);

	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-footer-small',
			array(
				'title'    => __( 'Footer Bar', 'analytica' ),
				'panel'    => 'panel-layout',
				'section'  => 'section-footer-group',
				'priority' => 10,
			)
		)
	);

	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-blog-group',
			array(
				'priority' => 40,
				'title'    => __( 'Blog', 'analytica' ),
				'panel'    => 'panel-layout',
			)
		)
	);

	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-blog',
			array(
				'priority' => 5,
				'title'    => __( 'Blog / Archive', 'analytica' ),
				'panel'    => 'panel-layout',
				'section'  => 'section-blog-group',
			)
		)
	);

	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-blog-single',
			array(
				'priority' => 10,
				'title'    => __( 'Single Post', 'analytica' ),
				'panel'    => 'panel-layout',
				'section'  => 'section-blog-group',
			)
		)
	);

	$wp_customize->add_section(
		'section-sidebars', array(
			'title'    => __( 'Sidebar', 'analytica' ),
			'panel'    => 'panel-layout',
			'priority' => 50,
		)
	);

	/**
	 * Colors Panel
	 */
	$wp_customize->add_panel(
		'panel-colors-background', array(
			'priority' => 15,
			'title'    => __( 'Colors & Background', 'analytica' ),
		)
	);

	$wp_customize->add_section(
		'section-colors-body', array(
			'title'    => __( 'Base Colors', 'analytica' ),
			'panel'    => 'panel-colors-background',
			'priority' => 1,
		)
	);

	$wp_customize->add_section(
		'section-colors-footer', array(
			'title'    => __( 'Footer Bar', 'analytica' ),
			'panel'    => 'panel-colors-background',
			'priority' => 60,
		)
	);

	$wp_customize->add_section(
		'section-footer-adv-color-bg', array(
			'title'    => __( 'Footer Widgets', 'analytica' ),
			'panel'    => 'panel-colors-background',
			'priority' => 55,
		)
	);

	/**
	 * Typography Panel
	 */
	$wp_customize->add_panel(
		'panel-typography', array(
			'priority' => 20,
			'title'    => __( 'Typography', 'analytica' ),
		)
	);

	$wp_customize->add_section(
		'section-body-typo', array(
			'title'    => __( 'Base Typography', 'analytica' ),
			'panel'    => 'panel-typography',
			'priority' => 1,
		)
	);

	$wp_customize->add_section(
		'section-content-typo', array(
			'title'    => __( 'Content', 'analytica' ),
			'panel'    => 'panel-typography',
			'priority' => 35,
		)
	);

	$wp_customize->add_section(
		new Analytica_WP_Customize_Section(
			$wp_customize, 'section-header-typo',
			apply_filters(
				'analytica_customizer_primary_header_typo',
				array(
					'title'    => __( 'Header', 'analytica' ),
					'panel'    => 'panel-typography',
					'priority' => 20,
				)
			)
		)
	);

	$wp_customize->add_section(
		'section-archive-typo', array(
			'title'    => __( 'Blog / Archive', 'analytica' ),
			'panel'    => 'panel-typography',
			'priority' => 40,
		)
	);

	$wp_customize->add_section(
		'section-single-typo', array(
			'title'    => __( 'Single Page / Post', 'analytica' ),
			'panel'    => 'panel-typography',
			'priority' => 45,
		)
	);

	/**
	 * Buttons Section
	 */
	$wp_customize->add_section(
		'section-buttons', array(
			'priority' => 50,
			'title'    => __( 'Buttons', 'analytica' ),
		)
	);

	/**
	 * Widget Areas Section
	 */
	$wp_customize->add_section(
		'section-widget-areas', array(
			'priority' => 55,
			'title'    => __( 'Widget Areas', 'analytica' ),
		)
	);

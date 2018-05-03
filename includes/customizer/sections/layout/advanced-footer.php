<?php
/**
 * Bottom Footer Options for Analytica Theme.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.12
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Option: Footer Widgets Layout Layout
	 */
	$wp_customize->add_setting(
		ANALYTICA_THEME_SETTINGS . '[footer-adv]', array(
			'default'           => analytica_get_option( 'footer-adv' ),
			'type'              => 'option',
			'sanitize_callback' => array( 'Analytica_Customizer_Sanitizes', 'sanitize_choices' ),
		)
	);

	$wp_customize->add_control(
		new Analytica_Control_Radio_Image(
			$wp_customize, ANALYTICA_THEME_SETTINGS . '[footer-adv]', array(
				'type'    => 'ast-radio-image',
				'label'   => __( 'Footer Widgets Layout', 'analytica' ),
				'section' => 'section-footer-adv',
				'choices' => array(
					'disabled' => array(
						'label' => __( 'Disable', 'analytica' ),
						'path'  => ANALYTICA_THEME_URI . '/assets/images/no-adv-footer-115x48.png',
					),
					'layout-4' => array(
						'label' => __( 'Layout 4', 'analytica' ),
						'path'  => ANALYTICA_THEME_URI . '/assets/images/layout-4-115x48.png',
					),
				),
			)
		)
	);

	// Learn More link if Analytica Pro is not activated.
	if ( ! defined( 'ANALYTICA_EXT_VER' ) ) {

		/**
		 * Option: Divider
		 */
		$wp_customize->add_control(
			new Analytica_Control_Divider(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-footer-widget-more-feature-divider]', array(
					'type'     => 'ast-divider',
					'section'  => 'section-footer-adv',
					'priority' => 20,
					'settings' => array(),
				)
			)
		);
		/**
		 * Option: Learn More about Footer Widget
		 */
		$wp_customize->add_control(
			new Analytica_Control_Description(
				$wp_customize, ANALYTICA_THEME_SETTINGS . '[ast-footer-widget-more-feature-description]', array(
					'type'     => 'ast-description',
					'section'  => 'section-footer-adv',
					'priority' => 20,
					'label'    => '',
					'help'     => '<p>' . __( 'More Options Available for Footer Widgets in Analytica Pro!', 'analytica' ) . '</p><a href="' . analytica_get_pro_url( 'https://wpanalytica.com/docs/footer-widgets-analytica-pro/', 'customizer', 'learn-more', 'upgrade-to-pro' ) . '" class="button button-primary"  target="_blank" rel="noopener">' . __( 'Learn More', 'analytica' ) . '</a>',
					'settings' => array(),
				)
			)
		);
	}

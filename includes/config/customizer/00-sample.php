<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_sample_control' );
/**
 * [analytica_theme_defaults description]
 */
function analytica_admin_add_customizer_sample_control( array $controls ) {

    $default = Analytica\Options::defaults();

    $controls[] = [
        'id'      => 'site-content-color',
        'section' => 'sample-sample',
        'label'   => esc_html__( 'Site container color', 'analytica' ),
        'type'    => 'color',
        'choices'     => array(
            'alpha' => true,
        ),
     ];

     $controls[] = [
        'id' 		=> 'site-content-dimensions',
        'section' => 'sample-sample',
        'label'   => esc_html__( 'Site container dimensions', 'analytica' ),
        'type'    => 'dimensions-responsive',
        'responsive' => true,
        'size_units' => [ 'px', 'em', '%' ],
        'default' => [
            'desktop' => [
                'top' 		=> 10,
                'right' 	=> 10,
                'bottom' 	=> 10,
                'left' 		=> 10,
                'unit' => 'px',
                'isLinked' => ''
            ],
            'tablet' => [
                'top' 		=> 10,
                'right' 	=> 10,
                'bottom' 	=> 10,
                'left' 		=> 10,
                'unit' => 'px',
                'isLinked' => ''
            ],
            'mobile' => [
                'top' 		=> 10,
                'right' 	=> 10,
                'bottom' 	=> 10,
                'left' 		=> 10,
                'unit' => 'px',
                'isLinked' => ''
            ]
        ],
        'placeholder' => [
            'top' 		=> 10,
            'right' 	=> 10,
            'bottom' 	=> 10,
            'left' 		=> 10,
        ],
        'choices' => array(
            'top',
            'right',
            'bottom',
            'left',
        ),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 500,
            'step'  => 1,
        ),
     ];

     $controls[] = [
        'id'      => 'site-content-icon',
        'section' => 'sample-sample',
        'label'   => esc_html__( 'Site container icon', 'analytica' ),
        'type'    => 'icon',
        'choices' => analytica_get_awesome_icons( 'up_arrows' ),
     ];

    return $controls;
}

add_action( 'customize_register', 'analytica_add_sample_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_sample_panels_and_sections( $wp_customize ) {
    $wp_customize->add_panel( 'sample', [
        'priority' => 9,
        'title'    => esc_html__( 'General', 'analytica' ),
    ]);

    $wp_customize->add_section( 'sample-sample', [
        'title'    => esc_html__( 'General Settings', 'analytica' ),
        'panel'    => 'sample',
        'priority' => 10,
    ]);

    $wp_customize->add_section( 'container-style', [
        'title'    => esc_html__( 'Container Style', 'analytica' ),
        'panel'    => 'sample',
        'priority' => 11,
    ]);

    $wp_customize->add_section( 'logo-favicon', [
        'title'    => esc_html__( 'Logo & Favicon', 'analytica' ),
        'priority' => 14,
    ]);

}
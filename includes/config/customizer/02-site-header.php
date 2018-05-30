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
add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_site_header_control' );
/**
 * [analytica_theme_defaults description]
 */
function analytica_admin_add_customizer_site_header_control( $controls ) {

    $default = Analytica\Options::defaults();

    $controls[] = [
        'id'      => 'site-header',
        'section' => 'site-header',
        'type'    => 'switch',
        'label'   => esc_html__( 'Enable Header' , 'analytica' ),
        'default' => $default['site-header'],
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ]
    ];

    $controls[] = [
        'id'              => 'site-header-background-color',
        'section'         => 'site-header',
        'type'            => 'color',
        'title'           => esc_html__( 'Background color' , 'analytica' ),
        'default'         => $default['site-header-background-color'],
        'conditions' => [
            [
                'setting'  => 'site-header',
                'operator' => '==',
                'value'    => true,
            ],
        ],
        'output'    => [
            [
                'element' => '.site-header',
                'property' => 'background-color',
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'site-header-overlay',
        'section' => 'site-header',
        'default' => $default['site-header-overlay'],
        'type'    => 'switch',
        'label'   => esc_html__( 'Header Overlay' , 'analytica' ),
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ],
    ];

    $controls[] = [
        'id'      => 'site-header-sticky',
        'section' => 'site-header',
        'default' => $default['site-header-sticky'],
        'type'    => 'switch',
        'label'   => esc_html__( 'Header Sticky' , 'analytica' ),
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ],
    ];

    $controls[] = [
        'id'      => 'site-header-transparent',
        'section' => 'site-header',
        'default' => $default['site-header-transparent'],
        'type'    => 'switch',
        'label'   => esc_html__( 'Header Transparent' , 'analytica' ),
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ],
    ];

    return $controls;
}

add_action( 'customize_register', 'analytica_add_header_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_header_panels_and_sections( $wp_customize ) {
    $wp_customize->add_section( 'site-header', [
        'title'    => esc_html__( 'Site Header', 'analytica' ),
        'priority' => 19,
    ] );
}

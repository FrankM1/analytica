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
        'id'      => 'header',
        'section' => 'header_composer',
        'type'    => 'switch',
        'label'   => esc_html__( 'Enable Header' , 'analytica' ),
        'default' => '1',
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ]
    ];

    $controls[] = [
        'id'              => 'site-header-background-color',
        'section'         => 'header_composer',
        'type'            => 'color',
        'title'           => esc_html__( 'Background color' , 'analytica' ),
        'default'         => '#fff',
        'conditions' => [
            [
                'setting'  => 'header',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'header-overlay',
        'section' => 'header_composer',
        'type'    => 'switch',
        'label'   => esc_html__( 'Header Overlay' , 'analytica' ),
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ],
    ];

    $controls[] = [
        'id'      => 'header-sticky',
        'section' => 'header_composer',
        'type'    => 'switch',
        'label'   => esc_html__( 'Header Sticky' , 'analytica' ),
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ],
    ];

    $controls[] = [
        'id'      => 'header-transparent',
        'section' => 'header_composer',
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
    $wp_customize->add_section( 'header_composer', [
        'title'    => esc_html__( 'Site Header', 'analytica' ),
        'priority' => 19,
    ] );
}

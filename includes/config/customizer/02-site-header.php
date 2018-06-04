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
        'section' => 'site-header-settings',
        'type'    => 'switch',
        'label'   => esc_html__( 'Enable Header' , 'analytica' ),
        'default' => $default['site-header'],
    ];

    $controls[] = [
        'id'              => 'site-header-background-color',
        'section'         => 'site-header-settings',
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
        'output' => [
            [
                'element' => '.site-header',
                'property' => 'background-color',
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'site-header-overlay',
        'section' => 'site-header-settings',
        'default' => $default['site-header-overlay'],
        'type'    => 'switch',
        'label'   => esc_html__( 'Header Overlay' , 'analytica' ),
    ];

    $controls[] = [
        'id'      => 'site-header-transparent',
        'section' => 'site-header-settings',
        'default' => $default['site-header-transparent'],
        'type'    => 'switch',
        'label'   => esc_html__( 'Header Transparent' , 'analytica' ),
    ];

    $controls[] = [
        'id'      => 'site-header-padding',
        'type'    => 'spacing',
        'label'   => esc_html__( 'Footer padding', 'analytica' ),
        'section' => 'site-header-style',
        'default'   => $default['site-header-padding'],
        'transport' => 'auto',
        'output'    => [
            [
                'property' => 'padding',
                'element'  => '.site-header',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site-header',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'        => 'site-header-link-color',
        'section'   => 'site-header-style',
        'type'      => 'color',
        'transport' => 'auto',
        'label'     => esc_html__( 'Link Color' , 'analytica' ),
        'output'    => [
            [
                'property' => 'color',
                'element'  => '.nav.nav-horizontal ul > li > a',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site-header',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'        => 'site-header-link-highlight-color',
        'section'   => 'site-header-style',
        'type'      => 'color',
        'transport' => 'auto',
        'label'     => esc_html__( 'Highlight Link Color' , 'analytica' ),
        'output'    => [
            [
                'property' => 'color',
                'element'  => '.nav.nav-horizontal ul > li:hover > a',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site-header',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'site-header-border-style',
        'type'    => 'select',
        'label'   => esc_html__( 'Border style', 'analytica' ),
        'section' => 'site-header-style',
        'default'   => $default['site-header-border-style'],
        'transport' => 'auto',
        'choices' => [
            'solid' => 'solid',
        ],
        'output'    => [
            [
                'property' => 'border-style',
                'element'  => '.site-header',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site-header',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'site-header-border',
        'type'    => 'spacing',
        'label'   => esc_html__( 'Border', 'analytica' ),
        'section' => 'site-header-style',
        'default'   => $default['site-header-border'],
        'transport' => 'auto',
        'conditions' => [
            [
                'setting'  => 'site-header',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'        => 'site-header-border-color',
        'section'   => 'site-header-style',
        'type'      => 'color',
        'transport' => 'auto',
        'label'     => esc_html__( 'Border Color' , 'analytica' ),
        'default'   => $default['site-header-border-color'],
        'output'    => [
            [
                'property' => 'border-color',
                'element'  => '.site-header',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site-header',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    return $controls;
}

add_action( 'customize_register', 'analytica_add_header_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_header_panels_and_sections( $wp_customize ) {
    $wp_customize->add_panel( 'site-header', [
        'title'    => esc_html__( 'Site Header', 'analytica' ),
        'priority' => 19,
    ] );

    $wp_customize->add_section( 'site-header-settings', [
        'title'    => esc_html__( 'Settings', 'analytica' ),
        'panel'    => 'site-header',
        'priority' => 20,
    ]);

    $wp_customize->add_section( 'site-header-style', [
        'title'    => esc_html__( 'Style', 'analytica' ),
        'panel'    => 'site-header',
        'priority' => 21,
    ] );
}

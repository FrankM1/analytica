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

add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_general_control' );
/**
 * [analytica_theme_defaults description]
 */
function analytica_admin_add_customizer_general_control( array $controls ) {
    $default = Analytica\Options::defaults();

    $controls[] = [
        'id'      => 'site-layout',
        'section' => 'general_settings',
        'type'    => 'radio-buttonset',
        'label'   => esc_html__( 'Site layout' , 'analytica' ),
        'default' => $default['site-layout'],
        'options' => [
            'site-boxed'     => esc_html__( 'Boxed' , 'analytica' ),
            'site-wide'      => esc_html__( 'Wide' , 'analytica' ),
            'site-fullwidth' => esc_html__( 'Fullwidth' , 'analytica' ),
        ],
    ];

    $controls[] = [
        'id'      => 'site-content-width',
        'section' => 'general_settings',
        'label'   => esc_html__( 'Site container width', 'analytica' ),
        'type'    => 'number',
        'default' => $default['site-content-width'],
     ];

    $controls[] = [
        'id'      => 'site-sidebar-width',
        'section' => 'general_settings',
        'label'   => esc_html__( 'Site sidebar width', 'analytica' ),
        'type'    => 'number',
        'default' => $default['site-sidebar-width'],
        'conditions' => [
            [
                'setting'  => 'site_sidebar_enable',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Body Background', 'analytica' ),
        'id'        => 'body_background',
        'type'      => 'background',
        'section'   => 'container_style',
        'transport' => 'auto',
        'default'     => array(
            'background-color'      => '',
            'background-image'      => '',
            'background-repeat'     => '',
            'background-position'   => '',
            'background-size'       => '',
            'background-attachment' => '',
        ),
        'output'    => [
            array(
                'element' => 'body',
            ),
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Body Background', 'analytica' ),
        'id'        => 'body_background',
        'type'      => 'background',
        'section'   => 'container_style',
        'transport' => 'auto',
        'default'     => array(
            'background-color'      => '',
            'background-image'      => '',
            'background-repeat'     => '',
            'background-position'   => '',
            'background-size'       => '',
            'background-attachment' => '',
        ),
        'output'    => [
            array(
                'element' => 'site-container-background',
            ),
        ],
    ];

    $controls[] = [
        'id' => 'site-container-background',
        'title' => esc_html__( 'Site container background' , 'analytica' ),
        'type' => 'background',
        'section' => 'container_style',
        'default' => [
            'background-color'      => '',
            'background-image'      => '',
            'background-repeat'     => '',
            'background-position'   => '',
            'background-size'       => '',
            'background-attachment' => '',
        ],
        'transport' => 'auto',
        'output' => [
            [
                'property' => 'background-color',
                'element' => '.site-inner',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site-layout',
                'operator' => '==',
                'value'    => 'site-boxed',
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'site-description',
        'type'    => 'switch',
        'section' => 'logo_favicon',
        'label'   => esc_html__( 'Enable Site description', 'analytica' ),
        'default' => $default['site-description'],
        'options' => [
            1 => esc_attr__( 'Enable', 'analytica' ),
            0 => esc_attr__( 'Disable', 'analytica' ),
        ],
    ];

    return $controls;
}

add_action( 'customize_register', 'analytica_add_general_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_general_panels_and_sections( $wp_customize ) {
    $wp_customize->add_panel( 'general', [
        'priority' => 9,
        'title'    => esc_html__( 'General', 'analytica' ),
    ]);

    $wp_customize->add_section( 'general_settings', [
        'title'    => esc_html__( 'General Settings', 'analytica' ),
        'panel'    => 'general',
        'priority' => 10,
    ]);

    $wp_customize->add_section( 'container_style', [
        'title'    => esc_html__( 'Container Style', 'analytica' ),
        'panel'    => 'general',
        'priority' => 11,
    ]);

    $wp_customize->add_section( 'logo_favicon', [
        'title'    => esc_html__( 'Logo & Favicon', 'analytica' ),
        'priority' => 14,
    ]);

}

<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Radium\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://radiumthemes.com/
 */

add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_general_control' );
/**
 * [analytica_theme_defaults description]
 */
function analytica_admin_add_customizer_general_control( array $controls ) {
    $default = Analytica\Options::defaults();

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
                'element' => '.site-boxed .site-inner, .site-inner, .content-sidebar-wrap',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site_layout',
                'operator' => '==',
                'value'    => 'site-boxed',
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'site_description',
        'type'    => 'switch',
        'section' => 'logo_favicon',
        'label'   => esc_html__( 'Enable Site description', 'analytica' ),
        'default' => $default['site_description'],
        'options' => [
            1 => esc_attr__( 'Enable', 'analytica' ),
            0 => esc_attr__( 'Disable', 'analytica' ),
        ],
    ];

    $controls[] = [
        'id'      => 'login_logo',
        'section' => 'logo_favicon',
        'type'    => 'image',
        'default' => $default['login_logo'],
        'label'   => esc_html__( 'Upload Login Logo', 'analytica' ),
        'desc'    => esc_html__( 'Upload a custom logo for the login page.', 'analytica' ),
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

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
        'id'      => 'site-content-color',
        'section' => 'general-settings',
        'label'   => esc_html__( 'Site container color', 'analytica' ),
        'type'    => 'alpha-color',
     ];

     $controls[] = [
        'id' 		=> 'site-content-dimensions',
        'section' => 'general-settings',
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
        'input_attrs' 			=> array(
            'min'   => 0,
            'max'   => 500,
            'step'  => 1,
        ),
     ];

     $controls[] = [
        'id'      => 'site-content-icon',
        'section' => 'general-settings',
        'label'   => esc_html__( 'Site container icon', 'analytica' ),
        'type'    => 'icon',
        'choices' => analytica_get_awesome_icons( 'up_arrows' ),
     ];

    $controls[] = [
        'id'      => 'site-layout',
        'section' => 'general-settings',
        'type'    => 'radio-buttonset',
        'label'   => esc_html__( 'Site layout' , 'analytica' ),
        'default' => $default['site-layout'],
        'options' => [
            'site-boxed'     => esc_html__( 'Boxed' , 'analytica' ),
            'site-wide'      => esc_html__( 'Wide' , 'analytica' ),
        ],
    ];

    $controls[] = [
        'id'      => 'site-sidebar-layout',
        'section' => 'general-settings',
        'type'    => 'radio-image',
        'label'   => esc_html__( 'Site sidebar Layout', 'energia' ),
        'options' => analytica_get_layouts_for_options(),
        'default' => $default['site-sidebar-layout'],
    ];

    $controls[] = [
        'id'      => 'site-content-width',
        'section' => 'general-settings',
        'label'   => esc_html__( 'Site container width', 'analytica' ),
        'type'    => 'number',
        'default' => $default['site-content-width'],
     ];

    $controls[] = [
        'id'      => 'site-sidebar-width',
        'section' => 'general-settings',
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
        'id'      => 'site-description',
        'type'    => 'switch',
        'section' => 'logo-favicon',
        'label'   => esc_html__( 'Enable Site description', 'analytica' ),
        'default' => $default['site-description'],
        'options' => [
            1 => esc_attr__( 'Enable', 'analytica' ),
            0 => esc_attr__( 'Disable', 'analytica' ),
        ],
    ];

    $controls[] = [
        'id'      => 'site-detach-containers',
        'section' => 'container-style',
        'type'    => 'switch',
        'label'   => esc_html__( 'Detach containers' , 'analytica' ),
        'default' => $default['site-detach-containers'],
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ]
    ];

    $controls[] = [
        'id'      => 'site-dual-containers',
        'section' => 'container-style',
        'type'    => 'switch',
        'label'   => esc_html__( 'Dual containers' , 'analytica' ),
        'default' => $default['site-dual-containers'],
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ]
    ];

    $controls[] = [
        'id'      => 'site-accent-color',
        'section' => 'container-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Accent color', 'analytica' ),
        'default' => $default['site-accent-color'],
    ];

    $controls[] = [
        'id'      => 'site-background-color',
        'section' => 'container-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Background color', 'analytica' ),
        'default' => $default['site-background-color'],
        'choices'     => array(
            'alpha' => true,
        ),
    ]; 

    $controls[] = [
        'id'      => 'site-content-background-color',
        'section' => 'container-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Content background', 'analytica' ),
        'default' => $default['site-content-background-color'],
        'choices'     => array(
            'alpha' => true,
        ),
        'output'    => array(
            array(
                'element' => '.site-mono-container .site-container, .site-dual-containers .site-main-inner, .site-dual-containers .site-sidebar .widget-area-inner',
                'property' => 'background-color'
            ),
        ),
    ];

    $controls[] = [
        'id'      => 'site-link-color',
        'section' => 'container-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Link color', 'analytica' ),
        'default' => $default['site-link-color'],
    ];

    $controls[] = [
        'id'      => 'site-link-highlight-color',
        'section' => 'container-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Link highlight color', 'analytica' ),
        'default' => $default['site-link-highlight-color'],
    ];

    $controls[] = [
        'id'      => 'site-text-color',
        'section' => 'container-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Text color', 'analytica' ),
        'default' => $default['site-text-color'],
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

    $wp_customize->add_section( 'general-settings', [
        'title'    => esc_html__( 'General Settings', 'analytica' ),
        'panel'    => 'general',
        'priority' => 10,
    ]);

    $wp_customize->add_section( 'container-style', [
        'title'    => esc_html__( 'Container Style', 'analytica' ),
        'panel'    => 'general',
        'priority' => 11,
    ]);

    $wp_customize->add_section( 'logo-favicon', [
        'title'    => esc_html__( 'Logo & Favicon', 'analytica' ),
        'priority' => 14,
    ]);

}

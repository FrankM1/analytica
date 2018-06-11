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
        'label'   => esc_html__( 'Site sidebar Layout', 'analytica' ),
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
        'output'    => array(
            array(
                'element' => 'body',
                'property' => 'background-color'
            ),
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

    $controls[] = [
        'id'      => 'site-border-color',
        'section' => 'container-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Border color', 'analytica' ),
        'default' => $default['site-border-color'],
        'choices'     => array(
            'alpha' => true,
        ),
        'output'    => array(
            array(
                'element' => '.single .post-navigation, .comments-area, .page-links .page-link, .page-links a .page-link, .gallery-icon, .analytica-comment-list li.depth-1 .analytica-comment, .analytica-comment-list li.depth-2 .analytica-comment',
                'property' => 'border-color'
            ),

            array(
                'element' => 'hr',
                'property' => 'background-color'
            ),
        ),
    ];

    $controls[] = [
        'id'      => 'site-form-inputs-background-color',
        'section' => 'form-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Form background color', 'analytica' ),
        'default' => $default['site-form-inputs-background-color'],
        'choices'     => array(
            'alpha' => true,
        ),
        'output'    => array(
            array(
                'element' => 'input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type=reset], input[type=tel], select, textarea',
                'property' => 'background-color'
            ),
        ),
    ];

    $controls[] = [
        'id'      => 'site-form-inputs-highlight-background-color',
        'section' => 'form-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Form highlight background color', 'analytica' ),
        'default' => $default['site-form-inputs-highlight-background-color'],
        'choices'     => array(
            'alpha' => true,
        ),
        'output'    => array(
            array(
                'element' => 'input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type=reset]:focus, input[type=tel]:focus, select:focus, textarea:focus',
                'property' => 'background-color'
            ),
        ),
    ];

    $controls[] = [
        'id'      => 'site-form-inputs-border-color',
        'section' => 'form-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Form border color', 'analytica' ),
        'default' => $default['site-form-inputs-border-color'],
        'choices'     => array(
            'alpha' => true,
        ),
        'output'    => array(
            array(
                'element' => 'input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type=reset], input[type=tel], select, textarea',
                'property' => 'border-color'
            ),
        ),
    ];

    $controls[] = [
        'id'      => 'site-form-inputs-text-color',
        'section' => 'form-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Form text color', 'analytica' ),
        'default' => $default['site-form-inputs-text-color'],
        'choices'     => array(
            'alpha' => true,
        ),
        'output'    => array(
            array(
                'element' => 'input[type="text"], input[type="number"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type=reset], input[type=tel], select, textarea',
                'property' => 'color'
            ),
        ),
    ];

    $controls[] = [
        'id'      => 'button-background-color',
        'section' => 'button-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Button background color', 'analytica' ),
        'default' => $default['button-background-color'],
        'choices'     => array(
            'alpha' => true,
        ),
    ];

    $controls[] = [
        'id'      => 'button-background-h-color',
        'section' => 'button-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Button background highlight color', 'analytica' ),
        'default' => $default['button-background-h-color'],
        'choices'     => array(
            'alpha' => true,
        ),
    ];

    $controls[] = [
        'id'      => 'button-text-color',
        'section' => 'button-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Button text color', 'analytica' ),
        'default' => $default['button-text-color'],
        'choices'     => array(
            'alpha' => true,
        ),
    ];

    $controls[] = [
        'id'      => 'button-radius',
        'section' => 'button-style',
        'type'    => 'text',
        'label'   => esc_html__( 'Button radius', 'analytica' ),
        'default' => $default['button-radius'],
    ];

    $controls[] = [
        'id'      => 'button-h-color',
        'section' => 'button-style',
        'type'    => 'color',
        'label'   => esc_html__( 'Button highlight color', 'analytica' ),
        'default' => $default['button-h-color'],
        'choices'     => array(
            'alpha' => true,
        ),
    ];

    $controls[] = [
        'id'      => 'button-h-padding',
        'section' => 'button-style',
        'type'    => 'text',
        'label'   => esc_html__( 'Button horizontal padding', 'analytica' ),
        'default' => $default['button-h-padding'],
    ];

    $controls[] = [
        'id'      => 'button-v-padding',
        'section' => 'button-style',
        'type'    => 'text',
        'label'   => esc_html__( 'Button vertical padding', 'analytica' ),
        'default' => $default['button-v-padding'],
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

    $wp_customize->add_section( 'form-style', [
        'title'    => esc_html__( 'Form Style', 'analytica' ),
        'panel'    => 'general',
        'priority' => 12,
    ]);

    $wp_customize->add_section( 'button-style', [
        'title'    => esc_html__( 'Button Style', 'analytica' ),
        'panel'    => 'general',
        'priority' => 13,
    ]);

    $wp_customize->add_section( 'logo-favicon', [
        'title'    => esc_html__( 'Logo & Favicon', 'analytica' ),
        'priority' => 14,
    ]);

}

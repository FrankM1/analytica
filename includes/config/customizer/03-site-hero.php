<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Radium\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_site_hero_control' );
/**
 * [analytica_theme_defaults description]
 */
function analytica_admin_add_customizer_site_hero_control( $controls ) {

    $controls[] = [
		'label'   => esc_html__( 'Enable Site Hero', 'analytica' ),
		'id'      => 'site-hero',
		'type'    => 'switch',
		'section' => 'site-hero-settings',
    ];

    $controls[] = [
		'label'   => esc_html__( 'Enable title', 'analytica' ),
		'id'      => 'site-hero-show-title',
		'type'    => 'switch',
		'section' => 'site-hero-settings',
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
		'label'   => esc_html__( 'Enable subtitle', 'analytica' ),
		'id'      => 'site-hero-show-subtitle',
		'type'    => 'switch',
		'section' => 'site-hero-settings',
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
		'label'   => esc_html__( 'Enable breadcrumbs', 'analytica' ),
		'id'      => 'site-hero-breadcrumbs',
		'type'    => 'switch',
		'section' => 'site-hero-settings',
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'single-post-site-hero',
        'section' => 'single_post_settings',
        'type'    => 'switch',
        'label'   => esc_html__( 'Display page header section on posts', 'analytica' ),
        'conditions' => [
            [
                'setting'  => 'single_post_style',
                'operator' => '!=',
                'value'    => 'single-post-overlay-wide',
            ],
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'archive-site-hero',
        'section' => 'archive_settings',
        'type'    => 'switch',
        'label'   => esc_html__( 'Display page header on post archives', 'analytica' ),
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'label'   => esc_html__( 'Full window height', 'analytica' ),
        'desc'    => esc_html__( 'Sets full window height for custom header', 'analytica' ),
        'id'      => 'site-hero-fullheight',
        'type'    => 'switch',
        'section' => 'site-hero-settings',
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'label'           => esc_html__( 'Custom header height in px', 'analytica' ),
        'desc'            => esc_html__( 'Allows you to set the custom header height', 'analytica' ),
        'id'              => 'site-hero-height',
        'type'            => 'text',
        'section'         => 'site-hero-settings',
        'conditions' => [
            [
                'setting'  => 'site-hero-fullheight',
                'operator' => '==',
                'value'    => false,
            ],
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
        'output'    => [
            array(
                'element'  => '.site-hero, .site-hero-wrapper',
                'property' => 'min-height',
            ),
        ],
        'media_query' => '@media only screen and (max-width: 768px)',
    ];

    $controls[] = [
		'label'   => esc_html__( 'Background color scheme style', 'analytica' ),
		'desc'    => esc_html__( 'According to the color scheme you choose the text colors will be changed to make it more readable.', 'analytica' ),
        'id'      => 'site-hero-background-color-base',
		'type'    => 'radio-buttonset',
		'section' => 'site-hero-settings',
		'options' => [
            'background-dark'  => esc_html__( 'Light', 'analytica' ),
            'background-light' => esc_html__( 'Dark', 'analytica' ),
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
	];

    $controls[] = [
        'label'   => esc_html__( 'Text alignment','analytica' ),
        'desc'    => esc_html__( 'Choose the text alignment in the custom header.', 'analytica' ),
        'id'      => 'site-hero-text-alignment',
        'type'    => 'radio-buttonset',
        'section' => 'site-hero-settings',
        'transport' => 'auto',
        'options' => [
            'text-left'   => esc_html__( 'Left', 'analytica' ),
            'text-center' => esc_html__( 'Center', 'analytica' ),
            'text-right'  => esc_html__( 'Right', 'analytica' ),
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
		'label'     => esc_html__( 'Background overlay color','analytica' ),
		'desc'      => esc_html__( 'The background color will be as an overlay.', 'analytica' ),
		'id'        => 'site-hero-background-overlay-color',
		'type'      => 'color',
		'transport' => 'auto',
		'section'   => 'site-hero-background',
		'output'    => [
            array(
                'element'  => '.site-hero-background',
                'property' => 'background-color',
            ),
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
	];

    $controls[] = [
        'label'     => esc_html__( 'Header Font', 'analytica' ),
        'desc'      => esc_html__( 'The page header for your site.', 'analytica' ),
        'id'        => 'site-hero-header-font',
        'section'   => 'site-hero-typography',
        'type'      => 'typography',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element' => '.site-hero .site-hero-wrapper .site-hero-header',
            ),
        ),
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
        'media_query' => '@media only screen and (min-width: 768px)',
    ];

    $controls[] = [
        'id'      => 'site-hero-header-padding',
        'type'    => 'spacing',
        'label'   => esc_html__( 'Heading padding', 'analytica' ),
        'section' => 'site-hero-typography',
        'transport' => 'auto',
        'output'    => [
            [
                'property' => 'padding',
                'element'  => '.site-hero .site-hero-wrapper .site-hero-header',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Sub header Font', 'analytica' ),
        'desc'      => esc_html__( 'The page subheader for your site.', 'analytica' ),
        'id'        => 'site-hero-subheader-font',
        'section'   => 'site-hero-typography',
        'type'      => 'typography',
        'transport' => 'auto',
        'media_query' => '@media only screen and (min-width: 768px)',
        'output'    => array(
            array(
                'element' => '.site-hero .site-hero-wrapper .site-hero-subheader',
            ),
        ),
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'hero_subheader-padding',
        'type'    => 'spacing',
        'label'   => esc_html__( 'Sub heading padding', 'analytica' ),
        'section' => 'site-hero-typography',
        'default' => [
            'top'    => '10px',
            'bottom' => '10px',
            'left'   => '',
            'right'  => '',
        ],
        'transport' => 'auto',
        'output'    => [
            [
                'property' => 'padding',
                'element'  => '.site-hero .site-hero-wrapper .site-hero-subheader',
            ],
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    return $controls;
}

add_action( 'customize_register', 'analytica_add_hero_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_hero_panels_and_sections( $wp_customize ) {
    $wp_customize->add_panel( 'site-hero', [
        'priority' => 21,
        'title'    => esc_html__( 'Site Hero', 'analytica' ),
    ] );

    $wp_customize->add_section( 'site-hero-settings', [
        'title'    => esc_html__( 'Settings', 'analytica' ),
        'panel'    => 'site-hero',
        'priority' => 1,
    ] );

    $wp_customize->add_section( 'site-hero-background', [
        'title'    => esc_html__( 'Background', 'analytica' ),
        'panel'    => 'site-hero',
        'priority' => 2,
    ] );

    $wp_customize->add_section( 'site-hero-typography', [
        'title'    => esc_html__( 'Typography', 'analytica' ),
        'panel'    => 'site-hero',
        'priority' => 3,
    ] );

    $wp_customize->add_section( 'site-hero-mobile', [
        'title'    => esc_html__( 'Mobile', 'analytica' ),
        'panel'    => 'site-hero',
        'priority' => 4,
    ] );
}

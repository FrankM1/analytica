<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Radium\Framework
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https://analyticathemes.com/
 */

add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_site_hero_control' );
/**
 * [analytica_theme_defaults description]
 */
function analytica_admin_add_customizer_site_hero_control( $controls ) {

    $default = Analytica\Options::defaults();

    $controls[] = [
		'label'   => esc_html__( 'Page Header', 'analytica' ),
		'id'      => 'site-hero',
		'type'    => 'radio-buttonset',
		'section' => 'site-hero-settings',
		'default' => $default['site-hero'],
		'options' => [
			'on'  => esc_html__( 'Enable', 'analytica' ),
			'off' => esc_html__( 'Disable', 'analytica' ),
		],
	];

    $controls[] = [
        'id'      => 'single-post-site-hero',
        'section' => 'single_post_settings',
        'type'    => 'switch',
        'label'   => esc_html__( 'Display page header section on posts', 'analytica' ),
        'default' => $default['single-post-site-hero'],
        'conditions' => [
            [
                'setting'  => 'single_post_style',
                'operator' => '!=',
                'value'    => 'single-post-overlay-wide',
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'archive-site-hero',
        'section' => 'archive_settings',
        'type'    => 'switch',
        'label'   => esc_html__( 'Display page header on post archives', 'analytica' ),
        'default' => $default['archive-site-hero'],
    ];

    $controls[] = [
        'label'   => esc_html__( 'Full window height', 'analytica' ),
        'desc'    => esc_html__( 'Sets full window height for custom header', 'analytica' ),
        'id'      => 'site-hero-fullheight',
        'type'    => 'radio-buttonset',
        'section' => 'site-hero-settings',
        'default'         => $default['site-hero-fullheight'],
        'options' => [
            'on'  => esc_html__( 'On', 'analytica' ),
            'off' => esc_html__( 'Off', 'analytica' ),
        ],
    ];

    $controls[] = [
        'label'           => esc_html__( 'Custom header height in px', 'analytica' ),
        'desc'            => esc_html__( 'Allows you to set the custom header height', 'analytica' ),
        'id'              => 'site-hero-height',
        'type'            => 'text',
        'default'         => $default['site-hero-height'],
        'section'         => 'site-hero-settings',
        'conditions' => [
            [
                'setting'  => 'site-hero-fullheight',
                'operator' => '==',
                'value'    => 'off',
            ],
        ],
    ];

    $controls[] = [
		'label'   => esc_html__( 'Background color scheme style', 'analytica' ),
		'desc'    => esc_html__( 'According to the color scheme you choose the text colors will be changed to make it more readable.', 'analytica' ),
        'id'      => 'site-hero-background-color-base',
        'default' => $default['site-hero-background-color-base'],
		'type'    => 'radio-buttonset',
		'section' => 'site-hero-settings',
		'options' => [
            'background-dark'  => esc_html__( 'Light', 'analytica' ),
            'background-light' => esc_html__( 'Dark', 'analytica' ),
		],
	];

    $controls[] = [
        'label'   => esc_html__( 'Text alignment','analytica' ),
        'desc'    => esc_html__( 'Choose the text alignment in the custom header.', 'analytica' ),
        'id'      => 'site-hero-text-alignment',
        'type'    => 'radio-buttonset',
        'section' => 'site-hero-settings',
        'transport' => 'auto',
        'default' => $default['site-hero-text-alignment'],
        'options' => [
            'text-left'   => esc_html__( 'Left', 'analytica' ),
            'text-center' => esc_html__( 'Center', 'analytica' ),
            'text-right'  => esc_html__( 'Right', 'analytica' ),
        ],
    ];

    $controls[] = [
		'label'   => esc_html__( 'Enable background image', 'analytica' ),
		'id'      => 'site-hero-background',
		'type'    => 'radio-buttonset',
		'section' => 'site-hero-background',
		'default' => $default['site-hero-background'],
		'options' => [
			'on'  => esc_html__( 'Enable', 'analytica' ),
			'off' => esc_html__( 'Disable', 'analytica' ),
		],
	];

    $controls[] = [
		'label'     => esc_html__( 'Background image','analytica' ),
		'desc'      => esc_html__( 'Select image for custom header background', 'analytica' ),
		'id'        => 'site-hero-background-image',
		'default'   => $default['site-hero-background-image'],
		'type'      => 'image',
		'transport' => 'auto',
        'section'   => 'site-hero-background',
        'conditions' => [
            [
                'setting'  => 'site-hero-background',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'site-hero-background-inherit',
        'section' => 'site-hero-background',
        'type'    => 'switch',
        'label'   => esc_html__( 'Inherit featured images', 'analytica' ),
        'desc'    => esc_html__( 'Allows the page header to use the post\'s featured images as a background when available. This will override the image above.', 'analytica' ),
        'default' => $default['site-hero-background-inherit'],
    ];

    $controls[] = [
        'label'   => esc_html__( 'Custom header parallax effect','analytica' ),
        'id'      => 'site-hero-parallax',
        'type'    => 'radio-buttonset',
        'section' => 'site-hero-settings',
        'default'         => $default['site-hero-parallax'],
        'options' => [
            'on'  => esc_html__( 'On', 'analytica' ),
            'off' => esc_html__( 'Off', 'analytica' ),
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero-background',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
    ];

    $controls[] = [
		'label'     => esc_html__( 'Background color','analytica' ),
		'desc'      => esc_html__( 'The background color will be shown if the image is not set for the custom header.', 'analytica' ),
		'id'        => 'site-hero-background-color',
		'default'   => $default['site-hero-background-color'],
		'type'      => 'color',
		'transport' => 'auto',
		'section'   => 'site-hero-background',
	];

    $controls[] = [
		'label'     => esc_html__( 'Background overlay color','analytica' ),
		'desc'      => esc_html__( 'The background color will be as an overlay.', 'analytica' ),
		'id'        => 'site-hero-background-overlay-color',
		'default'   => $default['site-hero-background-overlay-color'],
		'type'      => 'color',
		'transport' => 'auto',
		'section'   => 'site-hero-background',
		'output'    => [
            array(
                'element'  => '.site-hero-overlay-color',
                'property' => 'background-color',
            ),
        ],
	];

    $controls[] = [
		'label'   => esc_html__( 'Background image position','analytica' ),
		'desc'    => esc_html__( 'The background position sets the starting position of a background image.', 'analytica' ),
		'id'      => 'site-hero-background-position',
		'type'    => 'select',
		'default' => $default['site-hero-background-position'],
		'section' => 'site-hero-background',
		'options' => [
			''              => esc_html__( 'Default', 'analytica' ),
			'left top'      => esc_html__( 'left top', 'analytica' ),
			'left center'   => esc_html__( 'left center','analytica' ),
			'left bottom'   => esc_html__( 'left bottom','analytica' ),
			'right top'     => esc_html__( 'right top','analytica' ),
			'right center'  => esc_html__( 'right center','analytica' ),
			'right bottom'  => esc_html__( 'right bottom','analytica' ),
			'center top'    => esc_html__( 'center top','analytica' ),
			'center center' => esc_html__( 'center center','analytica' ),
			'center bottom' => esc_html__( 'center bottom','analytica' ),
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero-background',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
	];

    $controls[] = [
		'label'   => esc_html__( 'Background size','analytica' ),
		'desc'    => esc_html__( 'Adjust the background image displaying.', 'analytica' ),
		'id'      => 'site-hero-background-size',
		'type'    => 'radio-buttonset',
		'section' => 'site-hero-background',
		'default' => $default['site-hero-background-size'],
		'options' => [
		  	'initial' => esc_html__( 'Initial', 'analytica' ),
		  	'contain' => esc_html__( 'Contain', 'analytica' ),
		  	'cover'   => esc_html__( 'Cover', 'analytica' ),
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero-background',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
	];

    $controls[] = [
		'label'   => esc_html__( 'Background attachment style', 'analytica' ),
		'desc'    => esc_html__( 'When scroll background style is enabled, the background image scrolls with the content. When fixed background style is enabled, the background image is fixed and content scrolls over it. When initial background style is enabled, the background image and content will be fixed.', 'analytica' ),
		'id'      => 'site-hero-background-fixed',
		'default' => $default['site-hero-background-fixed'],
		'type'    => 'radio-buttonset',
		'section' => 'site-hero-background',
		'options' => [
			'initial' => esc_html__( 'Initial', 'analytica' ),
			'scroll'  => esc_html__( 'Scroll', 'analytica' ),
			'fixed'   => esc_html__( 'Fixed', 'analytica' ),
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero-background',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
	];

    $controls[] = [
		'label'   => esc_html__( 'Background repeat', 'analytica' ),
		'desc'    => esc_html__( 'Allows you to repeat or do not repeat the image set on the background.', 'analytica' ),
		'id'      => 'site-hero-background-repeat',
		'default' => $default['site-hero-background-repeat'],
		'type'    => 'radio-buttonset',
		'section' => 'site-hero-background',
		'options' => [
			'no-repeat' => esc_html__( 'No repeat', 'analytica' ),
			'repeat-x'  => esc_html__( 'Repeat-X', 'analytica' ),
			'repeat-y'  => esc_html__( 'Repeat-Y', 'analytica' ),
			'repeat'    => esc_html__( 'Repeat', 'analytica' ),
        ],
        'conditions' => [
            [
                'setting'  => 'site-hero-background',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Header Font', 'analytica' ),
        'desc'      => esc_html__( 'The page header for your site.', 'analytica' ),
        'id'        => 'site-hero-header-font',
        'section'   => 'site-hero-typography',
        'default'   => $default['site-hero-header-font'],
        'type'      => 'typography',
        'transport' => 'auto',
        'output'    => array(
            array(
                'element' => '.hero .hero-wrapper .header',
            ),
        ),
        'media_query' => '@media only screen and (min-width: 768px)',
    ];

    $controls[] = [
        'id'      => 'site-hero-header-padding',
        'type'    => 'spacing',
        'label'   => esc_html__( 'Heading padding', 'analytica' ),
        'section' => 'site-hero-typography',
        'default'   => $default['site-hero-header-padding'],
        'transport' => 'auto',
        'output'    => [
            [
                'property' => 'padding',
                'element'  => '.hero .hero-wrapper .header',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Sub header Font', 'analytica' ),
        'desc'      => esc_html__( 'The page subheader for your site.', 'analytica' ),
        'id'        => 'site-hero-subheader-font',
        'section'   => 'site-hero-typography',
        'default'   => $default['site-hero-subheader-font'],
        'type'      => 'typography',
        'transport' => 'auto',
        'media_query' => '@media only screen and (min-width: 768px)',
        'output'    => array(
            array(
                'element' => '.hero .hero-wrapper .subheader',
            ),
        ),
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
                'element'  => '.hero .hero-wrapper .subheader',
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
        'title'    => esc_html__( 'Page Hero', 'analytica' ),
    ] );

    $wp_customize->add_section( 'site-hero-settings', [
        'title'    => esc_html__( 'Settings', 'analytica' ),
        'panel'    => 'site-hero',
        'priority' => 22,
    ] );

    $wp_customize->add_section( 'site-hero-background', [
        'title'    => esc_html__( 'Background', 'analytica' ),
        'panel'    => 'site-hero',
        'priority' => 23,
    ] );

    $wp_customize->add_section( 'site-hero-typography', [
        'title'    => esc_html__( 'Typography', 'analytica' ),
        'panel'    => 'site-hero',
        'priority' => 24,
    ] );

    $wp_customize->add_section( 'site-hero-mobile', [
        'title'    => esc_html__( 'Mobile', 'analytica' ),
        'panel'    => 'site-hero',
        'priority' => 24,
    ] );
}

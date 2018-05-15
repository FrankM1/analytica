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

    $prefix  = 'hero_';

    $controls[] = [
		'label'   => esc_html__( 'Page Header', 'energia' ),
		'id'      => $prefix . 'enable',
		'type'    => 'radio-buttonset',
		'section' => 'hero-settings',
		'default' => $default[$prefix . 'enable'],
		'options' => [
			'on'  => esc_html__( 'Enable', 'energia' ),
			'off' => esc_html__( 'Disable', 'energia' ),
		],
	];

    $controls[] = [
        'id'      => 'show_hero_on_posts',
        'section' => 'single_post_settings',
        'type'    => 'switch',
        'label'   => esc_html__( 'Display page header section on posts', 'energia' ),
        'default' => $default['show_hero_on_posts'],
        'conditions' => [
            [
                'setting'  => 'single_post_style',
                'operator' => '!=',
                'value'    => 'single-post-overlay-wide',
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'show_hero_on_post_archives',
        'section' => 'archive_settings',
        'type'    => 'switch',
        'label'   => esc_html__( 'Display page header on post archives', 'energia' ),
        'default' => $default['show_hero_on_post_archives'],
    ];

    $controls[] = [
        'label'   => esc_html__( 'Full window height', 'energia' ),
        'desc'    => esc_html__( 'Sets full window height for custom header', 'energia' ),
        'id'      => $prefix . 'full_height',
        'type'    => 'radio-buttonset',
        'section' => 'hero-settings',
        'default' => 'off',
        'options' => [
            'on'  => esc_html__( 'On', 'energia' ),
            'off' => esc_html__( 'Off', 'energia' ),
        ],
    ];

    $controls[] = [
        'label'           => esc_html__( 'Custom header height in px', 'energia' ),
        'desc'            => esc_html__( 'Allows you to set the custom header height', 'energia' ),
        'id'              => $prefix . 'custom_height',
        'type'            => 'text',
        'default'         => $default[$prefix . 'custom_height'],
        'section'         => 'hero-settings',
        'conditions' => [
            [
                'setting'  => $prefix . 'full_height',
                'operator' => '==',
                'value'    => 'off',
            ],
        ],
    ];

    $controls[] = [
		'label'   => esc_html__( 'Background color scheme style', 'energia' ),
		'desc'    => esc_html__( 'According to the color scheme you choose the text colors will be changed to make it more readable.', 'energia' ),
        'id'      => $prefix . 'bg_color_base',
        'default' => $default[$prefix . 'bg_color_base'],
		'type'    => 'radio-buttonset',
		'section' => 'hero-settings',
		'options' => [
            'background-dark'  => esc_html__( 'Light', 'energia' ),
            'background-light' => esc_html__( 'Dark', 'energia' ),
		],
	];

    $controls[] = [
        'label'   => esc_html__( 'Text alignment','energia' ),
        'desc'    => esc_html__( 'Choose the text alignment in the custom header.', 'energia' ),
        'id'      => $prefix . 'text_alignment',
        'type'    => 'radio-buttonset',
        'section' => 'hero-settings',
        'transport' => 'auto',
        'default' => $default[$prefix . 'text_alignment'],
        'options' => [
            'text-left'   => esc_html__( 'Left', 'energia' ),
            'text-center' => esc_html__( 'Center', 'energia' ),
            'text-right'  => esc_html__( 'Right', 'energia' ),
        ],
    ];

    $controls[] = [
		'label'   => esc_html__( 'Enable background image', 'energia' ),
		'id'      => $prefix . 'bg_img_enable',
		'type'    => 'radio-buttonset',
		'section' => 'hero-background',
		'default' => $default[$prefix . 'bg_img_enable'],
		'options' => [
			'on'  => esc_html__( 'Enable', 'energia' ),
			'off' => esc_html__( 'Disable', 'energia' ),
		],
	];

    $controls[] = [
		'label'     => esc_html__( 'Background image','energia' ),
		'desc'      => esc_html__( 'Select image for custom header background', 'energia' ),
		'id'        => $prefix . 'bg_img',
		'default'   => $default[$prefix . 'bg_img'],
		'type'      => 'image',
		'transport' => 'auto',
        'section'   => 'hero-background',
        'conditions' => [
            [
                'setting'  => $prefix . 'bg_img_enable',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
    ];

    $controls[] = [
        'id'      => $prefix . 'bg_img_inherit',
        'section' => 'hero-background',
        'type'    => 'switch',
        'label'   => esc_html__( 'Inherit featured images', 'energia' ),
        'desc'    => esc_html__( 'Allows the page header to use the post\'s featured images as a background when available. This will override the image above.', 'energia' ),
        'default' => $default[$prefix . 'bg_img_inherit'],
    ];

    $controls[] = [
        'label'   => esc_html__( 'Custom header parallax effect','energia' ),
        'id'      => $prefix . 'parallax',
        'type'    => 'radio-buttonset',
        'section' => 'hero-settings',
        'default' => 'on',
        'options' => [
            'on'  => esc_html__( 'On', 'energia' ),
            'off' => esc_html__( 'Off', 'energia' ),
        ],
        'conditions' => [
            [
                'setting'  => $prefix . 'bg_img_enable',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
    ];

    $controls[] = [
		'label'     => esc_html__( 'Background color','energia' ),
		'desc'      => esc_html__( 'The background color will be shown if the image is not set for the custom header.', 'energia' ),
		'id'        => $prefix . 'bg_color',
		'default'   => $default[$prefix . 'bg_color'],
		'type'      => 'color',
		'transport' => 'auto',
		'section'   => 'hero-background',
	];

    $controls[] = [
		'label'     => esc_html__( 'Background overlay color','energia' ),
		'desc'      => esc_html__( 'The background color will be as an overlay.', 'energia' ),
		'id'        => $prefix . 'bg_overlay_color',
		'default'   => $default[$prefix . 'bg_overlay_color'],
		'type'      => 'color',
		'transport' => 'auto',
		'section'   => 'hero-background',
		'output'    => [
            array(
                'element'  => '.hero-overlay-color',
                'property' => 'background-color',
            ),
        ],
	];

    $controls[] = [
		'label'   => esc_html__( 'Background image position','energia' ),
		'desc'    => esc_html__( 'The background position sets the starting position of a background image.', 'energia' ),
		'id'      => $prefix . 'bg_img_position',
		'type'    => 'select',
		'default' => $default[$prefix . 'bg_img_position'],
		'section' => 'hero-background',
		'options' => [
			''              => esc_html__( 'Default', 'energia' ),
			'left top'      => esc_html__( 'left top', 'energia' ),
			'left center'   => esc_html__( 'left center','energia' ),
			'left bottom'   => esc_html__( 'left bottom','energia' ),
			'right top'     => esc_html__( 'right top','energia' ),
			'right center'  => esc_html__( 'right center','energia' ),
			'right bottom'  => esc_html__( 'right bottom','energia' ),
			'center top'    => esc_html__( 'center top','energia' ),
			'center center' => esc_html__( 'center center','energia' ),
			'center bottom' => esc_html__( 'center bottom','energia' ),
        ],
        'conditions' => [
            [
                'setting'  => $prefix . 'bg_img_enable',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
	];

    $controls[] = [
		'label'   => esc_html__( 'Background size','energia' ),
		'desc'    => esc_html__( 'Adjust the background image displaying.', 'energia' ),
		'id'      => $prefix . 'background_size',
		'type'    => 'radio-buttonset',
		'section' => 'hero-background',
		'default' => $default[$prefix . 'background_size'],
		'options' => [
		  	'initial' => esc_html__( 'Initial', 'energia' ),
		  	'contain' => esc_html__( 'Contain', 'energia' ),
		  	'cover'   => esc_html__( 'Cover', 'energia' ),
        ],
        'conditions' => [
            [
                'setting'  => $prefix . 'bg_img_enable',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
	];

    $controls[] = [
		'label'   => esc_html__( 'Background attachment style', 'energia' ),
		'desc'    => esc_html__( 'When scroll background style is enabled, the background image scrolls with the content. When fixed background style is enabled, the background image is fixed and content scrolls over it. When initial background style is enabled, the background image and content will be fixed.', 'energia' ),
		'id'      => $prefix . 'bg_fixed',
		'default' => $default[$prefix . 'bg_fixed'],
		'type'    => 'radio-buttonset',
		'section' => 'hero-background',
		'options' => [
			'initial' => esc_html__( 'Initial', 'energia' ),
			'scroll'  => esc_html__( 'Scroll', 'energia' ),
			'fixed'   => esc_html__( 'Fixed', 'energia' ),
        ],
        'conditions' => [
            [
                'setting'  => $prefix . 'bg_img_enable',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
	];

    $controls[] = [
		'label'   => esc_html__( 'Background repeat', 'energia' ),
		'desc'    => esc_html__( 'Allows you to repeat or do not repeat the image set on the background.', 'energia' ),
		'id'      => $prefix . 'bg_repeat',
		'default' => $default[$prefix . 'bg_repeat'],
		'type'    => 'radio-buttonset',
		'section' => 'hero-background',
		'options' => [
			'no-repeat' => esc_html__( 'No repeat', 'energia' ),
			'repeat-x'  => esc_html__( 'Repeat-X', 'energia' ),
			'repeat-y'  => esc_html__( 'Repeat-Y', 'energia' ),
			'repeat'    => esc_html__( 'Repeat', 'energia' ),
        ],
        'conditions' => [
            [
                'setting'  => $prefix . 'bg_img_enable',
                'operator' => '==',
                'value'    => 'on',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Header Font', 'energia' ),
        'desc'      => esc_html__( 'The page header for your site.', 'energia' ),
        'id'        => $prefix . 'font',
        'section'   => 'hero-typography',
        'default'   => $default[$prefix . 'font_h1'],
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
        'id'      => $prefix . 'header-padding',
        'type'    => 'spacing',
        'label'   => esc_html__( 'Heading padding', 'energia' ),
        'section' => 'hero-typography',
        'default' => [
            'top'    => '',
            'bottom' => '',
            'left'   => '',
            'right'  => '',
        ],
        'transport' => 'auto',
        'output'    => [
            [
                'property' => 'padding',
                'element'  => '.hero .hero-wrapper .header',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Sub header Font', 'energia' ),
        'desc'      => esc_html__( 'The page subheader for your site.', 'energia' ),
        'id'        => $prefix . 'subheader_font',
        'section'   => 'hero-typography',
        'default'   => $default[$prefix . 'font_h3'],
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
        'id'      => $prefix . 'subheader-padding',
        'type'    => 'spacing',
        'label'   => esc_html__( 'Sub heading padding', 'energia' ),
        'section' => 'hero-typography',
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
    $wp_customize->add_panel( 'hero', [
        'priority' => 21,
        'title'    => esc_html__( 'Page Hero', 'energia' ),
    ] );

    $wp_customize->add_section( 'hero-settings', [
        'title'    => esc_html__( 'Settings', 'energia' ),
        'panel'    => 'hero',
        'priority' => 22,
    ] );

    $wp_customize->add_section( 'hero-background', [
        'title'    => esc_html__( 'Background', 'energia' ),
        'panel'    => 'hero',
        'priority' => 23,
    ] );

    $wp_customize->add_section( 'hero-typography', [
        'title'    => esc_html__( 'Typography', 'energia' ),
        'panel'    => 'hero',
        'priority' => 24,
    ] );

    $wp_customize->add_section( 'hero-mobile', [
        'title'    => esc_html__( 'Mobile', 'energia' ),
        'panel'    => 'hero',
        'priority' => 24,
    ] );
}

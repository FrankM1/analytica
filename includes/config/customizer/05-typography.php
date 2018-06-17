<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https: //radiumthemes.com/
 */

add_filter( 'analytica_customizer_controls', 'analytica_add_typography_controls' );
/**
 * [analytica_add_typography_controls description]
 * @param [type] $controls [description]
 */
function analytica_add_typography_controls( $controls ) {
    
    $base = analytica_get_option( 'font-base' );
    $secondary = analytica_get_option( 'font-secondary-base' );
    
    $default    = Analytica\Options::defaults();

    $controls[] = [
        'label'     => esc_html__( 'Base Font', 'analytica' ),
        'desc'      => esc_html__( 'The main font for your site. This is used by paragraphs, divs, etc', 'analytica' ),
        'id'        => 'font-base',
        'section'   => 'general_typography',
        'default'   => $default['font-base'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'variant',
            'font-size',
            'line-height',
            'letter-spacing',
            'text-align',
            'text-transform',
        ],
        'output'    => [
    		[
                'element' => 'body, p, button, input, select, textarea',
    		],
    	],
    ];


    $controls[] = [
        'label'     => esc_html__( 'Secondary Font', 'analytica' ),
        'desc'      => esc_html__( 'The secondary font for your site. This is used by headings, and large text.', 'analytica' ),
        'id'        => 'font-secondary-base',
        'section'   => 'general_typography',
        'default'   => $default['font-secondary-base'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'variant',
            'font-size',
            'line-height',
            'letter-spacing',
            'text-align',
            'text-transform',
        ],
        'output'    => [
            [
                'element' => 'h1, .entry-content h1, h2, .entry-content h2, h3, .entry-content h3, h4, .entry-content h4, h5, .entry-content h5, h6, .entry-content h6',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'H1 Font', 'analytica' ),
        'id'        => 'font-h1',
        'section'   => 'general_typography',
        'default'   => $default['font-h1'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'font-family',
        ],
        'output'    => [
            [
                'element' => 'h1, .h1',
            ],
        ],
   ];

    $controls[] = [
        'id'        => 'font-h2',
        'section'   => 'general_typography',
        'label'     => esc_html__( 'H2 Font', 'analytica' ),
        'default'   => $default['font-h2'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'font-family',
        ],
        'output'    => [
            [
                'element' => 'h2, .h2',
            ],
        ],
    ];

    $controls[] = [
        'id'        => 'font-h3',
        'section'   => 'general_typography',
        'label'     => esc_html__( 'H3 Font', 'analytica' ),
        'default'   => $default['font-h3'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'font-family',
        ],
        'output'    => [
            [
                'element' => 'h3, .h3',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'H4 Font', 'analytica' ),
        'id'        => 'font-h4',
        'section'   => 'general_typography',
        'default'   => $default['font-h4'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'font-family',
        ],
        'output'    => [
            [
                'element' => 'h4, .h4',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'H5 Font', 'analytica' ),
        'id'        => 'font-h5',
        'section'   => 'general_typography',
        'default'   => $default['font-h5'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'font-family',
        ],
        'output'    => [
            [
                'element' => 'h5, .h5',
            ],
        ],
    ];

    $controls[] = [
        'label'   => esc_html__( 'H6 Font', 'analytica' ),
        'id'      => 'font-h6',
        'section' => 'general_typography',
        'default' => $default['font-h6'],
        'type'    => 'typography',
        'exclude'   => [
            'font-family',
        ],
        'output'  => [
            [
                'element' => 'h6, .h6',
            ],
        ],
        'transport' => 'auto',
    ];

    $controls[] = [
        'label'     => esc_html__( 'Widget Title Font', 'analytica' ),
        'id'        => 'font-widget-title',
        'section'   => 'general_typography',
        'default'   => $default['font-widget-title'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'font-family',
        ],
        'output'    => [
            [
                'element' => '.widget-title',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Emphasis', 'analytica' ),
        'desc'      => esc_html__( 'The emphasis font for your site.', 'analytica' ),
        'id'        => 'font-em',
        'section'   => 'general_typography',
        'default'   => $default['font-em'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'font-size',
            'line-height',
            'letter-spacing',
            'text-align',
            'text-transform',
        ],
        'output'    => [
            [
                'element' => 'body i, body em, body .em, body b.em, body blockquote, body blockquote p',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Strong', 'analytica' ),
        'desc'      => esc_html__( 'The strong font for your site.', 'analytica' ),
        'id'        => 'font-strong',
        'section'   => 'general_typography',
        'default'   => $default['font-strong'],
        'type'      => 'typography',
        'transport' => 'auto',
        'exclude'   => [
            'font-size',
            'line-height',
            'letter-spacing',
            'text-align',
            'text-transform',
        ],
        'output'    => [
            [
                'element' => 'body strong, body b, body strong, body blockquote strong',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Form Labels', 'analytica' ),
        'desc'      => esc_html__( 'The font for form labels.', 'analytica' ),
        'id'        => 'font-form-labels',
        'default'   => $default['font-form-labels'],
        'type'      => 'typography',
        'section'   => 'forms_typography',
        'transport' => 'auto',
        'output'    => [
            [
                'element' => 'label',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Form Legend', 'analytica' ),
        'desc'      => esc_html__( 'The font for form legend.', 'analytica' ),
        'id'        => 'font-form-legend',
        'default'   => $default['font-form-legend'],
        'type'      => 'typography',
        'section'   => 'forms_typography',
        'transport' => 'auto',
        'output'    => [
            [
                'element' => 'label',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Site credits typography', 'analytica' ),
        'desc'      => esc_html__( 'Typography applied to the footer copyright section of the site.', 'analytica' ),
        'id'        => 'site-credit-typography',
        'default'   => $default['site-credit-typography'],
        'type'      => 'typography',
        'section'   => 'site_footer_typography',
        'transport' => 'auto',
        'output'    => [
            [
                'element' => '.site-creds',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Blog heading', 'analytica' ),
        'desc'      => esc_html__( 'Typography applied to the blog headings.', 'analytica' ),
        'id'        => 'archive-heading-typography',
        'default'   => $default['archive-heading-typography'],
        'type'      => 'typography',
        'section'   => 'site_blog_typography',
        'transport' => 'auto',
        'output'    => [
            [
                'element' => '.blog .entry-title, .archive .entry-title, .search .entry-title, .blog .entry-title a, .archive .entry-title a, .search .entry-title a',
            ],
        ],
    ];

    return $controls;
}

add_action( 'customize_register', 'analytica_add_typography_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_typography_panels_and_sections( $wp_customize ) {
    $wp_customize->add_panel( 'typography', [
        'priority' => 33,
        'title' => esc_html__( 'Typography', 'analytica' ),
    ] );

    $wp_customize->add_section( 'general_typography', [
        'title' => esc_html__( 'General', 'analytica' ),
        'panel' => 'typography',
        'priority' => 34,
    ] );

    $wp_customize->add_section( 'forms_typography', [
        'title' => esc_html__( 'Forms', 'analytica' ),
        'panel' => 'typography',
        'priority' => 35,
    ] );

    $wp_customize->add_section( 'site_blog_typography', [
        'title' => esc_html__( 'Blog', 'analytica' ),
        'panel' => 'typography',
        'priority' => 36,
    ] );

    $wp_customize->add_section( 'site_footer_typography', [
        'title' => esc_html__( 'Footer', 'analytica' ),
        'panel' => 'typography',
        'priority' => 37,
    ] );
}

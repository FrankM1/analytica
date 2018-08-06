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

add_filter( 'analytica_customizer_controls', 'analytica_get_customizer_breadcrumbs' );
 /**
  * Register Breadcrumbs options
  *
  * @since 1.0.0
  *
  * @return array
  */
 function analytica_get_customizer_breadcrumbs( $controls ) {
    
    $default = Analytica\Options::defaults();

    $controls[] = [
        'label'     => esc_html__( 'Link Color', 'analytica' ),
        'id'        => 'site-breadcrumb-color',
        'type'      => 'color',
        'default'   => $default['site-breadcrumb-color'],
        'section'   => 'breadcrumb',
        'transport' => 'auto',
        'output'    => [
            [
                'element'  => '.breadcrumb',
                'property' => 'color',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Active Link Color', 'analytica' ),
        'id'        => 'site-breadcrumb-active-color',
        'type'      => 'color',
        'default'   => $default['site-breadcrumb-active-color'],
        'section'   => 'breadcrumb',
        'transport' => 'auto',
        'output'    => [
            [
                'element'  => '.breadcrumb a',
                'property' => 'color',
            ],
        ],
    ];

    $controls[] = [
        'label'     => esc_html__( 'Background Color', 'analytica' ),
        'id'        => 'site-breadcrumb-background-color',
        'type'      => 'color',
        'default'   => $default['site-breadcrumb-background-color'],
        'section'   => 'breadcrumb',
        'transport' => 'auto',
        'output'    => [
            [
                'element'  => '.breadcrumb',
                'property' => 'background-color',
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'breadcrumb_prefix',
        'section' => 'breadcrumb',
        'type'    => 'text',
        'label'   => esc_html__( 'Breadcrumb Prefix' , 'analytica' ),
        'default' => esc_html__( 'You Are Here:', 'analytica' ),
    ];

    $controls[] = [
        'id'      => 'breadcrumb_home_label',
        'section' => 'breadcrumb',
        'type'    => 'text',
        'label'   => esc_html__( 'Breadcrumb Home Title' , 'analytica' ),
        'default' => esc_html__( 'Home', 'analytica' ),
    ];

    $controls[] = [
        'id'      => 'breadcrumb_sep',
        'section' => 'breadcrumb',
        'type'    => 'text',
        'label'   => esc_html__( 'Breadcrumb Seperator' , 'analytica' ),
        'default' => ' / ',
    ];

    $controls[] = [
        'id'      => 'breadcrumb_home',
        'section' => 'breadcrumb',
        'type'    => 'switch',
        'label'   => esc_html__( 'Homepage' , 'analytica' ),
        'default' => true,
        'desc'    => esc_html__( 'The homepage for the \'Blog\' section' , 'analytica' ),
    ];

    $controls[] = [
        'id'      => 'breadcrumb_front_page',
        'section' => 'breadcrumb',
        'type'    => 'switch',
        'label'   => esc_html__( 'Front Page' , 'analytica' ),
        'default' => true,
        'desc'    => esc_html__( 'The frontpage is be the page set in Settings -> Reading' , 'analytica' ),
    ];

    $controls[] = [
        'id'      => 'breadcrumb_posts_page',
        'section' => 'breadcrumb',
        'type'    => 'switch',
        'label'   => esc_html__( 'Posts Page' , 'analytica' ),
        'default' => true,
    ];

    $controls[] = [
        'id'              => 'breadcrumb_single',
        'section'         => 'breadcrumb',
        'type'            => 'switch',
        'label'           => esc_html__( 'Single' , 'analytica' ),
        'default'         => true,
        'conditions' => [
            [
                'setting'  => 'show_page_header_on_posts',
                'operator' => '==',
                'value'    => true,
            ],
        ],
    ];

    $controls[] = [
        'id'      => 'breadcrumb_page',
        'section' => 'breadcrumb',
        'type'    => 'switch',
        'label'   => esc_html__( 'Page' , 'analytica' ),
        'default' => true,
    ];

    $controls[] = [
        'id'      => 'breadcrumb_archive',
        'section' => 'breadcrumb',
        'type'    => 'switch',
        'label'   => esc_html__( 'Archive' , 'analytica' ),
        'default' => true,
    ];

    $controls[] = [
        'id'      => 'breadcrumb_404',
        'section' => 'breadcrumb',
        'type'    => 'switch',
        'label'   => esc_html__( '404' , 'analytica' ),
        'default' => true,
    ];

    $controls[] = [
        'id'      => 'breadcrumb_attachment',
        'section' => 'breadcrumb',
        'type'    => 'switch',
        'label'   => esc_html__( 'Attachment/Media', 'analytica' ),
        'default' => true,
    ];

    $controls[] = [
        'id'      => 'breadcrumb-padding',
        'type'    => 'spacing',
        'label'   => esc_html__( 'Breadcrumb Padding', 'analytica' ),
        'section' => 'breadcrumb',
        'default' => [
            'top'    => '',
            'bottom' => '',
            'left'   => '',
            'right'  => '',
        ],
        'transport' => 'auto',
        'output'    => [
            [
                'property'    => 'padding',
                'element'     => '.site-hero .site-hero-wrapper .breadcrumb',
            ],
        ],
    ];

    return $controls;
}

add_action( 'customize_register', 'analytica_add_breadcrumb_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_breadcrumb_panels_and_sections( $wp_customize ) {
    $wp_customize->add_section( 'breadcrumb', [
        'priority' => 40,
        'panel'    => 'general',
        'title'    => esc_html__( 'Breadcrumb', 'analytica' ),
    ] );
}

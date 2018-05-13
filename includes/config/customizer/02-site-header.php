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

    // Get all headers.
    $list_header = new WP_Query( [
        'posts_per_page'   => -1, // WPCS: Disabling pagination ok.
        'post_type'        => 'header_composer',
        'post_status'      => 'publish',
        'suppress_filters' => true,
        'orderby'          => 'title',
        'order'            => 'ASC',
    ]);

    $header_composer = [];

    // Set to normal headers default
    if ( $list_header->post_count ) {
        foreach ( $list_header->posts as $val ) {
            $header_composer[ $val->ID ] = $val->post_title;
        }
    };

    $controls[] = [
        'id'      => 'header',
        'section' => 'header_composer',
        'type'    => 'switch',
        'label'   => esc_html__( 'Enable Header' , 'analytica' ),
        'default' => '1',
        'options' => [
            '1' => esc_attr__( 'Enable', 'analytica' ),
            '0' => esc_attr__( 'Disable', 'analytica' ),
        ]
    ];

    if ( ! empty( $header_composer ) && function_exists( 'header_composer' ) ) {
        $controls[] = [
            'type'            => 'select',
            'label'           => esc_html__( 'Select Header', 'analytica' ),
            'id'              => 'header_composer',
            'section'         => 'header_composer',
            'default'         => '',
            'description'     => sprintf( __( 'This theme allows you to build an unlimited amount of unique header styles. The "magic" happens via the section <b><a target="_blank" href="%1$s">Manage Headers</a></b>.', 'analytica' ), esc_url( admin_url( 'edit.php?post_type=header_composer' ) ) ) . '<a class="link-doc-header" target="_blank" href="http://docs.radiumthemes.com/docs/document/footer"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
            'options'         => $header_composer,
            'conditions' => [
                [
                    'setting'  => 'header',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ];

    } else {

        $controls[] = [
            'id'              => 'no_header_found',
            'title'           => esc_html__( 'Custom Built Header', 'analytica' ),
            'section'         => 'header_composer',
            'type'            => 'custom',
            'default'         => sprintf( __( 'No header was found on your site. Create a custom header <a target="_blank" href="%1$s">here</a>.', 'analytica' ), esc_url( admin_url( 'edit.php?post_type=header_composer' ) ) ),
            'conditions' => [
                [
                    'setting'  => 'header',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ];

        $controls[] = [
            'id'              => 'site-header-background-color',
            'section'         => 'header_composer',
            'type'            => 'color',
            'title'           => esc_html__( 'Site container background color' , 'analytica' ),
            'default'         => '#fff',
            'conditions' => [
                [
                    'setting'  => 'header',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ];

        $controls[] = [
            'id'      => 'header-overlay',
            'section' => 'header_composer',
            'type'    => 'switch',
            'label'   => esc_html__( 'Header Overlay' , 'analytica' ),
            'default' => '1',
            'options' => [
                '1' => esc_attr__( 'Enable', 'analytica' ),
                '0' => esc_attr__( 'Disable', 'analytica' ),
            ],
        ];
 
        $controls[] = [
            'id'      => 'header-sticky',
            'section' => 'header_composer',
            'type'    => 'switch',
            'label'   => esc_html__( 'Header Sticky' , 'analytica' ),
            'default' => '1',
            'options' => [
                '1' => esc_attr__( 'Enable', 'analytica' ),
                '0' => esc_attr__( 'Disable', 'analytica' ),
            ],
        ];

        $controls[] = [
            'id'      => 'header-transparent',
            'section' => 'header_composer',
            'type'    => 'switch',
            'label'   => esc_html__( 'Header Transparent' , 'analytica' ),
            'default' => '1',
            'options' => [
                '1' => esc_attr__( 'Enable', 'analytica' ),
                '0' => esc_attr__( 'Disable', 'analytica' ),
            ],
        ];
    }

    return $controls;
}

add_action( 'customize_register', 'analytica_add_header_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_header_panels_and_sections( $wp_customize ) {
    $wp_customize->add_section( 'header_composer', [
        'title'    => esc_html__( 'Site Header', 'analytica' ),
        'priority' => 19,
    ] );
}

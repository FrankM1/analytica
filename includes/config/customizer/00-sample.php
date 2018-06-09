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
 
/**
 * Array of Font Awesome Icons for the scroll up button
 *
 * @since 1.0.0
 */
function analytica_get_awesome_icons( $return = 'up_arrows', $default = 'none' ) {

    // Add none to top of array
    $icons_array = array(
        'none' =>''
    );

    // Define return icons
    $return_icons = array();

    // Returns up arrows only
    if ( 'up_arrows' == $return ) {
        $return_icons = array('fa fa-chevron-up','fa fa-caret-up','fa fa-angle-up','fa fa-angle-double-up','fa fa-long-arrow-up','fa fa-arrow-circle-o-up','fa fa-arrow-up','fa fa-level-up','fa fa-toggle-up');
        $return_icons = array_combine( $return_icons, $return_icons );
    }
    
    return apply_filters( __FUNCTION__, array_merge( $icons_array, $return_icons ) );
    
}

add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_sample_control' );
/**
 * [analytica_theme_defaults description]
 */
function analytica_admin_add_customizer_sample_control( array $controls ) {

    $default = Analytica\Options::defaults();

    $controls[] = [
        'id'      => 'site-content-color',
        'section' => 'sample-sample',
        'label'   => esc_html__( 'Site container color', 'analytica' ),
        'type'    => 'color',
        'choices'     => array(
            'alpha' => true,
        ),
     ];

     $controls[] = [
        'id' 		=> 'site-content-dimensions',
        'section' => 'sample-sample',
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
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 500,
            'step'  => 1,
        ),
     ];

     $controls[] = [
        'id'      => 'site-content-icon',
        'section' => 'sample-sample',
        'label'   => esc_html__( 'Site container icon', 'analytica' ),
        'type'    => 'icon',
        'choices' => analytica_get_awesome_icons( 'up_arrows' ),
     ];

    return $controls;
}

add_action( 'customize_register', 'analytica_add_sample_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_sample_panels_and_sections( $wp_customize ) {
    $wp_customize->add_panel( 'sample', [
        'priority' => 9,
        'title'    => esc_html__( 'General', 'analytica' ),
    ]);

    $wp_customize->add_section( 'sample-sample', [
        'title'    => esc_html__( 'General Settings', 'analytica' ),
        'panel'    => 'sample',
        'priority' => 10,
    ]);

    $wp_customize->add_section( 'container-style', [
        'title'    => esc_html__( 'Container Style', 'analytica' ),
        'panel'    => 'sample',
        'priority' => 11,
    ]);

    $wp_customize->add_section( 'logo-favicon', [
        'title'    => esc_html__( 'Logo & Favicon', 'analytica' ),
        'priority' => 14,
    ]);

}
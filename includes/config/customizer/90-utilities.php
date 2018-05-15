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

 add_filter( 'analytica_customizer_controls', 'analytica_get_customizer_utilities', 99 );
 /**
  * Register utility settings
  *
  * @since 1.0.0
  *
  * @return array
  */
 function analytica_get_customizer_utilities( $controls ) {

     $new_controls = [
        [
            'id'      => 'css-print-method',
            'section' => 'utilities',
            'type'    => 'radio-buttonset',
            'title'   => esc_html__( 'CSS Print Method' , 'energia' ),
            'default' => 'external',
            'options' => [
                'external' => esc_html__( 'External File', 'energia' ),
                'internal' => esc_html__( 'Internal Embedding', 'energia' ),
            ],
        ],

        [
            'id' => 'settings-update-time',
            'title'   => 'Time',
            'type' => 'hidden',
            'sanitize_callback' => 'time',
        ],
    ];

     return array_merge( $controls, $new_controls );
 }

add_action( 'customize_register', 'analytica_add_utilities_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_utilities_panels_and_sections( $wp_customize ) {
    $wp_customize->add_section( 'utilities', [
        'title'    => esc_html__( 'Theme Utilities', 'energia' ),
        'priority' => 90,
    ] );
}

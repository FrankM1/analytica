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

add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_blog_single_controls' );
/**
 * [analytica_admin_add_customizer_control description]
 */
function analytica_admin_add_customizer_blog_single_controls( $controls) {

    $new_controls = [

        [
            'id'      => 'single-post-structure',
            'section' => 'single_post_settings',
            'label'   => esc_html__( 'Single post structure', 'analytica' ),
            'type'    => 'sortable',
            'options'  => array(
                'single-image'      => __( 'Featured Image', 'analytica' ),
                'single-title-meta' => __( 'Title & Single Meta', 'analytica' ),
            ),
        ],

        [
            'id'      => 'single-post-meta',
            'section' => 'single_post_settings',
            'label'   => esc_html__( 'Single meta', 'analytica' ),
            'type'    => 'sortable',
            'options'  => array(
                'comments' => __( 'Comments', 'analytica' ),
                'category' => __( 'Category', 'analytica' ),
                'author'   => __( 'Author', 'analytica' ),
                'date'     => __( 'Publish Date', 'analytica' ),
                'tag'      => __( 'Tag', 'analytica' ),
            ),
        ],

        [
            'id'      => 'single-has-post-thumbnail',
            'section' => 'single_post_settings',
            'type'    => 'switch',
            'label'   => esc_html__( 'Enable Featured Image' , 'analytica' ),
            'options' => [
                1 => esc_attr__( 'Enable', 'analytica' ),
                0 => esc_attr__( 'Disable', 'analytica' ),
            ],
        ],
    ];

    $controls = array_merge( $controls, $new_controls );

    return $controls;
}

add_action( 'customize_register', 'analytica_add_blog_single_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_blog_single_panels_and_sections( $wp_customize ) {

    $wp_customize->add_panel( 'blog-single', array(
        'priority' => 39,
        'title'    => esc_html__( 'Single Layout', 'analytica' ),
    ));

    $wp_customize->add_section( 'single_post_settings', array(
        'title'    => esc_html__( 'Single Post', 'analytica' ),
        'panel'    => 'blog',
        'priority' => 40,
    ));

}

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

add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_blog_controls' );
/**
 * [analytica_admin_add_customizer_control description]
 */
function analytica_admin_add_customizer_blog_controls( $controls) {

    $default = Analytica\Options::defaults();

    $new_controls = [

        [
            'id'      => 'blog-post-structure',
            'section' => 'archive_settings',
            'label'   => esc_html__( 'Blog post structure', 'energia' ),
            'type'    => 'multicheck',
            'default' => $default['blog-post-structure'],
            'options'  => array(
                'image'      => __( 'Featured Image', 'astra' ),
                'title-meta' => __( 'Title & Blog Meta', 'astra' ),
            ),
        ],

        [
            'id'      => 'blog-post-content',
            'section' => 'archive_settings',
            'label'   => esc_html__( 'Blog post content', 'energia' ),
            'type'    => 'select',
            'default' => $default['blog-post-content'],
            'options'  => array(
                'full-content' => __( 'Full Content', 'astra' ),
                'excerpt'      => __( 'Excerpt', 'astra' ),
            ),
        ],

        [
            'id'      => 'blog-meta',
            'section' => 'archive_settings',
            'label'   => esc_html__( 'Blog meta', 'energia' ),
            'type'    => 'multicheck',
            'default' => $default['blog-meta'],
            'options'  => array(
                'comments' => __( 'Comments', 'astra' ),
                'category' => __( 'Category', 'astra' ),
                'author'   => __( 'Author', 'astra' ),
                'date'     => __( 'Publish Date', 'astra' ),
                'tag'      => __( 'Tag', 'astra' ),
            ),
        ],

        [
            'id'      => 'blog-width',
            'section' => 'archive_settings',
            'label'   => esc_html__( 'Blog content width', 'energia' ),
            'type'    => 'select',
            'default' => $default['blog-meta'],
            'options'  => array(
                'default' => __( 'Default', 'astra' ),
                'custom'  => __( 'Custom', 'astra' ),
            ),
        ],

        [
            'id'      => 'blog-max-width',
            'section' => 'archive_settings',
            'label'   => esc_html__( 'Enter Width', 'energia' ),
            'type'    => 'slider',
            'default' => $default['blog-max-width'],
            'suffix'      => '',
            'input_attrs' => array(
                'min'  => 768,
                'step' => 1,
                'max'  => 1920,
            ),
            'conditions' => [
                [
                    'setting'  => 'blog-width',
                    'operator' => '==',
                    'value'    => 'custom',
                ],
            ],
        ],

    ];

    $controls = array_merge( $controls, $new_controls );

    return $controls;
}

add_action( 'customize_register', 'analytica_add_blog_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_blog_panels_and_sections( $wp_customize ) {

    $wp_customize->add_panel( 'blog', array(
        'priority' => 39,
        'title'    => esc_html__( 'Blog Layout', 'energia' ),
    ));

    $wp_customize->add_section( 'archive_settings', array(
        'title'    => esc_html__( 'Post Archive', 'energia' ),
        'panel'    => 'blog',
        'priority' => 40,
    ));

    $wp_customize->add_section( 'single_post_settings', array(
        'title'    => esc_html__( 'Single post settings', 'energia' ),
        'panel'    => 'blog',
        'priority' => 41,
    ));

}

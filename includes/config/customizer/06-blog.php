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
            'id'      => 'archive-content-structure',
            'section' => 'archive_settings',
            'label'   => esc_html__( 'Blog post structure', 'analytica' ),
            'type'    => 'sortable',
            'default' => $default['archive-content-structure'],
            'options'  => array(
                'image'      => __( 'Featured Image', 'analytica' ),
                'title-meta' => __( 'Title & Blog Meta', 'analytica' ),
            ),
        ],

        [
            'id'      => 'archive-post-content',
            'section' => 'archive_settings',
            'label'   => esc_html__( 'Blog post content', 'analytica' ),
            'type'    => 'select',
            'default' => $default['archive-post-content'],
            'options'  => array(
                'full-content' => __( 'Full Content', 'analytica' ),
                'excerpt'      => __( 'Excerpt', 'analytica' ),
            ),
        ],

        [
            'id'      => 'archive-post-meta',
            'section' => 'archive_settings',
            'label'   => esc_html__( 'Blog meta', 'analytica' ),
            'type'    => 'sortable',
            'default' => $default['archive-post-meta'],
            'options'  => array(
                'comments' => __( 'Comments', 'analytica' ),
                'category' => __( 'Category', 'analytica' ),
                'author'   => __( 'Author', 'analytica' ),
                'date'     => __( 'Publish Date', 'analytica' ),
                'tag'      => __( 'Tag', 'analytica' ),
            ),
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
        'title'    => esc_html__( 'Blog Layout', 'analytica' ),
    ));

    $wp_customize->add_section( 'archive_settings', array(
        'title'    => esc_html__( 'Post Archive', 'analytica' ),
        'panel'    => 'blog',
        'priority' => 40,
    ));

    $wp_customize->add_section( 'single_post_settings', array(
        'title'    => esc_html__( 'Single post settings', 'analytica' ),
        'panel'    => 'blog',
        'priority' => 41,
    ));

}

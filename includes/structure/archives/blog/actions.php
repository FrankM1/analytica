<?php
/**
 * Radium Framework Core - A WordPress theme development framework.
 *
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file.
 * Modifying the contents of this file can be a poor life decision if you don't know what you're doing.
 *
 * NOTE: Theme data (options, global variables etc ) can be accessed anywhere in the theme by calling  <?php $framework = radium_framework(); ?>
 *
 * @category Radium\Framework
 * @package  Energia WP
 * @author   Franklin Gitonga
 * @link     https://radiumthemes.com/
 */

add_filter( 'excerpt_more', 'analytica_post_link', 1 );
/**
 * Function to get Read More Link of Post
 *
 * @param  string $output_filter Filter string.
 * @return html                Markup.
 */
function analytica_post_link( $output_filter = '' ) {

    $enabled = apply_filters( 'analytica_post_link_enabled', '__return_true' );
    if ( ( is_admin() && ! wp_doing_ajax() ) || ! $enabled ) {
        return $output_filter;
    }

    $read_more_text    = apply_filters( 'analytica_post_read_more', __( 'Read More &raquo;', 'analytica' ) );
    $read_more_classes = apply_filters( 'analytica_post_read_more_class', array() );

    $post_link = sprintf(
        esc_html( '%s' ),
        '<a class="' . implode( ' ', $read_more_classes ) . '" href="' . esc_url( get_permalink() ) . '"> ' . the_title( '<span class="screen-reader-text">', '</span>', false ) . $read_more_text . '</a>'
    );

    $output = ' &hellip;<p class="read-more"> ' . $post_link . '</p>';

    return apply_filters( 'analytica_post_link', $output, $output_filter );
}

add_filter( 'the_content_more_link', 'analytica_the_content_more_link', 10, 2 );
/**
 * Filters the Read More link text.
 *
 * @param  string $more_link_element Read More link element.
 * @param  string $more_link_text Read More text.
 * @return html                Markup.
 */
function analytica_the_content_more_link( $more_link_element = '', $more_link_text = '' ) {

    $enabled = apply_filters( 'analytica_the_content_more_link_enabled', '__return_true' );
    if ( ( is_admin() && ! wp_doing_ajax() ) || ! $enabled ) {
        return $more_link_element;
    }

    $more_link_text    = apply_filters( 'analytica_the_content_more_string', __( 'Read More &raquo;', 'analytica' ) );
    $read_more_classes = apply_filters( 'analytica_the_content_more_link_class', array() );

    $post_link = sprintf(
        esc_html( '%s' ),
        '<a class="' . implode( ' ', $read_more_classes ) . '" href="' . esc_url( get_permalink() ) . '"> ' . the_title( '<span class="screen-reader-text">', '</span>', false ) . $more_link_text . '</a>'
    );

    $more_link_element = ' &hellip;<p class="analytica-the-content-more-link"> ' . $post_link . '</p>';

    return apply_filters( 'analytica_the_content_more_link', $more_link_element, $more_link_text );
}

add_filter( 'body_class', 'analytica_blog_body_classes' );
/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 * @param array $classes Classes for the body element.
 * @return array
 */
function analytica_blog_body_classes( $classes ) {

    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    return $classes;
}

add_filter( 'post_class', 'analytica_post_class_blog_grid' );
/**
 * Adds custom classes to the array of post grid classes.
 *
 * @since 1.0.0
 * @param array $classes Classes for the post element.
 * @return array
 */
function analytica_post_class_blog_grid( $classes ) {

    if ( is_archive() || is_home() || is_search() ) {
        $classes[] = 'analytica-article-post';
    }

    return $classes;
}

add_action( 'analytica_blog_post_featured_format', 'analytica_blog_post_get_featured_item' );
/**
 * To featured image / gallery / audio / video etc. As per the post format.
 *
 * @since 1.0.0
 * @return mixed
 */
function analytica_blog_post_get_featured_item() {

    $post_featured_data = '';
    $post_format        = get_post_format();

    if ( has_post_thumbnail() ) {

        $post_featured_data  = '<a href="' . esc_url( get_permalink() ) . '" >';
        $post_featured_data .= get_the_post_thumbnail();
        $post_featured_data .= '</a>';

    } else {

        switch ( $post_format ) {
            case 'image':
                break;

            case 'video':
                $post_featured_data = analytica_get_video_from_post( get_the_ID() );
                break;

            case 'gallery':
                $post_featured_data = get_post_gallery( get_the_ID(), false );
                if ( isset( $post_featured_data['ids'] ) ) {
                    $img_ids = explode( ',', $post_featured_data['ids'] );

                    $image_alt = get_post_meta( $img_ids[0], '_wp_attachment_image_alt', true );
                    $image_url = wp_get_attachment_url( $img_ids[0] );

                    if ( isset( $img_ids[0] ) ) {
                        $post_featured_data  = '<a href="' . esc_url( get_permalink() ) . '" >';
                            $post_featured_data .= '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $image_alt ) . '" >';
                        $post_featured_data .= '</a>';
                    }
                }
                break;

            case 'audio':
                $post_featured_data = do_shortcode( analytica_get_audios_from_post( get_the_ID() ) );
                break;
        }
    }

    echo $post_featured_data; // WPCS: XSS OK.
}


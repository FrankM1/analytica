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

add_action( 'analytica_entry_related_content_blog', 'analytica_entry_related_content_blog_template' );
/**
 * Undocumented function
 *
 * @return void
 */
function analytica_entry_related_content_blog_template() {
    get_template_part( 'template-parts/blog/blog-layout' );
}

add_action( 'analytica_after_loop', 'analytica_related_posts' );
/**
 * Undocumented function
 *
 * @return void
 */
function analytica_related_posts() {

    if ( ! is_singular('post' ) ) {
        return;
    }

    $in_tax_query_array = $and_tax_query_array = $found_posts = array();

    $args = array(
        'current_post_id' => get_the_ID(),
        'posts_per_page' => 5,
        'taxes' => array( 'post_tag', 'category' )
    );

    $current_post_id = $args['current_post_id'];

    // Check limited number
    if ( ! $args['posts_per_page'] ) {
        return;
    }

    // Check taxonomies
    $taxes = get_post_taxonomies( $current_post_id );

    if ( empty( $taxes ) ) {
        return;
    }

    $taxes = apply_filters( 'analytica_related_posts_posts_taxes', array_unique( array_merge( $args['taxes'], $taxes ) ) );

    foreach ( $taxes as $tax ) :

        if ( $tax == 'post_format' ) {

            // Post format
            $post_format = get_post_format( $current_post_id ) ? get_post_format( $current_post_id ) : 'standard';

            $in_tax_query_array[$tax] = array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => 'post-format-' . $post_format,
                'operator' => 'IN',
            );
        }

        $terms = get_the_terms( $current_post_id, $tax );

        if ( empty( $terms ) ) {
            continue;
        }

        $term_ids = array();

        foreach ( $terms as $term ) {
            $term_ids[] = $term->term_id;
        }

        $in_tax_query_array[$tax] = array(
            'taxonomy' => $tax,
            'field' => 'id',
            'terms' => $term_ids,
            'operator' => 'IN',
        );

        $and_tax_query_array[$tax] = array(
            'taxonomy' => $tax,
            'field' => 'id',
            'terms' => $term_ids,
            'operator' => 'AND',
        );

    endforeach;

    if ( empty( $in_tax_query_array ) && empty( $and_tax_query_array ) ) {
        return;
    }

    $query_args = array(
        'post_type' => get_post_type( $current_post_id ),
        'ignore_sticky_posts' => true,
        'posts_per_page' => $args['posts_per_page'],
    );

    // Multiple Taxonomy Query: relation = AND, operator = AND
    $query_args['tax_query'] = $and_tax_query_array;
    $query_args['tax_query']['relation'] = 'AND';
    $query_args['post__not_in'] = array( $current_post_id );

    $related = new WP_Query( $query_args );

    foreach ( $related->posts as $post ) {
        $found_posts[] = $post->ID;
    }

    // Multiple Taxonomy Query: relation = AND, operator = IN
    if ( count( $found_posts ) < $args['posts_per_page'] ) {
        $query_args['tax_query'] = $in_tax_query_array;
        $query_args['tax_query']['relation'] = 'AND';
        $query_args['post__not_in'] = array_merge( array( $current_post_id ), $found_posts );
        $related = new WP_Query( $query_args );
        foreach ( $related->posts as $post ) {
            $found_posts[] = $post->ID;
        }
    }

    // Foreach Each Taxonomy Query: operator = AND
    if ( count( $found_posts ) < $args['posts_per_page'] ) {
        foreach ( $and_tax_query_array as $and_tax_query ) {
            $query_args['tax_query'] = array( $and_tax_query );
            $query_args['tax_query']['relation'] = 'AND';
            $query_args['post__not_in'] = array_merge( array( $current_post_id ), $found_posts );
            $related = new WP_Query( $query_args );
            foreach ( $related->posts as $post ) {
                $found_posts[] = $post->ID;
            }

            if ( count( $found_posts ) > $args['posts_per_page'] ) {
                break;
            }
        }
    }

    // Foreach Each Taxonomy Query: operator = IN
    if ( count( $found_posts ) < $args['posts_per_page'] ) {
        foreach ( $in_tax_query_array as $in_tax_query ) {
            $query_args['tax_query'] = array( $in_tax_query );
            $query_args['tax_query']['relation'] = 'AND';
            $query_args['post__not_in'] = array_merge( array( $current_post_id ), $found_posts );
            $related = new WP_Query( $query_args );
            foreach ( $related->posts as $post ) {
                $found_posts[] = $post->ID;
            }

            if ( count( $found_posts ) > $args['posts_per_page'] ) {
                break;
            }
        }
    }

    if ( empty( $found_posts ) ) {
        return;
    }

    $related_posts_query_args = array(
        'ignore_sticky_posts'   => true,
        'post_type'             => get_post_type( $current_post_id ),
        'posts_per_page'        => $args['posts_per_page'],
        'post__not_in'          => array( $current_post_id ),
        'post__in'              => $found_posts
    );

    $related_posts_query_args = apply_filters( 'analytica_related_posts_query_args', $related_posts_query_args );

    $related_posts_query = new WP_Query( $query_args );

    if ( $related_posts_query->have_posts() ) :

        ?><aside class="related-posts">
			<div class="related-posts-inner"><?php

        while ( $related_posts_query->have_posts() ) : $related_posts_query->the_post();
            get_template_part( 'template-parts/content', 'related' );
        endwhile;

		?></div>
	</aside><?php

   endif;

     wp_reset_postdata();

}

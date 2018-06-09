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
 
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 1.0.0
 * @return mixed            Markup.
 */
function analytica_blog_get_post_meta() {

    $enable_meta = apply_filters( 'analytica_blog_post_meta_enabled', '__return_true' );
    $post_meta   = analytica_get_option( 'archive-post-meta' );

    if ( 'post' == get_post_type() && is_array( $post_meta ) && $enable_meta ) {

        $output_str = analytica_get_post_meta( $post_meta );

        if ( ! empty( $output_str ) ) {
            echo apply_filters( 'analytica_blog_post_meta', '<div class="entry-meta">' . $output_str . '</div>', $output_str ); // WPCS: XSS OK.
        }
    }
}

/**
 * Post meta
 *
 * @param  string $post_meta Post meta.
 * @param  string $separator Separator.
 * @return string            post meta markup.
 */
function analytica_get_post_meta( $post_meta, $separator = '<span class="meta-sep"></span>' ) {

    $output_str = '';
    $loop_count = 1;

    foreach ( $post_meta as $meta_value ) {

        switch ( $meta_value ) {

            case 'author':
                $output_str .= ( 1 != $loop_count && '' != $output_str ) ? ' ' . $separator . ' ' : '';
                $output_str .= esc_html( analytica_default_strings( 'string-blog-meta-author-by', false ) ) . analytica_post_author();
                break;

            case 'date':
                $output_str .= ( 1 != $loop_count && '' != $output_str ) ? ' ' . $separator . ' ' : '';
                $output_str .= analytica_post_date();
                break;

            case 'category':
                $category = analytica_post_categories();
                if ( '' != $category ) {
                    $output_str .= ( 1 != $loop_count && '' != $output_str ) ? ' ' . $separator . ' ' : '';
                    $output_str .= $category;
                }
                break;

            case 'tag':
                $tags = analytica_post_tags();
                if ( '' != $tags ) {
                    $output_str .= ( 1 != $loop_count && '' != $output_str ) ? ' ' . $separator . ' ' : '';
                    $output_str .= $tags;
                }
                break;

            case 'comments':
                $comment = analytica_post_comments();
                if ( '' != $comment ) {
                    $output_str .= ( 1 != $loop_count && '' != $output_str ) ? ' ' . $separator . ' ' : '';
                    $output_str .= $comment;
                }
                break;
            default:
                $output_str .= apply_filters( 'analytica_meta_case_' . $meta_value, $output_str, $loop_count, $separator );

        }

        $loop_count ++;
    }

    return $output_str;
}

/**
 * Function to get Date of Post
 *
 * @return html                Markup.
 */
function analytica_post_date() {

    $output        = '';
    $format        = apply_filters( 'analytica_post_date_format', '' );
    $time_string   = esc_html( get_the_date( $format ) );
    $modified_date = esc_html( get_the_modified_date( $format ) );
    $posted_on     = sprintf(
        esc_html( '%s' ),
        $time_string
    );
    $modified_on   = sprintf(
        esc_html( '%s' ),
        $modified_date
    );
    $output       .= '<span class="posted-on">';
    $output       .= '<span class="published" itemprop="datePublished"> ' . $posted_on . '</span>';
    $output       .= '<span class="updated" itemprop="dateModified"> ' . $modified_on . '</span>';
    $output       .= '</span>';
    
    return apply_filters( 'analytica_post_date', $output );
}

/**
 * Function to get Author of Post
 *
 * @param  string $output_filter Filter string.
 * @return html                Markup.
 */
function analytica_post_author( $output_filter = '' ) {
    $output = '';

    $byline = sprintf(
        esc_html( '%s' ),
        '<a class="url fn n" title="View all posts by ' . esc_attr( get_the_author() ) . '" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author" itemprop="url"> <span class="author-name" itemprop="name">' . esc_html( get_the_author() ) . '</span> </a>'
    );

    $output .= '<span class="posted-by vcard author" itemtype="https://schema.org/Person" itemscope="itemscope" itemprop="author"> ' . $byline . '</span>';

    return apply_filters( 'analytica_post_author', $output, $output_filter );
}

/**
 * Function to get Number of Comments of Post
 *
 * @param  string $output_filter Output filter.
 * @return html                Markup.
 */
function analytica_post_comments( $output_filter = '' ) {

    $output = '';

    ob_start();
    if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        ?>
        <span class="comments-link">
            <?php
            /**
             * Get Comment Link
             *
             * @see analytica_default_strings()
             */
            comments_popup_link( analytica_default_strings( 'string-blog-meta-leave-a-comment', false ), analytica_default_strings( 'string-blog-meta-one-comment', false ), analytica_default_strings( 'string-blog-meta-multiple-comment', false ) );
            ?>

            <!-- Comment Schema Meta -->
            <span itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter">
                <meta itemprop="interactionType" content="https://schema.org/CommentAction" />
                <meta itemprop="userInteractionCount" content="<?php echo absint( wp_count_comments( get_the_ID() )->approved ); ?>" />
            </span>
        </span>

        <?php
    }

    $output = ob_get_clean();

    return apply_filters( 'analytica_post_comments', $output, $output_filter );
}

/**
 * Function to get Tags applied of Post
 *
 * @param  string $output_filter Output filter.
 * @return html                Markup.
 */
function analytica_post_tags( $output_filter = '' ) {

    $output = '';

    /* translators: used between list items, there is a space after the comma */
    $tags_list = get_the_tag_list( '', __( ', ', 'analytica' ) );

    if ( $tags_list ) {
        $output .= '<span class="tags-links">' . $tags_list . '</span>';
    }

    return apply_filters( 'analytica_post_tags', $output, $output_filter );
}

/**
 * Function to get Categories applied of Post
 *
 * @param  string $output_filter Output filter.
 * @return html                Markup.
 */
function analytica_post_categories( $output_filter = '' ) {

    $output = '';

    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( __( ', ', 'analytica' ) );

    if ( $categories_list ) {
        $output .= '<span class="cat-links">' . $categories_list . '</span>';
    }

    return apply_filters( 'analytica_post_categories', $output, $output_filter );
}

/**
 * Layout class
 *
 * @param  string $class Class.
 */
function analytica_blog_layout_class( $class = '' ) {

    // Separates classes with a single space, collates classes for body element.
    echo 'class="' . esc_attr( join( ' ', analytica_get_blog_layout_class( $class ) ) ) . '"';
}

/**
 * Retrieve the classes for the body element as an array.
 *
 * @param string $class Class.
 */
function analytica_get_blog_layout_class( $class = '' ) {

    // array of class names.
    $classes = array();

    $post_format = get_post_format() ? get_post_format() : 'standard';

    $classes[] = 'analytica-post-format-' . $post_format;

    if ( ! has_post_thumbnail() || ! wp_get_attachment_image_src( get_post_thumbnail_id() ) ) {
        switch ( $post_format ) {

            case 'aside':
                $classes[] = 'analytica-no-thumb';
                break;

            case 'image':
                $has_image = analytica_get_first_image_from_post();
                if ( empty( $has_image ) || is_single() ) {
                    $classes[] = 'analytica-no-thumb';
                }
                break;

            case 'video':
                $post_featured_data = analytica_get_video_from_post( get_the_ID() );
                if ( empty( $post_featured_data ) ) {
                    $classes[] = 'analytica-no-thumb';
                }
                break;

            case 'quote':
                $classes[] = 'analytica-no-thumb';
                break;

            case 'link':
                $classes[] = 'analytica-no-thumb';
                break;

            case 'gallery':
                $post_featured_data = get_post_gallery();
                if ( empty( $post_featured_data ) || is_single() ) {
                    $classes[] = 'analytica-no-thumb';
                }
                break;

            case 'audio':
                $has_audio = analytica_get_audios_from_post( get_the_ID() );
                if ( empty( $has_audio ) || is_single() ) {
                    $classes[] = 'analytica-no-thumb';
                } else {
                    $classes[] = 'analytica-embeded-audio';
                }
                break;

            case 'standard':
            default:
                if ( ! has_post_thumbnail() || ! wp_get_attachment_image_src( get_post_thumbnail_id() ) ) {
                    $classes[] = 'analytica-no-thumb';
                }
                break;
        }
    }

    if ( ! empty( $class ) ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_merge( $classes, $class );
    } else {
        $class = array(); // Ensure that we always coerce class to being an array.
    }

    /**
     * Filter primary div class names
     */
    $classes = apply_filters( 'analytica_blog_layout_class', $classes, $class );

    $classes = array_map( 'sanitize_html_class', $classes );

    return array_unique( $classes );
}

/**
 * Analytica get post thumbnail image
 *
 * @since 1.0.15
 * @param string  $before Markup before thumbnail image.
 * @param string  $after  Markup after thumbnail image.
 * @param boolean $echo   Output print or return.
 * @return string|void
 */
 function analytica_get_post_thumbnail( $before = '', $after = '', $echo = true ) {

    $output = '';

    $check_is_singular = is_singular();

    $featured_image = true;

    $is_featured_image = analytica_get_option( 'featured-image' );

    if ( 'disabled' === $is_featured_image ) {
        $featured_image = false;
    }

    $featured_image = apply_filters( 'analytica_featured_image_enabled', $featured_image );
    $blog_post_thumb   = analytica_get_option( 'archive-content-structure'            , [] );
    $single_post_thumb = analytica_get_option( 'single-post-structure', [] );

    if ( ( ( ! $check_is_singular && in_array( 'image', $blog_post_thumb ) ) || ( is_single() && in_array( 'single-image', $single_post_thumb ) ) || is_page() ) && has_post_thumbnail() ) {

        if ( $featured_image && ( ! ( $check_is_singular ) || ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) ) ) {

            $post_thumb = get_the_post_thumbnail(
                get_the_ID(),
                apply_filters( 'analytica_post_thumbnail_default_size', 'blog-featured' ),
                array(
                    'itemprop' => 'image',
                )
            );

            if ( '' != $post_thumb ) {
                $output .= '<div class="post-thumb-img-content post-thumb">';
                if ( ! $check_is_singular ) {
                    $output .= '<a href="' . esc_url( get_permalink() ) . '" >';
                }
                $output .= $post_thumb;
                if ( ! $check_is_singular ) {
                    $output .= '</a>';
                }
                $output .= '</div>';
            }
        }
    }

    if ( ! $check_is_singular ) {
        $output = apply_filters( 'analytica_blog_post_featured_image_after', $output );
    }

    $output = apply_filters( 'analytica_get_post_thumbnail', $output, $before, $after );

    if ( $echo ) {
        echo $before . $output . $after; // WPCS: XSS OK.
    } else {
        return $before . $output . $after;
    }
}

/**
 * Blog post Thubmnail, Title & Blog Meta order
 *
 * @since  1.0.0
 */
 function analytica_blog_post_thumbnail_and_title_order() {

    $blog_post_thumb_title_order = analytica_get_option( 'archive-content-structure' );
    if ( is_single() ) {
        $blog_post_thumb_title_order = analytica_get_option( 'single-post-structure' );
    }
    if ( is_array( $blog_post_thumb_title_order ) ) {
        // Append the custom class for second element for single post.
        foreach ( $blog_post_thumb_title_order as $post_thumb_title_order ) {

            switch ( $post_thumb_title_order ) {

                // Blog Post Featured Image.
                case 'image':
                    do_action( 'analytica_blog_archive_featured_image_before' );
                    analytica_get_blog_post_thumbnail( 'archive' );
                    do_action( 'analytica_blog_archive_featured_image_after' );
                    break;

                // Blog Post Title and Blog Post Meta.
                case 'title-meta':
                    do_action( 'analytica_blog_archive_title_meta_before' );
                    analytica_get_blog_post_title_meta();
                    do_action( 'analytica_blog_archive_title_meta_after' );
                    break;

                // Single Post Featured Image.
                case 'single-image':
                    do_action( 'analytica_blog_single_featured_image_before' );
                    analytica_get_blog_post_thumbnail( 'single' );
                    do_action( 'analytica_blog_single_featured_image_after' );
                    break;

                // Single Post Title and Single Post Meta.
                case 'single-title-meta':
                    do_action( 'analytica_blog_single_title_meta_before' );
                    analytica_get_single_post_title_meta();
                    do_action( 'analytica_blog_single_title_meta_after' );
                    break;
            }
        }
    }
}

/**
 * Blog post Thumbnail
 *
 * @param string $type Type of post.
 * @since  1.0.0
 */
function analytica_get_blog_post_thumbnail( $type = 'archive' ) {

    if ( 'archive' === $type ) {
        // Blog Post Featured Image.
        analytica_get_post_thumbnail( '<div class="analytica-blog-featured-section">', '</div>' );
    } elseif ( 'single' === $type && analytica_get_option( 'single-get-post-thumbnail' ) ) {
        // Single Post Featured Image.
        analytica_get_post_thumbnail();
    }
}

/**
 * Blog post Thumbnail
 *
 * @since  1.0.0
 */
function analytica_get_blog_post_title_meta() {

    // Blog Post Title and Blog Post Meta.
    do_action( 'analytica_archive_entry_header_before' );
    ?>
    <header class="entry-header">
        <?php

            do_action( 'analytica_archive_post_title_before' );

            /* translators: 1: Current post link, 2: Current post id */
            analytica_the_post_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>', get_the_id() );

            do_action( 'analytica_archive_post_title_after' );

        ?>
        <?php

            do_action( 'analytica_archive_post_meta_before' );

            analytica_blog_get_post_meta();

            do_action( 'analytica_archive_post_meta_after' );

        ?>
    </header><!-- .entry-header -->
    <?php

    do_action( 'analytica_archive_entry_header_after' );
}

/**
 * Blog post Thumbnail
 *
 * @since  1.0.0
 */
function analytica_get_single_post_title_meta() {

    // Single Post Title and Single Post Meta.
    do_action( 'analytica_single_post_order_before' );

    ?><div class="analytica-single-post-order"><?php

        do_action( 'analytica_single_post_title_before' );

        analytica_the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );

        do_action( 'analytica_single_post_title_after' );

        do_action( 'analytica_single_post_meta_before' );

        analytica_single_get_post_meta();

        do_action( 'analytica_single_post_meta_after' );

    ?></div><?php

    do_action( 'analytica_single_post_order_after' );
}

/**
 * Get audio files from post content
 *
 * @param  number $post_id Post id.
 * @return mixed          Iframe.
 */
function analytica_get_audios_from_post( $post_id ) {

    // for audio post type - grab.
    $post    = get_post( $post_id );
    $content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
    $embeds  = apply_filters( 'analytica_get_post_audio', get_media_embedded_in_content( $content ) );

    if ( empty( $embeds ) ) {
        return '';
    }

    // check what is the first embed containg video tag, youtube or vimeo.
    foreach ( $embeds as $embed ) {
        if ( strpos( $embed, 'audio' ) ) {
            return '<span class="analytica-post-audio-wrapper">' . $embed . '</span>';
        }
    }
}

/**
 * Get first image from post content
 *
 * @since 1.0.0
 * @param  number $post_id Post id.
 * @return mixed
 */
function analytica_get_video_from_post( $post_id ) {

    $post    = get_post( $post_id );
    $content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
    $embeds  = apply_filters( 'analytica_get_post_audio', get_media_embedded_in_content( $content ) );

    if ( empty( $embeds ) ) {
        return '';
    }

    // check what is the first embed containg video tag, youtube or vimeo.
    foreach ( $embeds as $embed ) {
        if ( strpos( $embed, 'video' ) || strpos( $embed, 'youtube' ) || strpos( $embed, 'vimeo' ) ) {
            return $embed;
        }
    }
}
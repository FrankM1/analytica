<?php
/**
 * Blog Config File
 * Common Functions for Blog and Single Blog
 *
 * @package Analytica
 */

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
                $output_str = apply_filters( 'analytica_meta_case_' . $meta_value, $output_str, $loop_count, $separator );

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

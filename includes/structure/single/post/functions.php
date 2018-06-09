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
 * @param boolean $echo   Output print or return.
 * @return string|void
 */
function analytica_single_get_post_meta( $echo = true ) {

    $enable_meta = apply_filters( 'analytica_single_post_meta_enabled', '__return_true' );
    $post_meta   = analytica_get_option( 'single-post-meta' );

    $output = '';
    if ( is_array( $post_meta ) && 'post' == get_post_type() && $enable_meta ) {

        $output_str = analytica_get_post_meta( $post_meta );
        if ( ! empty( $output_str ) ) {
            $output = apply_filters( 'analytica_single_post_meta', '<div class="entry-meta">' . $output_str . '</div>', $output_str ); // WPCS: XSS OK.
        }
    }
    if ( $echo ) {
        echo wp_kses( $output, analytica_get_allowed_tags() ); 
    } else {
        return $output;
    }
}

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own analytica_theme_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @param  string $comment Comment.
 * @param  array  $args    Comment arguments.
 * @param  number $depth   Depth.
 * @return mixed          Comment markup.
 */
function analytica_theme_comment( $comment, $args, $depth ) {

    switch ( $comment->comment_type ) {

        case 'pingback':
        case 'trackback':
            // Display trackbacks differently than normal comments.
        ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p><?php esc_html_e( 'Pingback:', 'analytica' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'analytica' ), '<span class="edit-link">', '</span>' ); ?></p>
            </li>
            <?php
            break;

        default:
            // Proceed with normal comments.
            global $post;
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

                <article id="comment-<?php comment_ID(); ?>" class="analytica-comment">
                    <div class='analytica-comment-avatar-wrap'><?php echo get_avatar( $comment, 50 ); ?></div><!-- Remove 1px Space
                    --><div class="analytica-comment-data-wrap">
                        <div class="analytica-comment-meta-wrap">
                            <header class="analytica-comment-meta analytica-comment-author vcard capitalize">

                                <?php

                                printf(
                                    '<div class="analytica-comment-cite-wrap"><cite><b class="fn">%1$s</b> %2$s</cite></div>',
                                    get_comment_author_link(),
                                    // If current post author is also comment author, make it known visually.
                                    ( $comment->user_id === $post->post_author ) ? '<span class="analytica-highlight-text analytica-cmt-post-author"></span>' : ''
                                );

                                printf(
                                    '<div class="analytica-comment-time"><span  class="timendate"><a href="%1$s"><time datetime="%2$s">%3$s</time></a></span></div>',
                                    esc_url( get_comment_link( $comment->comment_ID ) ),
                                    get_comment_time( 'c' ),
                                    /* translators: 1: date, 2: time */
                                    sprintf( esc_html__( '%1$s at %2$s', 'analytica' ), get_comment_date(), get_comment_time() )
                                );

                                ?>

                            </header> <!-- .analytica-comment-meta -->
                        </div>
                        <section class="analytica-comment-content comment">
                            <?php comment_text(); ?>
                            <div class="analytica-comment-edit-reply-wrap">
                                <?php edit_comment_link( analytica_default_strings( 'string-comment-edit-link', false ), '<span class="analytica-edit-link">', '</span>' ); ?>
                                <?php
                                comment_reply_link(
                                    array_merge(
                                        $args, array(
                                            'reply_text' => analytica_default_strings( 'string-comment-reply-link', false ),
                                            'add_below' => 'comment',
                                            'depth'  => $depth,
                                            'max_depth' => $args['max_depth'],
                                            'before' => '<span class="analytica-reply-link">',
                                            'after'  => '</span>',
                                        )
                                    )
                                );
                                ?>
                            </div>
                            <?php if ( '0' == $comment->comment_approved ) : ?>
                                <p class="analytica-highlight-text comment-awaiting-moderation"><?php echo esc_html( analytica_default_strings( 'string-comment-awaiting-moderation', false ) ); ?></p>
                            <?php endif; ?>
                        </section> <!-- .analytica-comment-content -->
                    </div>
                </article><!-- #comment-## -->
            <!-- </li> -->
            <?php
            break;
    }
}

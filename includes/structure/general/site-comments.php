<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */
 
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

add_filter( 'comment_form_default_fields', 'analytica_comment_form_default_fields_markup' );
/**
 * Function filter comment form's default fields
 *
 * @since 1.0.0
 * @param array $fields Array of comment form's default fields.
 * @return array        Comment form fields.
 */
function analytica_comment_form_default_fields_markup( $fields ) {

    $commenter = wp_get_current_commenter();
    $req       = get_option( 'require_name_email' );
    $aria_req  = ( $req ? " aria-required='true'" : '' );

    $fields['author'] = '<div class="analytica-comment-formwrap"><p class="comment-form-author analytica-col-xs-12 analytica-col-sm-12 analytica-col-md-4 analytica-col-lg-4">' .
                '<label for="author" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-name', false ) ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                '" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-name', false ) ) . '" size="30"' . $aria_req . ' /></p>';
    $fields['email']  = '<p class="comment-form-email analytica-col-xs-12 analytica-col-sm-12 analytica-col-md-4 analytica-col-lg-4">' .
                '<label for="email" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-email', false ) ) . '</label><input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
                '" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-email', false ) ) . '" size="30"' . $aria_req . ' /></p>';
    $fields['url']    = '<p class="comment-form-url analytica-col-xs-12 analytica-col-sm-12 analytica-col-md-4 analytica-col-lg-4"><label for="url">' .
                '<label for="url" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-website', false ) ) . '</label><input id="url" name="url" type="text" value="' . esc_url( $commenter['comment_author_url'] ) .
                '" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-website', false ) ) . '" size="30" /></label></p></div>';

    return apply_filters( 'analytica_comment_form_default_fields_markup', $fields );
}

add_filter( 'comment_form_defaults', 'analytica_comment_form_default_markup' );
/**
 * Function filter comment form arguments
 *
 * @since 1.0.0
 * @param array $args   Comment form arguments.
 * @return array
 */
function analytica_comment_form_default_markup( $args ) {

    $args['id_form']           = 'analytica-commentform';
    $args['title_reply']       = analytica_default_strings( 'string-comment-title-reply', false );
    $args['cancel_reply_link'] = analytica_default_strings( 'string-comment-cancel-reply-link', false );
    $args['label_submit']      = analytica_default_strings( 'string-comment-label-submit', false );
    $args['comment_field']     = '<div class="comment-textarea"><fieldset class="comment-form-comment"><div class="comment-form-textarea"><label for="comment" class="screen-reader-text">' . esc_html( analytica_default_strings( 'string-comment-label-message', false ) ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr( analytica_default_strings( 'string-comment-label-message', false ) ) . '" cols="45" rows="8" aria-required="true"></textarea></div></fieldset></div>';

    return apply_filters( 'analytica_comment_form_default_markup', $args );
}
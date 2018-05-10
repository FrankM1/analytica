<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Analytica
 * @since 1.0.0
 */

?>

<?php do_action( 'analytica_entry_before' ); ?>

<article itemtype="https://schema.org/CreativeWork" itemscope="itemscope" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'analytica_entry_top' ); ?>

	<?php do_action( 'analytica_entry_content_blog' ); ?>

	<?php do_action( 'analytica_entry_bottom' ); ?>

</article><!-- #post-## -->

<?php do_action( 'analytica_entry_after' ); ?>

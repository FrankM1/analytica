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

<?php analytica_entry_before(); ?>

<article itemtype="https://schema.org/CreativeWork" itemscope="itemscope" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php analytica_entry_top(); ?>

	<?php analytica_entry_content_blog(); ?>

	<?php analytica_entry_bottom(); ?>

</article><!-- #post-## -->

<?php analytica_entry_after(); ?>

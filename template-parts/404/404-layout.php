<?php
/**
 * Template for 404
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        https://qazana.net/
 * @since       Analytica 1.0.0
 */

?>
<div class="ast-404-layout-1">

	<?php analytica_the_title( '<header class="page-header"><h1 class="page-title">', '</h1></header><!-- .page-header -->' ); ?>

	<div class="page-content">

		<div class="page-sub-title">
			<?php echo esc_html( analytica_default_strings( 'string-404-sub-title', false ) ); ?>
		</div>

		<div class="ast-404-search">
			<?php the_widget( 'WP_Widget_Search' ); ?>
		</div>

	</div><!-- .page-content -->
</div>

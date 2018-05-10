<?php
/**
 * Template for Primary Header
 *
 * The header layout 2 for Analytica Theme. ( No of sections - 1 [ Section 1 limit - 3 )
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @see https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

?>

<div class="main-header-bar-wrap">
	<div class="main-header-bar">
		<?php do_action( 'analytica_main_header_bar_top' ); ?>
		<div class="ast-container">

			<div class="ast-flex main-header-container">
				<?php do_action( 'analytica_masthead_content' ); ?>
			</div><!-- Main Header Container -->
		</div><!-- ast-row -->
		<?php do_action( 'analytica_main_header_bar_bottom' ); ?>
	</div> <!-- Main Header Bar -->
</div> <!-- Main Header Bar Wrap -->

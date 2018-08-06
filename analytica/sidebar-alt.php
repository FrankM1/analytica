<?php
/**
 * Radium Framework Core - A WordPress theme development framework.
 *
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file.
 * Modifying the contents of this file can be a poor life decision if you don't know what you're doing.
 *
 * NOTE: Theme data (options, global variables etc ) can be accessed anywhere in the theme by calling  <?php $framework = analytica_framework(); ?>
 *
 * @category Analytica
 * @package  Analytica
 * @author   Franklin Gitonga
 * @link     https://qazana.net/
 */

//* Output secondary sidebar structure
analytica_markup( array(
    'element'   => '<aside %s><div class="widget-area-inner">',
    'context' => 'sidebar-secondary',
) );

do_action( 'analytica_before_sidebar_alt_widget_area' );
do_action( 'analytica_sidebar_alt' );
do_action( 'analytica_after_sidebar_alt_widget_area' );

analytica_markup( array(
    'element' => '</div></aside>', //* end .sidebar-alt
) );

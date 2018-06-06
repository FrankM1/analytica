<?php
namespace Analytica;

/**
 * Custom Walker for the fallback menu
 *
 * @since 1.0.0
 **/
class Fallback_Menu_Walker extends \Walker_Page {

    function start_lvl( &$output, $depth = 0, $args = array() ) {

        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class='sub-menu'>\n";
     }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}

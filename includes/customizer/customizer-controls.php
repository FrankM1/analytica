<?php
/**
 * Analytica Theme Customizer Controls.
 *
 * @package     Analytica
 * @author      Analytica
 * @copyright   Copyright (c) 2018, Analytica
 * @link        http://wpanalytica.com/
 * @since       Analytica 1.0.0
 */

$control_dir = ANALYTICA_THEME_DIR . 'includes/customizer/custom-controls';

require $control_dir . '/sortable/class-analytica-control-sortable.php';
require $control_dir . '/radio-image/class-analytica-control-radio-image.php';
require $control_dir . '/slider/class-analytica-control-slider.php';
require $control_dir . '/responsive-slider/class-analytica-control-responsive-slider.php';
require $control_dir . '/responsive/class-analytica-control-responsive.php';
require $control_dir . '/typography/class-analytica-control-typography.php';
require $control_dir . '/spacing/class-analytica-control-spacing.php';
require $control_dir . '/responsive-spacing/class-analytica-control-responsive-spacing.php';
require $control_dir . '/divider/class-analytica-control-divider.php';
require $control_dir . '/color/class-analytica-control-color.php';
require $control_dir . '/description/class-analytica-control-description.php';
require $control_dir . '/background/class-analytica-control-background.php';


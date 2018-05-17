<?php do_action('analytica_before_header_primary'); ?>

<?php analytica_structural_wrap( 'site-header', 'open' ); ?>

<?php get_template_part( 'template-parts/header/header', 'logo' ); ?>

<?php do_action( 'analytica_before_nav_primary' ); ?>

<nav class="nav nav-horizontal nav-animation-submenu-left-to-right">
    <?php do_action( 'analytica_before_header_nav' ); ?>

        <?php get_template_part( 'template-parts/header/responsive', 'nav-button' ); ?>

        <?php do_action( 'analytica_do_primary_nav', array( 'container' => false ) ); ?>

    <?php do_action( 'analytica_after_header_nav' ); ?>
</nav>

<?php do_action( 'analytica_after_nav_primary' ); ?>

<?php analytica_structural_wrap( 'site-header', 'close' ); ?>

<?php do_action( 'analytica_after_header_primary' ); ?>

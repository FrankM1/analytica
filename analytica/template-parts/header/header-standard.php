<?php

do_action('analytica_before_header_primary');

analytica_structural_wrap( 'site-header', 'open' );

get_template_part( 'template-parts/header/header', 'logo' );

 ?><div class="site-navigation"><?php

	do_action( 'analytica_before_nav_primary' );

	 ?><nav class="nav nav-horizontal nav-animation-submenu-left-to-right"><?php

			do_action( 'analytica_before_header_nav' );

				get_template_part( 'template-parts/header/responsive', 'nav-button' );

				do_action( 'analytica_do_primary_nav', array( 'container' => false ) );

			do_action( 'analytica_after_header_nav' );

	 ?></nav><?php

	do_action( 'analytica_after_nav_primary' );

 ?></div><?php

analytica_structural_wrap( 'site-header', 'close' );

do_action( 'analytica_after_header_primary' );

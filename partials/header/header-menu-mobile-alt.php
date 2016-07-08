<?php
/**
 * Mobile Menu alternative.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SmallShop
 */ ?>

<div id="mobile-menu-alternative" class="wpsp-hidden">
    <?php wp_nav_menu( array(
        'theme_location' => 'mobile_menu_alt',
        'menu_class'     => 'dropdown-menu',
        'fallback_cb'    => false,
    ) ); ?>
</div><!-- #mobile-menu-alternative -->
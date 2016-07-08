<?php
/**
 * Navbar Style Mobile Menu Toggle
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Menu Location
$menu_location = apply_filters( 'wpsp_main_menu_location', 'main_menu' );

// Display if menu is defined
if ( has_nav_menu( $menu_location ) ) :

	// Get menu icon
	$icon = apply_filters( 'wpsp_mobile_menu_navbar_open_icon', '<span class="fa fa-navicon"></span>' );

	// Get menu text
	$text = wpsp_get_translated_theme_mod( 'mobile_menu_toggle_text' );
	$text = $text ? $text : esc_html__( 'Menu', 'smallshop' );
	$text = apply_filters( 'wpsp_mobile_menu_navbar_open_text', $text ); ?>

	<?php
	// Closing toggle for the sidr mobile menu style
	if ( 'sidr' == wpsp_get_redux( 'mobile-menu-style' ) ) : ?>

		<div id="sidr-close"><a href="#sidr-close" class="toggle-sidr-close"></a></div>

	<?php endif; ?>

	<div id="wpsp-mobile-menu-navbar" class="clear wpsp-hidden">
		<div class="container clear">
			<a href="#mobile-menu" class="mobile-menu-toggle" title="<?php echo $text; ?>"><?php echo $icon; ?><span class="wpsp-text"><?php echo $text; ?></span></a>
		</div><!-- .container -->
	</div><!-- #wpsp-mobile-menu-navbar -->

<?php endif; ?>
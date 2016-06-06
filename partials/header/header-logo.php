<?php
/**
 * Header Logo
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define variables
$logo_url     = wpsp_header_logo_url();
$logo_img     = wpsp_get_redux( 'custom-logo' );
$logo_title   = wpsp_header_logo_title(); ?>

<div id="site-logo" class="site-branding <?php echo wpsp_header_logo_classes(); ?>">
	<div id="site-logo-inner" class="site-logo-inner clear">	
		<a href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo esc_attr( $logo_title ); ?>" rel="home" class="main-logo">
			<img src="<?php echo esc_url( $logo_img['url'] ); ?>" alt="<?php echo esc_attr( $logo_title ); ?>" />
		</a>
	</div> <!-- .site-logo-inner -->
</div><!-- .site-branding -->
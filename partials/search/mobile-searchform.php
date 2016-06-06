<?php
/**
 * Searchform for the mobile sidebar menu
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div id="mobile-menu-search" class="clear wpsp-hidden">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-menu-searchform">
		<input type="search" name="s" autocomplete="off" placeholder="<?php echo esc_attr( apply_filters( 'wpsp_mobile_searchform_placeholder', __( 'Search', 'wpsp-blog-textdomain' ) ) ); ?>" />
		<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) { ?>
			<input type="hidden" name="lang" value="<?php echo( ICL_LANGUAGE_CODE ); ?>"/>
		<?php } ?>
		<button type="submit" class="searchform-submit">
			<span class="fa fa-search"></span>
		</button>
	</form>
</div><!-- .mobile-menu-search -->
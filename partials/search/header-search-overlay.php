<?php
/**
 * Site header search dropdown HTML
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<section id="searchform-overlay" class="header-searchform-wrap clear">
	<div id="searchform-overlay-title"><?php esc_html_e( 'Search', 'smallshop' ); ?></div>
	<?php get_search_form( true ); ?>
</section><!-- #searchform-overlay -->
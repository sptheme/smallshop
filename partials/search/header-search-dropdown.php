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

<div id="searchform-dropdown" class="header-searchform-wrap clear">
	<?php get_search_form( true ); ?>
</div><!-- #searchform-dropdown -->
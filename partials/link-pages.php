<?php
/**
 * Page links
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Link pages when using <!--nextpage-->
wp_link_pages( array(
	'before'      => '<div class="page-links clr">',
	'after'       => '</div>',
	'link_before' => '<span>',
	'link_after'  => '</span>'
) );
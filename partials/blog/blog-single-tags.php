<?php
/**
 * Single blog tags
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display tags
the_tags( '<div class="post-tags clear">','','</div>' );
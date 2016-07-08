<?php
/**
 * Blog single post related heading
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.3.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Output heading
wpsp_heading( array(
	'content'		=> wpsp_blog_related_heading(),
	'tag'			=> 'div',
	'classes'		=> array( 'related-posts-title' ),
	'apply_filters'	=> 'blog_related',
) );
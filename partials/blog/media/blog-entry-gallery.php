<?php
/**
 * Blog entry gallery format media
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get attachments
//$attachments = wpsp_get_gallery_ids( get_the_ID() );

// Return standard entry style if password protected or there aren't any attachments
if ( post_password_required() || empty( $attachments ) ) {
	get_template_part( 'partials/blog/media/blog-entry' );
	return;
} ?>

<div class="blog-entry-media entry-media clear">

	<h3>Will styling like facebook gallery posted!</h3>

</div><!-- .blog-entry-media -->
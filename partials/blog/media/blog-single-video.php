<?php
/**
 * Blog single post video format media
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get post video
$video = wpsp_get_post_video_html();

// Show featured image for password-protected post or if video isn't defined
if ( post_password_required() || ! $video ) {
    get_template_part( 'partials/blog/media/blog-single', 'thumbnail' );
    return;
} ?>

<div id="post-media" class="clear">
	<div id="blog-post-video"><?php echo $video; ?></div>
</div>
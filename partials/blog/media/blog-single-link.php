<?php
/**
 * Blog single post link format media
 * Link formats should redirect to the URL defined in the custom fields
 * This template file is used as a fallback only.
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get thumbnail
$thumbnail = wpsp_get_blog_post_thumbnail();

// Return if there isn't a thumbnail
if ( ! $thumbnail ) {
    return;
} ?>

<div id="post-media" class="clear">
	<?php get_template_part( 'partials/blog/media/blog-single', 'thumbnail' ); ?>
</div><!-- #post-media -->
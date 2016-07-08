<?php
/**
 * Blog single post audio format media
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get audio html
$audio = wpsp_get_post_audio_html();

// Display audio if audio exists and the post isn't protected
if ( $audio && ! post_password_required()  ) : ?>

	<div id="post-media" class="clear">
		<div class="blog-post-audio clear"><?php echo $audio; ?></div>
	</div>

<?php
// Otherwise get post thumbnail
else : ?>

	<?php get_template_part( 'partials/blog/media/blog-single', 'thumbnail' ); ?>

<?php endif; ?>
<?php
/**
 * Blog entry link format media
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display media if thumbnail exists
if ( $thumbnail = wpsp_get_blog_entry_thumbnail() ) : ?>
	<div class="blog-entry-media entry-media clear">
		<a href="<?php wpsp_permalink(); ?>" title="<?php wpsp_esc_title(); ?>" rel="bookmark" class="blog-entry-media-link<?php wpsp_entry_image_animation_classes(); ?>">
			<?php echo $thumbnail; ?>
		</a>
	</div>
<?php endif; ?>
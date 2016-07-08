<?php
/**
 * Blog entry avatar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $tags = wpsp_get_category_tags() ) : ?>

	<div class="entry-media-term-tags clear">
		<?php echo wpsp_get_category_tags(); ?>
	</div><!-- .entry-media-term-tags -->

<?php endif; ?>
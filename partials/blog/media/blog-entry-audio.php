<?php
/**
 * Blog entry audio format media
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display if thumbnail is defined
if ( $thumbnail = wpsp_get_blog_entry_thumbnail() ) :

	// Overlay style
	$overlay = wpsp_get_mod( 'blog-entry-overlay' );
	$overlay = $overlay ? $overlay : 'none'; ?>

	<div class="blog-entry-media entry-media clear">
		<a href="<?php wpsp_permalink(); ?>" title="<?php wpsp_esc_title(); ?>" rel="bookmark" class="blog-entry-img-link<?php wpsp_entry_image_animation_classes(); ?>">
			<?php echo $thumbnail; ?>
			<?php if ( $overlay ) { ?>
				<?php wpsp_overlay( 'inside_link', $overlay ); ?>
			<?php } else { ?>
				<div class="blog-entry-music-icon-overlay"><span class="fa fa-music"></span></div>
			<?php } ?>
		</a>
		<?php wpsp_overlay( 'outside_link', $overlay ); ?>
	</div>

<?php endif; ?>
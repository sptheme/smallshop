<?php
/**
 * Blog entry standard format media
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
if ( $thumbnail = wpsp_get_blog_entry_thumbnail() ) :

	// Overlay style
	$overlay = wpsp_get_redux( 'blog-entry-overlay' );
	$overlay = $overlay ? $overlay : 'none'; ?>

	<div class="blog-entry-media entry-media clear <?php echo wpsp_overlay_classes( $overlay ); ?>">

		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="blog-entry-media-link<?php wpsp_entry_image_animation_classes(); ?>">
			<?php echo $thumbnail; ?>
			<?php wpsp_overlay( 'inside_link', $overlay ); ?>
		</a><!-- .blog-entry-media-link -->
		<?php wpsp_overlay( 'outside_link', $overlay ); ?>

	</div><!-- .blog-entry-media -->

<?php endif; ?>
<?php
/**
 * Portfolio entry media template part
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get loop
$wpsp_loop = isset( $wpsp_loop ) ? $wpsp_loop : 'archive';

// Get video and thumbnail
$video     = wpsp_get_portfolio_post_video();
$thumbnail = wpsp_get_portfolio_entry_thumbnail( $wpsp_loop );

// Classes
$classes = array( 'portfolio-entry-media', 'clear' );
if ( $overlay = wpsp_overlay_classes() ) {
	$classes[] = $overlay;
}
$classes = implode( ' ', $classes );

// Return if there isn't a video or a thumbnail
if ( ! $video && ! $thumbnail ) {
	return;
} ?>

<div class="<?php echo esc_attr( $classes ); ?>">

	<?php
	// If the portfolio post has a video display it
	if ( $video ) : ?>

		<?php echo $video; ?>

	<?php
	// Otherwise display thumbnail if one exists
	elseif ( $thumbnail ) : ?>
		<a href="<?php the_permalink(); ?>" title="<?php wpsp_esc_title(); ?>" class="portfolio-entry-media-link">
			<?php echo $thumbnail; ?>
			<?php wpsp_overlay( 'inside_link' ); ?>
		</a>
		<?php wpsp_overlay( 'outside_link' ); ?>
	<?php endif; ?>

</div><!-- .portfolio-entry-media -->
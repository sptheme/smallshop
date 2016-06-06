<?php
/**
 * Used to display the portfolio slider
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Habitat Cambodia
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

// Get attachments
$attachments = rwmb_meta( 'wpsp_portfolio_gallery', array('type' => 'image_advanced', 'size' => 'thumb-landscape') );

// Add Standard Classes
$classes   = 'col ';
$classes .= wpsp_grid_class(3); 

// Overlay style
$overlay = 'magnifying-hover'; ?>

<div id="portfolio-single-gallery" class="portfolio-single-gallery clear">
	<div class="gallery wpsp-row clearfix">
	<?php foreach ( $attachments as $attachment ) : ?>
		<div class="<?php echo $classes; ?>">
			<div class="blog-entry-media entry-media <?php echo wpsp_overlay_classes( $overlay ); ?>">
				<a href="<?php echo $attachment['full_url'];?>" rel="bookmark" title="<?php echo $attachment['title'];?>">
					<img src="<?php echo $attachment['url'];?>">
					<?php wpsp_overlay( 'inside_link', $overlay ); ?>
				</a>
				<?php wpsp_overlay( 'outside_link', $overlay ); ?>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>
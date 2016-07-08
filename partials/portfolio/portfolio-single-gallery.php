<?php
/**
 * Used to display the portfolio slider
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

// Get attachments
$attachments = rwmb_meta( 'wpsp_portfolio_gallery', array('type' => 'image_advanced', 'size' => 'thumb-landscape') );

// Overlay style
$overlay = 'magnifying-hover'; 

// Main Classes
$wrap_classes = array( 'wpsp-carousel', 'wpsp-carousel-portfolio', 'clear', 'owl-carousel', 'portfolio-single-gallery' ); 

// Turn arrays into strings
$wrap_classes = implode( ' ', $wrap_classes ); 

// Sanitize carousel data
$arrows                 = false;
$dots                   = true;
$auto_play              = false;
$infinite_loop          = true;
$center                 = false;
$items                  = 3;
$items_scroll           = 1;
$timeout_duration       = 5000;
$items_margin           = 0;
$tablet_items           = 3;
$mobile_landscape_items = 2;
$mobile_portrait_items  = 1;
$animation_speed        = 150; ?>

<div id="portfolio-single-gallery" class="<?php echo $wrap_classes; ?>" data-items="<?php echo $items; ?>" data-slideby="<?php echo $items_scroll; ?>" data-nav="<?php echo $arrows; ?>" data-dots="<?php echo $dots; ?>" data-autoplay="<?php echo $auto_play; ?>" data-loop="<?php echo $infinite_loop; ?>" data-autoplay-timeout="<?php echo $timeout_duration ?>" data-center="<?php echo $center; ?>" data-margin="<?php echo intval( $items_margin ); ?>" data-items-tablet="<?php echo $tablet_items; ?>" data-items-mobile-landscape="<?php echo $mobile_landscape_items; ?>" data-items-mobile-portrait="<?php echo $mobile_portrait_items; ?>" data-smart-speed="<?php echo $animation_speed; ?>">
	
	<?php foreach ( $attachments as $attachment ) : ?>
		<div class="wpsp-carousel-slide">
			<div class="entry-media wpsp-carousel-entry-media clear <?php echo wpsp_overlay_classes( $overlay ); ?>">
				<a href="<?php echo $attachment['full_url'];?>" rel="bookmark" title="<?php echo $attachment['title'];?>" class="wpsp-lightbox-group-item">
					<img src="<?php echo $attachment['url'];?>">
					<?php wpsp_overlay( 'inside_link', $overlay ); ?>
				</a>
				<?php wpsp_overlay( 'outside_link', $overlay ); ?>
			</div>
		</div> <!-- .wpsp-carousel-slide -->
	<?php endforeach; ?>

</div>
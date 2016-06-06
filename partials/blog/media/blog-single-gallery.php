<?php
/**
 * Blog single post gallery format media
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Habitat Cambodia
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

$photos_meta = rwmb_meta( 'wpsp_format_gallery_album', array('type' => 'image_advanced', 'size' => 'thumb-landscape') );
$photo_col = wpsp_get_redux('post-gallery-format-cols');
// Add Standard Classes
$classes   = 'col ';
$classes .= wpsp_grid_class( $photo_col ); 

// Overlay style
$overlay = wpsp_get_redux( 'media-gallery-overlay' ); ?>

<div id="post-media" class="clear">
	<div class="gallery wpsp-row clearfix">
	<?php foreach ( $photos_meta as $photo ) : ?>
		<div class="<?php echo $classes; ?>">
			<div class="blog-entry-media entry-media <?php echo wpsp_overlay_classes( $overlay ); ?>">
				<a href="<?php echo $photo['full_url'];?>" rel="bookmark" title="<?php echo $photo['title'];?>">
					<img src="<?php echo $photo['url'];?>">
					<?php wpsp_overlay( 'inside_link', $overlay ); ?>
				</a>
				<?php wpsp_overlay( 'outside_link', $overlay ); ?>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div> <!-- #post-media -->


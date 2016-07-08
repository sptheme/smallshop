<?php
/**
 * Blog single post gallery format media
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

$attachments = rwmb_meta( 'wpsp_format_gallery_album', array('type' => 'image_advanced', 'size' => 'thumb-landscape') ); ?>

<?php if ( $attachments ) : ?>
<div id="post-media" class="clear">

	<div class="gallery-format-post-slider">

		<div class="wpsp-slider-preloaderimg">
			<?php
			// Display first image as a placeholder while the others load
			wpsp_get_blog_entry_thumbnail(); ?>
		</div><!-- .wpsp-slider-preloaderimg -->

		<div class="wpsp-slider slider-pro" <?php wpsp_blog_slider_data_atrributes(); ?>>

			<div class="wpsp-slider-slides sp-slides">

			<?php foreach ( $attachments as $attachment ) : ?>
				<div class="wpsp-slider-slide sp-slide">
					<a href="<?php echo $attachment['full_url'];?>" rel="bookmark" title="<?php echo $attachment['title'];?>" class="wpsp-lightbox-group-item">
						<img src="<?php echo $attachment['url'];?>">
					</a>
				</div> <!-- .sp-slide -->
			<?php endforeach; ?>

			</div> <!-- .sp-slides -->

			<div class="wpsp-slider-thumbnails sp-thumbnails">
				<?php foreach ( $attachments as $attachment ) : ?>
					<img src="<?php echo $attachment['url'];?>" class="wpsp-slider-thumbnail sp-thumbnail">
				<?php endforeach; ?>
			</div> <!-- .sp-thumbnails -->

		</div> <!-- .slider-pro -->

	</div> <!-- .gallery-format-post-slider -->

</div> <!-- #post-media -->
<?php endif; ?>


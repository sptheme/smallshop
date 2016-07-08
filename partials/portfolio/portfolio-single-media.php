<?php
/**
 * Portfolio single media template part
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get portfolio video
$video = wpsp_get_portfolio_post_video();

// Get portfolio attachment ( gallery images )
$attachments = rwmb_meta( 'wpsp_portfolio_gallery', array('type' => 'image_advanced', 'size' => 'thumb-landscape') );

// Get portfolio thumbnail
$thumbnail = ( ! $video ) ? wpsp_get_portfolio_post_thumbnail() : ''; ?>

<div id="portfolio-single-media" class="clear">

    <?php
    // Display slider if there are $attachments
    if ( $attachments ) :

        get_template_part( 'partials/portfolio/portfolio-single-gallery' );

    // Display Post Video if defined
    elseif ( $video ) : ?>
    
        <?php echo $video; ?>
    
    <?php
    // Otherwise display post thumbnail
    elseif ( $thumbnail ) : ?>
        
            <?php echo $thumbnail; ?>

    <?php endif; ?>

</div><!-- .portfolio-entry-media -->
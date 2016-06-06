<?php
/**
 * Portfolio single layout
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Single layout blocks
$blocks = wpsp_portfolio_post_blocks();

// Make sure we have blocks
if ( ! empty( $blocks ) ) :

	// Loop through blocks and get template part
	foreach ( $blocks as $key => $value ) :
		if ( $key && $value ) {
			get_template_part( 'partials/portfolio/portfolio-single-'. $key );	
		}
	endforeach;

endif;
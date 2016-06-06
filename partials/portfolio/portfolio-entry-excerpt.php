<?php
/**
 * Outputs the portfolio entry excerpt
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get excerpt length
$excerpt_length = wpsp_get_redux( 'portfolio-entry-excerpt-length', '20' );

// Return if excerpt length is set to 0
if ( '0' == $excerpt_length ) {
	return;
} ?>

<div class="portfolio-entry-excerpt clear">
	<?php wpsp_excerpt( array(
		'length'   => $excerpt_length,
		'readmore' => false,
	) ); ?>
</div><!-- .portfolio-entry-excerpt -->
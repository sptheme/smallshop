<?php
/**
 * Main portfolio entry template part
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Sanitize loop
$wpsp_loop = !empty( $wpsp_loop ) ? $wpsp_loop : 'archive';

// Make sure $wpsp_count is defined
if ( ! isset( $wpsp_count ) ) {
	global $wpsp_count;
}

// Add standard class
$classes = array();
$classes[] = 'portfolio-entry';
$classes[] = 'col';
$classes[] = wpsp_portfolio_column_class( $wpsp_loop );
$classes[] = 'col-' . $wpsp_count;

// Get grid style
$wpsp_grid_style = wpsp_get_redux( 'portfolio-archive-grid-style' , 'fit-rows');

// Masonry classes
if ( 'archive' == $wpsp_loop && in_array( $wpsp_grid_style, array( 'masonry', 'no-margins' ) ) ) {
	$classes[] = ' isotope-entry';
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes); ?>>
	<div class="portfolio-entry-inner clear">
		<?php
		// Include entry media, include is required to pass along $wpsp_loop var
		if ( $template = locate_template( 'partials/portfolio/portfolio-entry-media.php' ) ) {
			include( $template );
		}
		// Get entry content
		get_template_part( 'partials/portfolio/portfolio-entry-content' ); ?>
	</div>
</article>

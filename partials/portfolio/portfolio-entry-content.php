<?php
/**
 * Portfolio entry content template part
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if disabled for standard entries
if ( ! is_singular( 'portfolio' ) && ! wpsp_get_redux( 'portfolio-entry-details', true ) ) {
	return;
}

// Return if disabled for related entries
if ( is_singular( 'portfolio' ) && ! wpsp_get_redux( 'portfolio-related-excerpts', true ) ) {
	return;
}

// Entry content classes
$classes = 'portfolio-entry-details clear';
if ( wpsp_portfolio_match_height() ) {
	$classes .= ' match-height-content';
} ?>

<div class="<?php echo $classes; ?>">
	<?php get_template_part( 'partials/portfolio/portfolio-entry-title' ); ?>
	<?php get_template_part( 'partials/portfolio/portfolio-entry-excerpt' ); ?>
</div><!-- .portfolio-entry-details -->
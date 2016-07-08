<?php
/**
 * Outputs the portfolio entry title
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<h2 class="portfolio-entry-title entry-title">
    <a href="<?php wpsp_permalink(); ?>" title="<?php wpsp_esc_title(); ?>"><?php the_title(); ?></a>
</h2><!-- .portfolio-entry-title -->
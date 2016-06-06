<?php
/**
 * Portfolio single comments
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if comments are disabled
if ( ! comments_open() ) {
	return;
} ?>

<div id="portfolio-post-comments" class="clear">
	<?php comments_template(); ?>
</div><!-- #portfolio-post-comments -->
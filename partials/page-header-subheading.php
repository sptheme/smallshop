<?php
/**
 * Page subheading output
 *
 * @package WPSP_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display subheading if there is one
if ( $subheading = wpsp_get_page_subheading() ) : ?>

	<div class="clear page-subheading">
		<?php echo do_shortcode( $subheading ); ?>
	</div><!-- .page-subheading -->

<?php endif; ?>
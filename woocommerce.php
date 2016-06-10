<?php
/**
 * WooCommerce Default template
 *
 * @link https://docs.woothemes.com/documentation/plugins/woocommerce/
 *
 * @package Small_Shop
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<article class="entry-content entry clear">

				<?php woocommerce_content(); // WooCommerce content is added here ?>
				
			</article><!-- #post -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

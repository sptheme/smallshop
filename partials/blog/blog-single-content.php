<?php
/**
 * Single blog post content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="entry clear"<?php wpsp_schema_markup( 'entry_content' ); ?>>
	<?php the_content(); ?>
</div><!-- .entry -->

<?php get_template_part( 'partials/next-prev' ); ?>
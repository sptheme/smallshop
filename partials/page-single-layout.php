<?php
/**
 * Template part for displaying page content layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php $title_align = get_post_meta( get_the_ID(), 'wpsp_post_title_align', true ); ?>
		<h1 class="entry-title" style="text-align:<?php echo $title_align; ?>"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<?php
	// Check if page should display featured image
	if ( has_post_thumbnail() && wpsp_get_redux( 'is-page-featured-image' ) ) : ?>

		<div id="page-featured-img" class="clear">
			<?php
			// Dislpay full featured image
			wpsp_post_thumbnail( array(
				'size'  => 'full',
				'alt'   => wpsp_get_esc_title(),
			) ); ?>
		</div><!-- #page-featured-img -->

	<?php endif; ?>

	<div class="entry-content entry">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'partials/link-pages' ); ?>

	<?php
	if ( wpsp_get_redux('social-share-pages', true) ) {
		get_template_part( 'partials/social', 'share' ); 
	} ?>
	
</article><!-- #post-## -->


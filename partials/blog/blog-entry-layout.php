<?php
/**
 * Blog entry layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get post data
$post_format = get_post_format();
$entry_style = wpsp_blog_entry_style();

// Quote format is completely different
if ( 'quote' == $post_format ) :

	// Get quote entry content
	get_template_part( 'partials/blog/blog-entry-quote' );

	// Don't run any other code in this file
	return;

endif;

// Add classes to the blog entry post class - see framework/blog/blog-functions
$classes = wpsp_blog_entry_classes();

// Get layout blocks
$blocks = wpsp_blog_entry_layout_blocks(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

	<div class="blog-entry-inner clear">

		<?php
		// Thumbnail entry style uses different layout
		if ( 'thumbnail-entry-style' == $entry_style ) : ?>

			<?php
			// Get media
			get_template_part( 'partials/blog/media/blog-entry', $post_format ); ?>

			<div class="blog-entry-content entry-details clear">

				<?php
				// Loop through entry blocks
				foreach ( $blocks as $key => $value ) : ?>

					<?php
					// Display the entry title
					if ( 'title' == $key && !empty($value) ) { ?>

						<?php get_template_part( 'partials/blog/blog-entry-title' ); ?>

					<?php }
					
					// Display the entry meta
					elseif ( 'meta' == $key && !empty($value) ) { ?>

						<?php get_template_part( 'partials/blog/blog-entry-meta' ); ?>

					<?php }

					// Display the entry excerpt or content
					elseif ( 'excerpt_content' == $key && !empty($value) ) { ?>

						<?php get_template_part( 'partials/blog/blog-entry-content' ); ?>

					<?php }

					// Display the readmore button
					elseif ( 'readmore' == $key && !empty($value) ) { ?>

						<?php if ( wpsp_get_redux( 'is-auto-excerpt', true ) ) { ?>

							<?php get_template_part( 'partials/blog/blog-entry-readmore' ); ?>

						<?php }

					}

					// Display the readmore button
					elseif ( 'social_share' == $key && !empty($value) ) { ?>

						<?php get_template_part( 'partials/social-share' ) ?>

					<?php } ?>

				<?php
				// End block loop
				endforeach; ?>

			</div><!-- blog-entry-content -->

		<?php

		// Other entry styles
		else :
			
			// Loop through composer blocks and output layout
			foreach ( $blocks as $key => $value ) : ?>

				<?php
				// Featured media
				if ( 'featured_media' == $key && !empty($value) ) { ?>

					<?php get_template_part( 'partials/blog/media/blog-entry', $post_format ); ?>

				<?php }

				// Display the entry header
				elseif ( 'title' == $key && !empty($value) ) { ?>

					<?php get_template_part( 'partials/blog/blog-entry-title' ); ?>

				<?php }
				
				// Display the entry meta
				elseif ( 'meta' == $key && !empty($value) ) { ?>

					<?php get_template_part( 'partials/blog/blog-entry-meta' ); ?>

				<?php }

				// Display the entry excerpt or content
				elseif ( 'excerpt_content' == $key && !empty($value) ) { ?>

					<?php get_template_part( 'partials/blog/blog-entry-content' ); ?>

				<?php }

				// Display the readmore button
				elseif ( 'readmore' == $key && !empty($value) ) { ?>

					<?php if ( wpsp_get_redux( 'is-auto-excerpt', true ) ) { ?>

						<?php get_template_part( 'partials/blog/blog-entry-readmore' ); ?>

					<?php } ?>

				<?php }

				// Display the readmore button
				elseif ( 'social_share' == $key && !empty($value) ) { ?>

					<?php get_template_part( 'partials/social-share' ) ?>

				<?php } ?>

			<?php
			// End block loop
			endforeach; ?>

		<?php
		// End block check
		endif; ?>

	</div><!-- .blog-entry-inner -->

</article><!-- .blog-entry -->
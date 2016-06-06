<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<article class="single-blog-article clear"<?php wpsp_schema_markup( 'blog_post' ); ?>>
	<?php
	// Get single blog layout blocks
	$post_format       = get_post_format();
	$password_required = post_password_required();

	// Quote format is completely different
	if ( 'quote' == $post_format ) :

		get_template_part( 'partials/blog/blog-single-quote' );

		return;

	// Blog Single Post Composer
	else :

		// Get layout blocks
		$layout_blocks = wpsp_blog_single_layout_blocks();

		// Loop through blocks
		foreach ( $layout_blocks as $key => $value ) : 

			// Loop through post detail

			// Post title
			if ( 'title' == $key && !empty($value) ) {	
				get_template_part( 'partials/blog/blog-single-title' );
			}

			// Post meta
			elseif ( 'meta' == $key && !empty($value) ) {
				get_template_part( 'partials/blog/blog-single-meta' );
			}

			// Featured Media - featured image, video, gallery, etc
			elseif ( 'featured_media' == $key && !empty($value) ) {
				if ( ! $password_required && ! get_post_meta( get_the_ID(), 'wpsp_post_media_position', true ) ) {

					$post_format = $post_format ? $post_format : 'thumbnail';
					
					get_template_part( 'partials/blog/media/blog-single', $post_format );

				}
			}

			// Get post content
			elseif ( 'the_content' == $key && !empty($value) ) {
				get_template_part( 'partials/blog/blog-single-content' );
			}	

			// Post Tags
			elseif ( 'post_tags' == $key && !empty($value) && ! $password_required ) {
				get_template_part( 'partials/blog/blog-single-tags' );
			}
			
			// Social sharing links
			elseif ( 'social_share' == $key && !empty($value) && ! $password_required ) {	
				get_template_part( 'partials/social-share' );
			}

			// Author bio
			elseif ( 'author_bio' == $key && !empty($value) && ! $password_required ) {
				get_template_part( 'author-bio' );
			}

			// Displays related posts
			elseif ( 'related_posts' == $key && !empty($value) ) {
				get_template_part( 'partials/blog/blog-single-related' ); 
			}

			// Get the post comments & comment_form
			elseif ( 'comments' == $key && !empty($value) || comments_open() || get_comments_number() ) {
				comments_template();
			}

		endforeach;

	endif; ?>
</article>
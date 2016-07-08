<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package SmallShop
 */

get_header(); ?>
	
	<div id="content-wrap" class="container clear">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'partials/blog/blog-single-layout' );

			endwhile; // End of the loop.
			?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- #content-wrap -->
	
<?php get_footer(); ?>

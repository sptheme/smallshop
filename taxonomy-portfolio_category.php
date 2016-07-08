<?php
/**
 * The template for displaying Portfolio Category archives
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SmallShop
 */

get_header(); ?>

	<div id="content-wrap" class="container clear">
	
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<div id="portfolio-entries" class="<?php echo wpsp_get_portfolio_wrap_classes(); ?>">

					<?php $wpsp_count = 0; ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php $wpsp_count++; ?>

							<?php get_template_part( 'partials/portfolio/portfolio-entry' ); ?>

						<?php if ( $wpsp_count == wpsp_portfolio_archive_columns() ) $wpsp_count=0; ?>

					<?php endwhile; ?>

					<?php
					// Display post pagination (next/prev - 1,2,3,4..)
					wpsp_pagination(); ?>

				</div> <!-- #portfolio-entries -->

			<?php else : ?>
				
				<?php get_template_part( 'partials/content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- #content-wrap -->
	
<?php get_footer(); ?>

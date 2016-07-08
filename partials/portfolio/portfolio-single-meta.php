<?php
/**
 * Single portfolio meta
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get meta sections
$sections = wpsp_portfolio_single_meta_sections();

// Make sure the meta should display
if ( ! empty( $sections ) ) : ?>

	<ul id="portfolio-single-meta" class="meta clear">

		<?php
		// Loop through meta sections
		foreach ( $sections as $section ) : ?>

			<?php if ( 'date' == $section ) : ?>
				<li class="meta-date"><span class="fa fa-clock-o"></span><time class="updated" datetime="<?php the_date('Y-m-d');?>"<?php wpsp_schema_markup( 'publish_date' ); ?>><?php echo get_the_date(); ?></time></li>
			<?php endif; ?>

			<?php if ( 'author' == $section ) : ?>
				<li class="meta-author"><span class="fa fa-user"></span><span class="vcard author"<?php wpsp_schema_markup( 'author_name' ); ?>><?php the_author_posts_link(); ?></span></li>
			<?php endif; ?>

			<?php if ( 'categories' == $section && $categories = wpsp_get_list_post_terms( 'portfolio_category' ) ) : ?>
				<li class="meta-category"><span class="fa fa-folder-o"></span><?php echo $categories; ?></li>
			<?php endif; ?>

			<?php if ( 'comments' == $section && comments_open() && ! post_password_required() ): ?>
				<li class="meta-comments comment-scroll"><span class="fa fa-comment-o"></span><?php comments_popup_link( esc_html__( '0 Comments', 'smallshop' ), esc_html__( '1 Comment',  'comics-arts' ), esc_html__( '% Comments', 'smallshop' ), 'comments-link' ); ?></li>
			<?php endif; ?>

		<?php endforeach; ?>

	</ul><!-- #portfolio-single-meta -->

<?php endif; ?>
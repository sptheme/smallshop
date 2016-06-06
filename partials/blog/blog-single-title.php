<?php
/**
 * Single blog post title
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<header class="single-blog-header clear">
	<h1 class="single-post-title entry-title"<?php wpsp_schema_markup( 'headline' ); ?>><?php the_title(); ?></h1><!-- .single-post-title -->
</header><!-- .blog-single-header -->
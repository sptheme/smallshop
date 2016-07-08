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

// Vars
$text   = wpsp_get_translated_theme_mod( 'blog_entry_readmore_text' );
$text   = $text ? $text : esc_html__( 'Read More', 'smallshop' );

// Apply filters for child theming
$text = apply_filters( 'wpsp_post_readmore_link_text', $text );

// Button classes
$button_args = apply_filters( 'wpsp_blog_entry_button_args', array(
	'style' => '',
	'color' => '',
) ); ?>

<div class="blog-entry-readmore clear">
	<a href="<?php the_permalink(); ?>" class="<?php echo wpsp_get_button_classes( $button_args ); ?>" title="<?php echo $text ?>"><?php echo $text ?><span class="readmore-rarr hidden">&rarr;</span></a>
</div><!-- .blog-entry-readmore -->
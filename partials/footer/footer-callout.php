<?php
/**
 * Footer bottom content
 *
 * @package SmallShop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get post content
$content = wpsp_get_redux( 'callout-text' );

// Bail if content is empty
if ( ! $content ) {
	return;
}

// Get link
if ( $callout_link = wpsp_get_redux( 'callout-link' ) ) {
	$link = $callout_link;
} else {
	$link = esc_url( home_url( '/' ) );
}

// Get link text
if ( $callout_link_text = wpsp_get_redux( 'callout-link-text' ) ) {
	$link_text = $callout_link_text;
} else {
	$link_text = wpsp_get_redux( 'callout-link-text', 'Get In Touch' );
}

// If link is defined set target and rel
if ( $link ) {

	// Link target
	$target	= wpsp_get_redux( 'callout_button_target', 'blank' );
	$target	= ( 'blank' == $target ) ? ' target="_blank"' : '';

	// Link rel
	$rel = wpsp_get_redux( 'callout_button_rel', false );
	$rel = ( 'nofollow' == $rel ) ? ' rel="nofollow"' : '';

}

// Translate Theme mods
$content   = wpsp_translate_theme_mod( 'callout_text', $content );
$link      = wpsp_translate_theme_mod( 'callout_link', $link );
$link_text = wpsp_translate_theme_mod( 'callout_link_txt', $link_text ); ?>
	
<div id="callout-wrap" class="clear <?php echo wpsp_get_redux( 'callout_visibility', 'always-visible' ); ?>">

	<div id="callout" class="clear container">

		<div id="callout-left" class="callout-content clear <?php if ( ! $link ) echo 'full-width'; ?>">

			<?php echo do_shortcode( $content ); ?>

		</div><!-- #callout-left -->

		<?php
		// Display footer callout button if callout link & text options are not blank in the admin
		if ( $link ) : ?>

			<div id="callout-right" class="callout-button clear">

				<a href="<?php echo esc_url( $link ); ?>" class="theme-button" title="<?php echo esc_attr( $link_text ); ?>"<?php echo $target; ?><?php echo $rel; ?>><?php echo $link_text; ?></a>

			</div><!-- #callout-right -->

		<?php endif; ?>

	</div><!-- #callout -->

</div><!-- #callout-wrap -->	
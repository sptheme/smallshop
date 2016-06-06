<?php
/**
 * Header aside content used in Header Style Two, Three and Four
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get header style
$header_style = wpsp_get_redux( 'header-style' );

// Get content
$content = wpsp_get_redux( 'header-aside-content' );

// Display header aside if content exists or it's header style 2 and the main search is enabled
if ( $content || ( wpsp_get_redux( 'is-main-search', true ) && 'two' == $header_style ) ) :

	// Add classes
	$classes = 'clear';
	if ( $visibility = wpsp_get_redux( 'header-aside-visibility', 'visible-desktop' ) ) {
		$classes .= ' '. $visibility;
	}
	if ( $header_style ) {
		$classes .= ' header-'. $header_style .'-aside';
	} ?>

	<aside id="header-aside" class="<?php echo esc_attr( $classes ); ?>">

		<div class="header-aside-content clear">

			<?php echo do_shortcode( $content ); ?>

		</div><!-- .header-aside-content -->

		<?php
		// Show header search field if enabled in the theme options panel and it's header style 2
		if ( wpsp_get_redux( 'header-aside-search', true ) && 'two' == $header_style ) : ?>

			<div id="header-two-search" class="clear">
				<form method="get" class="header-two-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" id="header-two-search-input" name="s" value="<?php esc_attr_e( 'search', 'wpsp-blog-textdomain' ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>
					<button type="submit" value="" id="header-two-search-submit" />
						<span class="fa fa-search"></span>
					</button>
				</form><!-- #header-two-searchform -->
			</div><!-- #header-two-search -->

		<?php endif; ?>

	</aside><!-- #header-two-aside -->

<?php endif; ?>
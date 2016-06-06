<?php
/**
 * Footer Layout
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php wpsp_hook_footer_before(); ?>

<?php if ( wpsp_get_redux( 'is-footer-widgets', true ) ) : ?>

<footer id="colophon" class="site-footer" role="contentinfo"<?php wpsp_schema_markup( 'footer' ); ?>>
	
	<?php wpsp_hook_footer_top(); ?>

	<div id="footer-inner" class="container clear">

		<?php wpsp_hook_footer_inner(); // widgets are added via this hook ?>

	</div>	

	<?php wpsp_hook_footer_bottom(); ?>

</footer><!-- #colophon -->

<?php endif; ?>

<?php wpsp_hook_footer_after(); ?>
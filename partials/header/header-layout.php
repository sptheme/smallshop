<?php
/**
 * Header layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Small_Shop
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'wpspblog' ); ?></a>

<?php wpsp_hook_header_before(); ?>

<header id="site-header" class="site-header <?php echo wpsp_header_classes(); ?>"<?php wpsp_schema_markup( 'header' ); ?> role="banner">
	
	<?php wpsp_hook_header_top(); ?>

	<div id="site-header-inner" class="container clear">

		<?php wpsp_hook_header_inner(); ?>

	</div> <!-- .container .clear -->

	<?php wpsp_hook_header_bottom(); ?>

</header><!-- #masthead -->

<?php wpsp_hook_header_after(); ?>
<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SmallShop
 */

?>

<?php if ( in_array( wpsp_post_layout(), array( 'full-screen', 'full-width' ) ) ) {
		return;
	} ?>

<?php $choice_sidebar = wpsp_sidebar_primary(); ?>
<?php if ( ! is_active_sidebar( $choice_sidebar ) ) {
		return;
	} ?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar($choice_sidebar); ?>
</div><!-- #secondary -->

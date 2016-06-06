<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Small_Shop
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?><?php wpsp_schema_markup( 'body' ); ?>>

<?php wpsp_outer_wrap_before(); ?>

<div id="page" class="site clear">

	<?php wpsp_hook_wrap_before(); ?>

	<div id="wrap" class="clear">

		<?php wpsp_hook_wrap_top(); ?>

		<?php wpsp_hook_content_before(); ?>

		<div id="content" class="site-content container clear">

			<?php wpsp_hook_content_top(); ?>

<?php
/**
 * Setup theme hooks
 *
 * @package SmallShop
 */

/**
 * Outer Wrap Hooks
 *
 * @since 1.0.0
 */
function wpsp_outer_wrap_before() {
	do_action( 'wpsp_outer_wrap_before' );
}
function wpsp_outer_wrap_after() {
	do_action( 'wpsp_outer_wrap_after' );
}


/**
 * Topbar Hooks
 *
 * @since 21.0.0
 */
function wpsp_hook_topbar_before() {
	do_action( 'wpsp_hook_topbar_before' );
}
function wpsp_hook_topbar_after() {
	do_action( 'wpsp_hook_topbar_after' );
}

/**
 * Wrap Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_wrap_before() {
	do_action( 'wpsp_hook_wrap_before' );
}
function wpsp_hook_wrap_top() {
	do_action( 'wpsp_hook_wrap_top' );
}
function wpsp_hook_wrap_bottom() {
	do_action( 'wpsp_hook_wrap_bottom' );
}
function wpsp_hook_wrap_after() {
	do_action( 'wpsp_hook_wrap_after' );
}

/**
 * Main Header Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_header_before() {
	do_action( 'wpsp_hook_header_before' );
}
function wpsp_hook_header_top() {
	do_action( 'wpsp_hook_header_top' );
}
function wpsp_hook_header_inner() {
	do_action( 'wpsp_hook_header_inner' );
}
function wpsp_hook_header_bottom() {
	do_action( 'wpsp_hook_header_bottom' );
}
function wpsp_hook_header_after() {
	do_action( 'wpsp_hook_header_after' );
}

/**
 * Main Menu Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_main_menu_before() {
	do_action( 'wpsp_hook_main_menu_before' );
}
function wpsp_hook_main_menu_top() {
	do_action( 'wpsp_hook_main_menu_top' );
}
function wpsp_hook_main_menu_bottom() {
	do_action( 'wpsp_hook_main_menu_bottom' );
}
function wpsp_hook_main_menu_after() {
	do_action( 'wpsp_hook_main_menu_after' );
}

/**
 * Main Content Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_content_before() {
	do_action( 'wpsp_hook_content_before' );
}
function wpsp_hook_content_top() {
	do_action( 'wpsp_hook_content_top' );
}
function wpsp_hook_content_bottom() {
	do_action( 'wpsp_hook_content_bottom' );
}
function wpsp_hook_content_after() {
	do_action( 'wpsp_hook_content_after' );
}

/**
 * Footer Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_footer_before() {
	do_action( 'wpsp_hook_footer_before' );
}
function wpsp_hook_footer_top() {
	do_action( 'wpsp_hook_footer_top' );
}
function wpsp_hook_footer_inner() {
	do_action( 'wpsp_hook_footer_inner' );
}
function wpsp_hook_footer_bottom() {
	do_action( 'wpsp_hook_footer_bottom' );
}
function wpsp_hook_footer_after() {
	do_action( 'wpsp_hook_footer_after' );
}
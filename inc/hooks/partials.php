<?php
/**
 * These functions are used to load template parts (partials) when used within action hooks,
 * and they probably should never be updated or modified.
 *
 * @package WPSP_Blog
 */

/*-------------------------------------------------------------------------------*/
/* #  Toggle Bar
/*-------------------------------------------------------------------------------*/

/**
 * Get togglebar layout template part if enabled.
 *
 * @since 1.0.0
 */
function wpsp_toggle_bar() {
	if ( wpsp_get_redux( 'has-togglebar' ) ) {
		get_template_part( 'partials/togglebar/togglebar-layout' );
	}
}

/**
 * Get togglebar button template part.
 *
 * @since 1.0.0
 */
function wpsp_toggle_bar_button() {
	if ( wpsp_get_redux( 'has-togglebar' ) ) {
		get_template_part( 'partials/togglebar/togglebar-button' );
	}

}

/*-------------------------------------------------------------------------------*/
/* #  Top Bar
/*-------------------------------------------------------------------------------*/

/**
 * Get Top Bar layout template part if enabled.
 *
 * @since 1.0.0
 */
function wpsp_top_bar() {
	if ( wpsp_get_redux( 'has-top_bar' ) || wpsp_get_redux( 'top-bar-social-alt' ) ) {
		get_template_part( 'partials/topbar/topbar-layout' );
	}
}

/*-------------------------------------------------------------------------------*/
/* #  Header
/*-------------------------------------------------------------------------------*/

/**
 * Get the header template part if enabled.
 *
 * @since 1.0.0
 */
function wpsp_header() {
	if ( wpsp_get_redux( 'enable-header' ) ) {
		get_template_part( 'partials/header/header-layout' );
	}
}

/**
 * Get the header logo template part.
 *
 * @since 1.0.0
 */
function wpsp_header_logo() {
	get_template_part( 'partials/header/header-logo' );
}

/**
 * Get the header aside content template part.
 *
 * @since 1.0.0
 */
function wpsp_header_aside() {
	if ( wpsp_header_supports_aside() ) {
		get_template_part( 'partials/header/header-aside' );
	}
}

/**
 * Get header search dropdown template part.
 *
 * @since 1.0.0
 */
function wpsp_search_dropdown() {

	// Make sure site is set to dropdown style
	if ( 'drop_down' != wpsp_get_redux( 'menu-search-style' ) ) {
		return;
	}

	// Get header style
	$header_style = wpsp_get_redux( 'header-style' );

	// Get current filter
	$filter = current_filter();

	// Set get variable to false by default
	$get = false;

	// Check current filter against header style
	if ( 'wpsp_hook_header_inner' == $filter ) {
		if ( 'one' == $header_style || 'five' == $header_style ) {
			$get = true;
		}
	} elseif ( 'wpsp_hook_main_menu_bottom' == $filter ) {
		if ( 'two' == $header_style || 'three' == $header_style || 'four' == $header_style ) {
			$get = true;
		}
	}

	// Get search dropdown template part
	if ( $get ) {
		get_template_part( 'partials/search/header-search-dropdown' );
	}

}

/**
 * Get header search replace template part.
 *
 * @since 1.0.0
 */
function wpsp_search_header_replace() {
	if ( 'header_replace' == wpsp_get_redux( 'menu-search-style' ) ) {
		get_template_part( 'partials/search/header-search-replace' );
	}
}

/**
 * Gets header search overlay template part.
 *
 * @since 1.0.0
 */
function wpsp_search_overlay() {
	if ( 'overlay' == wpsp_get_redux( 'menu-search-style' ) ) {
		get_template_part( 'partials/search/header-search-overlay' );
	}
}

/**
 * Overlay Header Wrap Open
 *
 * @since 1.0.0
 */
function wpsp_overlay_header_wrap_open() {
	if ( wpsp_get_redux( 'has-overlay-header' ) ) {
		echo '<div id="overlay-header-wrap" class="clear">';
	}
}

/**
 * Overlay Header Wrap Close
 *
 * @since 1.0.0
 */
function wpsp_overlay_header_wrap_close() {
	if ( wpsp_get_redux( 'has-overlay-header' ) ) {
		echo '</div><!-- .overlay-header-wrap -->';
	}
}

/*-------------------------------------------------------------------------------*/
/* # Menu
/*-------------------------------------------------------------------------------*/

/**
 * Outputs the main header menu
 *
 * @since 1.0.0
 */
function wpsp_header_menu() {

	// Set vars
	$header_style = wpsp_get_redux( 'header-style' );
	$filter       = current_filter();
	$get          = false;

	// Header Inner Hook
	if ( 'wpsp_hook_header_inner' == $filter ) {
		if ( ( 'one' == $header_style || 'five' == $header_style || 'six' == $header_style ) ) {
			$get = true;
		}
	}

	// Header Top Hook
	elseif ( 'wpsp_hook_header_top' == $filter ) {
		if (  'four' == $header_style ) {
			$get = true;
		}
	}

	// Header bottom hook
	elseif ( 'wpsp_hook_header_bottom' == $filter ) {
		if ( ( 'two' == $header_style || 'three' == $header_style ) ) {
			$get = true;
		}
	}

	// Get menu template part
	if ( $get ) {
		get_template_part( 'partials/header/header-menu' );
	}

}

/*-------------------------------------------------------------------------------*/
/* ##  Menu > Mobile
/*-------------------------------------------------------------------------------*/

/**
 * Gets the template part for the fixed top mobile menu style
 *
 * @since 1.0.0
 */
function wpsp_mobile_menu_fixed_top() {
	if ( wpsp_get_redux( 'is-responsive' )
		&& 'disabled' != wpsp_get_redux( 'mobile-menu-style' )
		&& 'fixed_top' == wpsp_get_redux( 'mobile-menu-toggle-style' )
	) {
		get_template_part( 'partials/header/header-menu-mobile-fixed-top' );
	}
}

/**
 * Gets the template part for the navbar mobile menu_style
 *
 * @since 1.0.0
 */
function wpsp_mobile_menu_navbar() {

	// Get var
	$get = false;

	// Current filter
	$filter = current_filter();

	// Check overlay header
	$has_overlay_header = wpsp_get_redux( 'has-overlay-header' );

	// Overlay header should display above and others below
	if ( $filter == 'wpsp_outer_wrap_before' && $has_overlay_header ) {
		$get = true;
	} elseif ( $filter == 'wpsp_hook_header_bottom' && ! $has_overlay_header ) {
		$get = true;
	}

	// Get mobile menu navbar
	if ( $get
		&& wpsp_get_redux( 'is-responsive' )
		&& 'disabled' != wpsp_get_redux( 'mobile-menu-style' )
		&& 'navbar' == wpsp_get_redux( 'mobile-menu-toggle-style' )
	) {
		get_template_part( 'partials/header/header-menu-mobile-navbar' );
	}

}

/**
 * Gets the template part for the "icons" style mobile menu.
 *
 * @since 1.0.0
 */
function wpsp_mobile_menu_icons() {
	$style = wpsp_get_redux( 'mobile-menu-toggle-style' );
	if ( wpsp_get_redux( 'is-responsive' )
		&& 'disabled' != wpsp_get_redux( 'mobile-menu-style' )
		&& ( 'icon_buttons' == $style || 'icon_buttons_under_logo' == $style )
	) {
		get_template_part( 'partials/header/header-menu-mobile-icons' );
	}
}

/**
 * Get mobile menu alternative if enabled.
 *
 * @since 1.0.0
 */
function wpsp_mobile_menu_alt() {
	if ( wpsp_get_redux( 'is-responsive' )
		&& 'disabled' != wpsp_get_redux( 'mobile-menu-style' )
		&& has_nav_menu( 'mobile_menu_alt' )
	) {
		get_template_part( 'partials/header/header-menu-mobile-alt' );
	}
}

/**
 * Adds a hidden searchbox in the footer for use with the mobile menu
 *
 * @since 1.0.0
 */
function wpsp_mobile_searchform() {
	if ( wpsp_get_redux( 'is-mobile-menu-search', true ) ) {
		get_template_part( 'partials/search/mobile-searchform' );
	}
}


/**
 * Sidr Close button
 *
 * @since 1.0.0
 */
function wpsp_sidr_close() { ?>
	<?php if ( 'sidr' == wpsp_get_redux( 'mobile-menu-style' ) ) : ?>
		<div id="sidr-close"><a href="#sidr-close" class="toggle-sidr-close"></a></div>
	<?php endif; ?>
<?php }


/*-------------------------------------------------------------------------------*/
/* #  Footer
/*-------------------------------------------------------------------------------*/

/**
 * Gets the footer callout template part.
 *
 * @since 1.0.0
 */
function wpsp_footer_callout() {
	if ( wpsp_get_redux( 'has-footer-callout' ) ) {
		get_template_part( 'partials/footer/footer-callout' );
	}
}

/**
 * Gets the footer layout template part.
 *
 * @since 1.0.0
 */
function wpsp_footer() {
	if ( wpsp_get_redux( 'has-footer' ) ) {
		get_template_part( 'partials/footer/footer-layout' );
	}
}

/**
 * Get the footer widgets template part.
 *
 * @since 1.0.0
 */
function wpsp_footer_widgets() {
	get_template_part( 'partials/footer/footer-widgets' );
}

/**
 * Gets the footer bottom template part.
 *
 * @since 1.0.0
 */
function wpsp_footer_bottom() {
	if ( wpsp_get_redux( 'has-footer-bottom', true ) ) {
		get_template_part( 'partials/footer/footer-bottom' );
	}
}

/**
 * Gets the scroll to top button template part.
 *
 * @since 1.0.0
 */
function wpsp_scroll_top() {
	get_template_part( 'partials/scroll-top' );
}

/*-------------------------------------------------------------------------------*/
/* -  Other
/*-------------------------------------------------------------------------------*/

/**
 * Returns social sharing template part
 *
 * @since 1.0.0
 */
function wpsp_social_share() {
	get_template_part( 'partials/social-share' );
}
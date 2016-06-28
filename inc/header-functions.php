<?php
/**
 * Site Header Helper Functions
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPSP_Blog
 */

/**
 * Check if the header supports aside content
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_supports_aside' ) ) :
function wpsp_header_supports_aside( $header_style = '' ) {

	// False by default
	$bool = false;

	// Get header style
	$header_style = $header_style ? $header_style : wpsp_get_redux( 'header-style' );

	// Validate
	if ( 'two' == $header_style || 'three' == $header_style || 'four' == $header_style ) {
		$bool = true;
	}

	// Apply filters and return
	return apply_filters( 'wpsp_header_supports_aside', $bool );

}
endif;

/**
 * Add classes to the header wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_classes' ) ) :
function wpsp_header_classes() {

	// Vars
	$header_style = wpsp_get_redux( 'header-style' );

	// Setup classes array
	$classes = array();

	// Main header style
	$classes['header_style'] = 'header-'. $header_style;

	// Full width header
	if ( wpsp_get_redux( 'is-full-width-header' ) ) {
		$classes[] = 'wpsp-full-width';
	}

	// Sticky Header
	if ( wpsp_get_redux( 'is-fixed-header' ) && ( 'one' == $header_style || 'five' == $header_style ) ) {
		$classes['fixed_scroll'] = 'fixed-scroll';
		if ( wpsp_get_redux( 'is-shrink-fixed-header' ) ) {
			$classes['wpsp-shrink-sticky-header'] = 'wpsp-shrink-sticky-header';
		}	
	}

	// Reposition cart and search dropdowns
	if ( 'three' == $header_style || 'five' == $header_style ) {
		$classes[] = 'wpsp-reposition-cart-search-drops';
	}

	// Dropdown style (must be added here so we can target shop/search dropdowns)
	if ( $dropdown_style = wpsp_get_redux( 'menu_dropdown_style' ) ) {
		$classes['wpsp-dropdown-style-'. $dropdown_style] = 'wpsp-dropdown-style-'. $dropdown_style;
	}

	// Header Overlay Style
	if ( wpsp_get_redux( 'has-overlay-header' ) ) {

		// Dark dropdowns for overlay header
		unset( $classes['wpsp-dropdown-style-'. $dropdown_style] );
		$classes[] = 'wpsp-dropdown-style-black';

		// Remove fixed scroll class
		if ( wpsp_get_redux( 'has-top-bar', true )  ) {
			//unset( $classes['fixed_scroll'] );
			//unset( $classes['wpsp-shrink-sticky-header'] );
		}

		// Add overlay header class
		$classes[] = 'overlay-header';

		// Add a fixed class for the overlay-header style only
		if ( wpsp_get_redux( 'is-fixed-header' ) ) {
			$classes[] = 'fix-overlay-header';
		}

		// Add overlay header class
		$classes[] = 'overlay-header';

		// Add overlay header style class
		$overlay_style = wpsp_get_redux( 'header-overlay-style' );
		$overlay_style = $overlay_style ? $overlay_style : 'light';
		$classes[] = $overlay_style .'-style';

	}


	// Clearfix class
	$classes[] = 'clear';

	// Set keys equal to vals
	$classes = array_combine( $classes, $classes );
	
	// Apply filters for child theming
	$classes = apply_filters( 'wpsp_header_classes', $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	// return classes
	return $classes;

}
endif;

/**
 * Returns header logo title
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_logo_title' ) ) :
function wpsp_header_logo_title() {
	$title = get_bloginfo( 'name' );
	$title = apply_filters( 'wpsp_logo_title', $title );
	return $title;
}
endif;

/**
 * Returns header logo URL
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_logo_url' ) ) :
function wpsp_header_logo_url() {
	$url = esc_url( home_url( '/' ) );
	$url = apply_filters( 'wpsp_logo_url', $url );
	return $url;
}
endif;

/**
 * Header logo classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_logo_classes' ) ) :
function wpsp_header_logo_classes() {

	// Define classes array
	$classes = array( 'site-branding', 'clr' );

	// Default class
	$classes[] = 'header-'. wpsp_get_redux( 'header-style' ) .'-logo';

	// Apply filters for child theming
	$classes = apply_filters( 'wpsp_header_logo_classes', $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	// Return classes
	return $classes;

}
endif;

function wpsp_body_classes( $classes ) {

	global $post;

	// Save some vars
	$main_layout  = wpsp_get_redux( 'main-layout' );
	$header_style = wpsp_get_redux( 'header-style' );
	$post_layout  = wpsp_post_layout();
	$global_layout = wpsp_get_redux( 'layout-global' );
	$post_id      = is_singular() ? $post->ID : NULL;

	// RTL
	if ( is_RTL() ) {
		$classes[] = 'rtl';
	}

	// Customizer
	if ( is_customize_preview() ) {
		$classes[] = 'is_customize_preview';
	}
	
	// Main class
	$classes[] = 'wpsp-theme';

	// Responsive
	if ( wpsp_get_redux( 'is-responsive' ) ) {
		$classes[] = 'wpsp-responsive';
	}

	// Layout Style
	$classes[] = $main_layout .'-main-layout';
	
	// Vertical header style
	if ( 'six' == $header_style) {
		$classes[] = 'wpsp-has-vertical-header';
		if ( 'fixed' == wpsp_get_redux( 'vertical-header-style' ) ) {
			$classes[] = 'wpsp-fixed-vertical-header';
		}
	}

	// Boxed Layout dropshadow
	if ( 'boxed' == $main_layout
		&& wpsp_get_redux( 'boxed-dropdshadow' )
	) {
		$classes[] = 'wrap-boxshadow';
	}

	// Sidebar enabled
	if ( 'left-sidebar' == $post_layout || 'right-sidebar' == $post_layout || 'left-sidebar' == $global_layout || 'right-sidebar' == $global_layout ) { 
		$classes[] = 'has-sidebar';
	} 

	// Content layout
	if ( $post_layout ) {
		$classes[] = $post_layout;
	}

	// Single Post cagegories
	if ( is_singular( 'post' ) ) {
		$cats = get_the_category( $post_id );
		foreach ( $cats as $cat ) {
			$classes[] = 'post-in-category-'. $cat->category_nicename;
		}
	}

	// Topbar
	if ( wpsp_get_redux( 'has-top-bar', false ) ) {
		$classes[] = 'has-topbar';
	}

	// Widget Icons
	if ( wpsp_get_redux( 'has-widget-icons', true ) ) {
		$classes[] = 'sidebar-widget-icons';
	}

	// Overlay header style
	if ( wpsp_get_redux( 'has-overlay-header' ) ) {
		$classes[] = 'has-overlay-header';
	}

	// Footer reveal
	if ( wpsp_get_redux( 'has-footer-reveal' ) ) {
		$classes[] = 'footer-has-reveal';
	}

	// Disabled main header
	if ( ! wpsp_get_redux( 'enable-header' ) ) {
		$classes[] = 'wpsp-site-header-disabled';
	}

	// Mobile menu toggle style
	$classes[] = 'wpsp-mobile-toggle-menu-'. wpsp_get_redux( 'mobile-menu-toggle-style' );

	// Mobile menu style
	if ( 'disabled' == wpsp_get_redux( 'mobile-menu-style' ) ) {
		$classes[] = 'mobile-menu-disabled';
	} else {
		$classes[] = 'has-mobile-menu';
	}

	// Navbar inner span bg
	if ( wpsp_get_redux( 'menu-link-span-background' ) ) {
		$classes[] = 'navbar-has-inner-span-bg';
	}

	// Check if avatars are enabled
	if ( is_singular() && ! get_option( 'show_avatars' ) ) {
		$classes[] = 'comment-avatars-disabled';
	}
	
	// Return classes
	return $classes;

}
add_filter( 'body_class', 'wpsp_body_classes' );

function wpsp_post_layout() {
	
	global $post;

	// Define variables
	$class  = 'right-sidebar';
	$meta   = get_post_meta( $post->ID, 'wpsp_layout', true );

	// Check meta first to override and return (prevents filters from overriding meta)
	if ( isset( $meta ) && !empty( $meta ) && $meta != 'inherit' ) {
		$class = $meta;
	}
	
	// Singular Page
	if ( is_page() ) {

		// Attachment
		if ( is_attachment() ) {
			$class = 'full-width';
		} 

		// All other pages
		else {
			$class = wpsp_get_redux( 'page-layout', 'right-sidebar' );	
		}
	}

	// Singular Post
	elseif ( is_singular( 'post' ) && ( wpsp_get_redux('single-layout') !='inherit' ) ) {

		$class = wpsp_get_redux( 'single-layout', 'right-sidebar' );

	}

	// Attachment
	elseif ( is_singular( 'attachment' ) ) {

		 $class = 'full-width';

	}

	// Home
	elseif ( is_home() ) {
		$class = wpsp_get_redux( 'archive-layout', 'right-sidebar' );
	}

	// Search
	elseif ( is_search() ) {
		$class = get_theme_mod( 'search-layout', 'right-sidebar' );
	}

	// Standard Categories
	elseif ( is_category() ) {
		$class = wpsp_get_redux( 'archives-layout', 'right-sidebar' );
		$term  = get_query_var( 'cat' );
		if ( $term_data = get_option( "category_$term" ) ) {
			if ( ! empty( $term_data['wpsp_term_layout'] ) ) {
				$class = $term_data['wpsp_term_layout'];
			}
		}
	}

	// Archives
	elseif (
		is_tag()
		|| is_date()
		|| is_author()
		|| ( is_tax( 'post_format' ) && 'post' == get_post_type() ) 
	) {
		$class = wpsp_get_redux( 'archives-layout', 'right-sidebar' );
	}
	
	// 404 page
	elseif ( is_404() ) {
		$class = 'full-width';
	}

	// All else
	else {
		$class = wpsp_get_redux( 'layout-global', 'right-sidebar' );
	}

	// Class should never be empty
	if ( empty( $class ) ) {
		$class = wpsp_get_redux( 'layout-global', 'right-sidebar' );
	}

	// Apply filters and return
	return apply_filters( 'wpsp_post_layout_class', $class );
}
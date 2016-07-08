<?php
/**
 * Helper awesome overlays for image hovers
 *
 * @package SmallShop
 */

/**
 * Displays the Overlay HTML
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_overlay' ) ) {
	function wpsp_overlay( $position = 'inside_link', $style = '', $args = array() ) {

		// If style is set to none lets bail
		if ( 'none' == $style ) {
			return;
		}

		// If style not defined get correct style based on theme_mods
		elseif ( ! $style ) {
			$style = wpsp_overlay_style();
		}

		// If style is defined lets locate and include the overlay template
		if ( $style ) {

			// Load the overlay template
			$overlays_dir = 'partials/overlays/';
			$template = $overlays_dir . $style .'.php';
			$template = locate_template( $template, false );

			// Only load template if it exists
			if ( $template ) {
				include( $template );
			}

		}

	}
}

/**
 * Create an array of overlay styles so they can be altered via child themes
 *
 * @since 1.0.0
 */
function wpsp_overlay_styles_array( $style = NULL ) {
	$array = array(
		''                              => esc_html__( 'None', 'smallshop' ),
		'hover-button'                  => esc_html__( 'Hover Button', 'smallshop' ),
		'magnifying-hover'              => esc_html__( 'Magnifying Glass Hover', 'smallshop' ),
		'plus-hover'                    => esc_html__( 'Plus Icon Hover', 'smallshop' ),
		'plus-two-hover'                => esc_html__( 'Plus Icon #2 Hover', 'smallshop' ),
		'plus-three-hover'              => esc_html__( 'Plus Icon #3 Hover', 'smallshop' ),
		'title-bottom'                  => esc_html__( 'Title Bottom', 'smallshop' ),
		'title-bottom-see-through'      => esc_html__( 'Title Bottom See Through', 'smallshop' ),
		'title-excerpt-hover'           => esc_html__( 'Title + Excerpt Hover', 'smallshop' ),
		'title-category-hover'          => esc_html__( 'Title + Category Hover', 'smallshop' ),
		'title-category-visible'        => esc_html__( 'Title + Category Visible', 'smallshop' ),
		'title-date-hover'              => esc_html__( 'Title + Date Hover', 'smallshop' ),
		'title-date-visible'            => esc_html__( 'Title + Date Visible', 'smallshop' ),
		'slideup-title-white'           => esc_html__( 'Slide-Up Title White', 'smallshop' ),
		'slideup-title-black'           => esc_html__( 'Slide-Up Title Black', 'smallshop' ),
		'category-tag'                  => esc_html__( 'Category Tag', 'smallshop' ),
	);
	return apply_filters( 'wpsp_overlay_styles_array', $array );
}

/**
 * Returns the overlay type depending on your theme options & post type
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_overlay_style' ) ) {
	function wpsp_overlay_style( $style = '' ) {
		$style = $style ? $style : get_post_type();
		if ( 'portfolio' == $style ) {
			$style = wpsp_get_redux( 'portfolio-entry-overlay-style' );
		} elseif ( 'staff' == $style ) {
			$style = wpsp_get_redux( 'staff-entry-overlay-style' );
		}
		return apply_filters( 'wpsp_overlay_style', $style );
	}
}

/**
 * Returns the correct overlay Classname
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_overlay_classes' ) ) {
	function wpsp_overlay_classes( $style = '' ) {

		// Return if style is none
		if ( 'none' == $style ) {
			return;
		}

		// Sanitize style
		$style = $style ? $style : wpsp_overlay_style();

		// Return classes
		if ( $style ) {
			return 'overlay-parent overlay-parent-'. $style;
		}
		
	}
}
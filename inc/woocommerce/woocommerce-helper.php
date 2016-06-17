<?php
/**
 * WooCommerce helper functions
 * This functions only load if WooCommerce is enabled because
 * they should be used within Woo loops only.
 *
 * @package Small_Shop
 * @subpackage WooCommerce
 * @version 1.0.0
 */


/*-------------------------------------------------------------------------------*/
/* [ Condition ]
/*-------------------------------------------------------------------------------*/

/**
 * Checks if on the WooCommerce shop page.
 *
 * @since 1.0.0
 */
function wpsp_is_woo_shop() {
	if ( ! WPSP_WOOCOMMERCE_ACTIVE ) {
		return false;
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		return true;
	}
}

/**
 * Checks if on a WooCommerce tax.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_is_woo_tax' ) ) {
	function wpsp_is_woo_tax() {
		if ( ! WPSP_WOOCOMMERCE_ACTIVE ) {
			return false;
		} elseif ( ! is_tax() ) {
			return false;
		} elseif ( function_exists( 'is_product_category' ) && function_exists( 'is_product_tag' ) ) {
			if ( is_product_category() || is_product_tag() ) {
				return true;
			}
		}
	}
}

/**
 * Checks if on singular WooCommerce product post.
 *
 * @since 1.0.0
 */
function wpsp_is_woo_single() {
	if ( ! WPSP_WOOCOMMERCE_ACTIVE ) {
		return false;
	} elseif ( is_woocommerce() && is_singular( 'product' ) ) {
		return true;
	}
}

/**
 * Outputs placeholder image
 *
 * @since 1.0.0
 */
function wpsp_woo_placeholder_img() {
	if ( function_exists( 'wc_placeholder_img_src' ) && wc_placeholder_img_src() ) {
		$placeholder = '<img src="'. wc_placeholder_img_src() .'" alt="'. esc_attr__( 'Placeholder Image', 'total' ) .'" class="woo-entry-image-main" />';
		$placeholder = apply_filters( 'wpsp_woo_placeholder_img_html', $placeholder );
		if ( $placeholder ) {
			echo $placeholder;
		}
	}
}

/**
 * Check if product is in stock
 *
 * @since 1.0.0
 */
function wpsp_woo_product_instock( $post_id = '' ) {
	global $post;
	$post_id      = $post_id ? $post_id : $post->ID;
	$stock_status = get_post_meta( $post_id, '_stock_status', true );
	if ( 'instock' == $stock_status ) {
		return true;
	} else {
		return false;
	}
}
<?php
/**
 * Perform all main WooCommerce configurations for this theme
 *
 * @package Small_Shop
 * @subpackage WooCommerce
 * @version 1.0.0
 */

// Define global var for class, make child theme easier/possible
global $wpsp_woocommerce_config;

// Start and run
if ( ! class_exists( 'WPSP_WooCommerce_Config' ) ) {
	
	class WPSP_WooCommerce_Config {

		/**
		* Main class constructor
		*/
		function __construct(){
			include_once( WPSP_INC_DIR . 'woocommerce/woocommerce-helper.php' );

			// Register Woo Sidebar
			add_filter( 'widgets_init', array( $this, 'register_woo_sidebar' ) );

			if ( ! is_admin() ) {
				// Display correct sidebar for products
				add_filter( 'wpsp_sidebar_primary', array( $this, 'display_woo_sidebar' ) );

				// Set correct post layouts
				add_filter( 'wpsp_layout_class', array( $this, 'layouts' ) );
			}
		}

		/**
		* Register WooCommerce Sidebar
		*
		* @since 1.0.0
		*/
		public static function register_woo_sidebar() {
			// Get correct sidebar heading tag
			$sidebar_headings = wpsp_get_redux( 'sidebar-headings', 'div' );
			$sidebar_headings = $sidebar_headings ? $sidebar_headings : 'div';

			// Register new woo_sidebar widget area
			register_sidebar( array (
				'name'          => esc_html__( 'WooCommerce Sidebar', 'wpsp-blog-textdomain' ),
				'id'            => 'woo_sidebar',
				'before_widget' => '<div class="widget %2$s clear">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $sidebar_headings .' class="widget-title">',
				'after_title'   => '</'. $sidebar_headings .'>',
			) );
		}

		/**
		 * Display WooCommerce sidebar.
		 *
		 * @since 1.0.0
		 */
		public static function display_woo_sidebar( $sidebar ) {

			// Alter sidebar display to show woo_sidebar where needed
			if ( is_woocommerce() && is_active_sidebar( 'woo_sidebar' ) ) {
				$sidebar = 'woo_sidebar';
			}

			// Return correct sidebar
			return $sidebar;

		}

		/**
		 * Tweaks the post layouts for WooCommerce archives and single product posts.
		 *
		 * @since 1.0.0
		 */
		public static function layouts( $class ) {
			if ( wpsp_is_woo_shop() ) {
				$class = 'full-width'; // wpsp_get_redux( 'woo_shop_layout', 'full-width' );
			} elseif ( wpsp_is_woo_tax() ) {
				$class = 'full-width'; // wpsp_get_redux( 'woo_shop_layout', 'full-width' );
			} elseif ( wpsp_is_woo_single() ) {
				$class = 'full-width'; //wpsp_get_redux( 'woo_product_layout', 'full-width' );
			}
			return $class;
		}
	}

}

$wpsp_woocommerce_config = new WPSP_WooCommerce_Config();
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

			// Scripts
			add_action( 'woocommerce_enqueue_styles', array( $this, 'remove_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'remove_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_custom_css' ) );

			// Social share
			add_action( 'woocommerce_after_single_product_summary', 'wpsp_social_share', 11 );

			// Product entries
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_out_of_stock_badge' ) );

			// Product post
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'clear_summary_floats' ), 1 );
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

		/**
		 * Remove WooCommerce styles not needed for this theme.
		 *
		 * @since 1.0.0
		 * @link  http://docs.woothemes.com/document/disable-the-default-stylesheet/
		 */
		public static function remove_styles( $enqueue_styles ) {
			unset( $enqueue_styles['woocommerce-layout'] );
			unset( $enqueue_styles['woocommerce_prettyPhoto_css'] );
			return $enqueue_styles;
		}

		/**
		 * Remove WooCommerce scripts.
		 *
		 *
		 * @since 1.0.0
		 */
		public static function remove_scripts() {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
		}

		/**
		 * Add Custom WooCommerce CSS.
		 *
		 * @since 1.0.0
		 */
		public static function add_custom_css() {

			// General WooCommerce Custom CSS
			wp_enqueue_style( 'wpsp-woocommerce', WPSP_CSS_DIR_URI .'wpsp-woocommerce.css' );

			// WooCommerce Responsiveness
			if ( wpsp_get_redux( 'responsive', true ) ) {
				wp_enqueue_style( 'wpsp-woocommerce-responsive', WPSP_CSS_DIR_URI .'wpsp-woocommerce-responsive.css', array( 'wpsp-woocommerce' ) );
			}

		}

		/**
		 * Adds an opening div "product-inner" around product entries.
		 *
		 * @since 1.0.0
		 */
		public static function add_shop_loop_item_inner_div() {
			echo '<div class="product-inner clear">';
		}

		/**
		 * Closes the "product-inner" div around product entries.
		 *
		 * @since 1.0.0
		 */
		public static function close_shop_loop_item_inner_div() {
			echo '</div><!-- .product-inner .clear -->';
		}

		/**
		 * Clear floats after single product summary.
		 *
		 * @since 1.0.0
		 */
		public static function clear_summary_floats() {
			echo '<div class="wpsp-clear-after-summary clear"></div>';
		}

		/**
		 * Adds an out of stock tag to the products.
		 *
		 * @since 2.0.0
		 */
		public static function add_shop_loop_item_out_of_stock_badge() {
			if ( function_exists( 'wpsp_woo_product_instock' ) && ! wpsp_woo_product_instock() ) { ?>
				<div class="outofstock-badge">
					<?php echo apply_filters( 'wpsp_woo_outofstock_text', esc_html__( 'Out of Stock', 'wpsp-blog-textdomain' ) ); ?>
				</div><!-- .product-entry-out-of-stock-badge -->
			<?php }
		}
	}

}

$wpsp_woocommerce_config = new WPSP_WooCommerce_Config();
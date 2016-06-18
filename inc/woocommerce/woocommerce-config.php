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

			// Menu cart
			add_action( 'wpsp_hook_header_inner', array( $this, 'cart_dropdown' ), 40 );
			add_action( 'wpsp_hook_main_menu_bottom', array( $this, 'cart_dropdown' ) );
			add_action( 'wp_footer', array( $this, 'cart_overlay' ) );

			// Product entries
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_out_of_stock_badge' ) );

			// Product post
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'clear_summary_floats' ), 1 );

			// Main Woo Filters
			add_filter( 'wp_nav_menu_items', array( $this, 'menu_cart_icon' ) , 10, 2 );
			add_filter( 'add_to_cart_fragments', array( $this, 'menu_cart_icon_fragments' ) );
			add_filter( 'woocommerce_general_settings', array( $this, 'remove_general_settings' ) );
			add_filter( 'woocommerce_product_settings', array( $this, 'remove_product_settings' ) );
			add_filter( 'woocommerce_sale_flash', array( $this, 'woocommerce_sale_flash' ), 10, 3 );
			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 20 );
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ) );
			add_filter( 'post_class', array( $this, 'add_product_entry_classes' ) );
			add_filter( 'product_cat_class', array( $this, 'product_cat_class' ) );
			add_filter( 'woocommerce_cart_item_thumbnail', array( $this, 'cart_item_thumbnail' ), 10, 3 );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_product_args' ) );
			add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );
			add_filter( 'woocommerce_continue_shopping_redirect', array( $this, 'continue_shopping_redirect' ) );
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
				$class = wpsp_get_redux( 'woo-shop-layout', 'left-sidebar' );
			} elseif ( wpsp_is_woo_tax() ) {
				$class = wpsp_get_redux( 'woo_shop_layout', 'left-sidebar' );
			} elseif ( wpsp_is_woo_single() ) {
				$class = wpsp_get_redux( 'woo_product_layout', 'left-sidebar' );
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

		/**
		 * Add WooCommerce cart dropdown to the header
		 *
		 * @since 1.0.0
		 */
		public static function cart_dropdown() {

			// Return if style not set to dropdown
			if ( 'drop_down' != menu_cart_style() ) {
				return;
			}

			// Should we get the template part?
			$get = false;

			// Get current header style
			$header_style = wpsp_get_redux( 'header-style' );

			// Header Inner Hook
			if ( 'wpsp_hook_header_inner' == current_filter() ) {
				if ( 'one' == $header_style ) {
					$get = true;
				}
			}
			
			// Menu bottom hook
			elseif ( 'wpsp_hook_main_menu_bottom' == current_filter() ) {
				if ( 'two' == $header_style
					|| 'three' == $header_style
					|| 'four' == $header_style
					|| 'five' == $header_style ) {
					$get = true;
				}
			}

			// Get template file
			if ( $get ) {
				get_template_part( 'partials/cart/cart-dropdown' );
			}

		}

		/**
		 * Adds Cart overlay code to footer
		 *
		 * @since 3.0.0
		 */
		public static function cart_overlay() {
			if ( 'overlay' == menu_cart_style() ) {
				get_template_part( 'partials/cart/cart-overlay' );
			}
		}
		
		/**
		 * Adds cart icon to menu
		 *
		 * @since 1.0.0
		 */
		public static function menu_cart_icon( $items, $args ) {

			// Only used for the main menu
			if ( 'main_menu' != $args->theme_location ) {
				return $items;
			}

			// Get style
			$style = menu_cart_style();

			// Return items if no style
			if ( ! $style ) {
				return $items;
			}

			// Toggle class
			$toggle_class = 'toggle-cart-widget';

			// Define classes to add to li element
			$classes = array( 'woo-menu-icon', 'wpsp-menu-extra' );
			
			// Add style class
			$classes[] = 'wcmenucart-toggle-'. $style;

			// Prevent clicking on cart and checkout
			if ( 'custom-link' != $style && ( is_cart() || is_checkout() ) ) {
				$classes[] = 'nav-no-click';
			}

			// Add toggle class
			else {
				$classes[] = $toggle_class;
			}

			// Turn classes into string
			$classes = implode( ' ', $classes );
			
			// Add cart link to menu items
			$items .= '<li class="'. $classes .'">' . wpsp_wcmenucart_menu_item() .'</li>';
			
			// Return menu items
			return $items;
		}

		/**
		 * Add menu cart item to the Woo fragments so it updates with AJAX
		 *
		 * @since 1.0.0
		 */
		public static function menu_cart_icon_fragments( $fragments ) {
			$fragments['.wcmenucart'] = wpsp_wcmenucart_menu_item();
			return $fragments;
		}

		/**
		 * Remove general settings from Woo Admin panel.
		 *
		 * @since 1.0.0
		 */
		public static function remove_general_settings( $settings ) {
			$remove = array( 'woocommerce_enable_lightbox' );
			foreach( $settings as $key => $val ) {
				if ( isset( $val['id'] ) && in_array( $val['id'], $remove ) ) {
					unset( $settings[$key] );
				}
			}
			return $settings;
		}

		/**
		 * Remove product settings from Woo Admin panel.
		 *
		 * @since 1.0.0
		 */
		public static function remove_product_settings( $settings ) {
			$remove = array(
				'image_options',
				'shop_catalog_image_size',
				'shop_single_image_size',
				'shop_thumbnail_image_size',
				'woocommerce_enable_lightbox'
			);
			foreach( $settings as $key => $val ) {
				if ( isset( $val['id'] ) && in_array( $val['id'], $remove ) ) {
					unset( $settings[$key] );
				}
			}
			return $settings;
		}

		/**
		 * Change onsale text.
		 *
		 * @since 1.0.0
		 */
		public static function woocommerce_sale_flash( $text, $post, $_product ) {
			return '<span class="onsale">'. esc_html__( 'Sale', 'wpsp-blog-textdomain' ) .'</span>';
		}

		/**
		 * Returns correct posts per page for the shop
		 *
		 * @since 1.0.0
		 */
		public static function loop_shop_per_page() {
			$posts_per_page = wpsp_get_redux( 'woo-shop-posts-per-page', 12 );
			$posts_per_page = $posts_per_page ? $posts_per_page : '12';
			return $posts_per_page;
		}

		/**
		 * Change products per row for the main shop.
		 *
		 * @since 1.0.0
		 */
		public static function loop_shop_columns() {
			$columns = wpsp_get_redux( 'woocommerce-shop-columns', 4 );
			$columns = $columns ? $columns : '4';
			return $columns;
		}

		/**
		 * Add classes to WooCommerce product entries.
		 *
		 * @since 1.0.0
		 */
		public static function add_product_entry_classes( $classes ) {
			global $product, $woocommerce_loop;
			if ( $product && $woocommerce_loop ) {
				$classes[] = 'col';
				$classes[] = wpsp_grid_class( $woocommerce_loop['columns'] );
			}
			return $classes;
		}

		/**
		 * Alter WooCommerce category classes
		 *
		 * @since 1.0.0
		 */
		public static function product_cat_class( $classes ) {
			global $woocommerce_loop;
			$classes[] = 'col';
			$classes[] = wpsp_grid_class( $woocommerce_loop['columns'] );
			return $classes;
		}

		/**
		 * Alter the cart item thumbnail size
		 *
		 * @since 1.0.0
		 */
		public static function cart_item_thumbnail( $thumb, $cart_item, $cart_item_key ) {
			if ( ! empty( $cart_item['variation_id'] )
				&& $thumbnail = get_post_thumbnail_id( $cart_item['variation_id'] )
			) {
				return wpsp_get_post_thumbnail( array(
					'size'       => 'shop_thumbnail',
					'attachment' => $thumbnail,
				) );
			} elseif ( isset( $cart_item['product_id'] )
				&& $thumbnail = get_post_thumbnail_id( $cart_item['product_id'] )
			) {
				return wpsp_get_post_thumbnail( array(
					'size'       => 'shop_thumbnail',
					'attachment' => $thumbnail,
				) );
			} else {
				return wc_placeholder_img();
			}
		}

		/**
		 * Alter the related product arguments.
		 *
		 * @since 1.0.0
		 */
		public static function related_product_args() {
			// Get global vars
			global $product, $orderby, $related;
			// Get posts per page
			$posts_per_page = wpsp_get_redux( 'woocommerce-related-count', 4 );
			$posts_per_page = $posts_per_page ? $posts_per_page : '4';
			// Get columns
			$columns = wpsp_get_redux( 'woocommerce-related-columns', 4 );
			$columns = $columns ? $columns : '4';
			// Return array
			return array(
				'posts_per_page' => $posts_per_page,
				'columns'        => $columns,
			);
		}

		/**
		 * Tweaks pagination arguments.
		 *
		 * @since 1.0.0
		 */
		public static function pagination_args( $args ) {
			$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
			$args['next_text'] = '<i class="fa fa-angle-right"></i>';
			return $args;
		}

		/**
		 * Alter continue shoping URL.
		 *
		 * @since 1.0.0
		 */
		public static function continue_shopping_redirect( $return_to ) {
			$shop_id = woocommerce_get_page_id( 'shop' );
			if ( function_exists( 'icl_object_id' ) ) {
				$shop_id = icl_object_id( $shop_id, 'page' );
			}
			if ( $shop_id ) {
				$return_to = get_permalink( $shop_id );
			}
			return $return_to;
		}

	}

}

$wpsp_woocommerce_config = new WPSP_WooCommerce_Config();
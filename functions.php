<?php
/**
 * WPSP Blog functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Small_Shop
 */

/**
* Start up class
*
* @version 1.0.0
*
*/

class WPSP_Theme_Setup {
	private $template_dir;

	/**
	 * Main Theme Class Constructor
	 *
	 * Loads all necessary classes, functions, hooks, configuration files and actions for the theme.
	 * Everything starts here.
	 *
	 * @since 1.1.0
	 *
	 */
	function __construct(){
		// define template directory
		$this->template_dir = get_template_directory();

		// Add redux framework as Theme Options
		require_once( $this->template_dir . '/inc/admin/admin-init.php' );

		// Included Metabox.io framework as meta boxes of theme core
		require_once( $this->template_dir . '/inc/meta-box/meta-box.php' );
		require_once( $this->template_dir . '/inc/meta-box/meta-config.php' );

		// Define constant
		add_action( 'after_setup_theme', array( $this , 'constants' ), 0 );

		// Load all core theme function files
		// Load Before classes and addons so we can make use of them
		add_action( 'after_setup_theme', array( $this, 'wpsp_include_functions' ), 1 );

		// Load all the theme addons - must run on this hook!!!
		add_action( 'after_setup_theme', array( $this, 'wpsp_addons' ), 2 );

		// Add custom post types supports
		add_action( 'after_setup_theme', array( $this, 'configs' ), 3 );

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc
		// Must run on 10 priority or else child theme locale will be overritten
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 10 );

		// Defines hooks and runs actions
		// @todo move to 'wp' hook since it's not needed so early? Would break a lot of snippets...
		add_action( 'init', array( $this, 'hooks_actions' ), 0 );

		// Load the scripts in WP Admin
		add_action( 'admin_enqueue_scripts', array( $this, 'wpsp_admin_scripts' ) );

		// Load theme js
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_js') );

		// Load theme style
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_css') );

		// Load responsive CSS - must be added last
		add_action( 'wp_enqueue_scripts', array( $this, 'responsive_css' ), 99 );

		// Add meta viewport tag to header
		add_action( 'wp_head', array( $this, 'meta_viewport' ), 1 );

		// Loads html5 shiv script
		add_action( 'wp_head', array( $this, 'html5_shiv' ) );

		// register sidebar widget areas
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );

		// Exclude categories from the blog page
		add_filter( 'pre_get_posts', array( $this, 'pre_get_posts' ) );

		// Add new social profile fields to the user dashboard
		add_filter( 'user_contactmethods', array( $this, 'add_user_social_fields' ) );

		// Allow for the use of shortcodes in the WordPress excerpt
		add_filter( 'the_excerpt', 'shortcode_unautop' );
		add_filter( 'the_excerpt', 'do_shortcode' );
	}

	/**
	 * Use rwmb_meta framework as metabox
	 * 
	 * @link https://metabox.io
	 * 
	 * @since 1.0.0
	 *
	 */
	public static function constants(){
		// Theme branding
		define( 'WPSP_THEME_BRANDING', 'WPSP Blog' );
		define( 'WPSP_THEME_BRANDING_PREFIX', 'WPSP' );
		define( 'WPSP_THEME_VERSION', '1.0.0' );

		// Paths to the parent theme directory
		define( 'WPSP_THEME_DIR', get_template_directory() );
		define( 'WPSP_THEME_URI', get_template_directory_uri() );

		// Javascript and CSS Paths
		define( 'WPSP_JS_DIR_URI', WPSP_THEME_URI.'/js/' );
		define( 'WPSP_CSS_DIR_URI', WPSP_THEME_URI.'/css/' );

		// INC path
		define( 'WPSP_INC_DIR', WPSP_THEME_DIR.'/inc/' );
		define( 'WPSP_INC_DIR_URL', WPSP_THEME_URI.'/inc/');

		// Define if plugins are active
		define( 'WPSP_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
	}

	/**
	 * Framework functions
	 * Load before Classes & Addons so we can use them
	 *
	 * @since 1.0.0
	 */
	public static function wpsp_include_functions() {
		require_once( WPSP_INC_DIR .'aq_resizer.php' );
		require_once( WPSP_INC_DIR .'sanitize-data.php' );
		require_once( WPSP_INC_DIR .'category-meta.php' );
		require_once( WPSP_INC_DIR .'wpml.php' );
		require_once( WPSP_INC_DIR .'fonts.php' );
		require_once( WPSP_INC_DIR .'custom-login.php' );
		require_once( WPSP_INC_DIR .'core-functions.php' );
		require_once( WPSP_INC_DIR .'blog-functions.php' );
		require_once( WPSP_INC_DIR .'header-functions.php' );
		require_once( WPSP_INC_DIR .'menu-functions.php' );
		require_once( WPSP_INC_DIR .'pagination.php' );
		require_once( WPSP_INC_DIR .'overlay.php' );
	}

	/**
	 * Addon functions
	 *
	 * @since 1.0.0
	 */
	public static function wpsp_addons() {
		require_once( WPSP_INC_DIR .'addons/widget-areas.php' );
	}

	/**
	 * Config custom post types and 3rd party plugins
	 *
	 * @since 1.0.0
	 */
	public static function configs() {
		require_once( WPSP_INC_DIR . 'post-types/post-types-helpers.php' );
		require_once( WPSP_INC_DIR . 'post-types/portfolio/portfolio-config.php' );

		// WooCommerce
		if ( WPSP_WOOCOMMERCE_ACTIVE ) {
			require_once( WPSP_INC_DIR . 'woocommerce/woocommerce-config.php' );
		}
	}

	/**
	 * Adds basic theme support functions and registers the nav menus
	 *
	 * @since 1.1.0
	 */
	public static function theme_setup() {

		// This theme styles the visual editor to resemble the theme style.
		$font_url = 'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic';
		add_editor_style( array( 'css/editor-style.css', str_replace( ',', '%2C', $font_url ) ) );

		// Load text domain
		load_theme_textdomain( 'wpsp-blog-textdomain', WPSP_THEME_DIR .'/languages' );

		// Get globals
		global $content_width;

		// Set content width based on theme's default design
		if ( ! isset( $content_width ) ) {
			$content_width = 980;
		}

		// Array of theme menus
		$menus = apply_filters( 'wpsp_nav_menus', array(
			'topbar_menu'     => esc_html__( 'Top Bar', 'wpsp-blog-textdomain' ),
			'main_menu'       => esc_html__( 'Main', 'wpsp-blog-textdomain' ),
			'mobile_menu_alt' => esc_html__( 'Mobile Menu Alternative', 'wpsp-blog-textdomain' ),
			'mobile_menu'     => esc_html__( 'Mobile Icons', 'wpsp-blog-textdomain' ),
			'footer_menu'     => esc_html__( 'Footer', 'wpsp-blog-textdomain' ),
		) );

		// Register navigation menus
		register_nav_menus( $menus );

		// Declare theme support
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5');
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );

		// Enable excerpts for pages.
		add_post_type_support( 'page', 'excerpt' );
	}

	/**
	 * Defines all theme hooks and runs all needed actions for theme hooks.
	 *
	 * @since 1.0.0
	 */
	public static function hooks_actions() {

		$dir = WPSP_INC_DIR;

		// Register hooks (needed in admin for Custom Actions panel)
		require_once( $dir .'hooks/hooks.php' );

		// Front-end stuff
		if ( ! is_admin() ) {
			require_once( $dir .'hooks/actions.php' );
			require_once( $dir .'hooks/partials.php' );
		}

	}

	/**
	 * Load scripts in the WP Admin
	 *
	 * @since 1.0.0 
	 *
	 */
	public static function wpsp_admin_scripts( $hook ){
		if ( !in_array($hook, array('post.php','post-new.php')) )
		return;
		wp_enqueue_script( 'admin-scripts', get_template_directory_uri() . '/js/admin-scripts.js', array( 'jquery' ) );
	}

	/**
	 * Returns all js needed for the front-end
	 *
	 * @since 1.0.0 
	 *
	 */
	public static function theme_js(){
		// Front end only
		if ( is_admin() ) {
			return;
		}

		// Get js directory uri
		$dir = WPSP_JS_DIR_URI;

		// Get current theme version
		$theme_version = WPSP_THEME_VERSION;

		// Make sure the core jQuery script is loaded
		wp_enqueue_script( 'jquery' );

		// Comment reply
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Load all non-minified js

		// Superfish used for menu dropdowns
		wp_enqueue_script( 'wpsp-superfish', $dir .'vendors/superfish.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'wpsp-supersubs', $dir .'vendors/supersubs.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'wpsp-hoverintent', $dir .'vendors/hoverintent.js', array( 'jquery' ), $theme_version, true );

		// Sticky header
		wp_enqueue_script( 'wpsp-sticky', $dir .'vendors/sticky.js', array( 'jquery' ), $theme_version, true );

		// Page animations
		wp_enqueue_script( 'wpsp-animsition', $dir .'vendors/animsition.js', array( 'jquery' ), $theme_version, true );

		// Checks if images are loaded within an element
		wp_enqueue_script( 'wpsp-images-loaded', $dir .'vendors/images-loaded.js', array( 'jquery' ), $theme_version, true );

		// Mobile menu
		wp_enqueue_script( 'wpsp-sidr', $dir .'vendors/sidr.js', array( 'jquery' ), $theme_version, true );

		// Equal Heights
		wp_enqueue_script( 'wpsp-match-height', $dir .'vendors/jquery.matchHeight.js', array( 'jquery' ), $theme_version, true );

		// Main masonry script
		wp_enqueue_script( 'wpsp-isotope', $dir .'vendors/isotope.js', array( 'jquery' ), '2.2.2', true );

		// Leaner modal used for search/woo modals: @todo: Replace with CSS+light js
		wp_enqueue_script( 'wpsp-leanner-modal', $dir .'vendors/leanner-modal.js', array( 'jquery' ), $theme_version, true );

		// Tooltips
		wp_enqueue_script( 'wpsp-tipsy', $dir .'vendors/tipsy.js', array( 'jquery' ), $theme_version, true );

		// Core global custom
		wp_enqueue_script( 'wpsp-custom', $dir .'custom.js', array( 'jquery' ), $theme_version, true );

		// Localize script
		// Get theme options
		$header_style      = wpsp_get_redux( 'header-style' );
		$sticky_header     = wpsp_get_redux( 'is-fixed-header' );
		$mobile_menu_style = wpsp_get_redux( 'mobile-menu-style' );

		$localize_array = array(
			'isRTL'                 => is_rtl(),
			'mainLayout'            => wpsp_get_redux( 'main-layout' ),
			'menuSearchStyle'       => wpsp_get_redux( 'menu-search-style' ),
			'hasStickyHeader'       => $sticky_header,
			'siteHeaderStyle'       => $header_style,
			'superfishDelay'        => 600,
			'superfishSpeed'        => 'fast',
			'superfishSpeedOut'     => 'fast',
			'mobileMenuStyle'       => $mobile_menu_style,
			'localScrollUpdateHash' => true,
			'localScrollSpeed'      => 800,
			'windowScrollTopSpeed'  => 800,
			'carouselSpeed'		    => 150,
			'customSelects'         => '.woocommerce-ordering .orderby, #dropdown_product_cat, .widget_categories select, .widget_archive select, #bbp_stick_topic_select, #bbp_topic_status_select, #bbp_destination_topic, .single-product .variations_form .variations select',
			'milestoneDecimalFormat' => ',',
		);

		// Sidr settings
		if ( 'sidr' == $mobile_menu_style ) {
			$localize_array['sidrSource']         = sidr_menu_source();
			$localize_array['sidrDisplace']       = wpsp_get_redux( 'mobile-menu-sidr-displace', true ) ?  true : false;
			$localize_array['sidrSide']           = wpsp_get_redux( 'mobile-menu-sidr-direction', 'left' );
			$localize_array['sidrSpeed']          = 300;
			$localize_array['sidrDropdownTarget'] = 'arrow';
		}

		// Toggle mobile menu
		if ( 'toggle' == $mobile_menu_style ) {
			$localize_array['animateMobileToggle'] = true;
		}

		// Full screen mobile menu style
		if ( 'full_screen' == $mobile_menu_style ) {
			$localize_array['fullScreenMobileMenuStyle'] = wpsp_get_redux( 'full-screen-mobile-menu-style', 'white' );
		}

		// Sticky Header
		if ( $sticky_header ) {
			$localize_array['hasStickyMobileHeader']  = wpsp_get_redux( 'is-fixed-header-mobile' );
			$localize_array['overlayHeaderStickyTop'] = 0;
			$localize_array['stickyHeaderBreakPoint'] = 960;

			// Shrink sticky header
			if ( wpsp_get_redux( 'is-shrink-fixed-header' ) ) {
				$localize_array['shrinkHeaderHeight']     = 70;
				$localize_array['shrinkHeaderLogoHeight'] = ''; // Calculate via js by default
			}
			
		}

		// Sticky topBar
		if ( wpsp_get_redux( 'top-bar-sticky' ) ) {
			$localize_array['stickyTopBarBreakPoint'] = 960;
			$localize_array['hasStickyTopBarMobile']  = true;
		}

		// Header five
		if ( 'five' == $header_style ) {
			$localize_array['headerFiveSplitOffset'] = 1;
		}

		wp_localize_script( 'wpsp-custom', 'wpspLocalize', $localize_array );
	}

	/**
	 * Load theme css
	 *
	 * @since 1.0.0 
	 *
	 */
	public static function theme_css(){
		wp_enqueue_style( 'wpspblog-style', get_stylesheet_uri() );

		//Add Google Fonts (English): Open Sans
		//wp_enqueue_style( 'google-font-english', 'https://fonts.googleapis.com/css?family=Oswald:400,300|Open+Sans:400,400italic,700,700italic' );
		//wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css' );

		//Add Google Font (Khmer): Hanuman
		//wp_enqueue_style( 'google-font-khmer', 'https://fonts.googleapis.com/css?family=Hanuman:400,700' );

		//Enabling Local Web Fonts
		wp_enqueue_style( 'local-fonts-english', get_template_directory_uri() . '/fonts/custom-fonts.css' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/fonts/font-awesome/css/font-awesome.min.css' );
	}

	/**
	 * Loads responsive css very last after all styles.
	 *
	 * @since 1.0.0
	 */
	public static function responsive_css() {
		if ( wpsp_get_redux( 'is-responsive' ) ) {
			wp_enqueue_style( 'wpsp-responsive', WPSP_CSS_DIR_URI .'responsive.css', false, WPSP_THEME_VERSION );
		}
	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.0.0
	 */
	public function meta_viewport() {

		// Responsive viewport viewport
		if ( wpsp_get_redux( 'is-responsive', true ) ) {
			$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';
		}

		// Non responsive meta viewport
		else {
			$width    = intval( wpsp_get_redux( 'main-container-width', '980' ) );
			$width    = $width ? $width: '980';
			$viewport = '<meta name="viewport" content="width='. $width .'" />';
		}
		
		// Apply filters to the meta viewport for child theme tweaking
		echo apply_filters( 'wpsp_meta_viewport', $viewport );

	}

	/**
	 * Load HTML5 dependencies for IE8
	 *
	 * @since 1.6.0
	 */
	public static function html5_shiv() {
		echo '<!--[if lt IE 9]><script src="'. WPSP_JS_DIR_URI .'vendors/html5.js"></script><![endif]-->';
	}

	/**
	 * Registers the theme sidebars (widget areas)
	 *
	 * @since 1.1.0
	 */
	public static function register_sidebars() {
		require_once( WPSP_INC_DIR .'widgets/widgets.php' );
	}

	/**
	 * This function runs before the main query.
	 *
	 * @since 1.0.0
	 */
	public static function pre_get_posts( $query ) {

		// Lets not break stuff
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		// Search pagination
		if ( is_search() ) {
			$query->set( 'posts_per_page', wpsp_get_redux( 'search-posts-per-page', '10' ) );
			return;
		}

		// Exclude categories from the main blog
		if ( ( is_home() || is_page_template( 'templates/blog.php' ) ) && $cats = wpsp_blog_exclude_categories() ) {
			set_query_var( 'category__not_in', $cats );
			return;
		}

		// Category pagination
		$terms = get_terms( 'category' );
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( is_category( $term->slug ) ) {
					$term_id    = $term->term_id;
					$term_data  = get_option( "category_$term_id" );
					if ( $term_data ) {
						if ( ! empty( $term_data['wpsp_term_posts_per_page'] ) ) {
							$query->set( 'posts_per_page', $term_data['wpsp_term_posts_per_page'] );
							return;
						}
					}
				}
			}
		}

	}

	/**
	 * Add new user fields / user meta
	 *
	 * @since 1.0.0
	 */
	public static function add_user_social_fields( $contactmethods ) {

		$branding = wpsp_get_theme_branding();
		$branding = $branding ? $branding .' - ' : '';

		if ( ! isset( $contactmethods['wpsp_twitter'] ) ) {
			$contactmethods['wpsp_twitter'] = $branding .'Twitter';
		}

		if ( ! isset( $contactmethods['wpsp_facebook'] ) ) {
			$contactmethods['wpsp_facebook'] = $branding .'Facebook';
		}

		if ( ! isset( $contactmethods['wpsp_googleplus'] ) ) {
			$contactmethods['wpsp_googleplus'] = $branding .'Google+';
		}

		if ( ! isset( $contactmethods['wpsp_linkedin'] ) ) {
			$contactmethods['wpsp_linkedin'] = $branding .'LinkedIn';
		}

		if ( ! isset( $contactmethods['wpsp_pinterest'] ) ) {
			$contactmethods['wpsp_pinterest'] = $branding .'Pinterest';
		}
		
		if ( ! isset( $contactmethods['wpsp_instagram'] ) ) {
			$contactmethods['wpsp_instagram'] = $branding .'Instagram';
		}

		return $contactmethods;

	}

}
$wpsp_theme_setup = new WPSP_Theme_Setup;
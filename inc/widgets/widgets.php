<?php
/**
 * Registers the theme sidebars (widget areas) and custom widgest
 *
 *  @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package WPSP_Blog
 */


// Heading element type
$sidebar_headings = wpsp_get_redux( 'sidebar-headings', 'div' );
$sidebar_headings = $sidebar_headings ? $sidebar_headings : 'div';
$footer_headings  = wpsp_get_redux( 'footer-headings', 'div' );
$footer_headings  = $footer_headings ? $footer_headings : 'div';

// Main Sidebar
register_sidebar( array(
	'name'          => esc_html__( 'Main Sidebar', 'wpsp-blog-textdomain' ),
	'id'            => 'sidebar',
	'before_widget' => '<div class="widget %2$s clear">',
	'after_widget'  => '</div>',
	'before_title'  => '<'. $sidebar_headings .' class="widget-title">',
	'after_title'   => '</'. $sidebar_headings .'>',
) );

// Pages Sidebar
if ( wpsp_get_redux( 'pages-custom-sidebar', true ) ) {
	register_sidebar( array(
		'name'          => esc_html__( 'Pages Sidebar', 'wpsp-blog-textdomain' ),
		'id'            => 'pages_sidebar',
		'before_widget' => '<div class="widget %2$s clear">',
		'after_widget'  => '</div>',
		'before_title'  => '<'. $sidebar_headings .' class="widget-title">',
		'after_title'   => '</'. $sidebar_headings .'>',
	) );
}

// Search Results Sidebar
if ( wpsp_get_redux( 'is-search-custom-sidebar', true ) ) {
	register_sidebar( array(
		'name'          => esc_html__( 'Search Results Sidebar', 'wpsp-blog-textdomain' ),
		'id'            => 'search_sidebar',
		'before_widget' => '<div class="widget %2$s clear">',
		'after_widget'  => '</div>',
		'before_title'  => '<'. $sidebar_headings .' class="widget-title">',
		'after_title'   => '</'. $sidebar_headings .'>',
	) );
}

// Check if footer widgets are enabled
$footer_widgets = wpsp_get_redux( 'is-footer-widgets', true );
$footer_widgets = apply_filters( 'wpsp_register_footer_sidebars', $footer_widgets );

// Register footer widgets if enabled
if ( $footer_widgets ) {

	// Footer widget columns
	$footer_columns = wpsp_get_redux( 'footer-widgets-columns', '4' );
	
	// Footer 1
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'wpsp-blog-textdomain' ),
		'id'            => 'footer_one',
		'before_widget' => '<div class="footer-widget %2$s clear">',
		'after_widget'  => '</div>',
		'before_title'  => '<'. $footer_headings .' class="widget-title">',
		'after_title'   => '</'. $footer_headings .'>',
	) );
	
	// Footer 2
	if ( $footer_columns > '1' ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Column 2', 'wpsp-blog-textdomain' ),
			'id'            => 'footer_two',
			'before_widget' => '<div class="footer-widget %2$s clear">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $footer_headings .' class="widget-title">',
			'after_title'   => '</'. $footer_headings .'>'
		) );
	}
	
	// Footer 3
	if ( $footer_columns > '2' ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Column 3', 'wpsp-blog-textdomain' ),
			'id'            => 'footer_three',
			'before_widget' => '<div class="footer-widget %2$s clear">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $footer_headings .' class="widget-title">',
			'after_title'   => '</'. $footer_headings .'>',
		) );
	}
	
	// Footer 4
	if ( $footer_columns > '3' ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Column 4', 'wpsp-blog-textdomain' ),
			'id'            => 'footer_four',
			'before_widget' => '<div class="footer-widget %2$s clear">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $footer_headings .' class="widget-title">',
			'after_title'   => '</'. $footer_headings .'>',
		) );
	}

	// Footer 5
	if ( $footer_columns > '4' ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Column 5', 'wpsp-blog-textdomain' ),
			'id'            => 'footer_five',
			'before_widget' => '<div class="footer-widget %2$s clear">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $footer_headings .' class="widget-title">',
			'after_title'   => '</'. $footer_headings .'>',
		) );
	}

}

/**
 * Sidebar choice - work with option tree
 * 
 */
if ( ! function_exists( 'wpsp_sidebar_primary' ) ) :	
function wpsp_sidebar_primary() {
	$sidebar = 'sidebar';

	// Set sidebar based on page
	if ( is_home() && wpsp_get_redux('sidebar-global') ) $sidebar = wpsp_get_redux('sidebar-global');

	if ( is_single() && wpsp_get_redux('sidebar-single') ) $sidebar = wpsp_get_redux('sidebar-single');
	if ( is_archive() && wpsp_get_redux('sidebar-archive') ) $sidebar = wpsp_get_redux('sidebar-archive');
	if ( is_category() && wpsp_get_redux('sidebar-category') ) $sidebar = wpsp_get_redux('sidebar-category');
	if ( is_search() && wpsp_get_redux('sidebar-search') ) $sidebar = wpsp_get_redux('sidebar-search');
	if ( is_404() && wpsp_get_redux('sidebar-404') ) $sidebar = wpsp_get_redux('sidebar-404');
	if ( is_page() && wpsp_get_redux('sidebar-page') ) $sidebar = wpsp_get_redux('sidebar-page');

	if ( is_singular('portfolio') && wpsp_get_redux('sidebar-portfolio-single-post') ) $sidebar = wpsp_get_redux('sidebar-portfolio-single-post');
	if ( is_tax('portfolio_category') && wpsp_get_redux('sidebar-portfolio-archive') ) $sidebar = wpsp_get_redux('sidebar-portfolio-archive');
	if ( is_tax('portfolio_tag') && wpsp_get_redux('sidebar-portfolio-archive') ) $sidebar = wpsp_get_redux('sidebar-portfolio-archive');

	// Check for page/post specific sidebar
	if ( is_page() || is_single() ) {
		// Reset post data
		wp_reset_postdata();
		global $post;
		// Get meta
		$meta = get_post_meta($post->ID,'wpsp_sidebar_primary',true);
		if ( $meta ) { $sidebar = $meta; }
	}

	// Return sidebar
	return $sidebar;
}
endif;

/**
 * Layout choice
 * 
 */
if ( ! function_exists( 'wpsp_layout_class' ) ) :
function wpsp_layout_class() {
	// Default layout
	$layout = 'full-width';
	$default = 'right-sidebar';

	// Check for page/post specific layout
	if ( is_page() || is_single() ) {
		// Reset post data
		wp_reset_postdata();
		global $post;
		// Get meta
		$meta = get_post_meta($post->ID,'wpsp_layout',true);
		
		// Get if set and not set to inherit
		if ( isset($meta) && !empty($meta) && $meta != 'inherit' ) { $layout = $meta; }
		
		// Else check for page-global / single-global
		elseif ( is_single() && ( wpsp_get_redux('single-layout') !='inherit' ) ) $layout = wpsp_get_redux('single-layout');
		elseif ( is_page() && ( wpsp_get_redux('page-layout') !='inherit' ) ) $layout = wpsp_get_redux('page-layout');

		// Else check for custom post
		elseif ( is_singular('portfolio') && ( wpsp_get_redux('portfolio-single-layout') !='inherit' ) ) $layout = wpsp_get_redux('portfolio-single-layout');

		// Else get global option
		else $layout = wpsp_get_redux( 'layout-global' );
	}

	// Set layout based on page
	elseif ( is_category() && ( wpsp_get_redux('category-layout') !='inherit' ) ) $layout = wpsp_get_redux('category-layout');
	elseif ( is_archive() && ( wpsp_get_redux('archive-layout') !='inherit' ) ) $layout = wpsp_get_redux('archive-layout');
	elseif ( is_search() && ( wpsp_get_redux('search-layout') !='inherit' ) ) $layout = wpsp_get_redux('search-layout');
	elseif ( is_404() && ( wpsp_get_redux('404-layout') !='inherit' ) ) $layout = wpsp_get_redux('404-layout');

	// Custom taxonomy layout
	elseif ( is_tax('portfolio_category') && wpsp_get_redux('portfolio-archive-layout') !='inherit' ) $sidebar = wpsp_get_redux('portfolio-archive-layout');
	elseif ( is_tax('portfolio_tag') && wpsp_get_redux('portfolio-archive-layout') !='inherit' ) $sidebar = wpsp_get_redux('portfolio-archive-layout');

	// Global option
	else $layout = wpsp_get_redux( 'layout-global' );

	// Return layout class
	return $layout;
}
endif;

/**
 * Add layout option in body class
 * 
 */
if ( ! function_exists( 'wpsp_layout_option_body_class' ) ) :
function wpsp_layout_option_body_class( $classes ) {
	$classes[] = wpsp_layout_class();
	return $classes;
}
add_filter( 'body_class', 'wpsp_layout_option_body_class' );	
endif;

/**
 * Include all custom widgets
 *
 * @since   1.0.0
 */
function wpsp_add_custom_widgets() {

    // Define array of custom widgets for the theme
    $widgets = array(
        'quick-contact',
        'facebook-page',
        'call-to-action',
        'social-fontawesome',
        'custom-taxonomy-menu',
        //'modern-menu',
        'video',
        'posts-thumbnails',
        'about',
        'events',
    );

    // Loop through widgets and load their files
    foreach ( $widgets as $widget ) {
        $widget_file = get_template_directory() .'/inc/widgets/'. $widget .'-widget.php';
        if ( file_exists( $widget_file ) ) {
            load_template( $widget_file );
        }
    }
}
//add_action( 'after_setup_theme', 'wpsp_add_custom_widgets', 5 );
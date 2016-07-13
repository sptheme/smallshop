<?php
/**
 * Registers the theme sidebars (widget areas) and custom widgest
 *
 *  @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package SmallShop
 */


// Heading element type
$sidebar_headings = wpsp_get_redux( 'sidebar-headings', 'div' );
$sidebar_headings = $sidebar_headings ? $sidebar_headings : 'div';
$footer_headings  = wpsp_get_redux( 'footer-headings', 'div' );
$footer_headings  = $footer_headings ? $footer_headings : 'div';

// Main Sidebar
register_sidebar( array(
	'name'          => esc_html__( 'Main Sidebar', 'wpsp-blog' ),
	'id'            => 'sidebar',
	'before_widget' => '<div class="widget %2$s clear">',
	'after_widget'  => '</div>',
	'before_title'  => '<'. $sidebar_headings .' class="widget-title">',
	'after_title'   => '</'. $sidebar_headings .'>',
) );

// Pages Sidebar
if ( wpsp_get_redux( 'pages-custom-sidebar', true ) ) {
	register_sidebar( array(
		'name'          => esc_html__( 'Pages Sidebar', 'wpsp-blog' ),
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
		'name'          => esc_html__( 'Search Results Sidebar', 'wpsp-blog' ),
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
		'name'          => esc_html__( 'Footer Column 1', 'wpsp-blog' ),
		'id'            => 'footer_one',
		'before_widget' => '<div class="footer-widget %2$s clear">',
		'after_widget'  => '</div>',
		'before_title'  => '<'. $footer_headings .' class="widget-title">',
		'after_title'   => '</'. $footer_headings .'>',
	) );
	
	// Footer 2
	if ( $footer_columns > '1' ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Column 2', 'wpsp-blog' ),
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
			'name'          => esc_html__( 'Footer Column 3', 'wpsp-blog' ),
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
			'name'          => esc_html__( 'Footer Column 4', 'wpsp-blog' ),
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
			'name'          => esc_html__( 'Footer Column 5', 'wpsp-blog' ),
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

	/***
	 * FILTER    => Add filter for tweaking the sidebar display via child theme's
	 * IMPORTANT => Must be added before meta options so that it doesn't take priority
	 ***/
	$sidebar = apply_filters( 'wpsp_sidebar_primary', $sidebar );

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
<?php
/**
 * Helper functions for the blog
 *
 * These functions are used throughout the theme and must be loaded
 * early on.
 *
 * @package SmallShop
 */

/**
 * Exclude categories from the blog
 * This function runs on pre_get_posts
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_exclude_categories' ) ) :
function wpsp_blog_exclude_categories( $deprecated = true ) {

	// Don't run in these places
	if ( is_admin()
		|| is_search()
		|| is_tag()
		|| is_category()
	) {
		return;
	}

	// Get Cat id's to exclude
	if ( $cats = wpsp_get_redux( 'blog-cats-exclude' ) ) {
		if ( ! is_array( $cats ) ) {
			$cats = explode( ',', $cats ); // Convert to array
		}
	}

	// Return ID's
	return $cats;
	
}
endif;

/**
 * Returns the correct blog style
 *
 * @since 1.5.3
 */
if ( ! function_exists( 'wpsp_blog_style' ) ) :
function wpsp_blog_style() {

	// Get default style from Customizer
	$style = wpsp_get_redux( 'blog-entry-style' );

	// Check custom category style
	if ( is_category() ) {
		$term      = get_query_var( 'cat' );
		$term_data = get_option( "category_$term" );
		if ( $term_data && ! empty ( $term_data['wpsp_term_style'] ) ) {
			$style = $term_data['wpsp_term_style'] .'-entry-style';
		}
	}

	// Sanitize
	$style = $style ? $style : 'large-image-entry-style';

	// Apply filters for child theming
	$style = apply_filters( 'wpsp_blog_style', $style );

	// Return style
	return $style;

}
endif;

/**
 * Returns the grid style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_grid_style' ) ) :
function wpsp_blog_grid_style() {

	// Get default style from Customizer
	$style = wpsp_get_redux( 'blog-grid-style' );

	// Check custom category style
	if ( is_category() ) {
		$term       = get_query_var( 'cat' );
		$term_data  = get_option( "category_$term" );
		if ( $term_data && ! empty ( $term_data['wpsp_term_grid_style'] ) ) {
			$style = $term_data['wpsp_term_grid_style'];
		}
	}

	// Sanitize
	$style = $style ? $style : 'fit-rows';

	// Apply filters for child theming
	$style = apply_filters( 'wpsp_blog_grid_style', $style );

	// Return style
	return $style;

}
endif;

/**
 * Returns the correct pagination style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_pagination_style' ) ) :
function wpsp_blog_pagination_style() {

	// Get default style from Customizer
	$style = wpsp_get_redux( 'blog-pagination-style' );

	// Check custom category style
	if ( is_category() ) {
		$term       = get_query_var( 'cat' );
		$term_data  = get_option( "category_$term" );
		if ( $term_data && ! empty ( $term_data['wpsp_term_pagination'] ) ) {
			$style = $term_data['wpsp_term_pagination'];
		}
	}

	// Apply filters for child theming
	$style = apply_filters( 'wpsp_blog_pagination_style', $style );

	// Return style
	return $style;
}
endif;

/**
 * Returns correct style for the blog entry based on theme options or category options
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_entry_style' ) ) :
function wpsp_blog_entry_style() {

	// Get default style from Customizer
	$style = wpsp_get_redux( 'blog-entry-style' );

	// Check custom category style
	if ( is_category() ) {
		$term       = get_query_var( "cat" );
		$term_data  = get_option( "category_$term" );
		if ( ! empty ( $term_data['wpsp_term_style'] ) ) {
			$style = $term_data['wpsp_term_style'] .'-entry-style';
		}
	}

	// Sanitize
	$style = $style ? $style : 'large-image-entry-style';

	// Apply filters for child theming
	$style = apply_filters( 'wpsp_blog_entry_style', $style );

	// Return style
	return $style;

}
endif;

/**
 * Checks if the blog entries should have equal heights
 *
 * @since   1.0.0
 * @return  bool
 */
if ( ! function_exists( 'wpsp_blog_entry_equal_heights' ) ) :
function wpsp_blog_entry_equal_heights() {

	// Return if disabled via theme mod
	if ( ! wpsp_get_redux( 'blog-archive-grid-equal-heights', false ) ) {
		return false;
	}

	// Return true for the grid style
	if ( 'grid-entry-style' == wpsp_blog_entry_style() && 'masonry' != wpsp_blog_grid_style() ) {
		return true;
	}

}
endif;

/**
 * Returns correct columns for the blog entries
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_entry_columns' ) ) :
function wpsp_blog_entry_columns() {

	// Get columns from customizer setting
	$columns = wpsp_get_redux( 'blog-grid-columns' );

	// Get custom columns per category basis
	if ( is_category() ) {
		$term       = get_query_var( 'cat' );
		$term_data  = get_option( "category_$term" );
		if ( ! empty ( $term_data['wpsp_term_grid_cols'] ) ) {
			$columns = $term_data['wpsp_term_grid_cols'];
		}
	}

	// Sanitize
	$columns = $columns ? $columns : '2';

	// Apply filters for child theming
	$columns = apply_filters( 'wpsp_blog_entry_columns', $columns );

	// Return columns
	return $columns;

}
endif;

/**
 * Returns correct blog entry classes
 *
 * @since 1.1.6
 */
if ( ! function_exists( 'wpsp_blog_entry_classes' ) ) :
function wpsp_blog_entry_classes() {

	// Define classes array
	$classes = array();

	// Entry Style
	$entry_style = wpsp_blog_entry_style();

	// Core classes
	$classes[] = 'blog-entry';
	$classes[] = 'clear';

	// Masonry classes
	if ( 'masonry' == wpsp_blog_grid_style() ) {
		$classes[] = 'isotope-entry';
	}

	// Equal heights
	if ( wpsp_blog_entry_equal_heights() ) {
		$classes[] = 'blog-entry-equal-heights';
	}

	// Add columns for grid style entries
	if ( $entry_style == 'grid-entry-style' ) {
		$classes[] = 'col';
		$classes[] = wpsp_grid_class( wpsp_blog_entry_columns() );
	}

	// No Featured Image Class, don't add if oembed or self hosted meta are defined
	if ( ! has_post_thumbnail()
		&& '' == get_post_meta( get_the_ID(), 'wpsp_post_oembed', true ) ) {
		$classes[] = 'no-featured-image';
	}

	// Blog entry style
	$classes[] = $entry_style;

	// Avatar
	if ( $avatar_enabled = wpsp_get_redux( 'blog-entry-author-avatar' ) ) {
		$classes[] = 'entry-has-avatar';
	}

	// Counter
	global $wpsp_count;
	if ( $wpsp_count ) {
		$classes[] = 'col-'. $wpsp_count;
	}

	// Apply filters to entry post class for child theming
	$classes = apply_filters( 'wpsp_blog_entry_classes', $classes );

	// Rturn classes array
	return $classes;
}
endif;

/**
 * Returns blog entry blocks
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_entry_layout_blocks' ) ) :
function wpsp_blog_entry_layout_blocks() {

	// Get layout blocks
	$blocks = wpsp_get_redux( 'blog-entry-block' );

	// If blocks are 100% empty return defaults
	$blocks = $blocks ? $blocks : 'featured_media,title,meta,excerpt_content,readmore';

	// Convert blocks to array so we can loop through them
	if ( ! is_array( $blocks ) ) {
		$blocks = explode( ',', $blocks );
	}

	// Set block keys equal to vals
	//$blocks = array_combine( $blocks, $blocks );

	// Apply filters to entry layout blocks after they are turned into an array
	$blocks = apply_filters( 'wpsp_blog_entry_layout_blocks', $blocks );

	// Return blocks
	return $blocks;

}
endif;

/**
 * Returns the blog entry thumbnail
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_entry_thumbnail' ) ) :
function wpsp_blog_entry_thumbnail( $args = '' ) {
	echo wpsp_get_blog_entry_thumbnail( $args );
}
endif;

/**
 * Returns the blog entry thumbnail
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_get_blog_entry_thumbnail' ) ) :
function wpsp_get_blog_entry_thumbnail( $args = '' ) {

	// If args isn't array then it's the attachment
	if ( $args && ! is_array( $args ) ) {
		$args = array(
			'attachment' => $args,
		);
	}

	// Define thumbnail args
	$defaults = array(
		'attachment'    => get_post_thumbnail_id(),
		'size'          => 'blog_entry',
		'alt'           => wpsp_get_esc_title(),
		'width'         => '',
		'height'        => '',
		'class'         => '',
	);

	// Parse arguments
	$args = wp_parse_args( $args, $defaults );

	// Custom sizes for categories
	if ( is_category() ) {

		// Get term data
		$term       = get_query_var('cat');
		$term_data  = get_option("category_$term");

		// Width
		if ( ! empty( $term_data['wpsp_term_image_width'] ) ) {
			$args['size']   = 'wpsp_custom';
			$args['width']  = $term_data['wpsp_term_image_width'];
		}

		// height
		if ( ! empty( $term_data['wpsp_term_image_height'] ) ) {
			$args['size']   = 'wpsp_custom';
			$args['height'] = $term_data['wpsp_term_image_height'];
		}

	}

	// Apply filter to args
	$args = apply_filters( 'wpsp_blog_entry_thumbnail_args', $args );

	// Generate thumbnail
	$thumbnail = wpsp_get_post_thumbnail( $args );

	// Return thumbnail
	return apply_filters( 'wpsp_blog_entry_thumbnail', $thumbnail );

}
endif;

/**
 * Returns blog entry post blocks
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_entry_meta_sections' ) ) :
function wpsp_blog_entry_meta_sections() {

	// Default sections
	$sections = array( 'date', 'author', 'categories', 'comments' );

	// Get Sections from Customizer
	$sections = wpsp_get_redux( 'blog-entry-meta-sections', $sections );

	// Turn into array if string
	if ( $sections && ! is_array( $sections ) ) {
		$sections = explode( ',', $sections );
	}

	// Apply filters for easy modification
	$sections = apply_filters( 'wpsp_blog_entry_meta_sections', $sections );

	// Return sections
	return $sections;

}
endif;

/**
 * Displays the blog post thumbnail
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_post_thumbnail' ) ) :
function wpsp_blog_post_thumbnail( $args = '' ) {
	echo wpsp_get_blog_post_thumbnail( $args );
}
endif;

/**
 * Returns the blog post thumbnail
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_get_blog_post_thumbnail' ) ) :
function wpsp_get_blog_post_thumbnail( $args = '' ) {

	// If args isn't array then it's the attachment
	if ( ! is_array( $args ) && ! empty( $args ) ) {
		$args = array(
			'attachment'    => $args,
			'alt'           => wpsp_get_esc_title(),
			'width'         => '',
			'height'        => '',
			'class'         => '',
			'schema_markup' => false,
		);
	}

	// Defaults
	$defaults = array(
		'size'          => 'blog_post',
		'schema_markup' => true,
	);

	// Parse arguments
	$args = wp_parse_args( $args, $defaults );

	// Apply filter to args
	$args = apply_filters( 'wpsp_blog_entry_thumbnail_args', $args );

	// Generate thumbnail
	$thumbnail = wpsp_get_post_thumbnail( $args );

	// Apply filters for child theming
	return apply_filters( 'wpsp_blog_post_thumbnail', $thumbnail );

}
endif;

/**
 * Returns single blog post blocks
 *
 * @since 2.0.0
 * @return array
 */
if ( ! function_exists( 'wpsp_blog_single_meta_sections' ) ) :
function wpsp_blog_single_meta_sections() {

	// Default sections
	$sections = array( 'date' => 1, 'author' => 1, 'categories' => 1, 'comments' => 1 );

	// Get Sections from Customizer
	$sections = wpsp_get_redux( 'blog-post-meta-sections', $sections );

	// Apply filters for easy modification
	$sections = apply_filters( 'wpsp_blog_single_meta_sections', $sections );

	// Turn into array if string
	if ( $sections && ! is_array( $sections ) ) {
		$sections = explode( ',', $sections );
	}

	// Return sections
	return $sections;

}
endif;

/**
 * Adds main classes to blog post entries
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_wrap_classes' ) ) :
function wpsp_blog_wrap_classes( $classes = NULL ) {
	
	// Return custom class if set
	if ( $classes ) {
		return $classes;
	}
	
	// Admin defaults
	$style   = wpsp_blog_style();
	$classes = array( 'entries', 'clear' );
		
	// Isotope classes
	if ( $style == 'grid-entry-style' ) {
		$classes[] = 'wpsp-row ';
		if ( 'masonry' == wpsp_blog_grid_style() ) {
			$classes[] = 'blog-masonry-grid ';
		} else {
			if ( 'infinite_scroll' == wpsp_blog_pagination_style() ) {
				$classes[] = 'blog-masonry-grid ';
			} else {
				$classes[] = 'blog-grid ';
			}
		}
	}

	// Left thumbs
	if ( 'thumbnail-entry-style' == $style ) {
		$classes[] = 'left-thumbs';
	}

	
	// Add some margin when author is enabled
	if ( $style == 'grid-entry-style' && wpsp_get_redux( 'blog-entry-author-avatar' ) ) {
		$classes[] = 'grid-w-avatars ';
	}
	
	// Infinite scroll classes
	if ( 'infinite_scroll' == wpsp_blog_pagination_style() ) {
		$classes[] = 'infinite-scroll-wrap ';
	}
	
	// Add filter for child theming
	$classes = apply_filters( 'wpsp_blog_wrap_classes', $classes );

	// Turn classes into space seperated string
	if ( is_array( $classes ) ) {
		$classes = implode( ' ', $classes );
	}

	// Echo classes
	echo esc_attr( $classes );
	
}
endif;

/**
 * Gets correct heading for the related blog items
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_related_heading' ) ) :
function wpsp_blog_related_heading() {
	$heading = wpsp_get_translated_theme_mod( 'blog_related_title' );
	$heading = $heading ? $heading : esc_html__( 'Related Posts', 'smallshop' );
	return $heading;
}
endif;

/**
 * Returns single blog post blocks
 *
 * @since 1.0.0
 * @return array
 */
if ( ! function_exists( 'wpsp_blog_single_layout_blocks' ) ) :
function wpsp_blog_single_layout_blocks() {

	// Get layout blocks
	$blocks = wpsp_get_redux( 'blog-single-block' );

	// If blocks are 100% empty return defaults
	$blocks = $blocks ? $blocks : 'featured_media,title,meta,post_series,the_content,post_tags,social_share,author_bio,related_posts,comments';

	// Convert blocks to array so we can loop through them
	if ( ! is_array( $blocks ) ) {
		$blocks = explode( ',', $blocks );
	}

	// Set block keys equal to vals
	//$blocks = array_combine( $blocks, $blocks );

	// Apply filters to entry layout blocks
	$blocks = apply_filters( 'wpsp_blog_single_layout_blocks', $blocks );

	// Return blocks
	return $blocks;

}
endif;


/*-------------------------------------------------------------------------------*/
/* [ Taxonomy & Terms ]
/*-------------------------------------------------------------------------------*/
/**
 * Returns the "category" taxonomy for a given post type
 *
 * @since 2.0.0
 */
if ( ! function_exists( 'wpsp_get_post_type_cat_tax' ) ) :
function wpsp_get_post_type_cat_tax( $post_type = '' ) {

	// Get the post type
	$post_type = $post_type ? $post_type : get_post_type();

	// Return taxonomy
	if ( 'post' == $post_type ) {
		$tax = 'category';
	} elseif ( 'portfolio' == $post_type ) {
		$tax = 'portfolio_category';
	} elseif ( 'staff' == $post_type ) {
		$tax = 'staff_category';
	} elseif ( 'testimonials' == $post_type ) {
		$tax = 'testimonials_category';
	} elseif ( 'product' == $post_type ) {
		$tax = 'product_cat';
	} elseif ( 'tribe_events' == $post_type ) {
		$tax = 'tribe_events_cat';
	} elseif ( 'download' == $post_type ) {
		$tax = 'download_category';
	} else {
		$tax = false;
	}

	// Apply filters & return
	return apply_filters( 'wpsp_get_post_type_cat_tax', $tax );

}
endif; 

/**
 * Check if a post has terms/categories
 *
 * This function is used for the next and previous posts so if a post is in a category it
 * will display next and previous posts from the same category.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_post_has_terms' ) ) :
	function wpsp_post_has_terms( $post_id = '', $post_type = '' ) {

		// Post data
		$post_id    = $post_id ? $post_id : get_the_ID();
		$post_type  = $post_type ? $post_type : get_post_type( $post_id );

		// Standard Posts
		if ( $post_type == 'post' ) {
			$terms = get_the_terms( $post_id, 'category');
			if ( $terms ) {
				return true;
			}
		}

		// Portfolio
		elseif ( 'portfolio' == $post_type ) {
			$terms = get_the_terms( $post_id, 'portfolio_category');
			if ( $terms ) {
				return true;
			}
		}

		// Staff
		elseif ( 'staff' == $post_type ) {
			$terms = get_the_terms( $post_id, 'staff_category');
			if ( $terms ) {
				return true;
			}
		}

		// Testimonials
		elseif ( 'testimonials' == $post_type ) {
			$terms = get_the_terms( $post_id, 'testimonials_category');
			if ( $terms ) {
				return true;
			}
		}

	}
endif;

/**
 * Check if term description should display above the loop.
 *
 * By default the term description displays in the subheading in the page header,
 * however, there are some built-in settings to enable the term description above the loop.
 * This function returns true if the term description should display above the loop and not in the header.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_has_term_description_above_loop' ) ) :
function wpsp_has_term_description_above_loop( $return = false ) {

	// Return true for tags and categories only
	if (  'above_loop' == wpsp_get_redux( 'category_description_position' )
		&& ( is_category() || is_tag() )
	) {
		$return = true;
	}

	// Apply filters
	$return = apply_filters( 'wpsp_has_term_description_above_loop', $return );

	// Return
	return $return;

}
endif;

/*-------------------------------------------------------------------------------*/
/* [ Authors ]
/*-------------------------------------------------------------------------------*/

/**
 * Check if current user has social profiles defined.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_author_has_social' ) ) :
function wpsp_author_has_social() {

	// Get global post object
	global $post;

	// Get post author
	$post_author = ! empty( $post->post_author ) ? $post->post_author : '';

	// Return if there isn't any post author
	if ( ! $post_author ) {
		return;
	}

	if ( get_the_author_meta( 'wpsp_twitter', $post_author ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpsp_facebook', $post_author ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpsp_googleplus', $post_author ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpsp_linkedin', $post_author ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpsp_pinterest', $post_author ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpsp_instagram', $post_author ) ) {
		return true;
	} else {
		return false;
	}

}
endif;


/*-------------------------------------------------------------------------------*/
/* [ Slider ]
/*-------------------------------------------------------------------------------*/

/**
 * Returns data attributes for the blog gallery slider
 *
 * @since 1.0.0
 * @return array
 */
function wpsp_blog_slider_data_atrributes() {

	// Define main vars
	$attributes                      = array();
	$data                            = '';
	$attributes['auto-play']         = 'false';
	$attributes['buttons']           = 'false';
	$attributes['fade']              = 'true';
	$attributes['loop']              = 'true';
	$attributes['thumbnails-height'] = '60';
	$attributes['thumbnails-width']  = '60';

	// Apply filters for child theming
	$attributes = apply_filters( 'wpsp_blog_slider_data_atrributes', $attributes );

	// Turn array into HTML
	foreach ( $attributes as $key => $val ) {
		echo ' data-'. esc_attr( $key ) .'="'. esc_attr( $val ) .'"';
	}

}
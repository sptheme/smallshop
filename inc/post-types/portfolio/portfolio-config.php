<?php 
/**
 * Portfolio custom post type
 *
 * @package Habitat Cambodia
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPSP_Cp_Portfolio' ) ) {
	class WPSP_Cp_Portfolio {
		
		private $label;

		/**
		 * Get things started.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Include helper functions first so we can use them in the class
			require_once( get_template_directory() .'/inc/post-types/portfolio/portfolio-helpers.php' );

			// Update vars
			$this->label = get_option( 'portfolio_labels' );
			$this->label = $this->label ? $this->label : _x( 'Portfolio', 'Portfolio Post Type Label', 'wpsp_admin' );

			// Adds the portfolio post type
			add_action( 'init', array( $this, 'register_post_type' ), 0 );

			// Adds the portfolio taxonomies
			if ( 'off' != get_option( 'portfolio_tags', 'on' ) ) {
				add_action( 'init', array( $this, 'register_tags' ), 0 );
			}
			if ( 'off' != get_option( 'portfolio_categories', 'on' ) ) {	
				add_action( 'init', array( $this, 'register_categories' ), 0 );
			}

			// Adds the portfolio custom sidebar
			if ( 'off' != get_option( 'portfolio_custom_sidebar', 'on' ) ) {
				add_filter( 'widgets_init', array( $this, 'register_sidebar' ) );
			}

			// Admin only actions
			if ( is_admin() ) {
				// Adds columns in the admin view for taxonomies
				add_filter( 'manage_edit-portfolio_columns', array( $this, 'edit_columns' ) );
				add_action( 'manage_portfolio_posts_custom_column', array( $this, 'column_display' ), 10, 2 );

				// Allows filtering of posts by taxonomy in the admin view
				add_action( 'restrict_manage_posts', array( $this, 'tax_filters' ) );

				// Create Editor for altering the post type arguments
				add_action( 'admin_menu', array( $this, 'add_page' ) );
				add_action( 'admin_init', array( $this,'register_page_options' ) );
				add_action( 'admin_notices', array( $this, 'notices' ) );
				add_action( 'admin_print_styles-portfolio_page_wpsp-portfolio-editor', array( $this,'css' ) );
			} else {
				
				// Display correct sidebar for portfolio items
				if ( 'off' != get_option( 'portfolio_custom_sidebar', 'on' ) ) {
					add_filter( 'wpsp_sidebar_primary', array( $this, 'display_sidebar' ) );
				}

				// Alter the post layouts for portfolio posts and archives
				add_filter( 'wpsp_post_layout_class', array( $this, 'layouts' ) );

				// Posts per page
				add_action( 'pre_get_posts', array( $this, 'posts_per_page' ) );	
			}

			

		}

		/**
		 * Register post type
		 *
		 * @since 1.0.0
		 */
		public function register_post_type() {

			// Get values and sanitize
			$name             = $this->label;
			$singular_name    = get_option( 'portfolio_singular_name' );
			$singular_name    = $singular_name ? $singular_name : esc_html__( 'Portfolio Item', 'wpsp_admin' );
			$slug  			  = get_option( 'portfolio_slug' );
			$slug             = $slug ? $slug : 'portfolio-item';
			$menu_icon        = get_option( 'portfolio_admin_icon' );
			$menu_icon        = $menu_icon ? $menu_icon : 'portfolio';
			$portfolio_search = ( 'off' != get_option( 'portfolio_search', 'on' ) ) ? false : true;

			// Args
			$args = array(
				'labels' => array(
					'name' => $name,
					'singular_name' => $singular_name,
					'add_new' => esc_html__( 'Add New', 'wpsp_admin' ),
					'all_items' => esc_html__( 'All ' . $name, 'wpsp_admin' ),
					'add_new_item' => esc_html__( 'Add New Item', 'wpsp_admin' ),
					'edit_item' => esc_html__( 'Edit Item', 'wpsp_admin' ),
					'new_item' => esc_html__( 'Add New Item', 'wpsp_admin' ),
					'view_item' => esc_html__( 'View Item', 'wpsp_admin' ),
					'search_items' => esc_html__( 'Search Items', 'wpsp_admin' ),
					'not_found' => esc_html__( 'No Items Found', 'wpsp_admin' ),
					'not_found_in_trash' => esc_html__( 'No Items Found In Trash', 'wpsp_admin' )
				),
				'public' => true,
				'capability_type' => 'post',
				'has_archive' => true,
				'menu_icon' => 'dashicons-'. $menu_icon,
				'menu_position' => 20,
				'exclude_from_search' => $portfolio_search,
				'rewrite' => array(
					'slug' => $slug,
				),
				'supports' => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
					'comments',
					'custom-fields',
					'revisions',
					'author',
					'page-attributes',
				),
			);

			// Register the post type
			register_post_type( 'portfolio', apply_filters( 'wpsp_portfolio_args', $args ) );

		}

		/**
		 * Register Portfolio tags.
		 *
		 * @since 1.0.0
		 */
		public static function register_tags() {

			// Define and sanitize options
			$name = esc_html( get_option( 'portfolio_tag_labels' ) );
			$name = $name ? $name : esc_html__( 'Portfolio Tags', 'wpsp_admin' );
			$slug = get_option( 'portfolio_tag_slug' );
			$slug = $slug ? $slug : 'portfolio-tag';

			// Define portfolio tag arguments
			$args = array(
				'labels' => array(
					'name' => $name,
					'singular_name' => $name,
					'menu_name' => $name,
					'search_items' => esc_html__( 'Search','wpsp_admin' ),
					'popular_items' => esc_html__( 'Popular', 'wpsp_admin' ),
					'all_items' => esc_html__( 'All', 'wpsp_admin' ),
					'parent_item' => esc_html__( 'Parent', 'wpsp_admin' ),
					'parent_item_colon' => esc_html__( 'Parent', 'wpsp_admin' ),
					'edit_item' => esc_html__( 'Edit', 'wpsp_admin' ),
					'update_item' => esc_html__( 'Update', 'wpsp_admin' ),
					'add_new_item' => esc_html__( 'Add New', 'wpsp_admin' ),
					'new_item_name' => esc_html__( 'New', 'wpsp_admin' ),
					'separate_items_with_commas' => esc_html__( 'Separate with commas', 'wpsp_admin' ),
					'add_or_remove_items' => esc_html__( 'Add or remove', 'wpsp_admin' ),
					'choose_from_most_used' => esc_html__( 'Choose from the most used', 'wpsp_admin' ),
				),
				'public' => true,
				'show_in_nav_menus' => true,
				'show_ui' => true,
				'show_tagcloud' => true,
				'hierarchical' => false,
				'rewrite' => array(
					'slug'  => $slug,
				),
				'query_var' => true,
			);

			// Apply filters
			$args = apply_filters( 'wpsp_taxonomy_portfolio_tag_args', $args );

			// Register the portfolio tag taxonomy
			register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $args );

		}

		/**
		 * Register Portfolio category.
		 *
		 * @since 1.0.0
		 */
		public static function register_categories() {

			// Define and sanitize options
			$name = esc_html( get_option( 'portfolio_cat_labels' ) );
			$name = $name ? $name : esc_html__( 'Portfolio Categories', 'wpsp_admin' );
			$slug = get_option( 'portfolio_cat_slug' );
			$slug = $slug ? $slug : 'portfolio-category';

			// Define portfolio category arguments
			$args = array(
				'labels' => array(
					'name' => $name,
					'singular_name' => $name,
					'menu_name' => $name,
					'search_items' => esc_html__( 'Search','wpsp_admin' ),
					'popular_items' => esc_html__( 'Popular', 'wpsp_admin' ),
					'all_items' => esc_html__( 'All', 'wpsp_admin' ),
					'parent_item' => esc_html__( 'Parent', 'wpsp_admin' ),
					'parent_item_colon' => esc_html__( 'Parent', 'wpsp_admin' ),
					'edit_item' => esc_html__( 'Edit', 'wpsp_admin' ),
					'update_item' => esc_html__( 'Update', 'wpsp_admin' ),
					'add_new_item' => esc_html__( 'Add New', 'wpsp_admin' ),
					'new_item_name' => esc_html__( 'New', 'wpsp_admin' ),
					'separate_items_with_commas' => esc_html__( 'Separate with commas', 'wpsp_admin' ),
					'add_or_remove_items' => esc_html__( 'Add or remove', 'wpsp_admin' ),
					'choose_from_most_used' => esc_html__( 'Choose from the most used', 'wpsp_admin' ),
				),
				'public' => true,
				'show_in_nav_menus' => true,
				'show_ui' => true,
				'show_tagcloud' => true,
				'hierarchical' => true,
				'rewrite' => array( 'slug' => $slug ),
				'query_var' => true
			);

			// Apply filters
			$args = apply_filters( 'wpsp_taxonomy_portfolio_category_args', $args );

			// Register the portfolio category taxonomy
			register_taxonomy( 'portfolio_category', array( 'portfolio' ), $args );

		}

		/**
		 * Adds columns to the WP dashboard edit screen.
		 *
		 * @since 1.0.0
		 */
		public static function edit_columns( $columns ) {
			if ( taxonomy_exists( 'portfolio_category' ) ) {
				$columns['portfolio_category'] = esc_html__( 'Category', 'wpsp_admin' );
			}
			if ( taxonomy_exists( 'portfolio_tag' ) ) {
				$columns['portfolio_tag']      = esc_html__( 'Tags', 'wpsp_admin' );
			}
			return $columns;
		}
		

		/**
		 * Adds columns to the WP dashboard edit screen.
		 *
		 * @since 1.0.0
		 */
		public static function column_display( $column, $post_id ) {

			switch ( $column ) :

				// Display the portfolio categories in the column view
				case 'portfolio_category':

					if ( $category_list = get_the_term_list( $post_id, 'portfolio_category', '', ', ', '' ) ) {
						echo $category_list;
					} else {
						echo '&mdash;';
					}

				break;

				break;

				// Display the portfolio tags in the column view
				case 'portfolio_tag':

					if ( $tag_list = get_the_term_list( $post_id, 'portfolio_tag', '', ', ', '' ) ) {
						echo $tag_list;
					} else {
						echo '&mdash;';
					}

				break;

			endswitch;

		}

		/**
		 * Adds taxonomy filters to the portfolio admin page.
		 *
		 * @since 1.0.0
		 */
		public static function tax_filters() {
			global $typenow;

			// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
			$taxonomies = array( 'portfolio_category', 'portfolio_tag' );

			// must set this to the post type you want the filter(s) displayed on
			if ( 'portfolio' == $typenow ) {

				foreach ( $taxonomies as $tax_slug ) {
					if ( ! taxonomy_exists( $tax_slug ) ) {
						continue;
					}
					$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
					$tax_obj = get_taxonomy( $tax_slug );
					$tax_name = $tax_obj->labels->name;
					$terms = get_terms($tax_slug);
					if ( count( $terms ) > 0) {
						echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
						echo "<option value=''>$tax_name</option>";
						foreach ( $terms as $term ) {
							echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
						}
						echo "</select>";
					}
				}
			}
		}

		/**
		 * Add sub menu page for the Portfolio Editor.
		 *
		 * @since 1.0.0
		 * @link    http://codex.wordpress.org/Function_Reference/add_theme_page
		 */
		public function add_page() {
			$wpsp_portfolio_editor = add_submenu_page(
				'edit.php?post_type=portfolio',
				esc_html__( 'Post Type Editor', 'wpsp_admin' ),
				esc_html__( 'Post Type Editor', 'wpsp_admin' ),
				'administrator',
				'wpsp-portfolio-editor',
				array( $this, 'create_admin_page' )
			);
			add_action( 'load-'. $wpsp_portfolio_editor, array( $this, 'flush_rewrite_rules' ) );
		}

		/**
		 * Flush re-write rules
		 *
		 * @since 1.1.0
		 */
		public static function flush_rewrite_rules() {
			$screen = get_current_screen();
			if ( $screen->id == 'portfolio_page_wpsp-portfolio-editor' ) {
				flush_rewrite_rules();
			}

		}

		/**
		 * Function that will register the portfolio editor admin page.
		 *
		 * @since 1.0.0
		 * @link    http://codex.wordpress.org/Function_Reference/register_setting
		 */
		public function register_page_options() {
			register_setting( 'wpsp_portfolio_options', 'wpsp_portfolio_editor', array( $this, 'sanitize' ) );
		}

		/**
		 * Displays saved message after settings are successfully saved
		 *
		 * @since 1.0.0
		 * @link    http://codex.wordpress.org/Function_Reference/settings_errors
		 */
		public static function notices() {
			settings_errors( 'wpsp_portfolio_editor_page_notices' );
		}

		/**
		 * Sanitizes input and saves theme_mods.
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// Save values to theme mod
			if ( ! empty ( $options ) ) {
				// Checkboxes
				$checkboxes = array(
					'portfolio_categories',
					'portfolio_tags',
					'portfolio_custom_sidebar',
					'portfolio_search',
				);
				foreach ( $checkboxes as $checkbox ) {
					if ( ! empty( $options[$checkbox] ) ) {
						delete_option( $checkbox );
						unset( $options[$checkbox] );
					} else {
						update_option( $checkbox, 'off' );
					}
				}

				// Not checkboxes
				foreach( $options as $key => $value ) {
					if ( $value ) {
						update_option( $key, $value );
					} else {
						delete_option( $key );
					}
				}
			}

			// Add notice
			add_settings_error(
				'wpsp_portfolio_editor_page_notices',
				esc_attr( 'settings_updated' ),
				esc_html__( 'Settings saved and rewrite rules flushed.', 'wpsp_admin' ),
				'updated'
			);

			// Lets delete the options as we are saving them into theme mods
			$options = '';
			return;
		}

		/**
		 * Output for the actual Portfolio Editor admin page.
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { ?>
			<div class="wrap">
				<h2><?php esc_html_e( 'Post Type Editor', 'wpsp_admin' ); ?></h2>
				<form method="post" action="options.php">
				<?php settings_fields( 'wpsp_portfolio_options' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Admin Icon', 'wpsp_admin' ); ?></th>
						<td>
							<?php
							// Mod
							$mod = get_option( 'portfolio_admin_icon', null );
							$mod = 'portfolio' == $mod ? '' : $mod;
							// Dashicons list
							$dashicons = wpsp_get_dashicons_array(); ?>
							<div id="wpsp-dashicon-select" class="wpsp-clr">
								<?php foreach ( $dashicons as $key => $val ) :
									$value = 'portfolio' == $key ? '' : $key;
									$class = $mod == $value ? 'button-primary' : 'button-secondary'; ?>
									<a href="#" data-value="<?php echo esc_attr( $value ); ?>" class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $key ); ?>"><span class="dashicons dashicons-<?php echo $key; ?>"></span></a>
								<?php endforeach; ?>
							</div>
							<input type="hidden" name="wpsp_portfolio_editor[portfolio_admin_icon]" id="wpsp-dashicon-select-input" value="<?php echo esc_attr( $mod ); ?>"></td>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Enable Custom Sidebar', 'total' ); ?></th>
						<?php
						// Get checkbox value
						$mod = get_option( 'portfolio_custom_sidebar', 'on' );
						$mod = 'off' != $mod ? 'on' : 'off'; // sanitize ?>
						<td><input type="checkbox" name="wpsp_portfolio_editor[portfolio_custom_sidebar]" value="<?php echo esc_attr( $mod ); ?>" <?php checked( $mod, 'on' ); ?> /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Include In Search', 'total' ); ?></th>
						<?php
						// Get checkbox value
						$mod = get_option( 'portfolio_search', 'on' );
						$mod = ( $mod && 'off' != $mod ) ? 'on' : 'off'; // sanitize ?>
						<td><input type="checkbox" name="wpsp_portfolio_editor[portfolio_search]" value="<?php echo esc_attr( $mod ); ?>" <?php checked( $mod, 'on' ); ?> /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Name', 'wpsp_admin' ); ?></th>
						<td><input type="text" name="wpsp_portfolio_editor[portfolio_labels]" value="<?php echo get_option( 'portfolio_labels' ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Post Type: Singular Name', 'wpsp_admin' ); ?></th>
						<td><input type="text" name="wpsp_portfolio_editor[portfolio_singular_name]" value="<?php echo get_option( 'portfolio_singular_name' ); ?>" /></td>
					</tr>
					<tr valign="top" id="wpsp-tags-enable">
						<th scope="row"><?php esc_html_e( 'Enable Tags', 'wpsp_admin' ); ?></th>
						<?php
						// Get checkbox value
						$mod = get_option( 'portfolio_tags', 'on' );
						$mod = 'off' != $mod ? 'on' : 'off'; // sanitize ?>
						<td><input type="checkbox" name="wpsp_portfolio_editor[portfolio_tags]" value="<?php echo esc_attr( $mod ); ?>" <?php checked( $mod, 'on' ); ?> /></td>
					</tr>
					<tr valign="top" id="wpsp-tags-label">
						<th scope="row"><?php esc_html_e( 'Tags: Label', 'wpsp_admin' ); ?></th>
						<td><input type="text" name="wpsp_portfolio_editor[portfolio_tag_labels]" value="<?php echo get_option( 'portfolio_tag_labels' ); ?>" /></td>
					</tr>
					<tr valign="top" id="wpsp-tags-slug">
						<th scope="row"><?php esc_html_e( 'Tags: Slug', 'wpsp_admin' ); ?></th>
						<td><input type="text" name="wpsp_portfolio_editor[portfolio_tag_slug]" value="<?php echo get_option( 'portfolio_tag_slug' ); ?>" /></td>
					</tr>
					<tr valign="top" id="wpsp-categories-enable">
						<th scope="row"><?php esc_html_e( 'Enable Categories', 'wpsp_admin' ); ?></th>
						<?php
						// Get checkbox value
						$mod = get_option( 'portfolio_categories', 'on' );
						$mod = 'off' != $mod ? 'on' : 'off'; // sanitize ?>
						<td><input type="checkbox" name="wpsp_portfolio_editor[portfolio_categories]" value="<?php echo esc_attr( $mod ); ?>" <?php checked( $mod, 'on' ); ?> /></td>
					</tr>
					<tr valign="top" id="wpsp-categories-label">
						<th scope="row"><?php esc_html_e( 'Categories: Label', 'wpsp_admin' ); ?></th>
						<td><input type="text" name="wpsp_portfolio_editor[portfolio_cat_labels]" value="<?php echo get_option( 'portfolio_cat_labels' ); ?>" /></td>
					</tr>
					<tr valign="top" id="wpsp-categories-slug">
						<th scope="row"><?php esc_html_e( 'Categories: Slug', 'wpsp_admin' ); ?></th>
						<td><input type="text" name="wpsp_portfolio_editor[portfolio_cat_slug]" value="<?php echo get_option( 'portfolio_cat_slug' ); ?>" /></td>
					</tr>
					
				</table>
				<?php submit_button(); ?>
				</form>	
				<script>
					( function( $ ) {
						"use strict";
						$( document ).ready( function() {
							// Dashicons
							var $buttons = $( '#wpsp-dashicon-select a' ),
								$input   = $( '#wpsp-dashicon-select-input' );
							$buttons.click( function() {
								var $activeButton = $( '#wpsp-dashicon-select a.button-primary' );
								$activeButton.removeClass( 'button-primary' ).addClass( 'button-secondary' );
								$( this ).addClass( 'button-primary' );
								$input.val( $( this ).data( 'value' ) );
								return false;
							} );
							// Categories enable/disable
							var $catsEnable   = $( '#wpsp-categories-enable input' ),
								$catsTrToHide = $( '#wpsp-categories-label, #wpsp-categories-slug' );
							if ( 'off' == $catsEnable.val() ) {
								$catsTrToHide.hide();
							}
							$( $catsEnable ).change(function () {
								if ( $( this ).is( ":checked" ) ) {
									$catsTrToHide.show();
								} else {
									$catsTrToHide.hide();
								}
							} );
							// Tags enable/disable
							var $tagsEnable   = $( '#wpsp-tags-enable input' ),
								$tagsTrToHide = $( '#wpsp-tags-label, #wpsp-tags-slug' );
							if ( 'off' == $tagsEnable.val() ) {
								$tagsTrToHide.hide();
							}
							$( $tagsEnable ).change(function () {
								if ( $( this ).is( ":checked" ) ) {
									$tagsTrToHide.show();
								} else {
									$tagsTrToHide.hide();
								}
							} );
						} );
					} ) ( jQuery );
				</script>
			</div>
		<?php }

		/**
		 * Post Type Editor CSS
		 *
		 * @since 1.1.0
		 */
		public static function css() { ?>
		
			<style type="text/css">
				#wpsp-dashicon-select { max-width: 800px; }
				#wpsp-dashicon-select a { display: inline-block; margin: 2px; padding: 0; width: 32px; height: 32px; line-height: 32px; text-align: center; }
				#wpsp-dashicon-select a .dashicons,
				#wpsp-dashicon-select a .dashicons-before:before { line-height: inherit; }
			</style>

		<?php }

		/**
		 * Registers a new custom portfolio sidebar.
		 *
		 * @since 1.0.0
		 */
		public static function register_sidebar() {

			// Get post type object to name sidebar correctly
			$obj            = get_post_type_object( 'portfolio' );
			$post_type_name = $obj->labels->name;

			// Register custom sidebar
			register_sidebar( array(
				'name'          => $post_type_name .' '. esc_html__( 'Sidebar', 'wpsp_admin' ),
				'id'            => 'portfolio_sidebar',
				'description'   => '',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
		}

		/**
		 * Alter main sidebar to display portfolio sidebar.
		 *
		 * @since 1.0.0
		 */
		public static function display_sidebar( $sidebar ) {

			// Display portfolio_sidebar where necessary
			if ( is_singular( 'portfolio' ) || wpsp_is_portfolio_tax() ) {
				$sidebar = 'portfolio_sidebar';
			}

			// Return correct sidebar to display
			return $sidebar;

		}

		/**
		 * Alter the post layouts for portfolio posts and archives.
		 *
		 * @since 1.0.0
		 */
		public static function layouts( $class ) {
			if ( is_singular( 'portfolio' ) && ( wpsp_get_redux('portfolio-single-layout') !='inherit' ) ) {
				$class = wpsp_get_redux( 'portfolio-single-layout', 'full-width' );
			} elseif ( wpsp_is_portfolio_tax() && ! is_search() ) {
				$class = wpsp_get_redux( 'portfolio-archive-layout', 'full-width' );
			}
			return $class;
		}
		
		/**
		 * Alters posts per page for the portfolio taxonomies.
		 *
		 * @since 1.0.0
		 * @link    http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
		 */
		public static function posts_per_page( $query ) {

			// Main Checks
			if ( is_admin() || ! $query->is_main_query() ) {
				return;
			}

			if ( wpsp_is_portfolio_tax() ) {
				$query->set( 'posts_per_page', wpsp_get_redux( 'portfolio-archive-posts-per-page', '12') );
				return;
			}

			// Alter seearch query to exclude type
			if ( 'off' != get_option( 'portfolio_search', 'on' ) && $query->is_search() ) {

				// Gather all searchable post types
				$types = get_post_types( array( 'exclude_from_search' => false ) );

				// Make sure you got the proper results, and that your post type is in the results
				if ( is_array( $types ) && in_array( 'portfolio', $types ) ) {

					// Remove the post type from the array
					unset( $types['portfolio'] );

					// Set the query to the remaining searchable post types
					$query->set( 'post_type', $types );

				}

			}
		}

	}	
}
$wpsp_cp_portfolio = new WPSP_Cp_Portfolio;
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
		}
	}

}

$wpsp_woocommerce_config = new WPSP_WooCommerce_Config();
<?php
/**
 * Plugin Name: WP eCommerce Toolbar
 * Description: A simple toolbar extension for users of The WPeCommerce plugin
 * Author: Nikhil Vimal
 * Author URI: http://nik.techvoltz.com
 * Version: 1.0
 * Plugin URI: https://wordpress.org/plugins/wp-ecommerce-toolbar/
 * License: GNU GPLv2+
 */

class WPecommerce_Admin_Bar {


	public function __construct() {
		add_action('admin_bar_menu', array( $this, 'admin_bar_nodes'),  999);

	}

	//The Toolbar Instance
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new WPecommerce_Admin_Bar();
		}
		return $instance;
	}

	/**
	 * The function that creates the menus (nodes) for the admin bar
	 *
	 * @param $wp_admin_bar The WordPress admin bar
	 */
	public function admin_bar_nodes( $wp_admin_bar ) {
		//only displayed on site, not in admin
		if ( ! is_admin()) {

			// Main Parent Node
			$wp_admin_bar->add_node( array(
					'id'    => 'wp_ecommerce_toolbar',
					'title' => 'WP eCommerce',
				)
			);

			$wp_admin_bar->add_node( array(
					'parent' => 'wp-logo',
					'id'    => 'wp_ecommerce_toolbar_about',
					'title' => 'About WP eCommerce',
					'href'  => 'https://wpecommerce.org/',
				)
			);

			$wp_admin_bar->add_node( array(
					'parent' => 'wp_ecommerce_toolbar',
					'id'    => 'wp_ecommerce_toolbar_products',
					'title' => 'Products',
					'href' => admin_url('edit.php?post_type=wpsc-product'),
				)
			);

			$wp_admin_bar->add_node( array(
					'parent' => 'wp_ecommerce_toolbar_products',
					'id'    => 'wp_ecommerce_toolbar_products_new',
					'title' => 'Add New',
					'href' => admin_url('post-new.php?post_type=wpsc-product'),
				)
			);

			$wp_admin_bar->add_node( array(
					'parent' => 'wp_ecommerce_toolbar',
					'id'    => 'wp_ecommerce_toolbar_coupons',
					'title' => 'Coupons',
					'href' => admin_url('edit.php?post_type=wpsc-product&page=wpsc-edit-coupons'),
				)
			);

			$wp_admin_bar->add_node( array(
					'parent' => 'wp_ecommerce_toolbar_coupons',
					'id'    => 'wp_ecommerce_toolbar_coupons_new',
					'title' => 'Add New',
					'href' => admin_url('edit.php?post_type=wpsc-product&page=wpsc-edit-coupons&wpsc-action=add_coupon'),
				)
			);

			$wp_admin_bar->add_node( array(
					'parent' => 'wp_ecommerce_toolbar',
					'id'    => 'wp_ecommerce_toolbar_variations',
					'title' => 'Variations',
					'href' => admin_url('edit-tags.php?taxonomy=wpsc-variation&post_type=wpsc-product'),
				)
			);

			$wp_admin_bar->add_node( array(
					'parent' => 'wp_ecommerce_toolbar',
					'id'    => 'wp_ecommerce_toolbar_settings',
					'title' => 'Settings',
					'href' => admin_url('options-general.php?page=wpsc-settings&tab=general'),
				)
			);

		}

	}


}

function load_wpecommerce_admin_bar() {
	if( !function_exists( 'is_plugin_active' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	//Check if plugin is activated, or else...
	if( is_plugin_active( 'wp-e-commerce/wp-shopping-cart.php' ) ) {

		return WPecommerce_Admin_Bar::init();

	}

}
add_action('plugins_loaded', 'load_wpecommerce_admin_bar');

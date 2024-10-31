<?php

defined( 'ABSPATH' ) or die( 'Keep Quit' );

// Add Plugin Action Link
// Enable Setting page Under Product Tab
// Add fields to enable/disable Product Notifier


if ( ! class_exists( 'PN_Settings_API' ) ) {

	class PN_Settings_API {

		private $setting_name = 'product_notifier';
		
		private $slug ;
		private $plugin_class ;

		public function __construct() {

			$this->plugin_class = product_notifier();

			$this->slug = 'wc-settings&tab=products&section=product_notifier';

			add_filter( 'plugin_action_links_' . $this->plugin_class->basename(), array( $this, 'plugin_action_links' ) );

			add_filter( 'woocommerce_get_sections_products', array($this,'add_section_in_prod_tab' ));

			add_filter( 'woocommerce_get_settings_products', array($this, 'product_notifier_settings' ), 10, 2 );

		}
		public function add_section_in_prod_tab($sections) {

			$sections['product_notifier'] = __( 'Product Notifier', WPN_PLUGIN_PREFIX );
			return $sections;
			
		}

		public function product_notifier_settings ( $settings, $current_section) {
			if ( $current_section == 'product_notifier' ) {
				$settings_slider = array();
				// Add Title to the Settings
				$settings_slider[] = array(
					 'name' => __( '', 'product-notifier' ), 
					 'type' => 'title',
					   'id' => 'product_notifier' );
				// Add first checkbox option
				$settings_slider[] = array(
					'name'     => __( 'Enable Message', 'product-notifier' ),
					'id'       => 'enable_notices',
					'type'     => 'checkbox',
					'desc' 		=> __( 'Mark this checkbox to enable message', 'product-notifier' ), 
					'css'      => 'min-width:500px;'
				);
					
				$settings_slider[] = array( 'type' => 'sectionend', 'id' => 'product_notifier' );
				return $settings_slider;
			
			/**
			 * If not, return the standard settings
			 **/
			} else {
				return $settings;
			}
		}

		public function plugin_action_links( $links ) {

			$url          = admin_url( sprintf( 'admin.php?page=%s', $this->slug ) );
			$plugin_links = array( sprintf( '<a href="%s">%s</a>', esc_url( $url ), esc_html__( 'Settings', 'product-notifier') ) );

			return array_merge( $plugin_links, $links );
		}

	}
}
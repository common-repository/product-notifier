<?php

defined( 'ABSPATH' ) or die( 'Keep Quit' );

// Enable Notice Field inside Product Tab


if ( ! class_exists( 'PN_Products_API' ) ) {

	class PN_Products_API {
		
		private $slug ;
		private $plugin_class ;

		public function __construct() {
            
			add_action( 'woocommerce_product_options_advanced', array($this,'woocommerce_product_notices_field' )); 
			add_action( 'woocommerce_process_product_meta', array($this,'woocommerce_product_notices_field_save' ));

		}
       public function woocommerce_product_notices_field () {
		   global $woocommerce, $post;
	   
			// Get the selected value  <== <== (updated)
			$_product_notifier = get_post_meta( $post->ID, '_product_notifier', true );
			$_enable_notice = get_post_meta( $post->ID, '_enable_notice', true );

			$_enable_btn = get_post_meta( $post->ID, '_enable_btn', true );
			$_button_text = get_post_meta( $post->ID, '_button_text', true );
			$_button_url = get_post_meta( $post->ID, '_button_url', true );
			
		
			// Checkbox
			woocommerce_wp_checkbox(
				array(
					'id'            => '_enable_notice',
					'label'         => __('Enable Message for this Product', 'product-notifier' ),
					'value'       => $_enable_notice
				)
			);
					
		   woocommerce_wp_textarea_input(
				array(
				'id'          => '_product_notifier',
				'label'       => __( 'Please enter your message to display as headline', 'product-notifier' ),
				'placeholder' => '....',
				'desc_tip'    => 'true',
				'value'       => $_product_notifier,
				'class'      => 'sadsa'
				)
		   );

		   	// Checkbox for Button
			woocommerce_wp_checkbox(
				array(
					'id'            => '_enable_btn',
					'label'         => __('Enable Button for this Product', 'product-notifier' ),
					'value'       => $_enable_btn
				)
			);
		
						
			woocommerce_wp_text_input(
				array(
				'id'          => '_button_text',
				'label'       => __( 'Please Button Text ', 'product-notifier' ),
				'placeholder' => '....',
				'desc_tip'    => 'true',
				'value'       => $_button_text
				)
		   );

		   woocommerce_wp_text_input(
				array(
				'id'          => '_button_url',
				'label'       => __( 'Please Button URL', 'product-notifier' ),
				'placeholder' => '....',
				'desc_tip'    => 'true',
				'value'       => $_button_url
				)
		   );
		   

		   }
		
		public function woocommerce_product_notices_field_save( $post_id ){
		   
			 
			   $_product_notifier = sanitize_text_field($_POST['_product_notifier']);
			   if( !empty( $_product_notifier ) )
				   update_post_meta( $post_id, '_product_notifier',  $_product_notifier  );
			   else {
				   update_post_meta( $post_id, '_product_notifier',  '' );
			   }
		
			   $_enable_notice = sanitize_text_field($_POST['_enable_notice']);
			   if( !empty( $_enable_notice ) )
				   update_post_meta( $post_id, '_enable_notice',  $_enable_notice  );
			   else {
				   update_post_meta( $post_id, '_enable_notice',  '' );
			   }

			   $_enable_btn = sanitize_text_field($_POST['_enable_btn']);
			   if( !empty( $_enable_btn ) )
				   update_post_meta( $post_id, '_enable_btn',  $_enable_btn  );
			   else {
				   update_post_meta( $post_id, '_enable_btn',  '' );
			   }

			   $_button_text = sanitize_text_field($_POST['_button_text']);
			   if( !empty( $_button_text ) )
				   update_post_meta( $post_id, '_button_text',  $_button_text  );
			   else {
				   update_post_meta( $post_id, '_button_text',  '' );
			   }

			   $_button_url = sanitize_text_field($_POST['_button_url']);
			   if( !empty( $_button_url ) )
				   update_post_meta( $post_id, '_button_url',  $_button_url  );
			   else {
				   update_post_meta( $post_id, '_button_url',  '' );
			   }

			   
		   }
		   
	   
        }
	}

new PN_Products_API();
//https://gist.github.com/maddisondesigns/e7ee7eef7588bbba2f6d024a11e8875a?permalink_comment_id=3041024
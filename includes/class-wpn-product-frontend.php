<?php

defined( 'ABSPATH' ) or die( 'Keep Quit' );

// Enable Notice Field inside Product Tab


if ( ! class_exists( 'PN_Products_Frontend' ) ) {

	class PN_Products_Frontend {

        public function __construct() {
            add_action('wp_head', array($this,'display_popup'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_css_assets'));
        }

        public function enqueue_css_assets() {
            wp_enqueue_style( 'prmotion-notices-css', WPN_PLUGIN_FILE.'includes/style.css');
        }
        public function display_popup() {

            if( is_product() && 'yes' == get_option('enable_notices') && 'yes' == get_post_meta(get_the_ID(),'_enable_notice',true) ) {
          ?>
          <div id="ofBar">
                <div id="ofBar-content"> <?php echo get_post_meta(get_the_ID(),'_product_notifier',true); ?></div>
                <?php
            
                if('yes' == get_post_meta(get_the_ID(),'_enable_btn',true) && !empty(get_post_meta(get_the_ID(),'_button_text',true))) { 
                    $btn_text = get_post_meta(get_the_ID(),'_button_text',true);
                    $btn_url = get_post_meta(get_the_ID(),'_button_url',true);

                    ?>
                    <div id="ofBar-right">
                        <a href="<?php echo esc_url($btn_url); ?>" target="_blank" id="btn-bar">
                            <?php echo esc_html( $btn_text); ?>
                        </a>
                    <?php } ?>
                <a id="close-bar">×</a></div>
          </div>
          <script>
                jQuery(document).ready(function(){
                   jQuery("#close-bar").on("click",function(){
                       jQuery("#ofBar").remove();
                   });
                });
          </script>
          <?php } ?>
          <?php
        }
    }
}


 if(!is_admin()) {
    new PN_Products_Frontend();
 }
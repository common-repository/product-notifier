<?php
/**
 * Plugin Name: Product Notifier
 * Description: Once click to enable/disable Notification. This plugin help you to display messages/alerts on product single template.
 * Plugin URI: #
 * Author: Mitch Bom
 * Author URI: http://mitchbom.com
 * Version: 1.0.1
 * Text Domain: product-notifier
 */

defined( 'ABSPATH' ) || die( 'Keep Silent' );

class Product_Notifier {

	protected $_version = '1.0.0';
	private $_settings_api;
	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	
	public function __construct() {

		 $this->constants();
		 $this->includes();
		 $this->hooks();
	}

	public function constants() {
		$this->define( 'WPN_PLUGIN_NAME', 'Product Notifier' );
		$this->define( 'WPN_PLUGIN_PREFIX', 'product-notifier' );

		$this->define( 'WPN_PLUGIN_FILE', plugin_dir_url( __FILE__ ) );
		$this->define( 'WPN_PLUGIN_URL', plugin_dir_path( __FILE__ ) );

		$this->define( 'WPN_VERSION', $this->version() );
		$this->define( 'WPN_PLUGIN_INCLUDE_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'includes' ) );

		$this->define( 'WPN_PLUGIN_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
		$this->define( 'WPN_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		$this->define( 'WPN_PLUGIN_FILE', __FILE__ );
	}

	public function includes() {
		if ( $this->is_required_php_version() && $this->is_wc_active() ) {
			require_once $this->include_path( 'class-wpn-settings-tab-api.php' );
			require_once $this->include_path( 'class-wpn-product-options-api.php' );
			require_once $this->include_path( 'class-wpn-product-frontend.php' );
		}
	}

	public function define( $name, $value, $case_insensitive = false ) {
		if ( ! defined( $name ) ) {
			define( $name, $value, $case_insensitive );
		}
	}

	public function include_path( $file ) {
		return WPN_PLUGIN_INCLUDE_PATH .$file;
	}

	public function hooks() {
		add_action( 'admin_notices', array( $this, 'wc_requirement_notice' ) );
		
		if ( $this->is_required_php_version() && $this->is_wc_active() ) {

			add_action( 'init', array( $this, 'settings_api' ), 5 );

		}
	 }

	
	 public function php__requirement_notice() {
		if ( ! $this->is_required_php_version() ) {
			$class   = 'notice notice-error';
			$text    = esc_html__( 'Please check PHP version requirement.', ' product-notifier' );
			$link    = esc_url( 'https://docs.woocommerce.com/document/server-requirements/' );
			$message = wp_kses( __( "It's required to use latest version of PHP to use <strong>${WPN_PLUGIN_NAME}</strong>.", 'product-notifier' ), array( 'strong' => array() ) );

			printf( '<div class="%1$s"><p>%2$s <a target="_blank" href="%3$s">%4$s</a></p></div>', $class, $message, $link, $text );
		}
	}

	public function basename() {
		return WPN_PLUGIN_BASENAME;
	}

	public function wc_requirement_notice() {

		if ( ! $this->is_wc_active() ) {
			?>
			<div class="error">
				<p>
					<?php
					echo sprintf( esc_html__( 'Product Notifier is activated but not effective. It requires %sWooCommerce Plugin%s in order to use its functionalities.', WPN_PLUGIN_PREFIX ), '<a href="' . esc_url( '//wordpress.org/plugins/woocommerce/' ) . '" target="_blank">', '</a>' );
					?>
				</p>
			</div>
			<?php
			
		}
	
	}
	public function version() {
		return esc_attr( $this->_version );
	}
	public function is_wc_active() {
		return class_exists( 'WooCommerce' );
	}
	public function is_required_php_version() {
		return version_compare( PHP_VERSION, '5.6.0', '>=' );
	}
	public function settings_api() {

		if ( ! $this->_settings_api ) {
			$this->_settings_api = new PN_Settings_API();
		}

		return $this->_settings_api;
	}
	public function dirname() {
		return WPN_PLUGIN_DIRNAME;
	}
	
}

function product_notifier() {
	return Product_Notifier::instance();
}

add_action( 'plugins_loaded', 'product_notifier', 20 );


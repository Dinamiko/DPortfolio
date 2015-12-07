<?php
/*
 * Plugin Name: DPortfolio
 * Version: 2.0
 * Plugin URI: http://wp.dinamiko.com/demos/dportfolio /
 * Description: Filterable Portfolio with Custom Post Type DPortfolio and Shorcode [dportfolio] 
 * Author: Emili Castells
 * Author URI: http://www.dinamiko.com
 * Requires at least: 3.9.0
 * Tested up to: 4.3.1
 *
 * Text Domain: dportfolio
 * Domain Path: /languages/
 */


if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DPORTFOLIO' ) ) {

	final class DPORTFOLIO {

		private static $instance;

		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof DPORTFOLIO ) ) {

				self::$instance = new DPORTFOLIO;

				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'dportfolio_load_textdomain' ) );				
				
				self::$instance->includes();	

			}

			return self::$instance;

		}

		public function dportfolio_load_textdomain() {

			load_plugin_textdomain( 'dportfolio', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

		}

		private function setup_constants() {

			if ( ! defined( 'DPORTFOLIO_VERSION' ) ) { define( 'DPORTFOLIO_VERSION', '2.0' ); }
			if ( ! defined( 'DPORTFOLIO_PLUGIN_DIR' ) ) { define( 'DPORTFOLIO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); }
			if ( ! defined( 'DPORTFOLIO_PLUGIN_URL' ) ) { define( 'DPORTFOLIOPLUGIN_URL', plugin_dir_url( __FILE__ ) ); }
			if ( ! defined( 'DPORTFOLIO_PLUGIN_FILE' ) ) { define( 'DPORTFOLIO_PLUGIN_FILE', __FILE__ ); }			

		}

		private function includes() {
			
			// settings / metaboxes
			if ( is_admin() ) {

				require_once DPORTFOLIO_PLUGIN_DIR . 'includes/class-dportfolio-settings.php';
				$settings = new DPORTFOLIO_Settings( $this );

				require_once DPORTFOLIO_PLUGIN_DIR . 'includes/class-dportfolio-admin-api.php';
				$this->admin = new DPORTFOLIO_Admin_API();

				require_once DPORTFOLIO_PLUGIN_DIR . 'includes/dportfolio-metaboxes.php';

			}

			// shortcodes
			require_once DPORTFOLIO_PLUGIN_DIR . 'includes/class-dportfolio-template-loader.php';
			require_once DPORTFOLIO_PLUGIN_DIR . 'includes/dportfolio-shortcodes.php';

			// load css / js
			require_once DPORTFOLIO_PLUGIN_DIR . 'includes/dportfolio-load-js-css.php';						

			// functions
			require_once DPORTFOLIO_PLUGIN_DIR . 'includes/dportfolio-functions.php';

			// custom post type and taxonomy				
			require_once DPORTFOLIO_PLUGIN_DIR . 'includes/class-dportfolio-post-type.php';
			require_once DPORTFOLIO_PLUGIN_DIR . 'includes/class-dportfolio-taxonomy.php';
			require_once DPORTFOLIO_PLUGIN_DIR . 'includes/dportfolio-setup-post-types-taxonomies.php';

			// activation
			require_once DPORTFOLIO_PLUGIN_DIR . 'includes/dportfolio-activation.php';

		}

		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dportfolio' ), DPORTFOLIO_VERSION );
		}

		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dportfolio' ), DPORTFOLIO_VERSION );
		}

	}

}

function DPORTFOLIO() {

	return DPORTFOLIO::instance();

}

DPORTFOLIO();

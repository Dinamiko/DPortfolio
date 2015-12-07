<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class DPortfolio {

	private static $_instance = null;

	public $settings = null;
	public $_version;
	public $_token;
	public $file;
	public $dir;
	public $assets_dir;
	public $assets_url;

	public function __construct ( $file = '', $version = '1.0' ) {

		$this->_version = $version;
		$this->_token = 'dportfolio';

		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

		register_activation_hook( $this->file, array( $this, 'install' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ));
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));

		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );

	}

	public function enqueue_styles () {
		wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-frontend' );
	}

	public function enqueue_scripts () {

		wp_register_script( $this->_token . '-imagesloaded', esc_url( $this->assets_url ) . 'js/imagesloaded.pkgd.min.js', array( 'jquery' ), $this->_version, true );
		wp_enqueue_script( $this->_token . '-imagesloaded' );

		wp_enqueue_script('masonry');	

		wp_register_script( $this->_token . '-multipleFilterMasonry', esc_url( $this->assets_url ) . 'js/multipleFilterMasonry.js', array( 'jquery' ), $this->_version, true );
		wp_enqueue_script( $this->_token . '-multipleFilterMasonry' );

		wp_register_script( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'js/frontend.js', array( 'jquery' ), $this->_version, true );
		wp_enqueue_script( $this->_token . '-frontend' );

	}

	public function load_localisation () {
		load_plugin_textdomain( 'dportfolio', false, dirname( plugin_basename( $this->file ) ) . '/languages/' );
	} 

	public function load_plugin_textdomain () {

	    $domain = 'dportfolio';
	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/languages/' );

	}

	public static function instance ( $file = '', $version = '1.0.0' ) {

		if ( is_null( self::$_instance ) ) {

			self::$_instance = new self( $file, $version );

		}

		return self::$_instance;

	}

	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} 

	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	}

	public function install () {

		$this->_log_version_number();

		flush_rewrite_rules();

	}

	private function _log_version_number () {

		update_option( $this->_token . '_version', $this->_version );

	}

}
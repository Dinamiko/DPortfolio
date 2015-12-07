<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class DPORTFOLIO_Settings {

	private static $_instance = null;
	public $parent = null;
	public $_token;
	public $base = '';
	public $settings = array();

	public function __construct ( $parent ) {

		$this->parent = $parent;

		$this->base = 'dportfolio_';

		// Initialise settings
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page	
		add_filter( 'plugin_action_links_' . plugin_basename( DPORTFOLIO_PLUGIN_FILE ) , array( $this, 'add_settings_link' ) );
		
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Adds DPorfolio admin menu
	 * @return void
	 */
	public function add_menu_item () {
		
		// main menu
		$page = add_menu_page( 'DPorfolio', 'DPorfolio', 'manage_options', 'dportfolio' . '_settings',  array( $this, 'settings_page' ) );	

		// support
		//add_submenu_page( 'dportfolio' . '_settings', 'Support', 'Support', 'manage_options', 'dportfolio-support', array( $this, 'dportfolio_support_screen' ));

		/*
		// Addons submenu
		add_submenu_page( 'dportfolio' . '_settings', 'Addons', 'Addons', 'manage_options', 'dportfolio-addons', array( $this, 'dportfolio_addons_screen' ));
		*/
		
		// settings assets
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );

	}

	public function dportfolio_support_screen() { ?>
		
		<div class="wrap">
			<h2>DPorfolio Support</h2>

			<div class="dportfolio-item">			
				<h3>Documentation</h3>
				<p>Everything you need to know for getting DPorfolio up and running.</p>
				<p><a href="http://wp.dinamiko.com/demos/dportfolio/documentation/" target="_blank">Go to Documentation</a></p>
			</div>

			<div class="dportfolio-item">			
				<h3>Support</h3>
				<p>Having trouble? don't worry, create a ticket in the support forum.</p>
				<p><a href="https://wordpress.org/support/plugin/dportfolio" target="_blank">Go to Support</a></p>
			</div>

		</div>

	<?php }

	/*
	public function dportfolio_addons_screen() { ?>

		<div class="wrap">
			<h2>DPorfolio Addons</h2>

			<div class="">			
				<h3></h3>
				<p></p>
			</div>

		</div>

	<?php }
	*/

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets () {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the dportfolio-admin-js script below
		wp_enqueue_style( 'farbtastic' );
    	wp_enqueue_script( 'farbtastic' );

    	// We're including the WP media scripts here because they're needed for the image upload field
    	// If you're not including an image upload then you can leave this function call out
    	wp_enqueue_media();

    	
    	wp_register_script( 'dportfolio' . '-settings-js', plugins_url( 'dportfolio/assets/js/settings-admin.js' ), array( 'farbtastic', 'jquery' ), '1.0.0' );
    	wp_enqueue_script( 'dportfolio' . '-settings-js' );
    	
    	
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="admin.php?page=' . 'dportfolio' . '_settings">' . __( 'Settings', 'dportfolio' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

		// dportfolio settings
		$settings['dpbasic'] = array(
			'title'					=> '',
			'description'			=> '',
			'fields'				=> array(				
				array(
					'id' 			=> 'portfolio_slug',
					'label'			=> __( 'Portfolio Slug' , 'dportfolio' ),
					'description'	=> '',
					'type'			=> 'text',
					'default'		=> 'dportfolio',
					'placeholder'	=> ''
				),
				
			)
		);


		$settings = apply_filters( 'dportfolio' . '_settings_fields', $settings );

		return $settings;

	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = $_GET['tab'];
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section != $section ) continue;

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'dportfolio' . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( 'dportfolio' . '_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), 'dportfolio' . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );
				}

				if ( ! $current_section ) break;
			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

		// Build page HTML
		$html = '<div class="wrap" id="' . 'dportfolio' . '_settings">' . "\n";
			$html .= '<h2>' . __( 'DPorfolio Settings' , 'dportfolio' ) . '</h2>' . "\n";

			$tab = '';
			if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
				$tab .= $_GET['tab'];
			}

			// Show page tabs
			if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

				$html .= '<h2 class="nav-tab-wrapper">' . "\n";

				$c = 0;
				foreach ( $this->settings as $section => $data ) {

					// Set tab class
					$class = 'nav-tab';
					if ( ! isset( $_GET['tab'] ) ) {
						if ( 0 == $c ) {
							$class .= ' nav-tab-active';
						}
					} else {
						if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
							$class .= ' nav-tab-active';
						}
					}

					// Set tab link
					$tab_link = add_query_arg( array( 'tab' => $section ) );
					if ( isset( $_GET['settings-updated'] ) ) {
						$tab_link = remove_query_arg( 'settings-updated', $tab_link );
					}

					// Output tab
					$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

					++$c;
				}

				$html .= '</h2>' . "\n";
			}

			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

				// Get settings fields
				ob_start();
				settings_fields( 'dportfolio' . '_settings' );
				do_settings_sections( 'dportfolio' . '_settings' );
				$html .= ob_get_clean();

				$html .= '<p class="submit">' . "\n";
					$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'dportfolio' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";

		$html .= '</div>' . "\n";

		echo $html;
	}

	/**
	 * Main DPORTFOLIO_Settings Instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __wakeup()

}
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

		$page = add_submenu_page('edit.php?post_type=dportfolio', __('Settings','dportfolio'), __('Settings','dportfolio'), 'manage_options', 'dportfolio_settings', array( $this, 'settings_page' ) );
		
		add_submenu_page('edit.php?post_type=dportfolio', __('Support','dportfolio'), __('Support','dportfolio'), 'manage_options', 'dportfolio_support', array( $this, 'dportfolio_support_screen' ) );
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
		$settings_link = '<a href="edit.php?post_type=dportfolio&page=dportfolio_settings">'. __( 'Settings', 'dportfolio' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

		// Thumbnails
		$settings['thumbnails'] = array(
			'title'					=> __( 'Thumbnails', 'dportfolio' ),
			'description'			=> __( '', 'dportfolio' ),
			'fields'				=> array(
				array(
					'id' 			=> 'show_content',
					'label'			=> __( 'Show content', 'dportfolio' ),
					'description'	=> __( '', 'dportfolio' ),
					'type'			=> 'checkbox',
					'default'		=> 'on'
				),
				array(
					'id' 			=> 'content_words',
					'label'			=> __( 'Content length' , 'dportfolio' ),
					'description'	=> __( 'Number of words.', 'dportfolio' ),
					'type'			=> 'number',
					'default'		=> 20,
					'placeholder'	=> __( '20', 'dportfolio' )
				),
				array(
					'id' 			=> 'show_details',
					'label'			=> __( 'Show details', 'dportfolio' ),
					'description'	=> __( '', 'dportfolio' ),
					'type'			=> 'checkbox',
					'default'		=> 'on'
				),	
				array(
					'id' 			=> 'show_categories',
					'label'			=> __( 'Show categories', 'dportfolio' ),
					'description'	=> __( '', 'dportfolio' ),
					'type'			=> 'checkbox',
					'default'		=> 'on'
				),	
										
				array(
					'id' 			=> 'columns_gutter',
					'label'			=> __( 'Columns gutter' , 'dportfolio' ),
					'description'	=> __( '', 'dportfolio' ),
					'type'			=> 'number',
					'default'		=> 30,
					'placeholder'	=> __( '30', 'dportfolio' )
				),				
			)
		);

		// Portfolio page
		$settings['portfoliopage'] = array(
			'title'					=> __( 'Portfolio page', 'dportfolio' ),
			'description'			=> __( '', 'dportfolio' ),
			'fields'				=> array(
				array(
					'id' 			=> 'portfolio_page_show_details',
					'label'			=> __( 'Show details', 'dportfolio' ),
					'description'	=> __( '', 'dportfolio' ),
					'type'			=> 'checkbox',
					'default'		=> 'on'
				),
				array(
					'id' 			=> 'portfolio_page_show_categories',
					'label'			=> __( 'Show categories', 'dportfolio' ),
					'description'	=> __( '', 'dportfolio' ),
					'type'			=> 'checkbox',
					'default'		=> 'on'
				),				
			)
		);

		// dportfolio settings
		$settings['urlslugs'] = array(
			'title'					=> __( 'URL slugs', 'dportfolio' ),
			'description'			=> __( 'Change default DPortfolio URL slugs.', 'dportfolio' ),
			'fields'				=> array(				
				array(
					'id' 			=> 'portfolio_slug',
					'label'			=> __( 'Portfolio URL slug' , 'dportfolio' ),
					'description'	=> __( 'Once changed, go to Settings / Permalinks page and Save Changes.', 'dportfolio' ),
					'type'			=> 'text',
					'default'		=> 'dportfolio',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'categories_slug',
					'label'			=> __( 'Categories URL slug' , 'dportfolio' ),
					'description'	=> __( 'Once changed, go to Settings / Permalinks page and Save Changes.', 'dportfolio' ),
					'type'			=> 'text',
					'default'		=> 'dportfolio_categories',
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
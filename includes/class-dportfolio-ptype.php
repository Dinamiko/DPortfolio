<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class DPortfolioPType {

	private static $_instance = null;

	public $parent = null;
	public $post_type;

	public function __construct ( $parent ) {

		$this->parent = $parent;
		$this->post_type = 'dportfolio';

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		if ( is_admin() ) {

			add_action( 'admin_menu', array( $this, 'meta_box_setup' ), 20 );
			add_action( 'save_post', array( $this, 'meta_box_save' ) );

			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

		}

		add_shortcode( 'dportfolio', array( $this, 'dportfolio_shortcode' ) );

	}

	public function register_post_type () {

		$labels = array(
			'name' => _x( 'DPortfolio', 'post type general name' , 'dportfolio' ),
			'singular_name' => _x( 'Single DPortfolio', 'post type singular name' , 'dportfolio' ),
			'add_new' => _x( 'Add New', $this->post_type , 'dportfolio' ),
			'add_new_item' => sprintf( __( 'Add New %s' , 'dportfolio' ), __( 'Post' , 'dportfolio' ) ),
			'edit_item' => sprintf( __( 'Edit %s' , 'dportfolio' ), __( 'Post' , 'dportfolio' ) ),
			'new_item' => sprintf( __( 'New %s' , 'dportfolio' ), __( 'Post' , 'dportfolio' ) ),
			'all_items' => sprintf( __( 'All %s' , 'dportfolio' ), __( 'DPortfolio' , 'dportfolio' ) ),
			'view_item' => sprintf( __( 'View %s' , 'dportfolio' ), __( 'Post' , 'dportfolio' ) ),
			'search_items' => sprintf( __( 'Search %a' , 'dportfolio' ), __( 'DPortfolio' , 'dportfolio' ) ),
			'not_found' =>  sprintf( __( 'No %s Found' , 'dportfolio' ), __( 'DPortfolio' , 'dportfolio' ) ),
			'not_found_in_trash' => sprintf( __( 'No %s Found In Trash' , 'dportfolio' ), __( 'DPortfolio' , 'dportfolio' ) ),
			'parent_item_colon' => '',
			'menu_name' => __( 'DPortfolio' , 'dportfolio' )
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $this->post_type ),
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'menu_position' => 5,
			'menu_icon' => 'dashicons-portfolio'
		);

		register_post_type( $this->post_type, $args );

	}

	public function register_taxonomy () {

        $labels = array(
            'name' => __( 'Categories' , 'dportfolio' ),
            'singular_name' => __( 'Category', 'dportfolio' ),
            'search_items' =>  __( 'Search Categories' , 'dportfolio' ),
            'all_items' => __( 'All Categories' , 'dportfolio' ),
            'parent_item' => __( 'Parent Category' , 'dportfolio' ),
            'parent_item_colon' => __( 'Parent Category:' , 'dportfolio' ),
            'edit_item' => __( 'Edit Category' , 'dportfolio' ),
            'update_item' => __( 'Update Category' , 'dportfolio' ),
            'add_new_item' => __( 'Add New Category' , 'dportfolio' ),
            'new_item_name' => __( 'New Category Name' , 'dportfolio' ),
            'menu_name' => __( 'Categories' , 'dportfolio' ),
        );

        $args = array(
            'public' => true,
            'hierarchical' => true,
            'rewrite' => true,
            'labels' => $labels,
            'show_admin_column' => true
        );

        register_taxonomy( 'dportfolio_categories' , $this->post_type , $args );
    }


	public function meta_box_setup () {

		add_meta_box( 'post-data', __( 'DPortfolio Details' , 'dportfolio' ), array( $this, 'meta_box_content' ), $this->post_type, 'normal', 'high' );
	
	}

	public function meta_box_content () {

		global $post_id;
		$fields = get_post_custom( $post_id );
		$field_data = $this->get_custom_fields_settings();

		$html = '';

		$html .= '<input type="hidden" name="' . $this->post_type . '_nonce" id="' . $this->post_type . '_nonce" value="' . wp_create_nonce( plugin_basename( $this->parent->dir ) ) . '" />';

		if ( 0 < count( $field_data ) ) {
			$html .= '<table class="form-table">' . "\n";
			$html .= '<tbody>' . "\n";

			foreach ( $field_data as $k => $v ) {
				$data = $v['default'];

				if ( isset( $fields[$k] ) && isset( $fields[$k][0] ) ) {
					$data = $fields[$k][0];
				}

				if( $v['type'] == 'checkbox' ) {
					$html .= '<tr valign="top"><th scope="row">' . $v['name'] . '</th><td><input name="' . esc_attr( $k ) . '" type="checkbox" id="' . esc_attr( $k ) . '" ' . checked( 'on' , $data , false ) . ' /> <label for="' . esc_attr( $k ) . '"><span class="description">' . $v['description'] . '</span></label>' . "\n";
					$html .= '</td></tr>' . "\n";
				} else {
					$html .= '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . $v['name'] . '</label></th><td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
					$html .= '<p class="description">' . $v['description'] . '</p>' . "\n";
					$html .= '</td></tr>' . "\n";
				}

			}

			$html .= '</tbody>' . "\n";
			$html .= '</table>' . "\n";
		}

		echo $html;
	}


	public function meta_box_save ( $post_id ) {

		global $post, $messages;

		// Verify nonce
		if ( ( get_post_type() != $this->post_type ) || ! wp_verify_nonce( $_POST[ $this->post_type . '_nonce'], plugin_basename( $this->parent->dir ) ) ) {
			return $post_id;
		}

		// Verify user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Handle custom fields
		$field_data = $this->get_custom_fields_settings();
		$fields = array_keys( $field_data );

		foreach ( $fields as $f ) {

			if( isset( $_POST[$f] ) ) {
				${$f} = strip_tags( trim( $_POST[$f] ) );
			}

			// Escape the URLs.
			if ( 'url' == $field_data[$f]['type'] ) {
				${$f} = esc_url( ${$f} );
			}

			if ( ${$f} == '' ) {
				delete_post_meta( $post_id , $f , get_post_meta( $post_id , $f , true ) );
			} else {
				update_post_meta( $post_id , $f , ${$f} );
			}
		}

	}

	public function updated_messages ( $messages ) {

	  global $post, $post_ID;

	  $messages[$this->post_type] = array(

	    0 => '', // Unused. Messages start at index 1.
	    1 => sprintf( __( 'DPortfolio updated. %sView dportfolio%s.' , 'dportfolio' ), '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    2 => __( 'DPortfolio details updated.' , 'dportfolio' ),
	    3 => __( 'DPortfolio details deleted.' , 'dportfolio' ),
	    4 => __( 'DPortfolio.' , 'dportfolio' ),
	    /* translators: %s: date and time of the revision */
	    5 => isset($_GET['revision']) ? sprintf( __( 'DPortfolio restored to revision from %s.' , 'dportfolio' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	    6 => sprintf( __( 'DPortfolio published. %sView dportfolio%s.' , 'dportfolio' ), '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    7 => __( 'DPortfolio saved.' , 'dportfolio' ),
	    8 => sprintf( __( 'DPortfolio submitted. %sPreview dportfolio%s.' , 'dportfolio' ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', '</a>' ),
	    9 => sprintf( __( 'DPortfolio scheduled for: %1$s. %2$sPreview dportfolio%3$s.' , 'dportfolio' ), '<strong>' . date_i18n( __( 'M j, Y @ G:i' , 'dportfolio' ), strtotime( $post->post_date ) ) . '</strong>', '<a target="_blank" href="' . esc_url( get_permalink( $post_ID ) ) . '">', '</a>' ),
	    10 => sprintf( __( 'DPortfolio draft updated. %sPreview dportfolio%s.' , 'dportfolio' ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', '</a>' ),
	  
	  );

	  return $messages;

	}

	public function get_custom_fields_settings () {

		$fields = array();

		$fields['_client'] = array(

		    'name' => __( 'Client:' , 'dportfolio' ),
		    'description' => '',
		    'type' => 'text',
		    'default' => '',
		    'section' => 'plugin-data'

		);

		$fields['_website'] = array(

		    'name' => __( 'Website:' , 'dportfolio' ),
		    'description' => '',
		    'type' => 'url',
		    'default' => '',
		    'section' => 'plugin-data'

		);

		return $fields;
	}

	/**
	* [dportfolio]
	* [dportfolio view="gallery" limit=-1 filter="true" filter_type="list"]
	*/
	public function dportfolio_shortcode( $atts ) { 
		
		$a = shortcode_atts( array(

	        'view' => 'gallery',
	        'limit' => -1,
	        'filter' => 'true',
	        'filter_type' => 'list'

	    ), $atts );

	    switch ($a['view']) {

	    	case 'single':

	    		$content = '<div class="dportfolio-container-main">';

			        global $post;

			        $client = get_post_meta( $post->ID, '_client', true );
			        $website = get_post_meta( $post->ID, '_website', true );    	

			        if( $client != '' || $website != '' ) {

				        $content .='<div class="dportfolio-header">';

					        $content .='<div class="dportfolio-single-details">';

								if( $client != '' ) {				     

						        	$content .='<p>'. $client .'</p>';

						       	}

								if( $website != '' ) {				     

						        	$content .='<p><a href="'. $website .'" target="_blank">'. __( 'Website' , 'dportfolio' ) .'</a></p>';

						       	}					       

					        $content .='</div>';

					    $content .='</div>';			    

			        }				      			        

				$content .='</div>';

				return $content;

	    		break;
	    	
	    	default:

				$content = '<div class="dportfolio-container-main">';

				    $args = array(
				    	'post_type' => $this->post_type,
				    	'post_status' => 'publish',
				    	'posts_per_page'=> $a['limit']
				    );
				    
				    $the_query = new WP_Query( $args ); 

					        $content .= '<div class="dportfolio-header">';

					        		if( $a['filter'] == 'true') {

					        			if( $a['filter_type'] == 'checkbox') {

						        			$terms = get_terms( 'dportfolio_categories' ); 

										    $content .= '<div class="dportfolio-filters">';

										        $content .= '<div data-toggle="dportfolio-buttons">';
		
													foreach ( $terms as $term ) { 

											            $content .= '<label class="dportfolio-btn">';
											                $content .= '<input type="checkbox" value="'. $term->slug .'">';
											                $content .= $term->name;
											            $content .= '</label>';

													} 									        

										        $content .= '</div>';

										    $content .= '</div>';					 

					        			} else {
					        				
					        				$terms = get_terms( 'dportfolio_categories' );

					        				$content .= '<ul class="dportfolio-filters">';					        				
												$content .= '<li data-filter="all">All</li>';

												foreach ( $terms as $term ) { 

													$content .= '<li data-filter="'. $term->slug .'">'. $term->name .'</li>';

												}

											$content .= '</ul>';

					        			}

					        		}

					        $content .= '</div>';

					        if( $a['filter_type'] == 'checkbox') {

					        	$content .= '<div id="dportfolio-container">';

					        } else {

					        	$content .= '<div id="dportfolio-container-list">';

					        }					        

							if ( $the_query->have_posts() ) {
						    	    	
						    	while ( $the_query->have_posts() ) {

						    		$the_query->the_post();
						    		global $post;

								    	$terms = get_the_terms( $post->ID, 'dportfolio_categories' );

								    	if ( $terms && ! is_wp_error( $terms ) ) { 

									    	foreach ( $terms as $term ) {

									    		$category = $term->slug;

									    	}

								    	}
					  
							                if( $a['filter_type'] == 'checkbox') {

							                	 $content .='<div class="dportfolio-item '. $category .'">';

							                } else {

							                	 $content .='<div class="dportfolio-item-list '. $category .'">';

							                }

								               
									                $content .='<a href="'. get_the_permalink() .'">';	

														$content .= get_the_post_thumbnail( $post->ID, 'large');

									                    $content .='<div class="dportfolio-item-info">';
									                        $content .='<h3>'. get_the_title() .'</h3>';
									                    $content .='</div>';

									                $content .='</a>';

								             	$content .='</div>';							             
 

						    	}

						    }

						    wp_reset_postdata(); 

							$content .='</div>';

				$content .='</div>';

				return $content;

	    		break;

	    }

	}

	public static function instance ( $parent ) {

		if ( is_null( self::$_instance ) ) {

			self::$_instance = new self( $parent );

		}

		return self::$_instance;
	} 


	public function __clone () {

		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );

	} 


	public function __wakeup () {

		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );

	}


}
<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class DPORTFOLIO_Taxonomy {

	public $taxonomy;
	public $plural;
	public $single;
	public $post_types;

	public function __construct ( $taxonomy = '', $plural = '', $single = '', $post_types = array() ) {

		if ( ! $taxonomy || ! $plural || ! $single ) return;

		$this->taxonomy = $taxonomy;
		$this->plural = $plural;
		$this->single = $single;
		if ( ! is_array( $post_types ) ) {
			$post_types = array( $post_types );
		}
		$this->post_types = $post_types;

		add_action('init', array( $this, 'register_taxonomy' ) );

	}

	public function register_taxonomy () {

        $labels = array(
            'name' => $this->plural,
            'singular_name' => $this->single,
            'menu_name' => $this->plural,
            'all_items' => sprintf( __( 'All %s' , 'dcpt' ), $this->plural ),
            'edit_item' => sprintf( __( 'Edit %s' , 'dcpt' ), $this->single ),
            'view_item' => sprintf( __( 'View %s' , 'dcpt' ), $this->single ),
            'update_item' => sprintf( __( 'Update %s' , 'dcpt' ), $this->single ),
            'add_new_item' => sprintf( __( 'Add New %s' , 'dcpt' ), $this->single ),
            'new_item_name' => sprintf( __( 'New %s Name' , 'dcpt' ), $this->single ),
            'parent_item' => sprintf( __( 'Parent %s' , 'dcpt' ), $this->single ),
            'parent_item_colon' => sprintf( __( 'Parent %s:' , 'dcpt' ), $this->single ),
            'search_items' =>  sprintf( __( 'Search %s' , 'dcpt' ), $this->plural ),
            'popular_items' =>  sprintf( __( 'Popular %s' , 'dcpt' ), $this->plural ),
            'separate_items_with_commas' =>  sprintf( __( 'Separate %s with commas' , 'dcpt' ), $this->plural ),
            'add_or_remove_items' =>  sprintf( __( 'Add or remove %s' , 'dcpt' ), $this->plural ),
            'choose_from_most_used' =>  sprintf( __( 'Choose from the most used %s' , 'dcpt' ), $this->plural ),
            'not_found' =>  sprintf( __( 'No %s found' , 'dcpt' ), $this->plural ),
        );

        $args = array(
        	'label' => $this->plural,
        	'labels' => apply_filters( $this->taxonomy . '_labels', $labels ),
        	'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'meta_box_cb' => null,
            'show_admin_column' => true,
            'update_count_callback' => '',
            'query_var' => $this->taxonomy,
            'rewrite' => true,
            'sort' => '',
        );

        register_taxonomy( $this->taxonomy, $this->post_types, apply_filters( $this->taxonomy . '_register_args', $args, $this->taxonomy, $this->post_types ) );
        
    }

}

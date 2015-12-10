<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Register doc post type
*/
function dportfolio_setup_post_types() {

	$dportfolio_labels = array(
		'name' => _x( 'Portfolio', 'post type general name' , 'dportfolio' ),
		'singular_name' => _x( 'Single Portfolio', 'post type singular name' , 'dportfolio' ),
		'add_new' => _x( 'Add New', 'Portfolio' , 'dportfolio' ),
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
		/*
		'name' 				=> _x( 'Docs', 'doc post type general name', 'dportfolio' ),
		'singular_name' 	=> _x( 'Doc', 'doc post type singular name', 'dportfolio' ),
		'add_new' 			=> __( 'Add New', 'dportfolio' ),
		'add_new_item' 		=> __( 'Add New Doc', 'dportfolio' ),
		'edit_item' 		=> __( 'Edit Doc', 'dportfolio' ),
		'new_item' 			=> __( 'New Doc', 'dportfolio' ),
		'all_items' 		=> __( 'All Docs', 'dportfolio' ),
		'view_item' 		=> __( 'View Doc', 'dportfolio' ),
		'search_items' 		=> __( 'Search Docs', 'dportfolio' ),
		'not_found' 		=> __( 'No Docs found', 'dportfolio' ),
		'not_found_in_trash'=> __( 'No Docs found in Trash', 'dportfolio' ),
		'parent_item_colon' => '',
		'menu_name' 		=> __( 'Docs', 'dportfolio' )
		*/
	);

	$dportfolio_args = array(
		/*
		'labels' 			=> apply_filters( 'dportfolio_doc_post_type_labels', $dportfolio_labels ),
        'public'                => true,
        'menu_position'         => 5,
        'rewrite'               => array('slug' => 'doc'),
        'supports'              => array('title','editor', 'thumbnail', 'excerpt'),
        'public'                => true,
        'show_ui'               => true,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
        'menu_icon' => 'dashicons-format-aside'
        */
		'labels' => $dportfolio_labels,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'dportfolio' ),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'menu_position' => 5,
		'menu_icon' => 'dashicons-portfolio'
	);

	register_post_type( 'dportfolio', apply_filters( 'dportfolio_post_type_args', $dportfolio_args ) );	

}

add_action( 'init', 'dportfolio_setup_post_types', 1 );


function dportfolio_get_default_labels() {

	$defaults = array(
	   'singular' => __( 'Portfolio', 'dportfolio' ),
	   'plural'   => __( 'Porfolios', 'dportfolio')
	);

	return apply_filters( 'dportfolio_default_docs_name', $defaults );
	
}

function dportfolio_get_label_singular( $lowercase = false ) {
	$defaults = dportfolio_get_default_labels();
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

function dportfolio_get_label_plural( $lowercase = false ) {
	$defaults = dportfolio_get_default_labels();
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}

function dportfolio_change_default_title( $title ) {

     if ( !is_admin() ) {
     	$label = dportfolio_get_label_singular();
        $title = sprintf( __( 'Enter %s name here', 'dportfolio' ), $label );
     	return $title;
     }
     
     $screen = get_current_screen();

     if ( 'doc' == $screen->post_type ) {
     	$label = dportfolio_get_label_singular();
        $title = sprintf( __( 'Enter %s name here', 'dportfolio' ), $label );
     }

     return $title;
}

add_filter( 'enter_title_here', 'dportfolio_change_default_title' );

/**
* Register doc_category taxonomy
*/
function dportfolio_setup_taxonomies() {

	$category_labels = array(
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
		/*
		'name' 				=> sprintf( _x( '%s Categories', 'taxonomy general name', 'dportfolio' ), dportfolio_get_label_singular() ),
		'singular_name' 	=> _x( 'Category', 'taxonomy singular name', 'dportfolio' ),
		'search_items' 		=> __( 'Search Categories', 'dportfolio'  ),
		'all_items' 		=> __( 'All Categories', 'dportfolio'  ),
		'parent_item' 		=> __( 'Parent Category', 'dportfolio'  ),
		'parent_item_colon' => __( 'Parent Category:', 'dportfolio'  ),
		'edit_item' 		=> __( 'Edit Category', 'dportfolio'  ),
		'update_item' 		=> __( 'Update Category', 'dportfolio'  ),
		'add_new_item' 		=> sprintf( __( 'Add New %s Category', 'dportfolio'  ), dportfolio_get_label_singular() ),
		'new_item_name' 	=> __( 'New Category Name', 'dportfolio'  ),
		'menu_name' 		=> __( 'Categories', 'dportfolio'  ),
		*/
	);

	$category_args = array(
		'hierarchical' 	=> true,
		'labels' 		=> $category_labels,
		'show_ui' 		=> true,
		'query_var' 	=> 'dportfolio_categories',
		'rewrite' 		=> array('slug' => 'dportfolio_categories', 'with_front' => false, 'hierarchical' => true ),
		//'rewrite' 		=> array('slug' => 'dportfolio_categories', 'with_front' => true ),
		'show_admin_column' => true,
		'has_archive' => true
		//'query_var' => true,
		//'rewrite' => true,


		/*
        'public' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'labels' => $category_labels,
        'show_admin_column' => true
        */
	);

	register_taxonomy( 'dportfolio_categories', array('dportfolio'), apply_filters('dportfolio_category_args', $category_args ) );
	register_taxonomy_for_object_type( 'dportfolio_categories', 'dportfolio' );

}

add_action( 'init', 'dportfolio_setup_taxonomies', 0 );


/**
* Forces taxonomy dportfolio_categories ? ....
*/
function custom_post_archive($query) {
    if (!is_admin() && is_tax('dportfolio_categories') && $query->is_tax) {

        $query->set( 'post_type', array('dportfolio') );
    	remove_action( 'pre_get_posts', 'custom_post_archive' );

    }
}

add_action('pre_get_posts', 'custom_post_archive');



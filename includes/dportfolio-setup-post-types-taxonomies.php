<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Register post types
*/
function dportfolio_setup_post_types() {

	dportfolio_register_post_type( 'dportfolio', __( 'Portfolios', 'dportfolio' ), __( 'Porfolio', 'dportfolio' ) );
	add_filter( 'dportfolio_register_args',  'dportfolio_register_args' );

}

add_action( 'init', 'dportfolio_setup_post_types', 1 );


/**
*
*/
function dportfolio_register_args( $args ) {

	$args['rewrite'] = array('slug' => 'dportfolio');
	$args['menu_icon'] = 'dashicons-portfolio';
	$args['supports'] = array( 'title', 'editor', 'excerpt', 'thumbnail' );
	$args['public'] = true;
	$args['publicly_queryable'] = true;
	$args['exclude_from_search'] = true;
	$args['show_ui'] = true;
	$args['show_in_menu'] = true;
	$args['show_in_nav_menus'] = true;
	$args['query_var'] = true;
	$args['capability_type'] = 'post';
	$args['has_archive'] = false;
	$args['hierarchical'] = false;

	return $args;

}

/**
* register post type
*/
function dportfolio_register_post_type ( $post_type = '', $plural = '', $single = '', $description = '' ) {

	if ( ! $post_type || ! $plural || ! $single ) return;

	$post_type = new DPORTFOLIO_Post_Type( $post_type, $plural, $single, $description );
	return $post_type;

}

/**
* Register taxonomies
*/
function dportfolio_setup_taxonomies() {

	dportfolio_register_taxonomy( 'dportfolio_categories', __( 'Categories', 'dportfolio' ), __( 'Category', 'dportfolio' ), 'dportfolio' );
	add_filter( 'dportfolio_register_taxonomy_args',  'dportfolio_register_taxonomy_args' );

}

add_action( 'init', 'dportfolio_setup_taxonomies', 0 );

/**
*
*/
function dportfolio_register_taxonomy_args( $args ) {

    $args['public'] = true;
    $args['hierarchical'] = true;
    $args['rewrite'] = true;

    return $args;

}


/**
* register taxonomy
*/
function dportfolio_register_taxonomy ( $taxonomy = '', $plural = '', $single = '', $post_types = array() ) {

	if ( ! $taxonomy || ! $plural || ! $single ) return;

	$taxonomy = new DPORTFOLIO_Taxonomy( $taxonomy, $plural, $single, $post_types );
	return $taxonomy;

}
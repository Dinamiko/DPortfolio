<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'dportfolio_enqueue_styles', 15 );
add_action( 'wp_enqueue_scripts', 'dportfolio_enqueue_scripts', 10 );
add_action( 'admin_enqueue_scripts', 'dportfolio_admin_enqueue_scripts', 10, 1 );
add_action( 'admin_enqueue_scripts', 'dportfolio_admin_enqueue_styles', 10, 1 );

function dportfolio_enqueue_styles () {	

	wp_register_style( 'dportfolio-frontend', plugins_url( 'dportfolio/assets/css/frontend.css' ), array(), DPORTFOLIO_VERSION );
	wp_enqueue_style( 'dportfolio-frontend' );

}

function dportfolio_enqueue_scripts () {

	wp_register_script( 'imagesloaded', plugins_url( 'dportfolio/assets/js/imagesloaded.pkgd.min.js' ), array( 'jquery' ), '3.1.6', true );
	wp_enqueue_script( 'imagesloaded' );

	wp_register_script( 'dportfolio-shuffle', plugins_url( 'dportfolio/assets/js/jquery.shuffle.modernizr.min.js' ), array( 'jquery' ), '3.0' );
	wp_enqueue_script( 'dportfolio-shuffle' );

	wp_enqueue_script('masonry');

	wp_register_script( 'dportfolio-frontend', plugins_url( 'dportfolio/assets/js/frontend.js' ), array( 'jquery' ), DPORTFOLIO_VERSION, true );

    // get dportfolio_columns_gutter option 
    $gutter = get_option( 'dportfolio_columns_gutter', 30 );

    $data = array(
        'thumbnails_gutter' => $gutter,
    );

	wp_localize_script( 'dportfolio-frontend', 'dportfolio_data', $data );	
	wp_enqueue_script( 'dportfolio-frontend' );

}

function dportfolio_admin_enqueue_styles ( $hook = '' ) {

	wp_register_style( 'dportfolio-admin', plugins_url( 'dportfolio/assets/css/admin.css' ), array(), DPORTFOLIO_VERSION );
	wp_enqueue_style( 'dportfolio-admin' );
	
}

function dportfolio_admin_enqueue_scripts ( $hook = '' ) {
	

				
}
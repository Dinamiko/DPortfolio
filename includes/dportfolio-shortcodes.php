<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* [dportfolio]
* This shortcode is used to display the contents of Docu index page 
*/
function dportfolio_shortcode( $atts, $content = null ) {

	global $dportfolio_atts;

	$dportfolio_atts = shortcode_atts( array(

		//2.0 args
		'columns' => '2',
		'categories' => 'none',

		// 1.1 args
	    'view' => 'gallery',
	    'limit' => 15,
	    'filter' => 'true',
	    'filter_type' => 'list',		

	), $atts );

	$template = new DPortfolio_Template_Loader;

	ob_start();

	$template->get_template_part( 'dportfolio-index' );

	return ob_get_clean();

}

add_shortcode( 'dportfolio', 'dportfolio_shortcode' );


/**
* [dportfolio_gallery]
* This shortcode is used to display all media images in the post
*/
/*
function dportfolio_gallery_shortcode( $atts, $content = null ) {

	global $dportfolio_gallery_atts;

	$dportfolio_gallery_atts = shortcode_atts( array(

		//1.2 args
		'columns' => '2',
		'categories' => 'none',

		// 1.1 args
	    'view' => 'gallery',
	    'limit' => -1,
	    'filter' => 'true',
	    'filter_type' => 'list'

		
		//'search' => 'false',
		//'columns' => '1',
		//'list_docs' => 'false',
		//'content' => $content
		

	), $atts );


	$template = new DPortfolio_Template_Loader;

	ob_start();

	$template->get_template_part( 'dportfolio-gallery' );

	return ob_get_clean();

}

add_shortcode( 'dportfolio_gallery', 'dportfolio_gallery_shortcode' );
*/


/**
* [dportfolio 
*	view="gallery"  
*	limit="-1" 
*	filter="true" 
*	filter_type="list"
* ]
*/
/*
function dportfolio_shortcode( $atts, $content = null ) {

	global $dportfolio_atts;

	$dportfolio_atts = shortcode_atts( array(

		'view' => 'gallery',
		'limit' => -1,
		'filter' => 'true',
		'filter_type' => 'list'

	), $atts );

	$template = new DPORTFOLIO_Template_Loader;

	ob_start();

	$template->get_template_part( 'dportfolio-index' );

	return ob_get_clean();

}

add_shortcode( 'dportfolio', 'dportfolio_shortcode' );
*/



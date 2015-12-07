<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* [dportfolio 
*	view="gallery"  
*	limit="-1" 
*	filter="true" 
*	filter_type="list"
* ]
*/

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



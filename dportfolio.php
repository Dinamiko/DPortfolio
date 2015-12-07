<?php
/*
 * Plugin Name: DPortfolio
 * Version: 1.1
 * Plugin URI: http://wp.dinamiko.com/demos/dportfolio /
 * Description: Filterable Portfolio with Custom Post Type DPortfolio and Shorcode [dportfolio] 
 * Author: Emili Castells
 * Author URI: http://www.dinamiko.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once( 'includes/class-dportfolio-ptype.php' );
require_once( 'includes/class-dportfolio.php' );

function DPortfolio() {

	$instance = DPortfolio::instance( __FILE__, '1.0' );
	
	$instance->post_type = DPortfolioPType::instance( $instance );

	return $instance;

}

DPortfolio();

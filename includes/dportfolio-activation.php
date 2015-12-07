<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function dportfolio_activation() {

	dportfolio_setup_post_types();
	dportfolio_setup_taxonomies();

	flush_rewrite_rules();
	
}

register_activation_hook( DPORTFOLIO_PLUGIN_FILE, 'dportfolio_activation' );
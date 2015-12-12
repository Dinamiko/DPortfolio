<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* load ... template ...
*/
function custom_dportfolio_before_content() {

  $template = new DPortfolio_Template_Loader;
  $template->get_template_part( 'dportfolio-before-single-content' );

}

//add_action( 'dportfolio_before_content', 'custom_dportfolio_before_content' );

/**
* Single dportfolio content filter
*/
/*
function single_dportfolio_filter_content( $content ) {

  global $post;
  
  if( $post && $post->post_type == 'dportfolio' && is_singular( 'dportfolio' ) && is_main_query() ) {


    // remove default next/prev links of single.php template
    add_filter( 'next_post_link' , 'docu_remove_default_prevnext_links' );
    add_filter( 'previous_post_link' , 'docu_remove_default_prevnext_links' );



    ob_start();
    do_action( 'docu_after_doc_content' );
    $content .= ob_get_clean();


  }

  return $content;

}

add_filter('the_content', 'single_dportfolio_filter_content');
*/
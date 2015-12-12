<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Single dportfolio before content
*/
function dportfolio_before_single_content( $content ) {

  global $post;
  
  if( $post && $post->post_type == 'dportfolio' && is_singular( 'dportfolio' ) && is_main_query() ) {

    $c = $content;
    $content = '';

    ob_start();

    do_action( 'dportfolio_before_content' );

    $content = ob_get_clean() . $c;

  }

  return $content;

}

add_filter('the_content', 'dportfolio_before_single_content');

/**
* loads a template before content 
*/
function custom_dportfolio_before_content() {

  $template = new DPortfolio_Template_Loader;
  $template->get_template_part( 'dportfolio-before-single-content' );

}

add_action( 'dportfolio_before_content', 'custom_dportfolio_before_content' );

/**
* Single dportfolio after content filter
*/
function dportfolio_after_single_content( $content ) {

  global $post;
  
  if( $post && $post->post_type == 'dportfolio' && is_singular( 'dportfolio' ) && is_main_query() ) {

    ob_start();

    do_action( 'dportfolio_after_content' );

    $content .= ob_get_clean();

  }

  return $content;

}

add_filter('the_content', 'dportfolio_after_single_content');

/**
* loads a template after content 
*/
function custom_dportfolio_after_content() {

  $template = new DPortfolio_Template_Loader;
  $template->get_template_part( 'dportfolio-after-single-content' );

}

add_action( 'dportfolio_after_content', 'custom_dportfolio_after_content' );

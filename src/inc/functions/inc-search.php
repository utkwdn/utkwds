<?php

/**
 * Functions and hooks related to site search.
 */

 function utk_wds_google_search() {
     wp_enqueue_script( 'utk-googlecse-script',  'https://cse.google.com/cse.js?cx=da48cf0836de1c946', array(), null, true );
 }
 add_action( 'wp_enqueue_scripts', 'utk_wds_google_search' );
 
 function utk_search_slider_script() {
    wp_enqueue_script( 'utk-search-slider-script', get_stylesheet_directory_uri() . '/js/search-slider.js', array('utkwds-bootstrap'), null, true );
}
add_action( 'wp_enqueue_scripts', 'utk_search_slider_script' );
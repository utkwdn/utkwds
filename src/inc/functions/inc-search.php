<?php
/**
 * Functions and hooks related to site search.
 *
 * @package utkwds
 */

/**
 * Enqueue Google Custom Search script.
 */
function utk_wds_google_search() {
	wp_enqueue_script( 'utk-googlecse-script', 'https://cse.google.com/cse.js?cx=da48cf0836de1c946', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'utk_wds_google_search' );

/**
 * Enqueue Search Slider script.
 */
function utk_search_slider_script() {
	$asset = include get_parent_theme_file_path( '/js/search-slider.asset.php' );
	wp_enqueue_script( 'utk-search-slider-script', get_stylesheet_directory_uri() . '/js/search-slider.js', array(), $asset['version'], true );
}
add_action( 'wp_enqueue_scripts', 'utk_search_slider_script' );

/**
 * Enqueue Tabs script.
 */
function utk_tabs_script() {
	$asset = include get_parent_theme_file_path( '/js/tabs.asset.php' );
	wp_enqueue_script( 'utk-tabs-script', get_stylesheet_directory_uri() . '/js/tabs.js', array(), $asset['version'], true );
}
add_action( 'wp_enqueue_scripts', 'utk_tabs_script' );

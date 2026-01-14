<?php
/**
 * Functions and hooks related to site search.
 *
 * @package utkwds
 */

/**
 * Enqueue Google Custom Search script.
 */
function utk_wds_enqueue_google_cse_script() {

	$theme_version = wp_get_theme()->get( 'Version' );

	// enqueue script.
	wp_enqueue_script(
		'utk-google-cse',
		get_template_directory_uri() . '/js/google-cse.js',
		array(),
		$theme_version,
		true
	);

	// Pass PHP data to google-cse.js script.
	wp_localize_script(
		'utk-google-cse',
		'UTK_CSE',
		array(
			'apiKey'   => 'AIzaSyDM4Csz3QyWvlPZVXHyJfsnj2BvolZ7RpQ',
			'cx'       => 'd01b54a48b2b24d99',
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			'query'    => isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '',
			'endpoint' => 'https://www.googleapis.com/customsearch/v1',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'utk_wds_enqueue_google_cse_script' );

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

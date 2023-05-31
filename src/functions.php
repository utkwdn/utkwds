<?php
/**
 * This file adds functions to the utkwds WordPress theme.
 *
 * @package utkwds
 * @author  WP Engine
 * @license GNU General Public License v2 or later
 * @link    https://utkwdswp.com/
 */

if ( ! function_exists( 'utkwds_setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since 0.8.0
	 *
	 * @return void
	 */
	function utkwds_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'utkwds', get_template_directory() . '/languages' );

		// Enqueue editor styles and fonts.
		add_editor_style(
			array(
				'./style.css',
			)
		);

		// Remove core block patterns.
		remove_theme_support( 'core-block-patterns' );

	}
}
add_action( 'after_setup_theme', 'utkwds_setup' );

// Enqueue style sheet.
add_action( 'wp_enqueue_scripts', 'utkwds_enqueue_style_sheet' );
function utkwds_enqueue_style_sheet() {

	wp_enqueue_style( 'utkwds', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'utkchancellor-bootstrap',  'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js', array(), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'utkwds', get_stylesheet_directory_uri() . '/js/utk.js', array(), wp_get_theme()->get( 'Version' ), true ); 

}

function utkwds_editor_assets() {
	wp_enqueue_script(
		'utkwds-block-variations',
		get_template_directory_uri() . '/js/block-variations.js',
		array( 'wp-blocks' )
	);
}
add_action( 'enqueue_block_editor_assets', 'utkwds_editor_assets' );


if ( ! defined( 'UTKDS_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'UTKDS_VERSION', '0.1.0' );
}
/**
 * Design system file
 * 
 * TODO: Remove this bootstrap dependancy when individual files are available
 * similar to genesis child theme
 * 
 */
function ut_designsystem_scripts() {
	//wp_enqueue_style( 'utk-bootstrap-designsytemstyles', 'https://images.utk.edu/designsystem/v1/0.1.0/assets/css/style.css', array(), UTKDS_VERSION );
	//wp_enqueue_style( 'utk-bootstrap-designsytemstyles', 'https://images.utk.edu/designsystem-test/css/style-aggregate-branch-02.css', array(), UTKDS_VERSION );
}
add_action( 'wp_enqueue_scripts', 'ut_designsystem_scripts' );


require_once( 'inc/functions/block-styles.php');
require_once( 'inc/functions/footer-widget.php');
require_once( 'inc/functions/inc-menu.php');
require_once( 'inc/functions/inc-patterns.php');
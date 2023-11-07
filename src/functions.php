<?php
/**
 * This file adds functions to the utkwds WordPress theme.
 *
 * @package utkwds
 * @author  WP Engine
 * @license GNU General Public License v2 or later
 * @link    https://utkwdswp.com/
 */


if ( ! defined( 'UTKDS_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'UTKDS_VERSION', '0.1.0' );
}

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
				'/screen.css',
			)
		);

		// Remove core block patterns.
		remove_theme_support( 'core-block-patterns' );

	}
}
add_action( 'after_setup_theme', 'utkwds_setup' );

// Enqueue style sheet.
function utkwds_enqueue_style_sheet() {
	
	// asset file is built by webpack
	$asset = include get_parent_theme_file_path( '/screen.asset.php' );
	
	wp_enqueue_style( 
		'utkwds', 
		get_template_directory_uri() . '/screen.css', 
		$asset['dependencies'],
		$asset['version'] 
	);
	
	wp_enqueue_script( 'utkwds-bootstrap',  'https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js', array(), wp_get_theme()->get( 'Version' ), true );
	//wp_enqueue_script( 'utkwds', get_stylesheet_directory_uri() . '/js/utk.js', array(), wp_get_theme()->get( 'Version' ), true ); 
}
add_action( 'wp_enqueue_scripts', 'utkwds_enqueue_style_sheet' );

function utkwds_editor_assets() {

	wp_enqueue_script(
		'utkwds-block-variations',
		get_template_directory_uri() . '/js/block-variations.js',
		array( 'wp-blocks' )
	);

}
add_action( 'enqueue_block_editor_assets', 'utkwds_editor_assets' );

// Enable the customizer so we can add a logo
add_action( 'customize_register', '__return_true' );
function utkwds_custom_logo_setup() {
	$defaults = array(
		'height'               => 35,
		'width'                => 155,
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'site-title', 'site-description' ),
		'unlink-homepage-logo' => false, 
	);
	add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'utkwds_custom_logo_setup' );

function utkwds_home_url_control( $wp_customize ) {
	$wp_customize->add_setting( 'utkwds_home_url', array(
		'default' => '',
		'transport' => 'refresh',
	) );
	$wp_customize->add_control( 'utkwds_home_url', array(
		'label' => __( 'Logo URL', 'utkwds' ),
		'section' => 'title_tagline',
		'type' => 'text',
	) );
}

add_action( 'customize_register', 'utkwds_home_url_control' );

require_once( 'inc/functions/block-styles.php');
require_once( 'inc/functions/customizer.php');
require_once( 'inc/functions/footer-widget.php');
require_once( 'inc/functions/inc-menu.php');
require_once( 'inc/functions/inc-patterns.php');
require_once( 'inc/functions/inc-search.php');
require_once( 'inc/functions/shortcodes.php');


// Register our custom blocks in the theme

function utkwds_block_init() {

	// asset file is built by webpack
	$accordion_script = include get_parent_theme_file_path( 'blocks/accordion/accordion.asset.php' );

	wp_register_script( 
		'utk-wds-accordion', 
		get_parent_theme_file_uri() . 'blocks/accordion/accordion.js', 
		$accordion_script['dependencies'], 
		$accordion_script['version'], 
		true
	);
	
	register_block_type( __DIR__ . '/blocks/accordion' );
	register_block_type( __DIR__ . '/blocks/accordion-panel' );
	register_block_type( __DIR__ . '/blocks/breadcrumbs' );
	register_block_type( __DIR__ . '/blocks/nav-menu' );
	register_block_type( __DIR__ . '/blocks/site-header' );
	register_block_type( __DIR__ . '/blocks/site-footer' );
	register_block_type( __DIR__ . '/blocks/tab-group' );
	register_block_type( __DIR__ . '/blocks/tab' );

}

add_action( 'init', 'utkwds_block_init', 5 );

add_filter( 'block_type_metadata', function ( $metadata ) {
	return $metadata;
});
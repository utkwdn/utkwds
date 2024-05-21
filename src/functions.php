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
	define( 'UTKDS_VERSION', '1.1.3' );
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

  $asset = include get_parent_theme_file_path( '/js/block-variations.asset.php' );

	wp_enqueue_script(
		'utkwds-block-variations',
		get_parent_theme_file_uri() . '/js/block-variations.js',
    $asset['dependencies'],
    $asset['version'],
		false
	);

}
add_action( 'enqueue_block_editor_assets', 'utkwds_editor_assets' );

require_once( 'inc/functions/block-styles.php');
require_once( 'inc/functions/customizer.php');
require_once( 'inc/functions/editor-restrictions.php');
require_once( 'inc/functions/footer-widget.php');
require_once( 'inc/functions/inc-menu.php');
require_once( 'inc/functions/inc-patterns.php');
require_once( 'inc/functions/inc-search.php');
require_once( 'inc/functions/shortcodes.php');
require_once( 'inc/functions/theme-update.php');

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

function utkwds_register_vars() {
	wp_register_script( 'utk-wds-navigation-blocks-vars', false );
	wp_enqueue_script( 'utk-wds-navigation-blocks-vars' );
	
	wp_add_inline_script(
		'utk-wds-navigation-blocks-vars',
		'const UTKWDS = ' . json_encode(
			array(
				'theme_url' => get_template_directory_uri(),
				'blocks_path' => '/build/blocks/',
			)
		),
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'utkwds_register_vars' );
add_action( 'admin_enqueue_scripts', 'utkwds_register_vars' );

function utkwds_editor_restrict_css() {
  
  if ( current_user_can( 'edit_theme_options' ) ) {
    return;
  }

  $asset = include get_parent_theme_file_path( '/editor-restrict.asset.php');
  
  wp_enqueue_style(
    'utkwds-editor-restrict',
    get_template_directory_uri() . '/editor-restrict.css',
    $asset['dependencies'],
		$asset['version'] 
  );
}

add_action( 'enqueue_block_editor_assets', 'utkwds_editor_restrict_css' );
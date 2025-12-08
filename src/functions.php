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
	define( 'UTKDS_VERSION', '1.3.1' );
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

/**
 * Enqueue theme stylesheet.
 */
function utkwds_enqueue_style_sheet() {

	// Aasset file is built by webpack.
	$asset = include get_parent_theme_file_path( '/screen.asset.php' );

	wp_enqueue_style(
		'utkwds',
		get_template_directory_uri() . '/screen.css',
		$asset['dependencies'],
		$asset['version']
	);
}
add_action( 'wp_enqueue_scripts', 'utkwds_enqueue_style_sheet' );

/**
 * Enqueue dropdowns script.
 */
function utk_dropdowns_script() {
	$asset = include get_parent_theme_file_path( '/js/dropdowns.asset.php' );
	wp_enqueue_script( 'utk-dropdowns-script', get_stylesheet_directory_uri() . '/js/dropdowns.js', array(), $asset['version'], true );
}
add_action( 'wp_enqueue_scripts', 'utk_dropdowns_script' );

/**
 * Enqueue collapse script.
 */
function utk_collapse_script() {
	$asset = include get_parent_theme_file_path( '/js/collapse.asset.php' );
	wp_enqueue_script( 'utk-collapse-script', get_stylesheet_directory_uri() . '/js/collapse.js', array(), $asset['version'], true );
}
add_action( 'wp_enqueue_scripts', 'utk_collapse_script' );

/**
 * Enqueue offcanvas script.
 */
function utk_offcanvas_script() {
	$asset = include get_parent_theme_file_path( '/js/offcanvas.asset.php' );
	wp_enqueue_script( 'utk-offcanvas-script', get_stylesheet_directory_uri() . '/js/offcanvas.js', array(), $asset['version'], true );
}
add_action( 'wp_enqueue_scripts', 'utk_offcanvas_script' );

/**
 * Enqueue editor scripts for block variations.
 */
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

require_once 'inc/functions/block-styles.php';
require_once 'inc/functions/customizer.php';
require_once 'inc/functions/editor-restrictions.php';
require_once 'inc/functions/footer-widget.php';
require_once 'inc/functions/google-tag-manager.php';
require_once 'inc/functions/inc-menu.php';
require_once 'inc/functions/inc-patterns.php';
require_once 'inc/functions/inc-search.php';
require_once 'inc/functions/kses.php';
require_once 'inc/functions/render-block.php';
require_once 'inc/functions/shortcodes.php';
require_once 'inc/functions/theme-update.php';
require_once 'inc/functions/user-roles.php';

/**
 * Register custom blocks for theme.
 */
function utkwds_block_init() {

	// Asset file is built by webpack.
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
	register_block_type( __DIR__ . '/blocks/icon' );
	register_block_type( __DIR__ . '/blocks/nav-menu' );
	register_block_type( __DIR__ . '/blocks/secondary-navigation' );
	register_block_type( __DIR__ . '/blocks/site-header' );
	register_block_type( __DIR__ . '/blocks/site-footer' );
	register_block_type( __DIR__ . '/blocks/tab-group' );
	register_block_type( __DIR__ . '/blocks/tab' );
}

add_action( 'init', 'utkwds_block_init' );

add_filter(
	'block_type_metadata',
	function ( $metadata ) {
		return $metadata;
	}
);

/**
 * Register theme JS global variables for scripts.
 */
function utkwds_register_vars() {
	wp_register_script( 'utk-wds-navigation-blocks-vars', false );
	wp_enqueue_script( 'utk-wds-navigation-blocks-vars' );

	wp_add_inline_script(
		'utk-wds-navigation-blocks-vars',
		'const UTKWDS = ' . json_encode(
			array(
				'theme_url'   => get_template_directory_uri(),
				'blocks_path' => '/build/blocks/',
			)
		),
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'utkwds_register_vars' );
add_action( 'admin_enqueue_scripts', 'utkwds_register_vars' );

/**
 * Enqueue editor-restrict CSS for non-admin users.
 */
function utkwds_editor_restrict_css() {

	if ( current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$asset = include get_parent_theme_file_path( '/editor-restrict.asset.php' );

	wp_enqueue_style(
		'utkwds-editor-restrict',
		get_template_directory_uri() . '/editor-restrict.css',
		$asset['dependencies'],
		$asset['version']
	);
}

add_action( 'enqueue_block_editor_assets', 'utkwds_editor_restrict_css' );

// Disable WordPress Administration Email verification Screen.
add_filter( 'admin_email_check_interval', '__return_false' );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once 'tests/kitchensink.php';
}






/**
 * Clone admin role to new Site Editor role and add edit_site capability.
 */
function sec_register_site_editor_role() {

	// Remove existing role to ensure caps update properly.
	remove_role( 'site_editor' );

	$admin = get_role( 'administrator' );
	if ( ! $admin ) {
		return;
	}

	// Create Site Editor role with Administrator’s caps.
	add_role( 'site_editor', 'Site Editor', $admin->capabilities );

	// Add custom edit_site cap to Site Editor role.
	$site_editor = get_role( 'site_editor' );
	if ( $site_editor ) {
		$site_editor->add_cap( 'edit_site' );
	}
}
add_action( 'init', 'sec_register_site_editor_role' );


/**
 * Restrict Site Editor access if user is not a Site Editor or Super Admin.
 */
function sec_manage_site_editor_restrictions() {

	// Do nothing if current user is Site Editor or Super Admin.
	if ( current_user_can( 'edit_site' ) ) {
		return;
	}
	if ( is_multisite() && is_super_admin() ) {
		return;
	}

	/**
	 * Hide the Appearance → Editor menu item.
	 */
	add_action(
		'admin_menu',
		function () {
			remove_submenu_page( 'themes.php', 'site-editor.php' );
		},
		999
	);

	/**
	 * Hide the "Edit Site" admin bar button.
	 */
	add_action(
		'admin_bar_menu',
		function ( $wp_admin_bar ) {
			$wp_admin_bar->remove_node( 'site-editor' );
		},
		999
	);

	/**
	 * Block direct access to /wp-admin/site-editor.php.
	 */
	add_action(
		'current_screen',
		function () {
			if ( function_exists( 'get_current_screen' ) ) {
				$screen = get_current_screen();
				if ( $screen && 'site-editor' === $screen->id ) {
					wp_die( 'You do not have permission to access the Site Editor.' );
				}
			}
		},
		1
	);
}
add_action( 'init', 'sec_manage_site_editor_restrictions', 20 );

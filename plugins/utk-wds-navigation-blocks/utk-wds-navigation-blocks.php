<?php
/**
 * Plugin Name:       UTK Navigation
 * Description:       Blocks for use in the main site and page header, including menus and breadcrumbs.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            NewCity &#x2F; UTK
 * License:           NONE
 * Text Domain:       utk-wds
 *
 * @package           utk-wds
 */

/**
 * Registers the blocks using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function utk_wds_breadcrumbs_block_init() {
	wp_register_script( 'utk-wds-accordion', plugin_dir_url( __FILE__ ) . 'build/blocks/accordion/accordion.js', array(), filemtime(plugin_dir_path( __FILE__ ) . 'build/blocks/accordion/accordion.js'), true );
	register_block_type( __DIR__ . '/build/blocks/breadcrumbs' );
	register_block_type( __DIR__ . '/build/blocks/nav-menu' );
	register_block_type( __DIR__ . '/build/blocks/site-header' );
}
add_action( 'init', 'utk_wds_breadcrumbs_block_init' );

add_filter( 'block_type_metadata', function ( $metadata ) {
	return $metadata;
});

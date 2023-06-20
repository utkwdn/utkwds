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
	register_block_type( __DIR__ . '/build/blocks/accordion' );
	register_block_type( __DIR__ . '/build/blocks/accordion-panel' );
	register_block_type( __DIR__ . '/build/blocks/breadcrumbs' );
	register_block_type( __DIR__ . '/build/blocks/nav-menu' );
	register_block_type( __DIR__ . '/build/blocks/site-header' );
}

add_action( 'init', 'utk_wds_breadcrumbs_block_init' );

add_filter( 'block_type_metadata', function ( $metadata ) {
	return $metadata;
});

/** The `EditorsKit` plugin is overzealous in its "Hide Title" feature.
 *  Its intended purpose is to hide the title of a post or page when rendering the
 *  front-end view, but it does so by changing the title to an empty string whenever
 *  `get_title()` is called on the post id. That means the title is also wiped out
 *  when menu items are retrieved, since they get their link title value using the
 *  same function.
 * 
 *  This filter only runs for menu items, and it temporarily disables the "Hide Title"
 *  setting to retrieve the title, then re-enables it.
 */
function utk_wds_menu_title_fix($item) {

	$hidden_by_editorskit = get_post_meta( $item->object_id, '_editorskit_title_hidden', true );

	if ( $hidden_by_editorskit ) {
		update_post_meta( $item->object_id, '_editorskit_title_hidden', false );
		$item->title = get_the_title( $item->object_id );
		update_post_meta( $item->object_id, '_editorskit_title_hidden', $hidden_by_editorskit );
	}

	return $item;
}

add_filter( 'wp_setup_nav_menu_item', 'utk_wds_menu_title_fix', 10, 1 );
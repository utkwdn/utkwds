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
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'utk_wds_breadcrumbs_block_init' );

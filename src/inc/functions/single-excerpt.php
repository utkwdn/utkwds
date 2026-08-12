<?php
/**
 * Hide the Post Excerpt block on the single post template when the post has
 * no manually written excerpt, instead of falling back to an auto-generated
 * excerpt pulled from the start of the post content.
 *
 * @package utkwds
 */

/**
 * Blank the core/post-excerpt block on singular posts unless the post has a
 * manual excerpt, since the single template uses it as a large intro
 * paragraph and an auto-generated excerpt duplicates the post content that
 * follows immediately after it.
 *
 * @param string $block_content Rendered block HTML.
 * @return string
 */
function utkwds_maybe_hide_single_post_excerpt( $block_content ) {

	if ( ! is_singular( 'post' ) ) {
		return $block_content;
	}

	if ( '' === get_post_field( 'post_excerpt', get_queried_object_id() ) ) {
		return '';
	}

	return $block_content;
}
add_filter( 'render_block_core/post-excerpt', 'utkwds_maybe_hide_single_post_excerpt' );

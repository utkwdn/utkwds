<?php
/**
 * Scope the Category template's 2-up featured posts Query Loop to the
 * category currently being viewed.
 *
 * @package utkwds
 */

/**
 * Restrict the Category template's 2-up featured posts block to the current
 * category, since the same block markup is reused across every category
 * archive rather than having its category set per instance.
 *
 * Note: `$block` here is whichever inner block triggered the query build
 * (e.g. Post Template), not the Query block itself, so its `className`
 * attribute isn't available. The Query block's `queryId` (1, set in
 * category.html) is passed down as block context and used to target it
 * instead.
 *
 * @param array    $query_vars Query args for the block.
 * @param WP_Block $block      Block instance.
 * @return array
 */
function utkwds_filter_category_highlights_query( $query_vars, $block ) {

	if ( ! is_category() ) {
		return $query_vars;
	}

	if ( 1 !== ( $block->context['queryId'] ?? null ) ) {
		return $query_vars;
	}

	$query_vars['cat'] = get_queried_object_id();

	return $query_vars;
}
add_filter( 'query_loop_block_query_vars', 'utkwds_filter_category_highlights_query', 10, 2 );

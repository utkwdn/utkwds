<?php
/**
 * Scope the Category template's 2-up featured posts Query Loop to the
 * category currently being viewed, and hide that whole area when nothing
 * qualifies.
 *
 * @package utkwds
 */

/**
 * Tax query restricting the Category template's featured posts to those
 * tagged with the "Top Categories" locations term, shared by the query
 * filter and the visibility check so both stay in sync.
 *
 * @return array
 */
function utkwds_category_featured_tax_query() {

	return array(
		array(
			'taxonomy' => 'locations',
			'field'    => 'slug',
			'terms'    => 'top-categories',
		),
	);
}

/**
 * Restrict the Category template's 2-up featured posts block to the current
 * category and the "Top Categories" locations term, since the same block
 * markup is reused across every category archive rather than having its
 * category set per instance.
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
function utkwds_filter_category_featured_query( $query_vars, $block ) {

	if ( ! is_category() ) {
		return $query_vars;
	}

	if ( 1 !== ( $block->context['queryId'] ?? null ) ) {
		return $query_vars;
	}

	$query_vars['cat']       = get_queried_object_id();
	$query_vars['tax_query'] = utkwds_category_featured_tax_query(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query

	return $query_vars;
}
add_filter( 'query_loop_block_query_vars', 'utkwds_filter_category_featured_query', 10, 2 );

/**
 * Hide the Category template's featured area (heading + 2-up query) when the
 * current category has no posts tagged with the "Top Categories" locations
 * term, since an empty heading over an empty grid isn't useful.
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Parsed block data.
 * @return string
 */
function utkwds_maybe_hide_category_featured_area( $block_content, $block ) {

	if ( ! is_category() ) {
		return $block_content;
	}

	$class_names = isset( $block['attrs']['className'] ) ? explode( ' ', $block['attrs']['className'] ) : array();

	if ( ! in_array( 'utkwds-category-featured', $class_names, true ) ) {
		return $block_content;
	}

	$featured_posts = get_posts(
		array(
			'post_type'              => 'post',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'cat'                    => get_queried_object_id(),
			'tax_query'              => utkwds_category_featured_tax_query(), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	return empty( $featured_posts ) ? '' : $block_content;
}
add_filter( 'render_block_core/group', 'utkwds_maybe_hide_category_featured_area', 10, 2 );

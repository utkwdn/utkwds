<?php
/**
 * Category/year dropdown filtering for the Home template's post listing.
 *
 * @package utkwds
 */

/**
 * Apply the `post-category` and `post-year` query string filters to the Home
 * template's main query.
 *
 * @param WP_Query $query The WordPress query object.
 */
function utkwds_filter_home_posts_query( $query ) {

	if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) {
		return;
	}

	if ( ! empty( $_GET['post-category'] ) ) {
		$category_slug = sanitize_title( wp_unslash( $_GET['post-category'] ) );

		if ( get_category_by_slug( $category_slug ) ) {
			$query->set( 'category_name', $category_slug );
		}
	}

	if ( ! empty( $_GET['post-year'] ) ) {
		$year = absint( wp_unslash( $_GET['post-year'] ) );

		if ( $year >= 1900 && $year <= (int) gmdate( 'Y' ) + 1 ) {
			$query->set( 'year', $year );
		}
	}
}
add_action( 'pre_get_posts', 'utkwds_filter_home_posts_query' );

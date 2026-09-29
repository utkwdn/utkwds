<?php
/**
 * Category/year dropdown filtering for the Home and Category templates' post listing.
 *
 * @package utkwds
 */

/**
 * Apply the `post-category` and `post-month` query string filters to the main
 * query on the Home and Category templates.
 *
 * The category filter only applies on the Home template — a Category
 * archive is already scoped to its own term, so there's no category
 * dropdown there to produce that query var.
 *
 * WordPress pins sticky posts to the front of the Home template's query
 * regardless of taxonomy/date filtering (it re-fetches them by post type/
 * status only), so once a filter is actually applied here we tell it to
 * stop — otherwise an unrelated sticky post can show up in a filtered list.
 *
 * @param WP_Query $query The WordPress query object.
 */
function utkwds_filter_post_listing_query( $query ) {

	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_home() && ! $query->is_category() ) {
		return;
	}

	$utkwds_filter_applied = false;

	if ( $query->is_home() && ! empty( $_GET['post-category'] ) ) {
		$category_slug = sanitize_title( wp_unslash( $_GET['post-category'] ) );

		if ( get_category_by_slug( $category_slug ) ) {
			$query->set( 'category_name', $category_slug );
			$utkwds_filter_applied = true;
		}
	}

	if ( ! empty( $_GET['post-month'] ) ) {
		$month_year = sanitize_text_field( wp_unslash( $_GET['post-month'] ) );

		if ( preg_match( '/^(\d{4})-(\d{2})$/', $month_year, $matches ) ) {
			$year  = (int) $matches[1];
			$month = (int) $matches[2];

			if ( $year >= 1900 && $year <= (int) gmdate( 'Y' ) + 1 && $month >= 1 && $month <= 12 ) {
				$query->set( 'year', $year );
				$query->set( 'monthnum', $month );
				$utkwds_filter_applied = true;
			}
		}
	}

	if ( $utkwds_filter_applied ) {
		$query->set( 'ignore_sticky_posts', true );
	}
}
add_action( 'pre_get_posts', 'utkwds_filter_post_listing_query' );

/**
 * Get the heading text for the post filters box, also reused by the
 * Category template's jump link.
 *
 * @return string
 */
function utkwds_get_post_filters_heading() {

	if ( is_category() ) {
		return sprintf(
			/* translators: %s: category name. */
			__( 'Browse %s', 'utkwds' ),
			single_cat_title( '', false )
		);
	}

	return __( 'Browse All News', 'utkwds' );
}

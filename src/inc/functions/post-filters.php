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
 * @param WP_Query $query The WordPress query object.
 */
function utkwds_filter_post_listing_query( $query ) {

	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_home() && ! $query->is_category() ) {
		return;
	}

	if ( $query->is_home() && ! empty( $_GET['post-category'] ) ) {
		$category_slug = sanitize_title( wp_unslash( $_GET['post-category'] ) );

		if ( get_category_by_slug( $category_slug ) ) {
			$query->set( 'category_name', $category_slug );
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
			}
		}
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

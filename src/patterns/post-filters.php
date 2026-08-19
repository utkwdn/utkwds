<?php
/**
 * Title: Post Filters
 * Slug: utkwds/post-filters
 * Description: Category and year dropdown filters for the News/Posts listing.
 * Keywords: filter, category, year, posts, news
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: false
 *
 * @package utkwds
 */

$utkwds_selected_category   = isset( $_GET['post-category'] ) ? sanitize_title( wp_unslash( $_GET['post-category'] ) ) : '';
$utkwds_selected_month_year = isset( $_GET['post-month'] ) ? sanitize_text_field( wp_unslash( $_GET['post-month'] ) ) : '';

// The category dropdown is redundant on a single category's own archive page.
$utkwds_show_category_filter = ! is_category();

$utkwds_filters_heading = utkwds_get_post_filters_heading();

$utkwds_filter_categories = $utkwds_show_category_filter ? get_categories(
	array(
		'hide_empty' => true,
	)
) : array();

// Scope the month list to the current category context (archive page or
// selected dropdown value) so months with no posts in that category don't
// show up as filter options.
$utkwds_month_query_category_id = null;

if ( is_category() ) {
	$utkwds_month_query_category_id = get_queried_object_id();
} elseif ( $utkwds_selected_category ) {
	$utkwds_month_query_category = get_category_by_slug( $utkwds_selected_category );

	if ( $utkwds_month_query_category ) {
		$utkwds_month_query_category_id = $utkwds_month_query_category->term_id;
	}
}

global $wpdb;

if ( $utkwds_month_query_category_id ) {
	$utkwds_filter_months = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT DISTINCT YEAR( p.post_date ) AS year, MONTH( p.post_date ) AS month
			FROM {$wpdb->posts} p
			INNER JOIN {$wpdb->term_relationships} tr ON tr.object_id = p.ID
			INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
			WHERE p.post_type = %s AND p.post_status = %s
				AND tt.taxonomy = 'category' AND tt.term_id = %d
			ORDER BY p.post_date DESC",
			'post',
			'publish',
			$utkwds_month_query_category_id
		)
	);
} else {
	$utkwds_filter_months = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month
			FROM {$wpdb->posts}
			WHERE post_type = %s AND post_status = %s
			ORDER BY post_date DESC",
			'post',
			'publish'
		)
	);
}

?>

<div class="utkwds-post-filters">
	<h2 class="wp-block-heading utkwds-eyebrow"><?php echo esc_html( $utkwds_filters_heading ); ?></h2>
	<form method="get" action="<?php echo esc_url( get_pagenum_link( 1, false ) ); ?>" class="utkwds-post-filters-form">
		<?php if ( $utkwds_show_category_filter ) : ?>
		<div class="utkwds-post-filters-field">
			<div class="utk-form-floating">
				<select name="post-category" id="utkwds-post-filter-category" class="utk-form-select">
					<option value=""><?php esc_html_e( 'Select a Topic', 'utkwds' ); ?></option>
					<?php foreach ( $utkwds_filter_categories as $utkwds_category ) : ?>
						<option value="<?php echo esc_attr( $utkwds_category->slug ); ?>" <?php selected( $utkwds_selected_category, $utkwds_category->slug ); ?>><?php echo esc_html( $utkwds_category->name ); ?></option>
					<?php endforeach; ?>
				</select>
				<label for="utkwds-post-filter-category"><?php esc_html_e( 'Topic', 'utkwds' ); ?></label>
			</div>
		</div>
		<?php endif; ?>

		<div class="utkwds-post-filters-field">
			<div class="utk-form-floating">
				<select name="post-month" id="utkwds-post-filter-month" class="utk-form-select">
					<option value=""><?php esc_html_e( 'Select a Month / Year', 'utkwds' ); ?></option>
					<?php foreach ( $utkwds_filter_months as $utkwds_month ) : ?>
						<?php
						$utkwds_month_value = sprintf( '%04d-%02d', $utkwds_month->year, $utkwds_month->month );
						$utkwds_month_label = date_i18n( 'M Y', mktime( 0, 0, 0, $utkwds_month->month, 1, $utkwds_month->year ) );
						?>
						<option value="<?php echo esc_attr( $utkwds_month_value ); ?>" <?php selected( $utkwds_selected_month_year, $utkwds_month_value ); ?>><?php echo esc_html( $utkwds_month_label ); ?></option>
					<?php endforeach; ?>
				</select>
				<label for="utkwds-post-filter-month"><?php esc_html_e( 'Month / Year', 'utkwds' ); ?></label>
			</div>
		</div>
	</form>
</div>

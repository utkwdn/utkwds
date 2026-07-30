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

$utkwds_selected_category = isset( $_GET['post-category'] ) ? sanitize_title( wp_unslash( $_GET['post-category'] ) ) : '';
$utkwds_selected_year     = isset( $_GET['post-year'] ) ? absint( wp_unslash( $_GET['post-year'] ) ) : 0;

// The category dropdown is redundant on a single category's own archive page.
$utkwds_show_category_filter = ! is_category();

$utkwds_filters_heading = utkwds_get_post_filters_heading();

$utkwds_filter_categories = $utkwds_show_category_filter ? get_categories(
	array(
		'hide_empty' => true,
	)
) : array();

global $wpdb;
$utkwds_filter_years = $wpdb->get_col(
	$wpdb->prepare(
		"SELECT DISTINCT YEAR( post_date ) FROM {$wpdb->posts} WHERE post_type = %s AND post_status = %s ORDER BY post_date DESC",
		'post',
		'publish'
	)
);

?>

<div class="utkwds-post-filters">
	<h2 class="wp-block-heading"><?php echo esc_html( $utkwds_filters_heading ); ?></h2>
	<form method="get" class="utkwds-post-filters-form">
		<?php if ( $utkwds_show_category_filter ) : ?>
		<div class="utkwds-post-filters-field">
			<div class="utk-form-floating">
				<select name="post-category" id="utkwds-post-filter-category" class="utk-form-select">
					<option value=""><?php esc_html_e( 'All Topics', 'utkwds' ); ?></option>
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
				<select name="post-year" id="utkwds-post-filter-year" class="utk-form-select">
					<option value=""><?php esc_html_e( 'All Years', 'utkwds' ); ?></option>
					<?php foreach ( $utkwds_filter_years as $utkwds_year ) : ?>
						<option value="<?php echo esc_attr( $utkwds_year ); ?>" <?php selected( $utkwds_selected_year, (int) $utkwds_year ); ?>><?php echo esc_html( $utkwds_year ); ?></option>
					<?php endforeach; ?>
				</select>
				<label for="utkwds-post-filter-year"><?php esc_html_e( 'Year', 'utkwds' ); ?></label>
			</div>
		</div>

		<!-- <button type="submit" class="utkwds-post-filters__submit"><?php esc_html_e( 'Apply Filters', 'utkwds' ); ?></button> -->
	</form>
</div>

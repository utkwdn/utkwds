<?php
/**
 * Template part for a Google Custom Search Engine (GCSE) search box and results.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package utkwds
 */

// Read query from URL (?s=term).
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$search_query = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
?>

<div class="utk-search-wrapper" style="margin-bottom: 20px;">

	<form class="utk-search-form" method="get" action="">
		<div class="form-floating">
			<input
				class="form-control"
				aria-label="Search utk.edu"
				id="search-input" 
				name="s"
				type="search"
				value="<?php echo esc_attr( $search_query ); ?>"
				placeholder="Search"
			/>
			<label for="search-input">Search</label>
		</div>
		<button aria-label="Search" class="wp-block-search__button wp-element-button" type="submit">Search</button>
	</form>
	
	<div id="utk-search-results"></div>
	<div id="utk-search-pagination" class="pagination"></div>

</div>

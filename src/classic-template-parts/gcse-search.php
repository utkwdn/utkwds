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
		<label for="search-input" class="screen-reader-text">Search</label>
		<input 
			type="text" 
			id="search-input" 
			name="s" 
			placeholder="Search utk.edu…" 
			value="<?php echo esc_attr( $search_query ); ?>"
		/>
		<button type="submit">Search</button>
	</form>

	<div id="utk-search-results" style="margin-top:20px;"></div>

	<div id="utk-search-pagination" class="pagination"></div>

</div>

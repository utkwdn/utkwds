<?php
/**
 * Template part for a Google Custom Search Engine (GCSE) search box and results.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package utkwds
 */

?>

<!-- Google SCE script is enqueued by utk_wds_google_search(), located
	in `inc/functions/inc-search.php` (which is required in functions.php) -->
<h2 class="utk-global-search-heading">Search results from: all of utk.edu</h2>
<div class="gcse-searchbox" data-gname="utk-global-search" data-queryParameterName="s"></div>
<div class="gcse-searchresults" data-gname="utk-global-search" data-enableImageSearch="false" data-enableOrderBy="false" data-queryParameterName="s"></div>
<script>
	
	// Update 'is-empty' class for floating label as input value changes.
	document.addEventListener('input', (e) => {
		if (!e.target.matches('#___gcse_0 input.gsc-input')) {
			return;
		}

		const row = e.target.closest('tr');
		row.classList.toggle('is-empty', e.target.value.trim() === '');
	});

	// Add 'is-empty' class when CSE X button is clicked
	document.addEventListener('click', (e) => {
		const clearBtn = e.target.closest('#___gcse_0 .gsst_a');
		if (!clearBtn) {
			return;
		}

		const row = clearBtn.closest('tr');
		if (row) {
			row.classList.add('is-empty');
		}
	});

	// Set 'is-empty' on load if no prefilled input (from URL params)
	window.addEventListener('load', () => {
		const input = document.querySelector('#___gcse_0 input.gsc-input');
		if (!input) return;

		const row = input.closest('tr');
		row.classList.toggle('is-empty', input.value.trim() === '');
	});
	
</script>

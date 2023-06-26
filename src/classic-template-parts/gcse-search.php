<?php
/**
 * Template part for a Google Custom Search Engine (GCSE) search box and results.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

?>

<form class="form-inline hidden-print mt-4" id="cse-searchbox-form">
    <div class="mb-3 input-group">
    <label class="sr-only visually-hidden" for="q">Search</label>
    <input type="search" class="form-control" title="Search utk.edu" placeholder="Example: Apply, Payroll, Provost, English Department"  name="q" id="q">
    <button type="submit" name="btnG" class="btn btn-utlink">
    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
				<title>Search Icon</title>
				<circle id="Ellipse 6" cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
				<line id="Line 2" x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
			</svg>
    <span class="visually-hidden">Search</span></button>
    </div>
</form>

<div class="gcse-searchresults-only" data-gname="this-site-results" data-enableImageSearch="false" data-enableOrderBy="false"></div>
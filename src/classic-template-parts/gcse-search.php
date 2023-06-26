<?php
/**
 * Template part for a Google Custom Search Engine (GCSE) search box and results.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

?>

<script
      src="https://cse.google.com/cse.js?cx=da48cf0836de1c946"
      defer=""
      data-nscript="beforeInteractive"
    ></script>
<!-- <div class="gcse-searchbox" data-gname="utk-global-search"></div>
<div class="gcse-searchresults" data-gname="utk-global-search" data-enableImageSearch="false" data-enableOrderBy="false"></div> -->

<p class="d-block d-sm-none">Search utk.edu</p>
    <form
        class="form-inline hidden-print mt-4"
        id="cse-searchbox-form"
    >
        <div class="mb-3 input-group">
        <label class="sr-only visually-hidden" for="q"
            >Search</label
        >
        <input
            type="search"
            class="form-control left-border"
            title="Search utk.edu"
            placeholder="Example: Apply, Payroll, Provost, English Department"
            name="q"
            id="q"
            autofocus=""
            value=""
        />
        <button type="submit" class="btn btn-utsearch">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            fill="currentColor"
            viewBox="0 0 24 24"
            id="searchHeader-open"
            >
            <path
                d="M23.822 20.88l-6.353-6.354c.93-1.465 1.467-3.2 1.467-5.059.001-5.219-4.247-9.467-9.468-9.467s-9.468 4.248-9.468 9.468c0 5.221 4.247 9.469 9.468 9.469 1.768 0 3.421-.487 4.839-1.333l6.396 6.396 3.119-3.12zm-20.294-11.412c0-3.273 2.665-5.938 5.939-5.938 3.275 0 5.94 2.664 5.94 5.938 0 3.275-2.665 5.939-5.94 5.939-3.274 0-5.939-2.664-5.939-5.939z"
            ></path>
            </svg>
            <span class="text-uppercase">Search</span>
        </button>
        </div>
    </form>
    <div></div>

<!-- <div class="gcse-searchbox" data-gname="this-site-results"> -->

<!-- <form class="form-inline hidden-print mt-4" id="cse-searchbox-form">
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
</form> -->
<!-- <div class="gcse-searchresults" data-gname="this-site-results" data-enableImageSearch="false" data-enableOrderBy="false"></div> -->
<?php

$query_title = do_blocks( '<!-- wp:query-title {"type":"search","fontSize":"large"} /-->' );
$query_body  = do_blocks( '<!-- wp:pattern {"slug":"utkwds/query"} /-->' );

get_header();
?>

<header class="wp-block-template-part site-header">
<?php block_header_area(); ?>
</header>

<main class="wp-block-group site-content has-global-padding is-layout-constrained" style="margin-top:0;padding-top:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--small)" id="wp--skip-link--target">
<div class="wp-block-group is-layout-flow" style="margin-bottom:var(--wp--preset--spacing--small)">
	<?php
		echo $query_title;
	?>
</div>
</div>

<ul class="nav nav-tabs main-tabs" id="mainTabs" role="tablist">
	<li class="nav-item block" role="presentation">
	<button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">This site</button>
	</li>
	<li class="nav-item block" role="presentation">
	<button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">All of utk.edu</button>
	</li>

</ul>

<div class="nav nav-tabs tab-content main-tabs-content search-tab" id="myTabContent">
	<div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">
	<h2 class="has-medium-font-size">Search results from <?php bloginfo( 'name' ); ?></h2>
	<form class="form-inline hidden-print mt-4" id="site-search-form" action="<?php bloginfo( 'wpurl' ); ?>/">
		<div class="mb-3 input-group">
		<label class="sr-only visually-hidden" for="site-search-input-tabpanel">Search</label>
		<input type="search" class="form-control" title="Search this site" placeholder="Search"  name="s" id="site-search-input-tabpanel" />
		<button type="submit" class="btn btn-utlink">
		<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
				<title>Search Icon</title>
				<circle cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
				<line x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
			</svg>
		<span>Search</span></button>
		</div>
	</form>
	<div class="site-search-results">
		<?php
			echo $query_body;
		?>
		</div>
	</div>
	<div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab">
	<?php get_template_part( 'classic-template-parts/gcse-search', 'gcse-search', array() ); ?>

	</div>
</div>

</main>
<script>
	const mainSearchField = document.getElementById('site-search-input-tabpanel');
	mainSearchField.value = '<?php echo get_search_query(); ?>';

	const allOfUtkLink = document.getElementById('search-all-utk-link');
  
	if (allOfUtkLink) {
	allOfUtkLink.addEventListener('click', function() {

	const triggerEl = document.querySelector('#mainTabs button[data-target="#profile-tab-pane"]');
	triggerEl.click();

	});
	}

</script>
<?php
get_footer();


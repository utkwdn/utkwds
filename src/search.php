<?php
/**
 * Displays the search page
 *
 * @package utkwds
 */

$query_title = do_blocks( '<!-- wp:query-title {"type":"search","fontSize":"large"} /-->' );
$query_body  = do_blocks( '<!-- wp:pattern {"slug":"utkwds/query"} /-->' );

get_header();
?>

<header class="wp-block-template-part site-header">
<?php block_header_area(); ?>
</header>

<main class="wp-block-group site-content has-global-padding is-layout-constrained" style="margin-top:0;padding-top:var(--wp--preset--spacing--small);" id="wp--skip-link--target">
<div class="wp-block-group is-layout-flow" style="margin-bottom:var(--wp--preset--spacing--small)">
	<h1 class="wp-block-post-title">SEARCH</h1>
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
	<h2 class="utk-global-search-heading">Search results from: <?php bloginfo( 'name' ); ?></h2>
	<form class="utk-site-search-form" method="get" action="">
		<div class="utk-form-floating">
			<input
				class="utk-form-control"
				aria-label="Search utk.edu"
				id="utk-site-search-input" 
				name="s"
				type="search"
				placeholder="Search"
			/>
			<label for="utk-site-search-input">Search</label>
		</div>
		<button aria-label="Search" class="wp-element-button button-submit" type="submit">Search</button>
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
	const mainSearchField = document.getElementById('utk-site-search-input');
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


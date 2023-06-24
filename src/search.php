<?php

$query_title = do_blocks('<!-- wp:query-title {"type":"search","fontSize":"large"} /-->');
$query_body = do_blocks('<!-- wp:pattern {"slug":"utkwds/query"} /-->');

get_header();
?>

<header class="wp-block-template-part site-header">
<?php block_header_area(); ?>
</header>

<main class="wp-block-group site-content has-global-padding is-layout-constrained" style="margin-top:0;padding-top:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--small)" id="wp--skip-link--target">
<div class="wp-block-group is-layout-flow" style="margin-bottom:var(--wp--preset--spacing--medium)">
    <?php 
        echo $query_title;
    ?>
</div>
</div>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Results for <?php bloginfo( 'name' ); ?></button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">All of utk.edu</button>
  </li>

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
  <?php 
    echo $query_body;
?>
  </div>
  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
    <form class="form-inline hidden-print mt-4" id="cse-searchbox-form">
      <div class="mb-3 input-group">
        <label class="sr-only visually-hidden" for="q">Search</label>
        <input type="search" class="form-control" title="Search utk.edu" placeholder="Example: Apply, Payroll, Provost, English Department"  name="q" id="q">
        <button type="submit" name="btnG" class="btn btn-utlink">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" aria-hidden="true" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg> <span class="visually-hidden">Search</span></button>
      </div>
    </form>
    <div class="gcse-searchresults-only" data-gname="this-site-results" data-enableImageSearch="false" data-enableOrderBy="false"></div>


  </div>
</div>

</main>

<?php
get_footer();
// <header class="site-header">
// <!-- wp:pattern {"slug":"utkwds/header-utk"} /-->
// </header>
// <!-- wp:template-part {"slug":"header","tagName":"header","className":"site-header","theme":"utkwds"} /-->

// <main class="wp-block-group site-content" style="margin-top:0;padding-top:var(--wp--preset--spacing--small);padding-bottom:var(--wp--preset--spacing--small)">
// <div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--medium)">
//  		<!-- wp:query-title {"type":"search","fontSize":"large"} /-->
// </div>
// <!-- wp:pattern {"slug":"utkwds/query"} /-->
// </main>
// <!-- wp:template-part {"slug":"footer","tagName":"footer","className":"site-footer","theme":"utkwds"} /-->
// EOT;

// $blocks_list = parse_blocks( $header_block_comments );

// foreach ($blocks_list as $parsed_block) {
//    render_block( $parsed_block );
// }

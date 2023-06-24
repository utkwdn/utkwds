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
    <?php get_template_part( 'classic-template-parts/gcse-search', 'gcse-search', array() ) ?>
    <div class="gcse-searchresults-only" data-gname="this-site-results" data-enableImageSearch="false" data-enableOrderBy="false"></div>


  </div>
</div>

</main>

<?php
get_footer();


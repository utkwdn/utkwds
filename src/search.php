<?php

get_header();
?>

<header class="wp-block-template-part site-header">
<?php block_header_area(); ?>
</header>

<footer class="wp-block-template-part site-footer">
<?php block_footer_area(); ?>
</footer>
</div>
<?php wp_footer(); ?>
</body>

<?php
// $header_block_comments = <<<EOT
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

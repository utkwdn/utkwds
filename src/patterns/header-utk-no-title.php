<?php
/**
 * Title: Header with NO site title
 * Slug: utkwds/header-utk-no-title
 * Categories: header
 * Inserter: true
 * Block Types: core/template-part/header
 */

 namespace UTK\WebDesignSystem;
?>
<!-- wp:utk-wds/site-header { "mainMenuName": "Main Nav Menu", "utilityMenuName": "Utility Nav Menu" } /-->

<!-- wp:group {"className":"wp-block-group header-site-title-wrapper universal-header__inner-blocks","layout":{"type":"default"}} -->
<div class="wp-block-group header-site-title-wrapper universal-header__inner-blocks"><!-- wp:site-title {"level":0,"isLink":true,"style":{"typography":{"lineHeight":"1.2"}},"className": "header-site-title"} /--></div>
<!-- /wp:group -->

<!-- wp:utk-wds/nav-menu { "menuName": "Main Nav Menu", "depth": "1", "id": "main-nav--large", "className": "main-nav--large", "interactive": "dropdown", "duplicate_top_links": true } /-->

<!-- wp:utk-wds/breadcrumbs /-->
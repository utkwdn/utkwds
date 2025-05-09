<?php
/**
 * Title: Header with site title
 * Slug: utkwds/header-utk
 * Categories: header
 * Inserter: false
 * Block Types: core/template-part/header
 */

 namespace UTK\WebDesignSystem;
?>
<!-- wp:utk-wds/site-header { "mainMenuName": "Main Nav Menu", "utilityMenuName": "Utility Nav Menu" } /-->

<!-- wp:group {"className":"wp-block-group header-site-title-wrapper universal-header__inner-blocks","layout":{"type":"default"}} -->
<div class="wp-block-group header-site-title-wrapper universal-header__inner-blocks">
<?php if ( get_theme_mod( 'parent_label' ) ) : ?>
    <!-- wp:paragraph {"className":"header-site-tagline"} -->
    <p class="header-site-tagline"> 
      <?php if ( get_theme_mod( 'parent_link' ) ) : ?>
        <a href="<?php echo esc_url( get_theme_mod( 'parent_link' ) ); ?>">
          <?php echo esc_html(get_theme_mod( 'parent_label' )); ?>
        </a></p><!-- /wp:paragraph -->
      <?php else : ?>
        <?php echo esc_html(get_theme_mod( 'parent_label' )); ?></p><!-- /wp:paragraph -->
      <?php endif; ?>
  <?php endif; ?>
  <!-- wp:site-title {"level":0,"isLink":true,"style":{"typography":{"lineHeight":"1.2"}},"className": "header-site-title"} /--></div>
<!-- /wp:group -->

<!-- wp:utk-wds/nav-menu { "menuName": "Main Nav Menu", "depth": "1", "id": "main-nav--large", "className": "main-nav--large", "interactive": "dropdown", "duplicate_top_links": true } /-->

<!-- wp:utk-wds/breadcrumbs /-->
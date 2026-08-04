<?php
/**
 * Title: Category Jump Link
 * Slug: utkwds/category-jump-link
 * Description: Jump link down to the filters/post listing section, labeled with the current category name.
 * Keywords: jump link, category, anchor
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: false
 *
 * @package utkwds
 */

?>

<p><a class="utkwds-jump-link" href="#post-filters"><?php echo esc_html( utkwds_get_post_filters_heading() ); ?></a></p>

<?php
/**
 * Title: Category 3up with Image
 * Slug: utkwds/category-3up-image
 * Description: Dynamic feed highlighting three recent posts from a category, showing featured image, title, date of publication, and a list of categories.
 * Categories: dynamic-content
 * Keywords: posts, news, feed, articles, announcements, featured image
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: true
 *
 * @package utkwds
 */

?>

<!-- wp:group {"metadata":{"patternName":"utkwds/category-3up-image","name":"Category 3up with Image"},"align":"full","className":"utkwds-category-3up-image","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull utkwds-category-3up-image"><!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"align":"wide"} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"aspectRatio":"3/2"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"className":"heading-style--h6"} /-->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"fontSize":"x-small"} /-->

<!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":20} /-->

<!-- wp:post-terms {"term":"category"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
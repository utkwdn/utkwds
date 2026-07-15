<?php
/**
 * Title: Post Horizontal
 * Slug: utkwds/post-horizontal
 * Description:
 * Keywords: post
 * Viewport Width: 1500
 * Block Types:
 * Post Types:
 * Inserter: false
 *
 * @package utkwds
 */

?>

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-title {"isLink":true,"className":"heading-style\u002d\u002dh6"} /-->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"fontSize":"x-small"} /-->

<!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":20} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"aspectRatio":"3/2","width":"220px"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

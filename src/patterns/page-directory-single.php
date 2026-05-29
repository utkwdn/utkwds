<?php
/**
 * Title: Directory Single
 * Slug: utkwds/page-directory-single
 * Categories: page-layouts
 * Block Types: core/post-content
 * Post Types: page
 *
 * @package utkwds
 */

?>

<!-- wp:group {"className":"alignwide","style":{"spacing":{"blockGap":"0","margin":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small"}}}} -->
<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--small);margin-bottom:var(--wp--preset--spacing--small)"><!-- wp:heading {"level":1,"align":"wide"} -->
<h1 class="wp-block-heading alignwide">First and Last Name</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-utkwds-paragraph-large"} -->
<p class="is-style-utkwds-paragraph-large">Title</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"is-style-columns-reverse"} -->
<div class="wp-block-columns alignwide is-style-columns-reverse"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:paragraph {"className":"is-style-default"} -->
<p class="is-style-default">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ultrices, magna non consectetur lacinia, nisl sapien ornare erat, id interdum justo massa nec dui. Donec nisl leo, convallis vel facilisis vel, posuere ac turpis. Vestibulum ipsum urna, placerat imperdiet nulla non, sodales iaculis ipsum. Integer porta ut nisl vel egestas. Maecenas consequat sit amet sapien eu scelerisque. In elementum, diam vitae ultrices egestas, ipsum leo blandit risus, nec convallis urna neque sit amet tortor. Phasellus a nulla malesuada, laoreet odio id, condimentum est. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ullamcorper elit libero, in malesuada nisi placerat id.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>In lobortis lectus erat, ut rhoncus erat pharetra sit amet. Vivamus quis congue felis. Praesent sapien erat, porttitor non lorem sit amet, semper facilisis ipsum. Suspendisse et est eget eros mollis vehicula. Sed maximus diam quis tortor aliquet, ut dictum orci suscipit. Vestibulum sollicitudin, leo id placerat suscipit, elit augue cursus augue, non venenatis elit mi eu odio. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras finibus ultricies ex, a varius est pharetra sit amet. Aliquam massa velit, imperdiet vitae nulla sit amet, vestibulum fermentum est. Vestibulum vehicula fringilla lectus ac fringilla. Morbi tincidunt ornare arcu et ornare. Nulla molestie lacus sed sollicitudin venenatis. Sed non nisl vitae eros posuere auctor ut quis neque. Ut sed tortor nec ex vehicula condimentum. In sagittis eu nisi non hendrerit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Vivamus nibh purus, tincidunt vel neque pretium, eleifend laoreet ipsum. Donec consectetur sagittis semper. Vestibulum in sapien ultricies, varius orci ut, fringilla nibh. Pellentesque aliquam lacus nec arcu fringilla, id vestibulum tortor malesuada. Integer cursus velit quis bibendum congue. Vivamus nec lacus euismod, tincidunt sapien eu, mattis sapien. Nulla facilisi. Nunc tempor porttitor nunc, bibendum eleifend sem facilisis a. Sed non molestie diam. Curabitur velit lectus, dignissim vitae erat at, mattis ultrices diam. Aliquam placerat facilisis erat vitae euismod. Donec eget libero quis justo faucibus congue a a e</p>
<!-- /wp:paragraph -->

<!-- wp:utk-wds/accordion -->
<div class="wp-block-utk-wds-accordion"><div data-accordion="true" class="utk-wds-accordion-wrapper" data-color-scheme="light"><!-- wp:utk-wds/accordion-panel -->
<div class="wp-block-utk-wds-accordion-panel"><h2 class="utk-wds-accordion__heading" data-accordion-heading="true"><div>Accordion 1</div></h2><section data-accordion-section="true"><div class="utk-wds-accordion__panel-body"><!-- wp:paragraph -->
<p>Accordion information</p>
<!-- /wp:paragraph --></div></section></div>
<!-- /wp:utk-wds/accordion-panel -->

<!-- wp:utk-wds/accordion-panel -->
<div class="wp-block-utk-wds-accordion-panel"><h2 class="utk-wds-accordion__heading" data-accordion-heading="true"><div>Accordion 2</div></h2><section data-accordion-section="true"><div class="utk-wds-accordion__panel-body"><!-- wp:paragraph -->
<p>Accordion information</p>
<!-- /wp:paragraph --></div></section></div>
<!-- /wp:utk-wds/accordion-panel -->

<!-- wp:utk-wds/accordion-panel -->
<div class="wp-block-utk-wds-accordion-panel"><h2 class="utk-wds-accordion__heading" data-accordion-heading="true"><div>Accordion 3</div></h2><section data-accordion-section="true"><div class="utk-wds-accordion__panel-body"><!-- wp:paragraph -->
<p>Accordion information</p>
<!-- /wp:paragraph --></div></section></div>
<!-- /wp:utk-wds/accordion-panel --></div></div>
<!-- /wp:utk-wds/accordion --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"400px"} -->
<div class="wp-block-column" style="flex-basis:400px"><!-- wp:group {"metadata":{"name":"Contact single large image light gray","categories":["contact-cards"],"patternName":"utkwds/contact-single-large-image-light-gray"},"className":"utkwds-contact-single utkwds-contact-single\u002d\u002dlarge","backgroundColor":"light","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group utkwds-contact-single utkwds-contact-single--large has-light-background-color has-background"><!-- wp:image -->
<figure class="wp-block-image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/person-placeholder.jpeg' ) ); ?>" alt="person placeholder"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><strong>Contact Information</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"utkwds-cta-link"} -->
<p class="utkwds-cta-link"><a href="mailto:email@utk.edu">email@utk.edu</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="tel:+18659741234">865-974-1234</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

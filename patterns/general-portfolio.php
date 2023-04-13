<?php
/**
 * Title: Portfolio with heading, text, images.
 * Slug: utkwds/general-portfolio
 * Categories: portfolio
 */
?>
<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|medium","left":"var:preset|spacing|large"}}},"className":"is-style-columns-reverse"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center is-style-columns-reverse"><!-- wp:column {"verticalAlignment":"center","width":""} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"fontSize":"x-large","anchor":"sample-heading"} -->
<h2 class="wp-block-heading has-x-large-font-size" id="sample-heading"><?php echo esc_html__( 'Build with utkwds', 'utkwds' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'utkwds is a powerful WordPress theme created for agencies and professional website builders. With its clean, minimal design, utkwds provides the perfect canvas for sophisticated websites.', 'utkwds' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html__( 'View Project', 'utkwds' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":""} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:gallery {"columns":0,"linkTo":"none","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|x-small","left":"var:preset|spacing|x-small"}}}} -->
<figure class="wp-block-gallery has-nested-images columns-0 is-cropped"><!-- wp:image {"id":3497,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_theme_file_uri() ) . '/assets/images/sample_800x800.jpg'; ?>" alt="Sample Image" class="wp-image-3497"/></figure>
<!-- /wp:image -->
<!-- wp:image {"id":3498,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_theme_file_uri() ) . '/assets/images/sample_800x800.jpg'; ?>" alt="Sample Image" class="wp-image-3498"/></figure>
<!-- /wp:image -->
<!-- wp:image {"id":3499,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_theme_file_uri() ) . '/assets/images/sample_800x800.jpg'; ?>" alt="Sample Image" class="wp-image-3499"/></figure>
<!-- /wp:image -->
<!-- wp:image {"id":3500,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_theme_file_uri() ) . '/assets/images/sample_800x800.jpg'; ?>" alt="Sample Image" class="wp-image-3500"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

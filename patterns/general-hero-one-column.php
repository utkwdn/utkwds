<?php
/**
 * Title: Section with image, text, buttons.
 * Slug: utkwds/general-hero-one-column
 * Categories: featured
 */
?>
<!-- wp:group {"align":"wide","layout":{"type":"constrained","wideSize":"800px"}} -->
<div class="wp-block-group alignwide"><!-- wp:image {"id":3480,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_theme_file_uri() ) . '/assets/images/sample_1920x1200.jpg'; ?>" alt="Sample Image" class="wp-image-3480"/></figure>
<!-- /wp:image -->
<!-- wp:heading {"textAlign":"center","anchor":"image-heading-text-buttons","style":{"spacing":{"margin":{"top":"var:preset|spacing|medium"}}},"className":"wp-block-heading","fontSize":"x-large"} -->
<h2 class="wp-block-heading has-text-align-center has-x-large-font-size" id="image-heading-text-buttons" style="margin-top:var(--wp--preset--spacing--medium)"><?php echo esc_html__( 'Welcome to utkwds', 'utkwds' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:group {"layout":{"type":"constrained","wideSize":"600px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php echo esc_html__( 'With its clean, minimal design and powerful feature set, utkwds enables agencies to build stylish and sophisticated WordPress websites.', 'utkwds' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html__( 'Get Started', 'utkwds' ); ?></a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button"><?php echo esc_html__( 'Learn More', 'utkwds' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

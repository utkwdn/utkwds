<?php
/**
 * Title: UTK Universal Footer
 * Slug: utkwds/footer-utk
 * Categories: footer
 * Inserter: false
 * Block Types: core/template-part/footer
 */
?>
<!-- wp:group {"align":"full","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","className":"universal-footer has-background","layout":{"type":"constrained"},"fontSize":"x-small"} -->
<div class="wp-block-group alignfull universal-footer has-background has-white-color has-text-color has-link-color has-x-small-font-size"><!-- wp:utk-wds/site-footer-info-panel {"panelContact":"The University of Tennessee\u003cbr\u003eKnoxville, Tennessee 37996\u003cbr\u003e865-974-1000","panelText":"The flagship campus of the \u003ca rel=\u0022noreferrer noopener\u0022 href=\u0022https://tennessee.edu/\u0022 target=\u0022_blank\u0022\u003eUniversity of Tennessee System\u003c/a\u003e and partner in the \u003ca rel=\u0022noreferrer noopener\u0022 href=\u0022https://www.tntransferpathway.org/\u0022 target=\u0022_blank\u0022\u003eTennessee Transfer Pathway\u003c/a\u003e.","panelLinks":"\u003ca href=\u0022https://dae.utk.edu/eoa/ada/\u0022\u003eADA\u003c/a\u003e\u003ca href=\u0022https://www.utk.edu/aboutut/privacy/\u0022\u003ePrivacy\u003c/a\u003e\u003ca href=\u0022https://safety.utk.edu/\u0022\u003eSafety\u003c/a\u003e\u003ca href=\u0022https://titleix.utk.edu/\u0022\u003eTitle IX\u003c/a\u003e\u003ca href=\u0022https://hub.utk.edu/\u0022\u003eEmployee Hub\u003c/a\u003e\u003ca href=\u0022https://hr.utk.edu/\u0022\u003eEmployment\u003c/a\u003e"} -->
<div class="wp-block-utk-wds-site-footer-info-panel"><a href="https://www.utk.edu/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/utk-logo-white.svg" alt="University of Tennessee Knoxville" class="utk-logo"/></a><div class="panel-text-wrapper"><div class="panel-contact">The University of Tennessee<br>Knoxville, Tennessee 37996<br>865-974-1000</div><div class="panel-text"><div class="panel-text">The flagship campus of the<a rel="noreferrer noopener" href="https://tennessee.edu/" target="_blank">University of Tennessee System</a> and partner in the <a rel="noreferrer noopener" href="https://www.tntransferpathway.org/" target="_blank">Tennessee Transfer Pathway</a>.</div></div><div class="panel-links universal-footer-links"><a href="https://dae.utk.edu/eoa/ada/">ADA</a><a href="https://www.utk.edu/aboutut/privacy/">Privacy</a><a href="https://safety.utk.edu/">Safety</a><a href="https://titleix.utk.edu/">Title IX</a><a href="https://hub.utk.edu/">Employee Hub</a><a href="https://hr.utk.edu/">Employment</a></div></div></div><!-- /wp:utk-wds/site-footer-info-panel -->

<!-- wp:group {"className":"footer-contact-info","metadata":{"name":"Footer Contact Info"}} -->
<div class="wp-block-group footer-contact-info">

<!-- wp:site-title {"level":0,"style":{"typography":{"lineHeight":"1.2"}},"className":"footer-site-title"} /-->

<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}}} -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small","padding":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0">

<?php if ( get_theme_mod( 'address' ) ): ?>

<!-- wp:paragraph -->
<p><?php echo wp_kses_post( get_theme_mod( 'address' ) ); ?></p>
<!-- /wp:paragraph -->

<?php endif; ?>

<?php if ( get_theme_mod( 'email_address' ) ): ?>

<!-- wp:paragraph -->
<p><?php echo esc_html( get_theme_mod( 'email_label') ); ?>: <a href="mailto:<?php echo esc_url( get_theme_mod( 'email_address' ) ); ?>"><?php echo esc_html( get_theme_mod( 'email_address') ); ?></a></p>
<!-- /wp:paragraph -->

<?php endif; ?>

<?php if ( get_theme_mod( 'phone_number_1' ) && get_theme_mod( 'phone_label_1' ) ): ?>
<!-- wp:paragraph -->
<p><?php echo esc_html( get_theme_mod( 'phone_label_1' ) ); ?>: <a href="tel:<?php echo esc_url( get_theme_mod( 'phone_number_1' ) ); ?>"><?php echo esc_html( get_theme_mod( 'phone_number_1') ); ?></a><br>

<?php if ( get_theme_mod( 'phone_number_2' ) && get_theme_mod( 'phone_label_2' ) ): ?>

<?php echo esc_html( get_theme_mod( 'phone_label_2' ) ); ?>: <a href="tel:<?php echo esc_url( get_theme_mod( 'phone_number_2' ) ); ?>"><?php echo esc_html( get_theme_mod( 'phone_number_2' ) ); ?></a><br>

<?php endif; ?>

<?php if ( get_theme_mod( 'phone_number_3' ) && get_theme_mod( 'phone_label_3' ) ): ?>

<?php echo esc_html( get_theme_mod( 'phone_label_3' ) ); ?>: <a href="tel:<?php echo esc_url( get_theme_mod( 'phone_number_3' ) ); ?>"><?php echo esc_html( get_theme_mod( 'phone_number_3' ) ); ?></a>

<?php endif; ?>

</p>
<!-- /wp:paragraph -->
<?php endif; ?>

<!-- wp:social-links {"iconColor":"gray2","iconColorValue":"#e0e0e0","className":"is-style-logos-only"} -->
<ul class="wp-block-social-links has-icon-color is-style-logos-only">

<?php if ( get_theme_mod( 'social_url_x' ) ): ?>
<!-- wp:social-link {"url":"<?php echo get_theme_mod( 'social_url_x' ); ?>","service":"x"} /-->
<?php endif; ?>

<?php if ( get_theme_mod( 'social_url_facebook' ) ): ?>
<!-- wp:social-link {"url":"<?php echo get_theme_mod( 'social_url_facebook' ); ?>","service":"facebook"} /-->
<?php endif; ?>

<?php if ( get_theme_mod( 'social_url_youtube' ) ): ?>
<!-- wp:social-link {"url":"<?php echo get_theme_mod( 'social_url_youtube' ); ?>","service":"youtube"} /-->
<?php endif; ?>

<?php if ( get_theme_mod( 'social_url_instagram' ) ): ?>
<!-- wp:social-link {"url":"<?php echo get_theme_mod( 'social_url_instagram' ); ?>","service":"instagram"} /-->
<?php endif; ?>

<?php if ( get_theme_mod( 'social_url_linkedin' ) ): ?>
<!-- wp:social-link {"url":"<?php echo get_theme_mod( 'social_url_linkedin' ); ?>","service":"linkedin"} /-->
<?php endif; ?>

</ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<?php 

$locations = get_nav_menu_locations();
$footer_menu = wp_get_nav_menu_object( $locations['footer'] );

?>

<?php if ( ! empty( $footer_menu ) ): ?>

<!-- wp:column {"width":"33%"} -->
<div class="wp-block-column" style="flex-basis:33%">

<?php if ( $footer_menu->name !== 'Footer Links Menu' ): ?>

<!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","fontSize":"normal"} -->
<h3 class="wp-block-heading has-white-color has-text-color has-link-color has-normal-font-size"><?php echo $footer_menu->name;?></h3>
<!-- /wp:heading -->

<?php endif; ?>

<!-- wp:utk-wds/nav-menu { "menuName": "<?php echo $footer_menu->name;?>", "depth": "0", "id": "footer-links", "className": "footer-links", "duplicate_top_links": false } /-->

</div>
<!-- /wp:column -->
<?php endif; ?>


</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
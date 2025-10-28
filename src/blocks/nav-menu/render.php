<?php
/**
 * Server-side rendering for the Main Nav Menu block.
 *
 * @package UTKWDS
 *
 * The following variables are exposed to the file:
 *
 * @var array     $attributes Block attributes.
 * @var string    $content    Default block content.
 * @var WP_Block  $block      Block instance.
 */

namespace UTK\WebDesignSystem;

require_once __DIR__ . '/../../classes/Menu.php';

$depth               = isset( $attributes['depth'] ) ? $attributes['depth'] : 0;
$interactive         = isset( $attributes['interactive'] ) ? $attributes['interactive'] : '';
$duplicate_top_links = isset( $attributes['duplicate_top_links'] ) ? $attributes['duplicate_top_links'] : '';

// Resolve main menu by registered menu location first (so the menu can be named anything).
$main_menu_name = false;

// Try to get the menu assigned to the 'main' location.
$locations = get_nav_menu_locations();
if ( isset( $locations['main'] ) && $locations['main'] ) {
	$main_menu_obj = wp_get_nav_menu_object( $locations['main'] );
	if ( $main_menu_obj && isset( $main_menu_obj->name ) ) {
		$main_menu_name = $main_menu_obj->name;
	}
}

// If no menu is found via locations, fall back to attributes or 'Main Nav Menu'.
if ( ! $main_menu_name ) {
	$main_menu_name = isset( $attributes['mainMenuName'] ) ? $attributes['mainMenuName'] : 'Main Nav Menu';
}

$main_menu  = new Menu( $main_menu_name );
$links      = $main_menu->get_links();
$class_name = isset( $attributes['className'] ) ? ' ' . $attributes['className'] : '';
$anchor     = isset( $attributes['id'] ) ? $attributes['id'] : '';

if ( count( $links ) ) :
	?>
	<div <?php echo( 'id="' . esc_attr( $anchor ) . '"' ); ?> class="wp-block-utk-wds-nav-menu utk-nav-menu-wrapper<?php echo( esc_attr( $class_name ) ); ?>">
		<?php
		echo wp_kses_post(
			$main_menu->get_menu_markup(
				array(
					'list_classes'        => 'utk-nav-menu',
					'depth'               => absint( $depth ),
					'interactive'         => esc_attr( $interactive ),
					'duplicate_top_links' => esc_attr( $duplicate_top_links ),
				)
			)
		);
		?>
	</div>
	<?php
endif;

<?php
/**
 * Server-side rendering for the Main Nav Menu and Footer Links Menu blocks.
 *
 * @package utkwds
 *
 * The following variables are exposed to the file:
 *
 * @var array     $attributes Block attributes.
 * @var string    $content    Default block content.
 * @var WP_Block  $block      Block instance.
 */

namespace UTK\WebDesignSystem;

require_once __DIR__ . '/../../classes/Menu.php';

$menu_name           = isset( $attributes['menuName'] ) ? $attributes['menuName'] : false;
$depth               = isset( $attributes['depth'] ) ? $attributes['depth'] : 0;
$interactive         = isset( $attributes['interactive'] ) ? $attributes['interactive'] : '';
$duplicate_top_links = isset( $attributes['duplicate_top_links'] ) ? $attributes['duplicate_top_links'] : '';
$nav_menu_name       = false;

if ( ! $menu_name ) {
	echo 'No menu name specified.';
	return;
}

// Use menu_name to determine menu location.
$menu_location = 'Main Nav Menu' === $menu_name ? 'main' : 'footer';

// Get menu by location to allow renaming of main nav menu.
$locations = get_nav_menu_locations();
if ( isset( $locations[ $menu_location ] ) && $locations[ $menu_location ] ) {
	$main_menu_obj = wp_get_nav_menu_object( $locations[ $menu_location ] );
	if ( $main_menu_obj && isset( $main_menu_obj->name ) ) {
		$nav_menu_name = $main_menu_obj->name;
	}
}

// If no menu is found via locations, fall back to $menu_name from attributes.
if ( ! $nav_menu_name ) {
	$nav_menu_name = $menu_name;
}

$nav_menu   = new Menu( $nav_menu_name );
$links      = $nav_menu->get_links();
$class_name = isset( $attributes['className'] ) ? ' ' . $attributes['className'] : '';
$anchor     = isset( $attributes['id'] ) ? $attributes['id'] : '';

if ( count( $links ) ) :
	?>
	<div <?php echo( 'id="' . esc_attr( $anchor ) . '"' ); ?> class="wp-block-utk-wds-nav-menu utk-nav-menu-wrapper<?php echo( esc_attr( $class_name ) ); ?>">
		<?php
		echo wp_kses_post(
			$nav_menu->get_menu_markup(
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
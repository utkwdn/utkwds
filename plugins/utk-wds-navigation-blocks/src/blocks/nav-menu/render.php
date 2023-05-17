<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 * The following variables are exposed to the file:
 * 
 * $attributes (array): The block attributes.
 * $content (string): The block default content.
 * $block (WP_Block): The block instance.
 */
namespace UTK\WebDesignSystem;
require_once( __DIR__ . '/../../classes/Menu.php' );
$menu_name = isset( $attributes['menuName'] ) ? $attributes['menuName'] : false;
$depth = isset( $attributes['depth'] ) ? $attributes['depth'] : 0;

if ( !$menu_name ) {
	return;
}

$menu = new Menu( $menu_name );
$links = $menu->get_links();
$className = isset( $attributes['className'] ) ? ' ' . $attributes['className'] : '';

if ( count( $links ) ):
?>
<div class="wp-block-utk-wds-nav-menu utk-nav-menu-wrapper<?php echo( $className ) ?>">
	<?php
	echo $menu->get_menu_markup(array( 'list_classes' => 'utk-nav-menu', 'depth' => $depth ) );
	?>
</div>
<?php
endif;
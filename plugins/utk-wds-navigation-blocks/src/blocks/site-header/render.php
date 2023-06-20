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

function build_menu( $menu_attributes ) {
	$menu_name = isset( $menu_attributes['menuName'] ) ? $menu_attributes['menuName'] : false;
	$depth = isset( $menu_attributes['depth'] ) ? $menu_attributes['depth'] : 0;

	if ( !$menu_name && WP_DEBUG ) {
		echo "No menu name specified.";
		return;
	}

	$menu = new Menu( $menu_name );
	$links = $menu->get_links();
	$className = isset( $menu_attributes['className'] ) ? ' ' . $menu_attributes['className'] : '';
	$itemClassName = isset( $menu_attributes['list_item_classes'] ) ? ' ' . $menu_attributes['list_item_classes'] : '';
	$interactive = isset( $menu_attributes['interactive'] ) ? ' ' . $menu_attributes['interactive'] : '';
	$id = isset( $menu_attributes['id'] ) ? '' . $menu_attributes['id'] : '';

	if ( count( $links ) ):
	?>
	<div class="wp-block-utk-wds-nav-menu utk-nav-menu-wrapper <?php echo( $className ) ?>">
		<?php
		echo $menu->get_menu_markup(array(
			'list_classes' => 'utk-nav-menu',
			'list_item_classes' => $itemClassName,
			'depth' => $depth,
			'top_level_links' => false,
			'id' => $id,
			'interactive' => $interactive,
			'duplicate_top_links' => true
		) );
		?>
	</div>
	<?php
	endif;
}

$menu_allowed_blocks = array('utk-wds/nav-menu');
$menu_template = array( array(
	'utk-wds/nav-menu', array()
));

$main_menu_name = isset($attributes['mainMenuName']) ? $attributes['mainMenuName'] : 'Main Nav Menu';
$utility_menu_name = isset($attributes['utilityMenuName']) ? $attributes['utilityMenuName'] : 'Utility Nav Menu';

?>

<div id="universal-header" class="universal-header">
	<div class="universal-header__inner">
		<div class="universal-header__logo">
			<img src="<?php echo get_template_directory_uri() ?>/assets/images/utk-logo-horizontal.svg" alt="University of Tennessee, Knoxville" />
		</div>
		<div class="universal-header__utility-nav">
		<?php build_menu(array( 'menuName' => $utility_menu_name, 'depth' => '0', 'id' => 'utility-nav-menu--large', 'className' => 'utility-nav-menu--large') ); ?>
		<div class="search-button-wrapper">
			<button class="search-button">Search Button</button>
		</div>
	</div>
	<div class="universal-header__menu-open-button">
		<button class="menu-search-button" data-bs-toggle="offcanvas" data-bs-target="#mobileMainNav" aria-controls="mobileMainNav">Menu <span class="visually-hidden">and search</span></button>
	</div>
</div>
	
<div class="main-menu-wrapper offcanvas offcanvas-end" tabindex="-1" id="mobileMainNav" data-max-breakpoint="600">
	<div class="offcanvas-header">
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
	</div>
	<div class="main-menu offcanvas-body">
		<?php build_menu(array( 'menuName' => $utility_menu_name, 'depth' => '0', 'id' => 'utility-nav-menu--mobile', 'className' => 'utility-nav-menu--mobile') ); ?>
		<?php build_menu(array( 'menuName' => $main_menu_name, 'id' => 'mobile-nav-menu', 'list_item_classes' => 'collapsible-menu-item', 'depth' => '1', 'className' => 'main-nav-menu-list', 'interactive' => 'collapse') ); ?>
	</div>
	
</div>
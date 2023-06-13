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

function build_menu( $attributes ) {
	$menu_name = isset( $attributes['menuName'] ) ? $attributes['menuName'] : false;
	$depth = isset( $attributes['depth'] ) ? $attributes['depth'] : 0;

	if ( !$menu_name ) {
		echo "No menu name specified.";
		return;
	}

	$menu = new Menu( $menu_name );
	$links = $menu->get_links();
	$className = isset( $attributes['className'] ) ? ' ' . $attributes['className'] : '';

	if ( count( $links ) ):
	?>
	<div class="wp-block-utk-wds-nav-menu utk-nav-menu-wrapper <?php echo( $className ) ?>">
		<?php
		echo $menu->get_menu_markup(array( 'list_classes' => 'utk-nav-menu', 'depth' => $depth ) );
		?>
	</div>
	<?php
	endif;
}

$menu_allowed_blocks = array('utk-wds/nav-menu');
$menu_template = array( array(
	'utk-wds/nav-menu', array()
));

?>

<div id="universal-header" class="wp-block-group universal-header">
	<div class="wp-block-group menu-universal-wrapper has-global-padding">
		<img src="<?php echo get_template_directory_uri() ?>/assets/images/utk-logo-horizontal.svg" alt="University of Tennessee, Knoxville" />
	</div>

	<div>
		Menu/Search Icon
	</div>
	
<div class="main-menu-wrapper">
	<div>Close Button</div>
	<div class="main-menu">

	</div>
	
</div>
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

if (has_custom_logo() ) {
	$custom_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
	$header_logo = $custom_logo[0];
} else {
	$header_logo = get_template_directory_uri() . '/assets/images/utk-logo-horizontal.svg';
}

$custom_home_url = get_theme_mod( 'utkwds_home_url' );
do_action('qm/debug', 'Custom home URL: ' . $custom_home_url );
if ( $custom_home_url ) {
	$home_url = $custom_home_url;
} else {
	$home_url = 'https://www.utk.edu';
}

?>

<div id="universal-header" class="universal-header">
	<div class="universal-header__inner">
		<div class="universal-header__logo">
			<a href="<?php echo $home_url ?>">
				<img src="<?php echo $header_logo ?>" alt="University of Tennessee, Knoxville" />
			</a>
		</div>
		<div class="universal-header__utility-nav">
			<?php build_menu(array( 'menuName' => $utility_menu_name, 'depth' => '0', 'id' => 'utility-nav-menu--large', 'className' => 'utility-nav-menu--large') ); ?>
			<div class="search-button-wrapper">
				<button class="search-button" data-bs-toggle="collapse" id="search-slider-button" data-bs-target="#search-slider" aria-expanded="false" aria-controls="search-slider">
					<div class="search-icon" role="presentation">
						<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<title>Search Icon</title>
							<circle id="Ellipse 6" cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2" style="stroke: rgb(0, 0, 0);"></circle>
							<line id="Line 2" x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2" style="stroke: rgb(0, 0, 0);"></line>
						</svg>
					</div>	
					<div class="hide-when-closed">Search</div>
					<div class="hide-when-open">Close</div>
				</button>
				<div class="search-slider collapse collapse-horizontal" id="search-slider">
					<form class="form-inline hidden-print mt-4" id="cse-searchbox-form" action="<?php bloginfo( 'wpurl' ); ?>/">
						<div class="mb-3 input-group">
							<label class="sr-only visually-hidden" for="q">Search</label>
							<input type="search" class="form-control" tabindex="0" title="Search this site" placeholder="Search"  name="s" id="site-search-field-slider" />
							<button type="submit" class="btn btn-utlink">
								<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<title>Search Icon</title>
									<circle id="Ellipse 6" cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
									<line id="Line 2" x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
								</svg>
								<span class="visually-hidden">Search</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="universal-header__menu-open-button">
			<button class="menu-search-button" data-bs-toggle="offcanvas" data-bs-target="#mobileMainNav" aria-controls="mobileMainNav">
				<div>Menu <span class="visually-hidden">and search</span></div>
				<div class="search-icon" role="presentation">
					<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
						<title>Search Icon</title>
						<circle id="Ellipse 6" cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
						<line id="Line 2" x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
					</svg>
				</div>
			</button>
		</div>
	</div>
</div>
	
<div class="main-menu-wrapper offcanvas offcanvas-end" tabindex="-1" id="mobileMainNav" data-max-breakpoint="600">
	<div class="offcanvas-header">
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
	</div>
	<div class="main-menu offcanvas-body">
		<?php build_menu(array( 'menuName' => $utility_menu_name, 'depth' => '0', 'id' => 'utility-nav-menu--mobile', 'className' => 'utility-nav-menu--mobile') ); ?>

		<form class="form-inline hidden-print mt-4" id="cse-searchbox-form" action="<?php bloginfo( 'wpurl' ); ?>/">
			<div class="mb-3 input-group">
			<label class="sr-only visually-hidden" for="q">Search</label>
			<input type="search" class="form-control" title="Search this site" placeholder="Search"  name="s" id="site-search-field-offcanvas" />
			<button type="submit" class="btn btn-utlink">
			<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
				<title>Search Icon</title>
				<circle id="Ellipse 6" cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
				<line id="Line 2" x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
			</svg>
			<span class="visually-hidden">Search</span></button>
			</div>
		</form>

		<?php build_menu(array( 'menuName' => $main_menu_name, 'id' => 'mobile-nav-menu', 'list_item_classes' => 'collapsible-menu-item', 'depth' => '1', 'className' => 'main-nav-menu-list', 'interactive' => 'collapse') ); ?>
	</div>
	
</div>
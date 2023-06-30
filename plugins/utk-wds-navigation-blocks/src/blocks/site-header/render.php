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
	$bold_holder = isset( $menu_attributes['bold_holder'] ) ? ' ' . $menu_attributes['bold_holder'] : '';
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
			'bold_holder' => $bold_holder,
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
					<div class="search-icon hide-when-closed" role="presentation">
						<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<title>Search Icon</title>
							<circle cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2" style="stroke: rgb(0, 0, 0);"></circle>
							<line x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2" style="stroke: rgb(0, 0, 0);"></line>
						</svg>
					</div>	
					<div class="hide-when-closed">Search</div>

					<div class="close-icon hide-when-open" role="presentation">
					<svg viewBox="0 0 500 500" width="14" height="10" xmlns="http://www.w3.org/2000/svg">
						<path d="M 9.15 9.55 C 21.34 -2.64 41.1 -2.64 53.31 9.55 L 249.82 206.05 L 446.32 9.55 C 463.02 -7.74 492.18 -0.47 498.79 22.65 C 501.97 33.73 498.77 45.68 490.47 53.7 L 293.96 250.22 L 490.47 446.72 C 507.17 464.01 498.89 492.91 475.58 498.71 C 465.12 501.33 454.08 498.37 446.32 490.87 L 249.82 294.37 L 53.31 490.87 C 36.01 507.58 7.13 499.29 1.31 475.98 C -1.29 465.52 1.67 454.46 9.15 446.72 L 205.67 250.22 L 9.15 53.7 C -3.05 41.51 -3.05 21.74 9.15 9.55 Z" style=""></path>
					</svg>
					</div>	
					<div class="hide-when-open">Close</div>
				</button>
				<div class="search-slider collapse collapse-horizontal" id="search-slider">
					<form class="form-inline hidden-print mt-4" id="site-searchbox-form" action="<?php bloginfo( 'wpurl' ); ?>/">
						<div class="mb-3 input-group">
							<label class="sr-only visually-hidden" for="q">Search</label>
							<input type="search" class="form-control" tabindex="0" title="Search this site" placeholder="Search"  name="s" id="site-search-field-slider" />
							<button type="submit" class="btn btn-utlink">
								<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<title>Search Icon</title>
									<circle cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
									<line x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
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
						<circle cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
						<line x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
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
					<circle cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
					<line x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
				</svg>
				<span class="visually-hidden">Search</span>
			</button>
			</div>
		</form>

		<?php build_menu(array( 'menuName' => $main_menu_name, 'id' => 'mobile-nav-menu', 'list_item_classes' => 'collapsible-menu-item', 'depth' => '1', 'className' => 'main-nav-menu-list', 'interactive' => 'collapse', 'bold_holder' => false) ); ?>
	</div>
	
</div>
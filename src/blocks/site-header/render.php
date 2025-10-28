<?php
/**
 * Server-side rendering for the Site Header block.
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

/**
 * Builds and renders a navigation menu block.
 *
 * Retrieves a specified menu and outputs its HTML markup with the
 * provided attributes and configuration options.
 *
 * @param array $menu_attributes {
 *     Attributes used to configure the menu output.
 *
 *     @type string $menuName           The registered menu name to display.
 *     @type int    $depth              Optional. Menu depth level. Default 0.
 *     @type string $className          Optional. Additional class name(s) for the wrapper element.
 *     @type string $list_item_classes  Optional. Additional class name(s) for each list item.
 *     @type string $interactive        Optional. Interactive behavior classes or data attributes.
 *     @type string $bold_holder        Optional. Class used for bold wrapper or holder styling.
 *     @type string $id                 Optional. HTML ID attribute for the menu container.
 * }
 *
 * @return void Outputs the rendered menu markup directly.
 */
function build_menu( $menu_attributes ) {
	$menu_name = isset( $menu_attributes['menuName'] ) ? $menu_attributes['menuName'] : false;
	$depth     = isset( $menu_attributes['depth'] ) ? $menu_attributes['depth'] : 0;

	if ( ! $menu_name && WP_DEBUG ) {
		echo 'No menu name specified.';
		return;
	}

	$menu            = new Menu( $menu_name );
	$links           = $menu->get_links();
	$class_name      = isset( $menu_attributes['className'] ) ? ' ' . $menu_attributes['className'] : '';
	$item_class_name = isset( $menu_attributes['list_item_classes'] ) ? ' ' . $menu_attributes['list_item_classes'] : '';
	$interactive     = isset( $menu_attributes['interactive'] ) ? ' ' . $menu_attributes['interactive'] : '';
	$bold_holder     = isset( $menu_attributes['bold_holder'] ) ? ' ' . $menu_attributes['bold_holder'] : '';
	$id              = isset( $menu_attributes['id'] ) ? '' . $menu_attributes['id'] : '';

	if ( count( $links ) ) :
		?>
		<div class="wp-block-utk-wds-nav-menu utk-nav-menu-wrapper <?php echo( esc_attr( $class_name ) ); ?>">
			<?php
			echo wp_kses_post(
				$menu->get_menu_markup(
					array(
						'list_classes'        => 'utk-nav-menu',
						'list_item_classes'   => esc_attr( $item_class_name ),
						'depth'               => absint( $depth ),
						'top_level_links'     => false,
						'id'                  => esc_attr( $id ),
						'interactive'         => esc_attr( $interactive ),
						'bold_holder'         => esc_attr( $bold_holder ),
						'duplicate_top_links' => true,
					)
				)
			);
			?>
		</div>
		<?php
	endif;
}

$menu_allowed_blocks = array( 'utk-wds/nav-menu' );
$menu_template       = array(
	array(
		'utk-wds/nav-menu',
		array(),
	),
);

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

// No menu location is registered for the utility nav, so use attributes.
$utility_menu_name = isset( $attributes['utilityMenuName'] ) ? $attributes['utilityMenuName'] : 'Utility Nav Menu';

if ( has_custom_logo() ) {
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
			<a href="<?php echo esc_attr( $home_url ); ?>">
				<img src="<?php echo esc_attr( $header_logo ); ?>" alt="University of Tennessee, Knoxville" />
			</a>
		</div>
		<div class="universal-header__utility-nav">
			<?php
			build_menu(
				array(
					'menuName'  => $utility_menu_name,
					'depth'     => '0',
					'id'        => 'utility-nav-menu--large',
					'className' => 'utility-nav-menu--large',
				)
			);
			?>
			<div class="search-button-wrapper">
				<button class="search-button" id="search-slider-button" aria-expanded="false" aria-controls="search-slider">
					<div class="search-icon hide-when-closed" role="presentation">
						<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<title>Search Icon</title>
							<circle cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
							<line x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
						</svg>
					</div>	
					<div class="hide-when-closed">Search</div>

					<div class="close-icon hide-when-open" role="presentation">
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
							<path d="M13.0153 2.15711L10.8582 4.18425e-05L6.50716 4.35006L2.15711 0L0 2.15711L4.35001 6.50714L0 10.8572L2.15711 13.0143L6.50716 8.66421L10.8582 13.0142L13.0153 10.8572L8.66525 6.50714L13.0153 2.15711Z" fill="#4B4B4B"/>
						</svg>
					</div>
					<div class="hide-when-open visually-hidden sr-only">Close</div>
					
				</button>
				<div class="search-slider" id="search-slider">
					<form class="form-inline hidden-print" id="site-searchbox-form" action="<?php bloginfo( 'wpurl' ); ?>/">
						<div class="input-group">
							<label class="sr-only visually-hidden" for="q">Search</label>
							<input type="search" class="form-control" tabindex="0" title="Search this site" placeholder="Search"  name="s" id="site-search-field-slider" />
							<button type="submit" class="btn btn-utlink">
								<div class="button-inner">
									<svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
										<title>Search Icon</title>
										<circle cx="6.12" cy="5.73" r="4.22" transform="matrix(0.99999, 0.00372, -0.00372, 0.99999, 0.02135, -0.02272)" stroke-width="2"></circle>
										<line x1="9.35" y1="8.41" x2="12.71" y2="11.8" stroke-width="2"></line>
									</svg>
									Search
								</div>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="universal-header__menu-open-button">
			<button class="menu-search-button" data-toggle="offcanvas" data-target="#mobileMainNav" aria-controls="mobileMainNav">
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
		<button type="button" class="btn-close" data-dismiss="offcanvas" aria-label="Close">Close</button>
	</div>
	<div class="main-menu offcanvas-body">
		<?php
		build_menu(
			array(
				'menuName'  => $utility_menu_name,
				'depth'     => '0',
				'id'        => 'utility-nav-menu--mobile',
				'className' => 'utility-nav-menu--mobile',
			)
		);
		?>

		<form class="form-inline hidden-print" id="cse-searchbox-form" action="<?php bloginfo( 'wpurl' ); ?>/">
			<div class="input-group">
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

		<?php
		build_menu(
			array(
				'menuName'          => $main_menu_name,
				'id'                => 'mobile-nav-menu',
				'list_item_classes' => 'collapsible-menu-item',
				'depth'             => '1',
				'className'         => 'main-nav-menu-list',
				'interactive'       => 'collapse',
				'bold_holder'       => false,
			)
		);
		?>
	</div>
	
</div>

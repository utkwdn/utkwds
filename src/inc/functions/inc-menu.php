<?php
/**
 * Menu registration and automatic utility menu building.
 *
 * @package utkwds
 */

/**
 * Register navigation menus.
 */
function utkwds_register_menus() {

	register_nav_menus(
		array(
			'main'   => __( 'Main Nav Menu', 'utkwds' ),
			'footer' => __( 'Footer Links Menu', 'utkwds' ),
		)
	);
}

add_action( 'after_setup_theme', 'utkwds_register_menus' );

/**
 * Build and update the Utility Nav Menu programmatically.
 */
function utkwds_build_utility_nav_menu() {

	$utility_menu_name   = 'Utility Nav Menu';
	$utility_menu_exists = wp_get_nav_menu_object( $utility_menu_name );

	$utility_items = array( 'Request Info', 'Visit', 'Apply', 'Give' );

	if ( is_object( $utility_menu_exists ) ) {
		$utility_menu_id = $utility_menu_exists->term_id;
	}

	if ( ! $utility_menu_exists ) {
		$utility_menu_id = wp_create_nav_menu( $utility_menu_name );
	}

	$position = 1;
	foreach ( $utility_items as $item ) {

		$args = array( 'title' => $item );

		$current_menu_item    = wp_get_nav_menu_items( $utility_menu_name, $args );
		$current_menu_item_id = 0;

		if ( ! empty( $current_menu_item ) && isset( $current_menu_item[0]->ID ) ) {
			$current_menu_item_id = $current_menu_item[0]->ID;
		}

		$menu_url = get_theme_mod( 'utility_menu_' . strtolower( str_replace( ' ', '_', $item ) ) );

		if ( empty( $menu_url ) || filter_var( $menu_url, FILTER_VALIDATE_URL ) === false ) {
			$menu_url = 'https://www.utk.edu/' . strtolower( str_replace( ' ', '', $item ) );
		}

		wp_update_nav_menu_item(
			$utility_menu_id,
			$current_menu_item_id,
			array(
				'menu-item-title'    => __( $item, 'utkwds' ),
				'menu-item-url'      => $menu_url,
				'menu-item-status'   => 'publish',
				'menu-item-type'     => 'custom',
				'menu-item-position' => $position,
			)
		);

		++$position;
	}

	update_option( 'utkwds_utility_nav_menu_version', UTKDS_VERSION, true );
}

add_action( 'wp_update_nav_menu', 'utkwds_build_utility_nav_menu' );
add_action( 'customize_save_after', 'utkwds_build_utility_nav_menu' );

/**
 * Build the Utility Nav Menu once per theme version.
 *
 * Runs on every request, so it only compares a stored version before
 * doing any work. Building on every request saved the menu items each
 * time, adding database writes and cache invalidation to every page load.
 */
function utkwds_maybe_build_utility_nav_menu() {

	if ( get_option( 'utkwds_utility_nav_menu_version' ) === UTKDS_VERSION ) {
		return;
	}

	utkwds_build_utility_nav_menu();
}

add_action( 'after_setup_theme', 'utkwds_maybe_build_utility_nav_menu' );

/**
 * Rebuild the Utility Nav Menu on the next request if a menu is deleted.
 */
function utkwds_reset_utility_nav_menu_version() {
	delete_option( 'utkwds_utility_nav_menu_version' );
}

add_action( 'wp_delete_nav_menu', 'utkwds_reset_utility_nav_menu_version' );

/**
 * Limit navigation menu depth in the admin interface.
 *
 * @param string $hook Current admin page hook.
 *
 * @return void
 */
function utkwds_register_naviation_limit_script( $hook ) {

	wp_register_script( 'utkwds-navigation-limit-depth', false );
	wp_add_inline_script(
		'utkwds-navigation-limit-depth',
		'if ( typeof wpNavMenu.options.globalMaxDepth !== "undefined" ){
			wpNavMenu.options.globalMaxDepth = 1;
		}',
		'before'
	);

	if ( 'nav-menus.php' === $hook ) {
		wp_enqueue_script( 'utkwds-navigation-limit-depth' );
	}
}
add_action( 'admin_enqueue_scripts', 'utkwds_register_naviation_limit_script' );

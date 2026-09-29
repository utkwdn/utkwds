<?php
/**
 * Sets up a custom Locations taxonomy for UTKWDS.
 *
 * @package utkwds
 */

/**
 * Register Locations Taxonom.
 */
function utkwds_register_locations_tax() {

	$labels = array(
		'name'                       => __( 'Locations', 'taxonomy general name' ),
		'singular_name'              => __( 'Location', 'taxonomy general name' ),
		'search_items'               => __( 'Search Locations' ),
		'all_items'                  => __( 'All Locations' ),
		'edit_item'                  => __( 'Edit Location' ),
		'update_item'                => __( 'Update Location' ),
		'add_new_item'               => __( 'Add Location' ),
		'new_item_name'              => __( 'New Location Name' ),
		'separate_items_with_commas' => __( 'Separate locations with commas' ),
		'add_or_remove_items'        => __( 'Add or remove locations' ),
		'choose_from_most_used'      => __( 'Choose from the most used locations' ),
		'not_found'                  => __( 'No locations found.' ),
		'menu_name'                  => __( 'Locations' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => true,
		'has_archive'        => false,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'query_var'          => false,
		'rewrite'            => array(
			'slug'       => 'locations',
			'with_front' => true,
		),
		'show_admin_column'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => false,
		'rest_base'          => 'locations',
		'show_in_quick_edit' => true,
		'sort'               => false,
		'default_term'       => false,
	);
	register_taxonomy( 'locations', 'post', $args );
}

add_action( 'init', 'utkwds_register_locations_tax' );

/**
 * Create location terms.
 */
function utkwds_create_default_terms() {

	$default_terms = array(
		'Top News',
		'Top Categories',
	);

	foreach ( $default_terms as $term ) {
		if ( ! term_exists( $term, 'locations' ) ) {
			wp_insert_term( $term, 'locations' );
		}
	}
}

add_action( 'init', 'utkwds_create_default_terms' );

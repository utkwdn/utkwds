<?php
/**
 *
 * Updates to user roles.
 *
 * @package utkwds
 */

/**
 * Add Gravity Forms permissions to Editor role
 */
function utkwds_add_gravityforms_caps_to_editor() {
	$role = get_role( 'editor' );
	$role->add_cap( 'gform_full_access' );
}

add_action( 'admin_init', 'utkwds_add_gravityforms_caps_to_editor' );

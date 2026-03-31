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
	$editor_role = get_role( 'editor' );

	if ( ! $editor_role ) {
		return;
	}

	// Remove full gravity form access if granted.
	$editor_role->remove_cap( 'gform_full_access' );

	// Add form access.
	$editor_role->add_cap( 'gravityforms_create_form' );
	$editor_role->add_cap( 'gravityforms_delete_forms' );
	$editor_role->add_cap( 'gravityforms_edit_forms' );
	$editor_role->add_cap( 'gravityforms_preview_forms' );

	// Add entries access.
	$editor_role->add_cap( 'gravityforms_view_entries' );
	$editor_role->add_cap( 'gravityforms_edit_entries' );
	$editor_role->add_cap( 'gravityforms_delete_entries' );

	// Add notes access.
	$editor_role->add_cap( 'gravityforms_view_entry_notes' );
	$editor_role->add_cap( 'gravityforms_edit_entry_notes' );

	// Add import/export access.
	$editor_role->add_cap( 'gravityforms_export_entries' );
}

add_action( 'admin_init', 'utkwds_add_gravityforms_caps_to_editor' );

<?php
/**
 * Modification des utilisateurs
 **/

if ( ! function_exists('ol_change_editor_capabilities') ) {
    function ol_change_editor_capabilities() {
        $role = get_role('editor');
        $role->add_cap( 'edit_theme_options' );
        $role->add_cap( 'edit_themes' );
        $role->add_cap ( 'manage_options' );
    }
}
add_action('admin_init', 'ol_change_editor_capabilities');
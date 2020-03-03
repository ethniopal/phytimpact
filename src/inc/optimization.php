<?php
/**
 * Remove Update Notification (for all users except ADMIN)
 */
global $user_login;
get_currentuserinfo();
if ($user_login !== "admin") { // change admin to the username that gets the updates
    add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
    add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

/**
 * Remove Update Notification (for all users except ADMIN)
 */
add_action('admin_head', function() {
    if(!current_user_can('manage_options')){
        remove_action( 'admin_notices', 'update_nag',      3  );
        remove_action( 'admin_notices', 'maintenance_nag', 10 );
    }
});


/**
 * Désactive les commentaires pour les médias
 */
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});


/**
 * REMOVE PAGE META BOXES
 */
function remove_my_page_metaboxes() {
    remove_meta_box( 'postcustom','page','normal' ); // Custom Fields Metabox
    remove_meta_box( 'postexcerpt','page','normal' ); // Excerpt Metabox
    remove_meta_box( 'commentstatusdiv','page','normal' ); // Comments Status Metabox
    remove_meta_box( 'commentsdiv', 'page','normal' ); // Comments Metabox
    remove_meta_box( 'trackbacksdiv','page','normal' ); // Talkback Metabox
    remove_meta_box( 'slugdiv','page','normal' ); // Slug Metabox
    remove_meta_box( 'authordiv','page','normal' ); // Author Metabox
}
add_action('admin_menu','remove_my_page_metaboxes');


/**
 * Change la longueur du excerpt de worpdress
 */
add_filter( 'excerpt_length', function($length) {
    return 20;
} );

/**
 * Turn off trackback
 * @param $links
 */
function disable_self_trackback( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}

add_action( 'pre_ping', 'disable_self_trackback' );

/**
 * Ajoute le defer aux script  du site web
 */
if (!is_admin()){
    function add_defer_attribute($tag, $handle) {
        return str_replace(' src', ' defer src', $tag);
    }
    add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);
}

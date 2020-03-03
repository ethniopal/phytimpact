<?php
//supprime les entêtes inutile de wp
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10);
remove_action('wp_head', 'parent_post_rel_link', 10);
remove_action('wp_head', 'adjacent_posts_rel_link', 10);

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// unregister all widgets
function unregister_default_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('Twenty_Eleven_Ephemera_Widget');
}
add_action('widgets_init', 'unregister_default_widgets', 11);


/**
 * Retire la version utilisé des scripts
 * @param $src
 * @return mixed
 */
function _remove_script_version( $src ){
    $parts = explode( '?ver', $src );
    return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );



/**
 * Désactivate heartbeat wp
 */
add_action( 'init', 'my_deregister_heartbeat', 1 );
function my_deregister_heartbeat() {
    global $pagenow;

    if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
        wp_deregister_script('heartbeat');
}


/**
 * Cache la bar d'administration si ce n'est pas l'admin qui est connecté
 */
function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
//        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'remove_admin_bar');


/**
 * Hide page
 */

add_filter('parse_query', 'ts_hide_pages_in_wp_admin');
function ts_hide_pages_in_wp_admin($query)
{
    global $pagenow, $post_type;
    if (is_admin() && $pagenow == 'edit.php' && $post_type == 'page') {
//        $query->query_vars['post__not_in'] = array('609');//Ajouter les id de pages à caché
    }
}

/**
 * Remove page admin
 */
add_action('admin_init', 'wpse_136058_remove_menu_pages');

function wpse_136058_remove_menu_pages()
{

    if (!current_user_can('administrator')) {

        remove_menu_page('edit.php?post_type=acf');
        remove_menu_page('wpcf7');
        remove_menu_page( 'smush' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'plugins.php' );
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'options-general.php' ); //menu réglages
        remove_menu_page( 'edit.php?post_type=acf-field-group' ); //ACF

        // PLUGINS THAT ADD AS DASHBOARD SUBMENU
        remove_submenu_page('index.php', 'iconize-plugin-update-notifier');

        // OR FOR EXAMPLE WOOCOMMERCE DASHBOARD SUBMENU
//        remove_submenu_page('index.php', 'wc-about'); //WOO
//        remove_submenu_page('index.php', 'wc-credits'); //WOO
//        remove_submenu_page('index.php', 'wc-translators'); //WOO

        // CUSTOM POST TYPE
//        remove_menu_page('edit.php?post_type={$POST_TYPE}'); //EXAMPLE FORMAT
//        remove_submenu_page( 'edit.php?post_type={$POST_TYPE}', '{$SUBMENU_URL_VARIABLE}' ); //EXAMPLE FORMAT


        // OTHER EXAMPLES
        remove_menu_page('revslider'); // REVSLIDER
        remove_menu_page('woocommerce'); // WOOCOMMERCE
        remove_menu_page('order-post-types-shop_order'); // WOOCOMMERCE
        remove_menu_page('order-post-types-shop_coupons'); // WOOCOMMERCE
        remove_menu_page('shortcodes-ultimate'); // SHORTCODES ULTIMATE
        remove_menu_page('wp-admin-microblog/wp-admin-microblog.php'); // ADMIN MICROBLOG
        remove_menu_page('snippets'); //CODE SNIPPETS
        remove_menu_page('gf_edit_forms'); // GRAVITY FORMS
        remove_submenu_page('gf_edit_forms', 'gf_settings'); // GRAVITY FORMS
        remove_submenu_page('gf_edit_forms', 'gf_export'); // GRAVITY FORMS
        remove_submenu_page('gf_edit_forms', 'gf_update'); // GRAVITY FORMS
        remove_submenu_page('gf_edit_forms', 'gf_addons'); // GRAVITY FORMS
        remove_submenu_page('gf_edit_forms', 'gf_help'); // GRAVITY FORMS


        remove_menu_page( 'w3tc_dashboard' );

        //suppression pour les autres utilisateur des outils wp installé
        add_action( 'admin_menu', 'hide_menu_priority',11);
        function hide_menu_priority() {
            remove_menu_page('w3tc_dashboard');
            remove_menu_page( 'WP-Optimize' );
            remove_menu_page( 'wpseo_dashboard' );
        }
   }
}


//Disable Default Dashboard Widgets
function remove_dashboard_meta()
{
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); //Removes the 'incoming links' widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Removes the 'plugins' widget
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
//    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); //Removes the secondary widget
//    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Removes the 'Quick Draft' widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Removes the 'Recent Drafts' widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Removes the 'Activity' widget
//    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
//    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //Removes the 'Activity' widget (since 3.8)
//    remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal'); //Removes the 'Activity' widget (since 3.8)
    remove_action('admin_notices', 'update_nag');
}
add_action('admin_init', 'remove_dashboard_meta');



/**
 * Supprime le logo de wp
 */
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );
function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
    $wp_admin_bar->remove_node( 'comments' );

    if ((!current_user_can('administrator'))) {
        $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
        $wp_admin_bar->remove_menu('w3tc_overlay_upgrade');
        $wp_admin_bar->remove_menu('w3tc_settings_general');
        $wp_admin_bar->remove_menu('w3tc_settings_extensions');
        $wp_admin_bar->remove_menu('w3tc_settings_faq');
        $wp_admin_bar->remove_menu('w3tc_support');

        $wp_admin_bar->remove_menu('wpseo-menu');
        $wp_admin_bar->remove_menu('wpseo-licenses');
    }
}


/**
 * supprime le span wrapper de contact form7
 **/
add_filter('wpcf7_form_elements', function ($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

    return $content;
});




/*
* Sanitize File Name pour enlever les accents des fichiers uploadé.
*/
add_filter('sanitize_file_name', 'remove_accents');




/**
 * ajout du menu "MENU" dans wordpress
 **/
if ( ! function_exists('new_nav_menu') ) {

    function new_nav_menu()
    {
        global $menu;

        add_menu_page(__('Menus', 'nav-menus'), __('Menus', 'nav-menus'), 'edit_themes', 'nav-menus.php', '', 'dashicons-menu');
//        add_submenu_page( 'theme-general-settings',  __('Menus', 'mav-menus'), __('Menus', 'nav-menus'), 'edit_themes', 'nav-menus.php');
    }

    add_action('admin_menu', 'new_nav_menu');
}
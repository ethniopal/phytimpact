<?php
/**
 * Permet de modifier le pied de page
 */
function modify_admin_footer() {
    echo '<span id="footer-thankyou">Développer par <a href="'.ThemeAuthorUrl.'" target="_blank" rel="noopener noreferrer">'. ThemeAuthor.'</a>.</span>';
}
add_filter( 'admin_footer_text', 'modify_admin_footer' );

function footer_dashboard_wp() {
    remove_filter( 'update_footer', 'core_update_footer' );
}

add_action( 'admin_menu', 'footer_dashboard_wp' );


/**
 * Ajouter la documentation wp dans le menu
 */

function modify_admin_toolbar( $admin_bar ) {
// admin toolbar first level item
    $admin_bar->add_menu( array(
        'id' => 'quick-links',
        'title' => 'Documentations',
        'href' => '#',
        'meta' => array(
            'title' => __( 'Quick Links'),
        ),
    ) );
// admin bar second level item
    $admin_bar->add_menu( array(
        'id' => 'quick-link-one',
        'parent' => 'quick-links',
        'title' => 'All Settings',
        'href' => admin_url( 'options.php' ),
        'meta' => array(
            'title' => __( 'All Settings'),
            'class' => 'quick-links-class'
        ),
    ) );
// admin bar second level item
    $admin_bar->add_menu( array(
        'id' => 'quick-link-two',
        'parent' => 'quick-links',
        'title' => 'All Posts',
        'href' => admin_url( 'edit.php' ),
        'meta' => array(
            'title' => __( 'All Posts' ),
            'class' => 'quick-links-class'
        ),
    ) );
}


/**
 * Changer le logo par le notre
 */
function modify_admin_logo() {
    if(file_exists(get_stylesheet_directory_uri() . '/custom-logo.png')):?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?= get_stylesheet_directory_uri() ?>/custom-logo.png);
            height: 84px;
            width: 84px;
            background-size: 84px 84px;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
    <?php
    endif;
}
add_action( 'login_enqueue_scripts', 'modify_admin_logo' );





/**
 * Active une feuille de style pour l'admin
 */
//add_action( 'admin_enqueue_scripts', 'load_admin_style' );
//function load_admin_style() {
//    wp_register_style( 'admin_css', $admin_stylesheet, false, '1.0.0' );
//}


function admin_style() {
    $admin_stylesheet = TemplateUrl . '/css/wp-admin.css';

    if(@url_exists($admin_stylesheet))
        wp_enqueue_style('admin-styles', $admin_stylesheet);
}
add_action('admin_enqueue_scripts', 'admin_style');





/* --------------------------------------------------------
code permettant de mettre la bar d'admin en pied de page
-----------------------------------------------------------
*/
if ( ! function_exists('olc_adminBarBottom') ) {
    function olc_adminBarBottom()
    {
        echo '<style type="text/css">
        body {
            margin-top: -28px;
        }
        #wpadminbar {
            top: auto !important;
            bottom: 0;
            display:none; 
        }
        #wpadminbar .quicklinks .ab-sub-wrapper {
            bottom: 28px;
        }
        #wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input {
            border-width: 1px 1px 0 1px;
            -moz-box-shadow:0 -4px 4px rgba(0,0,0,0.2);
            -webkit-box-shadow:0 -4px 4px rgba(0,0,0,0.2);
            box-shadow:0 -4px 4px rgba(0,0,0,0.2);
        }
        #wpadminbar .quicklinks .menupop ul#wp-admin-bar-wp-logo-default {
            background-color: #eee;
        }
        #wpadminbar .quicklinks .menupop ul#wp-admin-bar-wp-logo-external {
            background-color: white;
        }
        body.wp-admin div#wpwrap div#footer {
            bottom: 28px !important;
        }
        @media only screen and (max-width : 776px) {
            #wpadminbar{
                display:none;
            }
        }
    </style>';
    }


    // Uncomment if you want it to be done in the Admin Section too
    /*
    if ( is_admin_bar_showing() ) {
         add_action( 'admin_head', 'olc_adminBarBottom' );
    }
    */

    if (is_admin_bar_showing()) {
        add_action('wp_head', 'olc_adminBarBottom');
    }

}
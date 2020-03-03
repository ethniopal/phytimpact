<?php
if ( ! function_exists( 'base_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
     */
    function base_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on base, use a find and replace
         * to change 'base' to the name of your theme in all the template files.
         */
        load_theme_textdomain( ThemeName, TemplateDir . "/languages" );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'gallery',
            'caption',
        ) );

        /**
         * Ajouts des menus dans le thèmes
         */
        add_theme_support('menus');
        register_nav_menus( array(
            'main-menu' => esc_html__( 'Menu principal', ThemeName ),
        ) );





        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );

        @remove_image_size('1536x1536' );
        @remove_image_size('2048x2048' );

	}
endif;
add_action( 'after_setup_theme', 'base_setup' );


/**
 * Remove Guttenberg editor
 */
//add_filter( 'use_block_editor_for_post', '__return_false' );

function gutenberg_setup() {
    // Support Featured Images
    add_theme_support( 'post-thumbnails' );

    //Gutenberg
    add_theme_support( 'align-wide' );
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support( 'dark-editor-style' );
    add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'gutenberg_setup' );



/**
 * Ajout des pages options ACF
 */
if( function_exists('acf_add_options_page') ) {

    $themeOption = acf_add_options_page(array(
        'page_title' 	=> __('Configuration du thème', ThemeName),
        'menu_title' 	=> __('Thème', ThemeName),
        'menu_slug'      => 'theme-general-settings',
        'redirect' 	=> true
    ));

    $themeChildOption = acf_add_options_sub_page(array(
        'page_title'  => __('Theme Options - En-tête', ThemeName),
        'menu_title'  => __('En-tête de site', ThemeName),
        'parent_slug' => $themeOption['menu_slug'],
        'capability'  => 'manage_options'
    ));

    $themeChildOption = acf_add_options_sub_page(array(
        'page_title'  => __('Theme Options - Pied de page', ThemeName),
        'menu_title'  => __('Pied de page', ThemeName),
        'parent_slug' => $themeOption['menu_slug'],
        'capability'  => 'manage_options'
    ));

}

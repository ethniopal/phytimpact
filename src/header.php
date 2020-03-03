<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package base
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fav icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= TemplateUrl?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= TemplateUrl?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= TemplateUrl?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= TemplateUrl?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= TemplateUrl?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= TemplateUrl?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= TemplateUrl?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= TemplateUrl?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= TemplateUrl?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= TemplateUrl?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= TemplateUrl?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= TemplateUrl?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= TemplateUrl?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= TemplateUrl?>/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= TemplateUrl?>/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <!-- skip links -->
    <nav class="skip-nav" role="navigation">
        <a class="skip-nav__link screen-reader-text" href="#content"><?php esc_html_e( 'Aller à la section contenu', ThemeName ); ?></a>
    </nav>

    <!-- navbar -->
	<header class="c-navbar">
        <div class="c-navbar__inner">
            <h1 class="c-logo"><a class="c-logo__link" href="<?= esc_url(home_url('/')); ?>">LOGO</a></h1>

            <button class="c-burger" aria-label="<?= __('Ouverture du menu', ThemeName)?>" role="button" aria-expanded="false">
                <span class="c-burger__line"></span>
            </button>

            <!-- menu -->
            <nav class="c-main-nav" role="navigation">
                <?php
                wp_nav_menu( array(
                    'container'      => 'ul',
                    'menu_class'      => 'c-main-nav__wrapper',
                    'menu_id'        => 'primary-menu',
                ) );
                ?>
            </nav>
        </div>
	</header>

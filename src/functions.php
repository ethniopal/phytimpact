<?php
//modifier ces permissions  dans le ftp:
//755 pour un dossier
//644 pour un fichier
//400 pour wp-config.php

//Ajouter plugin : WangGuard ou Stop Spammers ou Spam Prevention. (éviter les spams)
//Ajouter plugin : https://wordpress.org/plugins/tac/ (vérification de sécurité)
//Ajouter plugin : WP-Super-Cache (pour la cache)
//Ajouter plugin : WP Smush plugin (pour les images du thèmes)

//Scan virus site web : https://sitecheck.sucuri.net/
//Scan rapidité : https://gtmetrix.com/

//variable qu'on va réutilisé
define('TemplateDir', get_template_directory());
define('TemplateUrl', get_template_directory_uri());
define('ThemeName',  wp_get_theme());
define('ThemeAuthor',  wp_get_theme()->get('Author'));
define('ThemeAuthorUrl',  wp_get_theme()->get('AuthorURI'));

//intègre tous les menus
require 'inc/all.php';

//les couleurs du thèmes
addPalette(array(
    '#939',
    '#193339',
    '#323935',
    '#923329',
    '#fff'
));


//déclaration des CPT du site web
$cptIngredient = newCpt("ingrédient", "ingrédients", true);
wp_die('CPT: ' . $cptIngredient);
//déclaration de la taxonomy
$taxonomyGamme = newTaxonomiy(array($cptIngredient), "Gamme de produit", "Gammes de produit", false);


//Configuration + modification des tailles des images du site web
//add_image_size('custom-size', 220, 180, true);

//priorisé ces formats, car sont généré par défaut par WP
changeImageSize('thumbnail', 320, 320, true);
changeImageSize('medium', 600, 600, true);
changeImageSize('large', 900, 900, true);


/**
 * Enqueue scripts and styles.
 */
function base_scripts() {
	wp_enqueue_style( 'base-style', get_stylesheet_uri() );


}
add_action( 'wp_enqueue_scripts', 'base_scripts' );

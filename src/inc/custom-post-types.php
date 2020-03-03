<?php
/**
 * Crée un cpt automatiquement selon les infos donnés, si un format d'image est donné, celle-ci sera attribué seulement à cette section
 *
 * @param $singularName
 * @param $plurialName
 * @param bool $male
 * @param array $newArgs
 * @param array $image : width, height, crop
 */
function newCpt( $singularName, $plurialName, $male = true, $newArgs = array())
{

    $singularName = removeAccent(strtolower($singularName));
    $plurialName = removeAccent(strtolower($plurialName));

    $prefix = 'init_cpt_';
    $cptName = slugify($plurialName);

    //cré la fonction custom
    $functionName = $prefix . $cptName;
    if(!function_exists($functionName)) {
        /**
         * Crée une fonction dynamique
         */
        $functionName = function () use ( $cptName, $singularName, $plurialName, $male, $newArgs ) {

            $firstLetter = substr($cptName, 0, 1);
            $apostrophe = array ('a', 'e', 'i', 'o', 'u', 'y', 'h');

            $singularName = removeAccent(strtolower($singularName));
            $plurialName = removeAccent(strtolower($plurialName));
            $hasApostrophe = (in_array($firstLetter, $apostrophe));

            $labels = array(
                'name'                  => _x( ucfirstUtf8($plurialName), ThemeName ),
                'singular_name'         => _x( ucfirstUtf8($singularName), ThemeName ),
                'menu_name'             => __( ucfirstUtf8($plurialName), ThemeName ),
                'name_admin_bar'        => __( ucfirstUtf8($singularName), ThemeName ),
                'archives'              => __( 'Archives '. getDeterminant('du',$male,$hasApostrophe) . $singularName, ThemeName ),
                'attributes'            => __( 'Attributs '. getDeterminant('du',$male,$hasApostrophe)  . $singularName, ThemeName ),
                'parent_item_colon'     => __( 'Parent '. getDeterminant('du',$male,$hasApostrophe) . $singularName, ThemeName ),
                'all_items'             => __( 'Tous les ' . $plurialName, 'text_domain' ),
                'add_new_item'          => __( 'Ajouter '. getDeterminant('un',$male,$hasApostrophe)  . $singularName, ThemeName ),
                'add_new'               => __( 'Ajouter '. getDeterminant('un',$male,$hasApostrophe)  . $singularName, ThemeName ),
                'new_item'              => __( ($male ? 'Nouveau ': 'Nouvelle ') . $singularName, 'text_domain' ),
                'edit_item'             => __( 'Éditer '. getDeterminant('le',$male,$hasApostrophe)  . $singularName, ThemeName ),
                'update_item'           => __( 'Mise à jour '. getDeterminant('du',$male,$hasApostrophe)  . $singularName, ThemeName ),
                'view_item'             => __( 'Voir '. getDeterminant('le',$male,$hasApostrophe)  . $singularName, ThemeName ),
                'view_items'            => __( 'Voir les ' . $plurialName, ThemeName ),
                'search_items'          => __( 'Rechercher '. getDeterminant('le',$male,$hasApostrophe)  . $singularName, ThemeName ),
                'not_found'             => __( 'Aucun trouvé', ThemeName ),
                'not_found_in_trash'    => __( 'Aucun trouvé dans la corbeille', ThemeName ),
                'featured_image'        => __( 'Image à la une', ThemeName ),
                'set_featured_image'    => __( "Définir l'image", ThemeName ),
                'remove_featured_image' => __( "Supprimer l'image à la une", ThemeName ),
                'use_featured_image'    => __( 'Utiliser comme image à la une', ThemeName ),
                'insert_into_item'      => __( 'Insérer dans ' . $singularName, ThemeName ),
                'uploaded_to_this_item' => __( 'Téléchargé sur '. getDeterminant('ce',$male,$hasApostrophe)  . $singularName, ThemeName ),
                'items_list'            => __( 'Liste des ' . $plurialName, ThemeName ),
                'items_list_navigation' => __( 'Liste des ' . $plurialName . ' pour la navigation', ThemeName ),
                'filter_items_list'     => __( 'Filtrer la liste des ' . $plurialName, ThemeName ),
            ); //end $labels



            $args = array(
                'labels'                => $labels,
                'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail'),
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'show_in_rest'          => true,
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => false,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
            );
            //end $args

            $args = array_merge($args, $newArgs);

            register_post_type( $cptName, $args );

        };//end $functionName()

        add_action('init',  $functionName);
    }//endif(!function_exists($functionName))

    return $cptName;
}//end newCpt()






/**
 * Crée un cpt automatiquement selon les infos donnés, si un format d'image est donné, celle-ci sera attribué seulement à cette section
 *
 * @param array $customPostTypes
 * @param $singularName
 * @param $plurialName
 * @param bool $male
 * @param array $newArgs
 * @param array $image : width, height, crop
 */
function newTaxonomiy( $customPostTypes, $singularName, $plurialName, $male = true, $newArgs = array())
{
    $singularName = strtolower($singularName);
    $plurialName = strtolower($plurialName);

    $prefix = 'init_taxonomy_';
    $taxonomyName = slugify($plurialName);

    //cré la fonction custom
    $functionName = $prefix . $taxonomyName;
    if(!function_exists($functionName)) {
        /**
         * Crée une fonction dynamique
         */
        $functionName = function () use ( $customPostTypes, $taxonomyName, $singularName, $plurialName, $male, $newArgs ) {

            $firstLetter = substr($taxonomyName, 0, 1);
            $apostrophe = array ('a', 'e', 'i', 'o', 'u', 'y', 'h');

            $hasApostrophe = (in_array($firstLetter, $apostrophe));

            $labels = array(
                    'name' => _x( ucfirstUtf8($plurialName), ThemeName ),
                    'singular_name' => _x( ucfirstUtf8($singularName), ThemeName ),
                    'search_items' =>  __( 'Rechercher les ' . $plurialName , ThemeName ),
                    'all_items' => __('Tous les '. $plurialName , ThemeName ),
                    'parent_item' => __( 'Parent '. getDeterminant('du',$male,$hasApostrophe) . $singularName , ThemeName ),
                    'parent_item_colon' => __( 'Parent '. getDeterminant('du',$male,$hasApostrophe) . $singularName .':' , ThemeName ),
                    'edit_item' => __( 'Éditer '. getDeterminant('le',$male,$hasApostrophe)  . $singularName , ThemeName ),
                    'update_item' => __( 'Mise à jour '. getDeterminant('du',$male,$hasApostrophe)  . $singularName , ThemeName ),
                    'add_new_item' => __( 'Ajouter '. getDeterminant('un',$male,$hasApostrophe)  . $singularName , ThemeName ),
                    'new_item_name' => __( 'Ajouter ' . ($male ? 'un nouveau' : 'une nouvelle') . $singularName , ThemeName ),
                    'menu_name' => __(ucfirstUtf8($plurialName) , ThemeName ),
                    'not_found'             => __( ($male ? 'Aucun': 'Aucune') . ' '. $plurialName .' trouvé' .($male ? 's' : 'es'), ThemeName ),


            ); //end $labels

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => $taxonomyName ),
            );

            $args = array_merge($args, $newArgs);

            register_taxonomy( $taxonomyName, $customPostTypes, $args );

        };//end $functionName()

        add_action('init',  $functionName);
    }//endif(!function_exists($functionName))

    return $taxonomyName;
}//end newTaxonomiy()






/**
 * Détermine le déterminant a utilisé
 *
 * @param $determinant
 * @param $male
 * @param bool $hasApostrophe
 * @return string
 */
function getDeterminant($determinant, $male, $hasApostrophe = false){
    $theDeterminant = '';
    switch($determinant){
        case 'du' : $theDeterminant = ($hasApostrophe ? "d'" : ($male ? 'du' : 'de la')); break;
        case 'un' : $theDeterminant = ($male ? 'un ' : 'une '); break;
        case 'le' : $theDeterminant = ($hasApostrophe ? "l'" : ($male ? 'le' : 'la')); break;
        case 'la' : $theDeterminant = ($hasApostrophe ? "l'" : ($male ? 'le' : 'la')); break;
        case 'ce' : $theDeterminant = ($male ? 'ce' : 'cette'); break;
        case 'cet': $theDeterminant = ($male ? 'cet' : 'cette'); break;
        default   : $theDeterminant = $determinant;  break;
    }
    $theDeterminant .= ($hasApostrophe ? '' :  ' ');
    return $theDeterminant;
}



add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Miniature', ThemeName);
    return $defaults;
}

function posts_custom_columns($column_name, $id){
    if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( array(100, 100) );
    }
}

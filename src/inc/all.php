<?php

//initialisation du projet
require_once 'setup.php';

//personnalisation des rôles utilisateurs
require_once 'permissions.php';

//fonctions php général
require_once 'php_functions.php';

//fonction seulement utilisé dans le projet
require_once 'project_functions.php';

//Custom Post Type
require_once 'custom-post-types.php';

//fonctions qui les navigations du site web
require_once 'navigation.php';

//Nettoyage de l'administration et des en-tête non-nécessaire
require_once 'cleanup.php';

//Optimisation de wp
require_once 'optimization.php';

//Optimisation de la sécurité de wp
require_once 'security.php';

//Sécurité au niveau du REST API de wp
require_once 'restapi.php';

//Optimisation pour le SEO
require_once 'seo.php';

//personnalisation du dashboard
require_once 'dashboard.php';

//personnalisation de guttenberg
require_once 'guttenberg.php';
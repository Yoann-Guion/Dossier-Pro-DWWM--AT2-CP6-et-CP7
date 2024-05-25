<?php

// Inclusion des dépendances via Composer
require_once '../vendor/autoload.php';

// Activation du système de SESSION de PHP
session_start();

//? --- ROUTAGE --- //

// Création de l'objet router
$router = new AltoRouter();

// Le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci, mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

//* Inclusion de la liste des routes
require_once "../app/config/routes.php";

//? --- DISPATCH --- //

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller on délégue à AltoDispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404 en cas de chemin non existant
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::error404');

// On a besoin d'avoir accès à la variable $router un peu partout dans notre code 
// On va donc l'envoyer comme paramètre lors de l'instanciation de nos contrôleurs
$dispatcher->setControllersArguments($router);

// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
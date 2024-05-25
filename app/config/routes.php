<?php

//* Route de la page d'accueil
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);

//* ROUTES UTILISATEUR
// Route pour la page de login
$router->map(
    'GET',
    '/signin',
    [
        'method' => 'signin',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-signin'
);

// Récupération des données de connexion
$router->map(
    'POST',
    '/signin',
    [
        'method' => 'signinPost',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-signinPost'
);

// Route pour la déconnexion
$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-logout'
);

// Route de la liste des utilisateurs
$router->map(
    'GET',
    '/appusers',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-list'
);

// Route du formulaire d'ajout d'un utilisateur
$router->map(
    'GET',
    '/appusers/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-add'
);

// Récupération des données du formulaire d'ajout d'utilisateurs
$router->map(
    'POST',
    '/appusers/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-addPost'
);

// Route du formulaire de modification d'un utilisateur
$router->map(
    'GET',
    '/appusers/update/[i:appUserId]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-update'
);

// Récupération des données du formulaire de modification d'un utilisateur
$router->map(
    'POST',
    '/appusers/update/[i:appUserId]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-updatePost'
);

// Route de suppression d'un utilisateur
$router->map(
    'GET',
    '/appusers/[i:appUserId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appusers-delete'
);

//* ROUTES POUR LES PROFS
// Route de la liste des profs
$router->map(
    'GET',                      // Méthode HTTP
    '/teachers',                // Le nom de la route qui sera dans l'URL
    [
        'method' => 'list',     // La méthode qui sera appelé
        'controller' => '\App\Controllers\TeacherController'        // Le controleur contenant la méthode à appeler
    ],
    'teachers-list'             // Le nom de la route (servira à générer des liens grâce à AltoRouter)
);

// Route du formulaire d'ajout de prof
$router->map(
    'GET',
    '/teachers/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teachers-add'
);

// Récupération des données du formulaire d'ajout de prof
$router->map(
    'POST',
    '/teachers/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teachers-addPost'
);

// Route du formulaire de modification d'un prof
$router->map(
    'GET',
    '/teachers/update/[i:teacherId]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teachers-update'
);

// Récupération des données du formulaire de modification d'un prof
$router->map(
    'POST',
    '/teachers/update/[i:teacherId]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teachers-updatePost'
);

// Route de suppression d'un prof
$router->map(
    'GET',
    '/teachers/[i:teacherId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teachers-delete'
);


//* ROUTES POUR ETUDIANTS
// Route de la liste des étudiants
$router->map(
    'GET',
    '/students',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\StudentController'
    ],
    'students-list'
);

// Route du formulaire d'ajout d'un étudiant
$router->map(
    'GET',
    '/students/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\StudentController'
    ],
    'students-add'
);

// Récupération des données du formulaire d'ajout d'étudiant
$router->map(
    'POST',
    '/students/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\StudentController'
    ],
    'students-addPost'
);

// Route du formulaire de modification d'un étudiant
$router->map(
    'GET',
    '/students/update/[i:studentId]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\StudentController'
    ],
    'students-update'
);

// Récupération des données du formulaire de modification d'un étudiant
$router->map(
    'POST',
    '/students/update/[i:studentId]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\StudentController'
    ],
    'students-updatePost'
);

// Route de suppression d'un étudiant
$router->map(
    'GET',
    '/students/[i:studentId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\StudentController'
    ],
    'students-delete'
);

//* ROUTES POUR LES ERREURS
// Route pour l'affichage d'une erreur 403
$router->map(
    'GET',
    '/error403',
    [
        'method' => 'error403',
        'controller' => '\App\Controllers\ErrorController'
    ],
    'error-403'
);


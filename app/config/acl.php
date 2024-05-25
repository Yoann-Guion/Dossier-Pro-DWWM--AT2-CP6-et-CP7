<?php

// On définit une liste de controle d'accès : la liste des role ayant le droit d'accéder à chaque route controllée.
// Dans notre implémentation, ne pas indiquer un nom de route dans notre liste de controle permet d'indiquer que cette route est publique (accessible par tous) - dans notre cas, la page de login

$acl = [
    // C'est un backOffice, la page d'accueil n'est accessible que par les utilisateurs connectés avec au moins le rôle user
    "main-home" => ["admin", "user"],

    // Pages liées aux utilisateurs (accessible seulement par un admin)
    "appusers-list" => ["admin"],
    "appusers-add" => ["admin"],
    "appusers-addPost" => ["admin"],
    "appusers-update" => ["admin"],
    "appusers-updatePost" => ["admin"],
    "appusers-delete" => ["admin"],

    // Pages liées aux profs (accessible seulement par un admin, sauf la liste qui l'est aussi à user)
    "teachers-list" => ["admin", "user"],
    "teachers-add" => ["admin"],
    "teachers-addPost" => ["admin"],
    "teachers-update" => ["admin"],
    "teachers-updatePost" => ["admin"],
    "teachers-delete" => ["admin"],


    // Pages liées aux étudiants (accessible par admin et user)
    "students-list" => ["admin", "user"],
    "students-add" => ["admin", "user"],
    "students-addPost" => ["admin", "user"],
    "students-update" => ["admin", "user"],
    "students-updatePost" => ["admin", "user"],
    "students-delete" => ["admin", "user"],
];
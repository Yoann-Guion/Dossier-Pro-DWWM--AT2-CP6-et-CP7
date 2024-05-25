<?php

namespace App\Controllers;

use App\Models\AppUser;

class AppUserController extends CoreController
{
    /**
     * Affichage de la page de login
     *
     * @return void
     */
    public function signin()
    {

        $this->show(
            'appusers/signin',
            [
                // On pré-remplit les champs (avec rien pour le moment)
                'email' => "",
                'password' => "",
                // On ne veut pas afficher la barre de navigation lorsque l'utilisateur n'est pas connecté
                'hideNavBar' => true,
                // Token anti-csrf (utile pour sécuriser la suppression d'un utilisateur)
                'csrfToken' => $this->generateCsrfToken()

            ]
        );
    }

    /**
     * Traitement des données une fois le formulaire de login soumis
     *
     * @return void
     */
    public function signinPost()
    {
        // Récupération des données du formulaire
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        // Validation des données
        // Définition du tableau d'erreurs
        $errors = [];

        // Si il y a une ou des erreurs, on le remplit
        if (empty($email)) {
            $errors[] = "L'adresse email doit être renseignée";
        }
        if (empty($password)) {
            $errors[] = 'Le mot de passe doit être renseigné';
        }
        if (mb_strlen($password) < 6) {
            $errors[] = 'Le mot de passe saisi doit faire au moins 6 caractères';
        }

        // Si le tableau d'erreurs est vide, on va vérifier si l'utilisateur exite
        if (empty($errors)) {

            // On  commence par récupèrer l'utilisateur correspondant à l'email
            $appUser = AppUser::findByEmail($email);

            // Si l'utilisateur a été trouvé (existe), on vient comparer les mdp
            if ($appUser) {
                if (password_verify($password, $appUser->getPassword())) {

                    // Si le mdp est correct, on enregistre les données de l'utilisateur en session 
                    $_SESSION['currentUser'] = $appUser;
                    $_SESSION['currentUserId'] = $appUser->getId();

                    // On redirige vers la page d'accueil
                    header("Location: " . $this->router->generate('main-home'));
                    exit;
                }
            }
            // Si on arrive là c'est que l'email n'a pas été trouvé ou le mdp n'est pas correct,
            $errors[] = "Utilisateur ou mot de passe incorrect";
        }

        // On renvoit la même vue avec l'affichage des messages d'erreurs
        $this->show('appusers/signin', [
            'errors' => $errors,
            'email' => $email,
            'password' => $password,
            // On ne veut pas afficher la barre de navigation lorsque l'utilisateur n'est pas connecté
            'hideNavBar' => true,
            // Token anti-csrf
            'csrfToken' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Méthode qui déconnecte l'utilisateur
     *
     * @return void
     */
    public function logout()
    {
        // On supprime de la session les information qui signifient qu'on est connecté (currentUser et currentUserId)
        unset($_SESSION["currentUser"]);
        unset($_SESSION["currentUserId"]);

        // On redirige l'utilisateur vers le formulaire de login
        header("Location: " . $this->router->generate("appusers-signin"));
    }

    /**
     * Affichage de la page avec la liste des utilisateurs
     *
     * @return void
     */
    public function list()
    {
        // Préparation des données
        $appUsersList = AppUser::findAll();

        // Affichage
        $this->show(
            'appusers/list',
            [
                'appUsersList' => $appUsersList,
                // Token anti-csrf
                'csrfToken' => $this->generateCsrfToken()
            ]
        );
    }

    /**
     * Affichage de la page d'ajout d'utilisateur
     *
     * @return void
     */
    public function add()
    {
        // On affiche la vue
        $this->show(
            // La vue form est utilisé pour l'ajout et la modification d'un utilisateur
            'appusers/form',
            [
                // Comme le template pour ajouter et modifier un utilisateur est le même, il faut envoyer à la vue un objet AppUser vide 
                // pour remplir les "values" de chaque champs (ici se sera vide, mais se ne sera pas le cas en cas d'erreur ou de modification)
                'appUser' => new AppUser(),
                // Token anti-csrf
                'csrfToken' => $this->generateCsrfToken()

            ]
        );
    }

    /**
     * Méthode s'occupant des données envoyés en POST par le formulaire d'ajout d'utilisateur
     *
     * @return void
     */
    public function addPost()
    {
        // On récupère les données + filtre sanitize pour éviter les injections JS
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Validation des données
        // On créé un tableau d'erreurs 
        $errors = [];

        // On le remplit si une ou plusieurs des conditions suivantes se vérifient
        if (empty($name)) {
            $errors[] = "Le prénom doit être renseigné";
        }
        if (mb_strlen($name) > 64) {
            $errors[] = "Le prénom renseigné est trop long";
        }
        if (empty($email)) {
            $errors[] = "L'email doit être renseigné";
        }
        if (mb_strlen($email) > 128) {
            $errors[] = "L'email renseigné est trop long";
        }
        if (empty($password)) {
            $errors[] = "Le mot de passe doit être renseigné";
        }
        if (mb_strlen($password) < 6) {
            $errors[] = "Le mot de passe doit faire plus de 6 caractères";
        }
        if ($role != "admin" && $role != "user") {
            $errors[] = "Le rôle sélectionné est incorrect";
        }
        if ($status < 0 || $status > 2) {
            $errorList[] = 'Le statut sélectionné est incorrect';
        }

        // On veut ajouter un utilisateur en BDD, on instancie un nouvel objet AppUser
        $newAppUser = new AppUser();

        // On remplit notre nouvel objet avec les valeurs récupérées du formulaire
        $newAppUser->setName($name);
        $newAppUser->setEmail($email);
        $newAppUser->setPassword($password);
        $newAppUser->setRole($role);
        $newAppUser->setStatus($status);

        // Si le tableau d'erreur est vide (donc qu'il n'y a pas d'erreur), on peut sauvegarder en base de données les infos récupérées du formulaire
        if (empty($errors)) {

            // On demande à notre objet de s'insérer en BDD
            // si l'ajout s'est bien passé, on redirige vers la liste 
            if ($newAppUser->insert()) {
                // insert() a renvoyé true, on redirige !
                header("Location:" . $this->router->generate('appusers-list'));
                exit;
            } else {
                // insert() a renvoyé false, on renvoit un message d'erreur 
                $errors[] = "Erreur lors de l'ajout d'un utilisateur !";
            }
        } else {
            // Si il y a des erreurs, on affiche à nouveau le formulaire, on le remplit avec les données déjà saisis et on affiche les erreurs
            $this->show(
                'appusers/form',
                [
                    'appUser' => $newAppUser,
                    'errors' => $errors,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken()
                ]
            );
        }
    }

    /**
     * Affichage de la page du modification d'un utilisateur
     *
     * @param int $appUserId
     * @return void
     */
    public function update($appUserId)
    {
        // On récupère les données de l'utilisateur demandé
        $appUser = AppUser::find($appUserId);

        // On appelle la vue et lui envoie les données
        $this->show(
            'appusers/form',
            [
                'appUser' => $appUser,
                'appUserId' => $appUserId,
                // Token anti-csrf
                'csrfToken' => $this->generateCsrfToken()
            ]
        );
    }

    /**
     * Méthode s'occupant des données envoyés en POST par le formulaire de modification d'utilisateur
     *
     * @param int $appUserId L'id du l'utilisater courant
     * @return void
     */
    public function updatePost($appUserId)
    {
        // On récupère les données + filtre sanitize pour éviter les injections JS
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Validation des données
        // On créé un tableau d'erreurs 
        $errors = [];

        // On le rempli si une ou plusieurs des conditions suivantes se vérifient
        if (empty($name)) {
            $errors[] = "Le prénom doit être renseigné";
        }
        if (mb_strlen($name) > 64) {
            $errors[] = "Le prénom renseigné est trop long";
        }
        if (empty($email)) {
            $errors[] = "L'email doit être renseigné";
        }
        if (mb_strlen($email) > 128) {
            $errors[] = "L'email renseigné est trop long";
        }
        if (empty($password)) {
            $errors[] = "Le mot de passe doit être renseigné";
        }
        if (mb_strlen($password) < 6) {
            $errors[] = "Le mot de passe doit faire plus de 6 caractères";
        }
        if ($role != "admin" && $role != "user") {
            $errors[] = "Le rôle sélectionné est incorrect";
        }
        if ($status < 0 || $status > 2) {
            $errorList[] = 'Le statut sélectionné est incorrect';
        }

        // On veut modifier un prof existant, on le récupère
        $appUser = AppUser::find($appUserId);

        // On remplit notre objet avec les nouvelles valeurs, récupérées du formulaire
        $appUser->setName($name);
        $appUser->setEmail($email);
        $appUser->setPassword($password);
        $appUser->setRole($role);
        $appUser->setStatus($status);

        // Si le tableau d'erreur est vide (donc qu'il n'y a pas d'erreur), on peut modifier en base de données les infos récupérées du formulaire
        if (empty($errors)) {

            // on demande à notre objet de s'insérer en BDD
            // si l'ajout s'est bien passé, on redirige vers la liste !
            if ($appUser->update()) {
                // insert() a renvoyé true, on redirige vers la liste
                header("Location:" . $this->router->generate('appusers-list'));
                exit;
            } else {
                // insert() a renvoyé false, on renvoit un message d'erreur !
                $errors[] = "Erreur lors de la modification d'un utilisateur.";
            }
        } else {
            // Si il y a des erreurs, on affiche à nouveau le formulaire et on le remplit avec les données déjà saisis et on affiche les erreurs
            $this->show(
                'appusers/form',
                [
                    'errors' => $errors,
                    'appUser' => $appUser,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken()
                ]
            );
        }
    }

    /**
     * Méthode permettant la suppression d'un utilisateur
     *
     * @param int $appUserId
     * @return void
     */
    public function delete($appUserId)
    {
        // On commence par récupérer le Model AppUser que l'on veut supprimer (grâce à son id)
        $appUser = AppUser::find($appUserId);

        // On vérifie que l'utilisateur avec cet id existe
        if (!empty($appUser)) {
            // Si c'est le cas, on peut supprimer
            $appUser->delete();

            // Puis rediriger sur la page "liste"
            header("Location:" . $this->router->generate('appusers-list'));
            exit;
        } else {
            // Si le prof n'existe pas, on récupère une liste d'utilisateurs
            $appUsersList = AppUser::findAll();

            // On affiche la page liste
            $this->show(
                'appusers/list',
                [
                    'appUsersList' => $appUsersList,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken(),
                    // Avec un message d'erreur
                    'errors' =>
                    [
                        "Impossible de supprimer un prof qui n'existe pas !"
                    ],
                ]
            );
        }
    }
}

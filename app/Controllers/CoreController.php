<?php

namespace App\Controllers;

abstract class CoreController
{
    // Une propriété pour stocker le router (et pouvoir générer des liens avec $router->generate)
    protected $router;

    // Constructeur, méthode appelée automatiquement dès que l'un des contrôleurs est instancié par AltoDispatcher
    public function __construct($router)
    {
        // On récupère le router envoyé en paramètre par AltoDispatcher et on le stocke dans la propriété privée prévue à cet effet 
        $this->router = $router;

        // A partir du router, on récupère le nom de la route qui a matchée
        $match = $router->match();
        $routeName = $match['name'];

        // --- GESTION DES ACCÈS ---//
        // On définit la liste des permissions pour les routes nécessitant une connexion utilisateur
        require __DIR__ . '/../config/acl.php';

        // Si cette route est référencée dans la liste des controles d'accès (cette route n'est pas publique)
        if (isset($acl[$routeName])) {
            // On récupère la liste des rôles qui ont accès à cette route
            $authorizedRoles = $acl[$routeName];
            // On demande à la méthode checkAuthorizations de vérifier si l'utilisateur connecté à le bon rôle pour accéder à cette page
            $this->checkAuthorizations($authorizedRoles);
        }

        // --- GESTION DES TOKENS ANTI-CRSF --- //
        // On définit la liste des routes nécessitant une vérification d'attaques CSRF (toutes les routes de récupération de données venant de formulaires)
        require __DIR__ . '/../config/csrf.php';

        // Si le nom de la route est dans le tableau des routes à protéger avec un token anti-CSRF, on appelle la fonction de contrôle de ces tokens
        if (in_array($routeName, $csrf)) {
            $this->checkCsrfToken();
        }
    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue (template)
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {

        // Le nom de la page doit être accessible dans la vue
        $viewData['currentPage'] = $viewName;

        // On définit l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';

        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On accéde aux données de $viewData grâce à extract (crée une variable pour chaque élément du tableau passé en argument)
        extract($viewData);

        // Permet de rendre accessible la génération de lien d'AltoRouter dans les vues
        $router = $this->router;

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }

    /**
     * Méthode permettant de vérifier si l'utilisateur connecté a le bon rôle
     *
     * @param array $roles 
     * @return bool
     */
    public function checkAuthorizations($roles = [])
    {
        // Si l'utilisateur est connecté
        if (!empty($_SESSION['currentUser'])) {
            // On le récupère
            $connectedUser = $_SESSION['currentUser'];

            // On récupère ensuite son rôle
            $userRole = $connectedUser->getRole();

            // Si le rôle est bien autorisé
            if (in_array($userRole, $roles)) {
                // On retourne vrai
                return true;
                
            } else {
                // Sinon le rôle n'est pas autorisé, on affiche une page 403
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/error403');
                exit;
            }
        } else {
            // Sinon l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
            header('Location: ' . $this->router->generate('appusers-signin'));
            exit;
        }
    }


    /**
     * Méthode permettant la génération d'un token aléatoire pour la protection anti-csrf
     *
     * @return string
     */
    protected function generateCsrfToken()
    {
        // Génération d'un token aléatoire
        $_SESSION['csrfToken'] = md5(getmypid() . '-skouleCSRF*' . time() . 'toto' . mt_rand(1000, 10000000));

        return $_SESSION['csrfToken'];
    }

    /**
     * Méthode permettant de vérifier si un token correspond au token en session et d'envoyer une page 403 si ce n'est pas le cas
     *
     * @param array $csrfToken
     * @return void
     */
    protected function checkCsrfToken()
    {
        // On récupère le token du formulaire en POST ou en GET
        $csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : (isset($_GET["csrfToken"]) ? $_GET["csrfToken"] : "");
        // On récupère le token en SESSION
        $csrfTokenInSession = $_SESSION["csrfToken"];

        // S'ils ne sont pas égaux ou vide
        if ($csrfToken !== $csrfTokenInSession || empty($csrfToken)) {
            // Alors on affiche une 403
            header('HTTP/1.0 403 Forbidden');
            $this->show('error/error403', ['hideNavBar' => true]);
            exit;

        } else {
            // Sinon, tout va bien, on peut supprimer le token en session
            // Ainsi, on ne pourra pas soumettre plusieurs fois le même formulaire, ni réutiliser ce token
            unset($_SESSION["csrftoken"]);
        }
    }
}

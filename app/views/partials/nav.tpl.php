
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= $router->generate('main-home'); ?>">Skoule</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === "main/home") ? "active" : "" ?>" href="<?= $router->generate('main-home'); ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === "teachers/list") ? "active" : "" ?>" href="<?= $router->generate('teachers-list'); ?>">Profs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === "students/list") ? "active" : "" ?>" href="<?= $router->generate('students-list'); ?>">Etudiants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === "appusers/list") ? "active" : "" ?> <?= ($_SESSION['currentUser']->getRole() === "user") ? "d-none" : "" ?>" href="<?= $router->generate('appusers-list'); ?>">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate('appusers-logout'); ?>">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
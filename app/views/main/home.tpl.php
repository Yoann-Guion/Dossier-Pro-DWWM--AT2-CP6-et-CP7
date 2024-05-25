    <!-- Template de la page d'accueil -->
    <p class="display-5 text-center m-5">
        Bienvenue dans le backOffice <strong>d'une école 100% en ligne formant des développeurs Web</strong>...
    </p>

    <!-- TODO n'afficher que 3 ou 5 lignes dans chaques listes -->

    <!-- Bloc pour la liste des profs -->
    <div class="row mt-5">
        <div class="col-12 col-md-6">
            <div class="card text-white mb-3">
                <div class="card-header bg-primary">Liste des professeurs</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Titre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($teachersList as $currentTeacher) : ?>
                                <tr>
                                    <th scope="row"><?= $currentTeacher->getId() ?></th>
                                    <td><?= $currentTeacher->getFirstname() ?></td>
                                    <td><?= $currentTeacher->getLastname() ?></td>
                                    <td><?= $currentTeacher->getJob() ?></td>

                                <tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="d-grid gap-2">
                        <a href="<?= $router->generate('teachers-list'); ?>" class="btn btn-success float-right">Voir plus</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloc pour la liste des étudiants -->
        <div class="col-12 col-md-6">
            <div class="card text-white mb-3">
                <div class="card-header bg-primary">Liste des étudiants</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Enseignant</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($studentsList as $currentStudent) : ?>
                                <tr>
                                    <th scope="row"><?= $currentStudent->getId() ?></th>
                                    <td><?= $currentStudent->getFirstname() ?></td>
                                    <td><?= $currentStudent->getLastname() ?></td>
                                    <td>
                                        <?php foreach ($teachersList as $currentTeacher) : ?>
                                            <?php if ($currentTeacher->getId() === $currentStudent->getTeacherId()) : ?>
                                                <?= $currentTeacher->getFirstname() . " " .  $currentTeacher->getLastname() ?>
                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    </td>
                                <tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="d-grid gap-2 g-col-4">
                        <a href="<?= $router->generate('students-list'); ?>" class="btn btn-success float-right">Voir plus</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloc pour la liste des utilisateurs -->
        <div class="col-12 <?= ($_SESSION['currentUser']->getRole() === "user") ? "d-none" : "" ?>">
            <div class="card text-white mb-3">
                <div class="card-header bg-primary">Liste des utilisateurs</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Email</th>
                                <th scope="col">Rôle</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($appUsersList as $currentAppUser) : ?>
                                <tr>
                                    <th scope="row"><?= $currentAppUser->getId() ?></th>
                                    <td><?= $currentAppUser->getName() ?></td>
                                    <td><?= $currentAppUser->getEmail() ?></td>
                                    <td><?= $currentAppUser->getRole() ?></td>
                                <tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="d-grid gap-2 g-col-4">
                        <a href="<?= $router->generate('appusers-list'); ?>" class="btn btn-success float-right">Voir plus</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
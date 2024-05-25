<div class="container my-4"> <a href="<?= $router->generate('teachers-add'); ?>" class="btn btn-success float-right <?= ($_SESSION['currentUser']->getRole() === "user") ? "d-none" : "" ?>">Ajouter</a>

<h2>Liste des Profs</h2>

<?php
        // Pour afficher les messages d'erreurs ou de succés si il y en a
        include __DIR__ . '/../partials/errors.tpl.php';
        include __DIR__ . '/../partials/success.tpl.php';
        ?>

<table class="table table-hover mt-4">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Prénom</th>
            <th scope="col">Nom</th>
            <th scope="col">Titre</th>
            <th scope="col">Statut</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($teachersList as $currentTeacher) : ?>
        <tr>
            <th scope="row"><?= $currentTeacher->getId() ?></th>
            <td><?= $currentTeacher->getFirstname() ?></td>
            <td><?= $currentTeacher->getLastname() ?></td>
            <td><?= $currentTeacher->getJob() ?></td>
            <td>
                        <?php

                        if ($currentTeacher->getStatus() == 0) {
                            echo "non renseigné";
                        } else if ($currentTeacher->getStatus() == 1) {
                            echo "✅ actif";
                        } else {
                            echo "❌ inactif";
                        }
                        ?>
                    </td>
            <td class="text-right <?= ($_SESSION['currentUser']->getRole() === "user") ? "d-none" : "" ?>">
                <a href="<?= $router->generate('teachers-update', ['teacherId' => $currentTeacher->getId()]); ?>" class="btn btn-sm btn-warning">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= $router->generate('teachers-delete', ['teacherId' => $currentTeacher->getId()]); ?>?csrfToken=<?= $csrfToken ?>">Oui, je veux supprimer</a>
                        <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach ; ?>
    </tbody>
</table>
</div>
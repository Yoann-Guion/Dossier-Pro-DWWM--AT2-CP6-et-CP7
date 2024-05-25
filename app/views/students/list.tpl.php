<div class="container my-4"> <a href="<?= $router->generate('students-add'); ?>" class="btn btn-success float-right">Ajouter</a>

    <h2>Liste des &#201;tudiants</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Enseignant</th>
                <th scope="col">Statut</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($studentsList as $currentStudent) : ?>
                <tr>
                    <th scope="row"><?= $currentStudent->getId() ?></th>
                    <td><?= $currentStudent->getFirstname() ?></td>
                    <td><?= $currentStudent->getLastname() ?></td>

                    <!-- Affichage du nom du prof -->
                    <?php foreach ($teachersList as $currentTeacher) : ?>
                        <?php if ($currentTeacher->getId() === $currentStudent->getTeacherId()) : ?>
                            <td><?= $currentTeacher->getFirstname() . " " .  $currentTeacher->getLastname() ?></td>
                        <?php endif ?>
                    <?php endforeach; ?>

                    <!-- Affichage du statut -->
                    <td>
                        <?php

                        if ($currentStudent->getStatus() == 0) {
                            echo "non renseigné";
                        } else if ($currentStudent->getStatus() == 1) {
                            echo "✅ Actif";
                        } else {
                            echo "❌ Inactif";
                        }
                        ?>
                    </td>

                    <td class="text-right">
                        <a href="<?= $router->generate('students-update', ['studentId' => $currentStudent->getId()]); ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= $router->generate('students-delete', ['studentId' => $currentStudent->getId()]); ?>?csrfToken=<?= $csrfToken ?>">Oui, je veux supprimer</a>
                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
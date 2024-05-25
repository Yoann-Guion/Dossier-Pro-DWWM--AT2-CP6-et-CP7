<div class="container my-4"> <a href="<?= $router->generate('appusers-add'); ?>" class="btn btn-success float-right">Ajouter</a>

    <h2>Liste des utilisateurs</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">E-mail</th>
                <th scope="col">Rôle</th>
                <th scope="col">Statut</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appUsersList as $currentAppUser) : ?>
                <tr>
                    <th scope="row"><?= $currentAppUser->getId() ?></th>
                    <td><?= $currentAppUser->getName() ?></td>
                    <td><?= $currentAppUser->getEmail() ?></td>
                    <td><?= $currentAppUser->getRole() ?></td>
                    <td><?php

                        if ($currentAppUser->getStatus() == 0) {
                            echo "non renseigné";
                        } else if ($currentAppUser->getStatus() == 1) {
                            echo "✅ Actif";
                        } else {
                            echo "❌ Inactif";
                        }

                        ?></td>
                    <td class="text-right">
                        <a href="<?= $router->generate('appusers-update', ['appUserId' => $currentAppUser->getId()]) ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= $router->generate('appusers-delete', ['appUserId' => $currentAppUser->getId()]); ?>?csrfToken=<?= $csrfToken ?>">Oui, je veux supprimer</a>
                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
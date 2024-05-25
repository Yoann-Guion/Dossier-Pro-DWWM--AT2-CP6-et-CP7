    <a href="<?= $router->generate('teachers-list') ?>" class="btn btn-success float-right">Retour</a>

    <h2><?= (!empty($teacherId)) ? "Mettre à jour" : "Ajouter" ?> un professeur</h2>

    <?php
        // Pour afficher les messages d'erreurs si il y en a
        include __DIR__ . '/../partials/errors.tpl.php';
        ?>

    <form action="" method="POST" class="mt-5">

        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" value="<?= $teacher->getFirstname() ?>">
        </div>

        <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" value="<?= $teacher->getLastname() ?>">
        </div>

        <div class="form-group">
            <label for="job">Titre</label>
            <input type="text" class="form-control" name="job" id="job" placeholder="" value="<?= $teacher->getJob() ?>">
        </div>

        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control">
                <option value="0"> --- Choisir un Statut --- </option>
                <option value="1" <?= ($teacher->getStatus() === 1) ? "selected" : "" ?>>Actif</option>
                <option value="2" <?= ($teacher->getStatus() === 2) ? "selected" : "" ?>>Inactif</option>
            </select>
        </div>

        <!-- Token anti-CSRF -->
        <input type="hidden" name="csrfToken" value="<?= $csrfToken ?>">

        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    
    </form>
</div>
    <a href="<?= $router->generate('students-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2><?= (!empty($studentId)) ? "Mettre à jour" : "Ajouter" ?> un étudiant</h2>

    <?php
    // Pour afficher les messages d'erreurs si il y en a
    include __DIR__ . '/../partials/errors.tpl.php';
    ?>


    <form action="" method="POST" class="mt-5">

        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="" value="<?= $student->getFirstname() ?>">
        </div>

        <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="" value="<?= $student->getLastname() ?>"">
        </div>

        <div class=" form-group">
            <label for="teacherId">Enseignant</label>
            <select name="teacherId" id="teacherId" class="form-control">
                <option value="0"> --- Choisir un Enseignant --- </option>

                <?php foreach ($teachersList as $currentTeacher) : ?>
                    <option value="<?= $currentTeacher->getId() ?>" <?= ($currentTeacher->getId() === $student->getTeacherId()) ? "selected" : "" ?>><?= $currentTeacher->getFirstname() . " " . $currentTeacher->getLastname() ?> </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control">
                <option value="0"> --- Choisir un statut --- </option>
                <option value="1" <?= ($student->getStatus() === 1) ? "selected" : "" ?>>Actif</option>
                <option value="2" <?= ($student->getStatus() === 2) ? "selected" : "" ?>>Inactif</option>
            </select>
        </div>

        <!-- Token anti-CSRF -->
        <input type="hidden" name="csrfToken" value="<?= $csrfToken ?>">


        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>

    </form>
    </div>
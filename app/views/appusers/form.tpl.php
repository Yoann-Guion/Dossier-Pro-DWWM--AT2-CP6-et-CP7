<a href="<?= $router->generate('appusers-list') ?>" class="btn btn-success float-right">Retour</a>

<h2><?= (!empty($appUserId)) ? "Mettre à jour" : "Ajouter" ?> un utilisateur</h2>

<?php
// Pour afficher les messages d'erreurs si il y en a
include __DIR__ . '/../partials/errors.tpl.php';
?>

<form action="" method="POST" class="mt-5">

    <div class="form-group">
        <label for="name">Prénom</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?= $appUser->getName() ?>">
    </div>

    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?= $appUser->getEmail() ?>">
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="text" class="form-control" name="password" id="password" placeholder="" value="">
    </div>

    <!-- todo vérifier role dans db (enum) -->
    <div class="form-group">
        <label for="role">Rôle</label>
        <select name="role" id="role" class="form-control">
            <option value="0"> --- Choisir un Rôle --- </option>
            <option value="admin" <?= ($appUser->getRole() === "admin") ? "selected" : "" ?>>Administrateur</option>
            <option value="user" <?= ($appUser->getRole() === "user") ? "selected" : "" ?>>Utilisateur</option>
        </select>
    </div>

    <div class="form-group">
        <label for="status">Statut</label>
        <select name="status" id="status" class="form-control">
            <option value="0"> --- Choisir un Statut --- </option>
            <option value="1" <?= ($appUser->getStatus() === 1) ? "selected" : "" ?>>Actif</option>
            <option value="2" <?= ($appUser->getStatus() === 2) ? "selected" : "" ?>>Inactif</option>
        </select>
    </div>

    <!-- Token anti-CSRF -->
    <input type="hidden" name="csrfToken" value="<?= $csrfToken ?>">


    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>

</form>
</div>
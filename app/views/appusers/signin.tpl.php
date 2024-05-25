<div class="container my-4">


    <div class="card card--signin">
        <div class="card-header">
            Connexion
        </div>


        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Saisissez votre adresse email" value="<?= $email ?>">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Saisissez votre mot de passe" value="<?= $password ?>">
                </div>

                <!-- Token anti-CSRF -->
                <input type="hidden" name="csrfToken" value="<?= $csrfToken ?>">


                <button type="submit" class="btn btn-primary btn-block mt-4">Se connecter</button>
            </form>

            <div class="">
                <?php
                // Pour afficher les messages d'erreurs si il y en a
                include __DIR__ . '/../partials/errors.tpl.php';
                ?>
            </div>
        </div>
    </div>
</div>
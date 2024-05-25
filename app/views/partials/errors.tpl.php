<!-- Template pour l'affichage des messages d'erreurs dans les vues -->
<div class="mt-4">
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $currentError) : ?>
                <div><?= $currentError ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
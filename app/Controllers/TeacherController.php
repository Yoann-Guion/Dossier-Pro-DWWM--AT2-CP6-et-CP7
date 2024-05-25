<?php

namespace App\Controllers;

use App\Models\Teacher;

class TeacherController extends CoreController
{
    /**
     * Affichage de la page avec la liste des profs
     *
     * @return void
     */
    public function list()
    {
        // Préparation des données : la liste des profs
        $teachersList = Teacher::findAll();

        // Affichage de la vue et envoi des données
        $this->show(
            'teachers/list',
            [
                'teachersList' => $teachersList,
                // Token anti-csrf (utile pour sécuriser la suppression d'un prof)
                'csrfToken' => $this->generateCsrfToken()
            ]
        );
    }

    /**
     * Affichage de la page d'ajout de profs
     *
     * @return void
     */
    public function add()
    {
        // On affiche la vue
        $this->show(
            // La vue form est utilisé pour l'ajout et la modification d'un prof
            'teachers/form',
            [
                // Comme le template pour ajouter et modifier un prof est le même, il faut envoyer à la vue un objet Teacher vide 
                // pour remplir les "values" de chaque champs (ici se sera vide, mais se ne sera pas le cas en cas d'erreur ou de modification)
                'teacher' => new Teacher(),
                // Token anti-csrf
                'csrfToken' => $this->generateCsrfToken()

            ]
        );
    }

    /**
     * Méthode s'occupant des données envoyés en POST par le formulaire d'ajout de prof
     *
     * @return void
     */
    public function addPost()
    {
        // On récupère les données + filtre sanitize pour éviter les injections JS
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $job = filter_input(INPUT_POST, 'job', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Validation des données
        // On créé un tableau d'erreurs 
        $errors = [];

        // On le rempli si une ou plusieurs des conditions suivantes se vérifient
        if (empty($firstname)) {
            $errors[] = "Le prénom doit être renseigné";
        }
        if (mb_strlen($firstname) > 64) {
            $errors[] = "Le prénom renseigné est trop long";
        }
        if (empty($lastname)) {
            $errors[] = "Le nom doit être renseigné";
        }
        if (mb_strlen($lastname) > 64) {
            $errors[] = "Le nom renseigné est trop long";
        }
        if (empty($job)) {
            $errors[] = "Le titre doit être renseigné";
        }
        if (mb_strlen($job) > 64) {
            $errors[] = "Le titre renseigné est trop long";
        }
        if ($status < 0 || $status > 2) {
            $errorList[] = 'Le statut sélectionné est incorrect';
        }

        // On veut ajouter un prof en BDD, on instancie un nouvel objet Teacher
        $newTeacher = new Teacher();

        // On remplit notre nouvel objet avec les valeurs récupérées du formulaire
        $newTeacher->setFirstname($firstname);
        $newTeacher->setLastname($lastname);
        $newTeacher->setJob($job);
        $newTeacher->setStatus($status);

        // Si le tableau d'erreur est vide (donc qu'il n'y a pas d'erreur), on peut sauvegarder en base de données les infos récupérées du formulaire
        if (empty($errors)) {

            // on demande à notre objet de s'insérer en BDD
            // si l'ajout s'est bien passé, on redirige vers la liste !
            if ($newTeacher->insert()) {
                // insert() a renvoyé true, on redirige !
                header("Location:" . $this->router->generate('teachers-list'));
                exit;
            } else {
                // insert() a renvoyé false, on renvoit un message d'erreur !
                $errors[] = "Erreur lors de l'ajout d'un professeur !";
            }
        } else {
            // Si il y a des erreurs, on affiche à nouveau le formulaire, on le remplit avec les données déjà saisis et on affiche les erreurs
            $this->show(
                'teachers/form',
                [
                    'teacher' => $newTeacher,
                    'errors' => $errors,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken()
                ]
            );
        }
    }

    /**
     * Affichage de la page du modification d'un prof
     *
     * @param int $teacherId L'id du prof courant
     * @return void
     */
    public function update($teacherId)
    {
        // On récupère les données du prof demandé
        $teacher = Teacher::find($teacherId);

        // On appelle la vue et lui envoi les données
        $this->show(
            'teachers/form',
            [
                'teacher' => $teacher,
                'teacherId' => $teacherId,
                // Token anti-csrf
                'csrfToken' => $this->generateCsrfToken()
            ]
        );
    }

    /**
     * Méthode s'occupant des données envoyés en POST par le formulaire de modification de prof
     *
     * @param int $teacherId L'id du prof courant
     * @return void
     */
    public function updatePost($teacherId)
    {
        // On récupère les données + filtre sanitize pour éviter les injections JS
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $job = filter_input(INPUT_POST, 'job', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Validation des données
        // On créé un tableau d'erreurs 
        $errors = [];

        // On le rempli si une ou plusieurs des conditions suivantes se vérifient
        if (empty($firstname)) {
            $errors[] = "Le prénom doit être renseigné";
        }
        if (mb_strlen($firstname) > 65) {
            $errors[] = "Le prénom renseigné est trop long";
        }
        if (empty($lastname)) {
            $errors[] = "Le nom doit être renseigné";
        }
        if (mb_strlen($lastname) > 65) {
            $errors[] = "Le nom renseigné est trop long";
        }
        if (empty($job)) {
            $errors[] = "Le titre doit être renseigné";
        }
        if (mb_strlen($job) > 65) {
            $errors[] = "Le titre renseigné est trop long";
        }
        if ($status < 0 || $status > 2) {
            $errorList[] = 'Le statut sélectionné est incorrect';
        }

        // On veut modifier un prof existant, on le récupère
        $teacher = Teacher::find($teacherId);

        // On remplit notre objet avec les nouvelles valeurs récupérées du formulaire
        $teacher->setFirstname($firstname);
        $teacher->setLastname($lastname);
        $teacher->setJob($job);
        $teacher->setStatus($status);

        // Si le tableau d'erreur est vide (donc qu'il n'y a pas d'erreur), on peut modifier en base de données les infos récupérées du formulaire
        if (empty($errors)) {

            // on demande à notre objet de s'insérer en BDD
            // si l'ajout s'est bien passé, on redirige vers la liste !
            if ($teacher->update()) {
                // insert() a renvoyé true, on redirige vers la liste
                header("Location:" . $this->router->generate('teachers-list'));
                exit;
            } else {
                // insert() a renvoyé false, on renvoit un message d'erreur !
                $errors[] = "Erreur lors de la modification d'un professeur.";
            }
        } else {
            // Si il y a des erreurs, on affiche à nouveau le formulaire et on le remplit avec les données déjà saisis et on affiche les erreurs
            $this->show(
                'teachers/form',
                [
                    'errors' => $errors,
                    'teacher' => $teacher,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken()
                ]
            );
        }
    }

    /**
     * Méthode permettant la suppression d'un prof
     *
     * @param int $teacherId L'id du prof courant
     * @return void
     */
    public function delete($teacherId)
    {
        // On commence par récupérer le Model Teacher que l'on veut supprimer (grâce à son id)
        $teacher = Teacher::find($teacherId);

        // On vérifie que le prof avec cet id existe
        if (!empty($teacher)) {
            // Si c'est le cas, on peut supprimer
            $teacher->delete();

            // Puis rediriger sur la page "liste"
            header("Location:" . $this->router->generate('teachers-list'));
            exit;
        } else {
            // Si le prof n'existe pas, on récupère une liste de profs
            $teachers = Teacher::findAll();

            // On affiche la page liste
            $this->show(
                'teachers/list',
                [
                    'teachersList' => $teachers,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken(),
                    // Avec un message d'erreur
                    'errors' =>
                    [
                        "Impossible de supprimer un prof qui n'existe pas !"
                    ],
                ]
            );
        }
    }
}

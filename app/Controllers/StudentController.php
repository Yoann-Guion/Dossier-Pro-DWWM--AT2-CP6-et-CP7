<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\Teacher;


class StudentController extends CoreController
{
    /**
     * Affichage de la page avec la liste des étudiants
     *
     * @return void
     */
    public function list()
    {
        // Préparation des données
        $studentsList = Student::findAll();
        $teachersList = Teacher::findAll();

        // On affiche la vue et lui envoie les données nécessaires
        $this->show(
            'students/list',
            [
                'studentsList' => $studentsList,
                'teachersList' => $teachersList,
                // Token anti-csrf (utile pour sécuriser la suppression d'un étudiant)
                'csrfToken' => $this->generateCsrfToken()

            ]
        );
    }

    /**
     * Affichage de la page d'ajout d'un étudiant
     *
     * @return void
     */
    public function add()
    {
        // On veut accéder aux données des profs
        $teachersList = Teacher::findAll();

        // On affiche la vue et lui envoie les données nécessaire
        $this->show(
            'students/form',
            [
                'teachersList' => $teachersList,
                // Comme le template pour ajouter et modifier un étudiant est le même, il faut envoyer à la vue un objet Student vide 
                // pour remplir les "values" de chaque champs (ici se sera vide, mais se ne sera pas le cas en cas d'erreur ou de modification)
                'student' => new Student(),
                // Token anti-csrf
                'csrfToken' => $this->generateCsrfToken()

            ]
        );
    }

    /**
     * Affichage de la page d'ajout d'étudiant en POST et récupération des données du formulaire (une fois soumis)
     *
     * @return void
     */
    public function addPost()
    {
        // On récupère les données + filtre sanitize pour éviter les injections JS
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $teacherId = filter_input(INPUT_POST, 'teacherId', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Validation des données
        // On créé un tableau d'erreurs 
        $errors = [];

        // On le remplit si une ou plusieurs des conditions suivantes se vérifient
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
        if (empty($teacherId)) {
            $errors[] = "Le nom de l'enseignant doit être renseigné";
        }
        if ($status < 0 || $status > 2) {
            $errorList[] = 'Le statut sélectionné est incorrect';
        }

        // On veut ajouter un étudiant en BDD, on instancie un nouvel objet Student
        $newStudent = new Student();

        // On remplit notre nouvel objet avec les valeurs récupérées du formulaire
        $newStudent->setFirstname($firstname);
        $newStudent->setLastname($lastname);
        $newStudent->setTeacherId($teacherId);
        $newStudent->setStatus($status);

        // Si le tableau d'erreur est vide (donc qu'il n'y a pas d'erreur), on peut sauvegarder en base de données les infos récupérées du formulaire
        if (empty($errors)) {

            // on demande à notre objet de s'insérer en BDD
            // si l'ajout s'est bien passé, on redirige vers la liste !
            if ($newStudent->insert()) {
                // insert() a renvoyé true, on redirige !
                header("Location:" . $this->router->generate('students-list'));
                exit;
            } else {
                // insert() a renvoyé false, on renvoit un message d'erreur !
                $errors[] = "Erreur lors de l'ajout d'un étudiant !";
            }
        } else {
            // Si il y a des erreurs, on affiche à nouveau le formulaire, on le rempli avec les données déjà saisis et on affiche les erreurs
            $this->show(
                'students/form',
                [
                    'student' => $newStudent,
                    'errors' => $errors,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken()
                ]
            );
        }
    }

    /**
     * Affichage de la page du modification d'un étudiant
     *
     * @param int $studentId L'id de l'étudiant courant
     * @return void
     */
    public function update($studentId)
    {
        // On récupère les données de l'étudiant demandé
        $student = Student::find($studentId);
        // On récupère aussi la liste des profs
        $teachersList = Teacher::findAll();

        // On appelle la vue et lui envoie les données
        $this->show(
            'students/form',
            [
                'student' => $student,
                'studentId' => $studentId,
                'teachersList' => $teachersList,
                // Token anti-csrf
                'csrfToken' => $this->generateCsrfToken()
            ]
        );
    }

    /**
     * Méthode s'occupant des données envoyés en POST par le formulaire de modification d'un étudiant
     *
     * @param int $studentId L'id de l'étudiant courant
     * @return void
     */
    public function updatePost($studentId)
    {
        // On récupère les données + filtre sanitize pour éviter les injections JS
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $teacherId = filter_input(INPUT_POST, 'teacherId', FILTER_VALIDATE_INT);
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
        if (empty($teacherId)) {
            $errors[] = "Le nom de l'enseignant doit être renseigné";
        }
        if ($status < 0 || $status > 2) {
            $errorList[] = 'Le statut sélectionné est incorrect';
        }

        // On veut modifier un étudiant existant, on le récupère
        $student = Student::find($studentId);

        // On remplit notre objet avec les nouvelles valeurs, récupérées du formulaire
        $student->setFirstname($firstname);
        $student->setLastname($lastname);
        $student->setTeacherId($teacherId);
        $student->setStatus($status);

        // Si le tableau d'erreur est vide (donc qu'il n'y a pas d'erreur), on peut modifier en base de données les infos récupérées du formulaire
        if (empty($errors)) {

            // on demande à notre objet de s'insérer en BDD
            // si l'ajout s'est bien passé, on redirige vers la liste !
            if ($student->update()) {
                // insert() a renvoyé true, on redirige vers la liste
                header("Location:" . $this->router->generate('students-list'));
                exit;
            } else {
                // insert() a renvoyé false, on renvoit un message d'erreur !
                $errors[] = "Erreur lors de la modification d'un étudiant.";
            }
        } else {
            // Si il y a des erreurs, on affiche à nouveau le formulaire et on le remplit avec les données déjà saisis et on affiche les erreurs
            $this->show(
                'students/form',
                [
                    'errors' => $errors,
                    'student' => $student,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken()
                ]
            );
        }
    }

    /**
     * Méthode permettant la suppression d'un étudiant
     *
     * @param int $studentId L'id de l'étudiant courant
     * @return void
     */
    public function delete($studentId)
    {
        // On commence par récupérer le Model Student que l'on veut supprimer (grâce à son id)
        $student = Student::find($studentId);

        // On vérifie que l'étudiant avec cet id existe
        if (!empty($student)) {
            // Si c'est le cas, on peut supprimer
            $student->delete();

            // Puis rediriger sur la page "liste"
            header("Location:" . $this->router->generate('students-list'));
            exit;
        } else {
            // Si l'étudiant n'existe pas, on récupère une liste d'étudiants'
            $studentsList = Student::findAll();

            // On affiche la page liste
            $this->show(
                'teachers/list',
                [
                    'studentsList' => $studentsList,
                    // Token anti-csrf
                    'csrfToken' => $this->generateCsrfToken(),
                    // Avec un message d'erreur
                    'errors' =>
                    [
                        "Impossible de supprimer un étudiant qui n'existe pas !"
                    ],
                ]
            );
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Models\Student;
use App\Models\Teacher;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de l'affichage de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // On veut afficher une liste des profs et des étudiants, on récupère donc les données
        $teachersList = Teacher::findAll();
        $studentsList = Student::findAll();
        $appUsersList = AppUser::findAll();

        // On appelle la méthode show() de l'objet courant et on lui envoi les données
        $this->show(
            'main/home',
            [
                'teachersList' => $teachersList,
                'studentsList' => $studentsList,
                'appUsersList' => $appUsersList
            ]
        );
    }
}

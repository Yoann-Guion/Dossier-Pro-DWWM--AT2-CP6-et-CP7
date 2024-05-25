# Dossier Professionnel pour titre pro DWWM

## Projet

Site de BackOffice pour la gestion d'une école fictive.

On veut un site assez simple :

- une page de login
- une page d'accueil avec l'affichage d'une liste des professeurs et des étudiants. On veut aussi la liste des utilisateurs mais seulement si notre rôle est admin
- une page professeurs pour en afficher une liste. Il faut aussi un bouton pour aller sur un formulaire de création de professeur, ainsi qu'un de modification et de suppression
- une page étudiants pour en afficher une liste. Il faut aussi un bouton pour aller sur un formulaire de création d'étudiant, ainsi qu'un de modification et de suppression
- une page utilisateurs pour en afficher une liste. Il faut aussi un bouton pour aller sur un formulaire de création d'utilisateur, ainsi qu'un de modification et de suppression
- un lien permettant de déconnecter l'utilisateur actif

Il faudra aussi implémenter un contrôle d'accès avec 2 rôles :

- Rôle `user` : accès à la liste de professeurs, liste d’étudiants ainsi qu’à l’ajout, modification et suppression d’étudiants. Il n’a pas d’accès à la liste des utilisateurs
- Rôle `admin` : accès sur tout le site

## AT2 - CP6 : Développer des composants d'accès aux données SQL et noSQL

La structure et les données de la base de données sont dans le dossier docs.

Mise en place des modèles pour l'accès aux données :

- CoreModel : modèle parent de tous les autres modèles (contient les propriétés communes à tous les modèles)
- Teacher : accès et manipulation de la table `teacher`
- Student : accès et manipulation de la table `student`
- AppUser : accès et manipulation de la table `app_user`

Dans chaque modèle il y a les methodes permettant de faire les opérations CRUD (create, read, update, delete)

## AT2 - CP7 : Développer des composants métier côté serveur

Développement des controleurs et des vues pour afficher les données récupérées de la base de données :

- CoreController: controller parent de tous les autres controleurs (contient les propriétés et méthodes communes à tous les controleurs)
- MainController: affichage de la page d'accueil
- ErrorController: affichage des erreurs 403 et 404
- TeacherController: affichage des vues 'professeurs' en envoyant les données récupérées des modèles à la bonne template de vue
- StudentController: affichage des vues 'étudiants' en envoyant les données récupérées des modèles à la bonne template de vue
- AppUserController: affichage des vues 'utilisateurs' en envoyant les données récupérées des modèles à la bonne template de vue

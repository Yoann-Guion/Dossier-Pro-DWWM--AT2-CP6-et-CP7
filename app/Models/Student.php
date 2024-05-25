<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Student extends CoreModel
{
    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $teacher_id;

    /**
     * Get the value of teacher_id
     *
     * @return  int
     */
    public function getTeacherId(): ?int
    {
        return $this->teacher_id;
    }

    /**
     * Set the value of teacher_id
     *
     * @param  int  $teacher_id
     *
     * @return  self
     */
    public function setTeacherId(int $teacher_id): self
    {
        $this->teacher_id = $teacher_id;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     *
     * @return  self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     *
     * @return  self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Méthode permettant de récupèrer un enregistrement de la table 'student' en fonction de son id
     *
     * @param int $studentId 
     * @return Student
     */

    public static function find($studentId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire la requête
        $sql = 'SELECT * FROM `student` WHERE `id` =' . $studentId;

        // exécuter la requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $student = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $student;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table `student`
     *
     * @return Student[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `student`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Student');

        return $results;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table `student`
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on écrit la requête
        $sql = "INSERT INTO `student` (`firstname`, `lastname`, `teacher_id`, `status`) 
                VALUES (:firstname, :lastname, :teacher_id, :status)
                ";

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':teacher_id', $this->teacher_id);
        $stmt->bindParam(':status', $this->status);

        // Si au moins une ligne ajoutée
        if ($stmt->execute()) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode permettant de modifier un enregistrement existant dans la table `student`
     *
     * @return bool
     */

    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // On écrit la requête
        $sql = "UPDATE `student`
                SET `firstname` = :firstname,
                    `lastname` = :lastname,
                    `status` = :status,
                    `teacher_id` = :teacher_id,
                    `updated_at` = NOW()
                WHERE `id` = :id
                ";

        // On prépare la requête
        $stmt = $pdo->prepare($sql);

        // On "bind" (associe) nos paramètres
        $stmt->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_INT);
        $stmt->bindParam(':teacher_id', $this->teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        // On exécute la requête préparée, qui renverra TRUE sur un succés, et FALSE sur un échec
        return $stmt->execute();
    }

    /**
     * Méthode permettant de supprimer un enregistrement de la table 'student'
     *
     * @return void
     */
    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // On écrit la requête
        $sql = "DELETE FROM `student`
                WHERE `id` = :id
                ";

        // On prépare la requête
        $stmt = $pdo->prepare($sql);

        // On bind nos paramètres
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        // On exécute la requête préparée, qui renverra TRUE sur un succés, et FALSE sur un échec
        return $stmt->execute();
    }
}

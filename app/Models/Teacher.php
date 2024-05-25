<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Teacher extends CoreModel
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
     * @var string
     */
    private $job;
    /**
     * @var int
     */
    private $status;

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
     * Get the value of job
     *
     * @return  string
     */
    public function getJob(): ?string
    {
        return $this->job;
    }

    /**
     * Set the value of job
     *
     * @param  string  $job
     *
     * @return  self
     */
    public function setJob(string $job): self
    {
        $this->job = $job;

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
     * Méthode permettant de récupèrer un enregistrement de la table 'teacher' en fonction de son id
     *
     * @param int $teacherId 
     * @return Teacher
     */
    public static function find($teacherId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire la requête
        $sql = 'SELECT * FROM `teacher` WHERE `id` =' . $teacherId;

        // exécuter la requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $teacher = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $teacher;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table `teacher`
     *
     * @return Teacher[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `teacher`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Teacher');

        return $results;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table `teacher`
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on écrit la requête
        $sql = "INSERT INTO `teacher` (`firstname`, `lastname`, `job`, `status`) 
                VALUES (:firstname, :lastname, :job, :status)";

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
        $stmt->bindParam(':job', $this->job, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_INT);

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
     * Méthode permettant de modifier un enregistrement existant dans la table `teacher`
     *
     * @return bool
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // On écrit la requête
        $sql = "UPDATE `teacher`
                SET `firstname` = :firstname,
                    `lastname` = :lastname,
                    `job` = :job,
                    `status` = :status,
                    `updated_at` = NOW()
                WHERE `id` = :id
                ";

        // On prépare la requête
        $stmt = $pdo->prepare($sql);

        // On "bind" (associe) nos paramètres
        $stmt->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
        $stmt->bindParam(':job', $this->job, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        // On exécute la requête préparée, qui renverra TRUE sur un succés, et FALSE sur un échec
        return $stmt->execute();
    }

    /**
     * Méthode permettant de supprimer un enregistrement de la table 'teacher'
     *
     * @return void
     */
    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // On écrit la requête
        $sql = "DELETE FROM `teacher`
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

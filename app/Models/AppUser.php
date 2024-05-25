<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{

    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $role;
    /**
     * @var int
     */
    private $status;

    /**
     * Get the value of role
     *
     * @return  string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  string  $role
     *
     * @return  self
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password with hash
     *
     * @param  string  $password
     *
     * @return  self
     */
    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

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
     * Méthode permettant de récupèrer un enregistrement de la table 'app_user' en fonction de son id
     *
     * @param int $appUserId L'id de l'utilisateur courant
     * @return AppUser
     */

    public static function find($appUserId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire la requête
        $sql = 'SELECT * FROM `app_user` WHERE `id` =' . $appUserId;

        // exécuter la requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $user = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $user;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table `app_user`
     *
     * @return AppUser[]
     */

    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');

        return $results;
    }

    /**
     * Récupère un utilisateur en fonction de son email
     *
     * @param string $userEmail
     * @return AppUser
     */
    public static function findByEmail($userEmail)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT * 
                FROM `app_user` 
                WHERE `email` = :email
                ";

        // on utilise prepare() car $email vient d'une saisie de l'utilisateur => Pas confiance !
        $stmt = $pdo->prepare($sql);
        // on exécute la requête en donnant à PDO la valeur à utiliser pour remplacer ':email'
        $stmt->execute([':email' => $userEmail]);
        // on récupère le résultat sous la forme d'un objet de la classe AppUser
        $result = $stmt->fetchObject('App\Models\AppUser');

        // on renvoie le résultat ou false en cas d'échec de la requête
        return $result;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table `app_user`
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // on écrit la requête
        $sql = "INSERT INTO `app_user` (`email`, `name`, `password`, `role`, `status`) 
                VALUES (:email, :name, :password, :role, :status)";

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
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
     * Méthode permettant de modifier un enregistrement existant dans la table `app_user`
     *
     * @return bool
     */

    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // On écrit la requête
        $sql = "UPDATE `app_user`
                SET `email` = :email,
                    `name` = :name,
                    `password` = :password,
                    `role` = :role,
                    `status` = :status,
                    `updated_at` = NOW()
                WHERE `id` = :id
                ";

        // On prépare la requête
        $stmt = $pdo->prepare($sql);

        // On "bind" (associe) nos paramètres
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        // On exécute la requête préparée, qui renverra TRUE sur un succés, et FALSE sur un échec
        return $stmt->execute();
    }

    /**
     * Méthode permettant de supprimer un enregistrement de la table 'app_user'
     *
     * @return void
     */
    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // On écrit la requête
        $sql = "DELETE FROM `app_user`
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

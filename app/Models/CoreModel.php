<?php

namespace App\Models;

// Classe mère de tous les Modèles
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les modèle
abstract class CoreModel
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    // J'utilise l'extension PHP Getters and Setters pour les générer rapidement
    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    // Comme la classe CoreModel est abstraite, on peut fixer des "règles" pour les modèles enfants, qu'ils devront obligatoirement suivrent
    abstract public static function find($id);
    abstract public static function findAll();

    abstract public function insert();
    abstract public function update();
    abstract public function delete();
}
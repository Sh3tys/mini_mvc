<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Categorie
{
    private $id;
    private $nom;

    // =====================
    // Getters / Setters
    // =====================

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère toutes les catégories
     * @return array
     */
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT * FROM categorie ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une catégorie par son ID
     * @param int $id
     * @return array|null
     */
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
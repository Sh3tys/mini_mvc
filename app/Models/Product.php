<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Product
{
    private $id;
    private $nom;
    private $description;
    private $prix;
    private $image;
    private $categorie_id;

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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getCategorieId()
    {
        return $this->categorie_id;
    }

    public function setCategorieId($categorie_id)
    {
        $this->categorie_id = $categorie_id;
    }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère tous les produits avec le nom de leur catégorie
     * @return array
     */
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $sql = "SELECT p.*, c.nom as categorie_nom 
                FROM produit p 
                LEFT JOIN categorie c ON p.categorie_id = c.id 
                ORDER BY c.id, p.id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un produit par son ID
     * @param int $id
     * @return array|null
     */
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT p.*, c.nom as categorie_nom 
                FROM produit p 
                LEFT JOIN categorie c ON p.categorie_id = c.id 
                WHERE p.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les produits par catégorie
     * @param int $categorieId
     * @return array
     */
    public static function getByCategorie($categorieId)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT p.*, c.nom as categorie_nom 
                FROM produit p 
                LEFT JOIN categorie c ON p.categorie_id = c.id 
                WHERE p.categorie_id = ? 
                ORDER BY p.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$categorieId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
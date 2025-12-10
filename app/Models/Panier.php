<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Panier
{
    /**
     * Récupère tous les articles du panier d'un utilisateur avec les détails produits
     * @param int $userId
     * @return array
     */
    public static function getByUser($userId)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT 
                    panier.id,
                    panier.user_id,
                    panier.produit_id,
                    panier.quantite,
                    panier.date_ajout,
                    produit.nom as produit_nom,
                    produit.prix as produit_prix,
                    produit.image as produit_image,
                    (produit.prix * panier.quantite) as total_ligne
                FROM panier
                INNER JOIN produit ON panier.produit_id = produit.id
                WHERE panier.user_id = ?
                ORDER BY panier.date_ajout DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un produit existe déjà dans le panier d'un utilisateur
     * @param int $userId
     * @param int $produitId
     * @return array|false
     */
    public static function findItem($userId, $produitId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM panier WHERE user_id = ? AND produit_id = ?");
        $stmt->execute([$userId, $produitId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un produit au panier
     * @param int $userId
     * @param int $produitId
     * @param int $quantite
     * @return bool
     */
    public static function add($userId, $produitId, $quantite = 1)
    {
        $pdo = Database::getPDO();
        
        // Vérifier si le produit existe déjà
        $existing = self::findItem($userId, $produitId);
        
        if ($existing) {
            // Incrémenter la quantité
            $newQuantite = $existing['quantite'] + $quantite;
            $stmt = $pdo->prepare("UPDATE panier SET quantite = ? WHERE id = ?");
            return $stmt->execute([$newQuantite, $existing['id']]);
        } else {
            // Ajouter un nouveau produit
            $stmt = $pdo->prepare("INSERT INTO panier (user_id, produit_id, quantite) VALUES (?, ?, ?)");
            return $stmt->execute([$userId, $produitId, $quantite]);
        }
    }

    /**
     * Met à jour la quantité d'un article dans le panier
     * @param int $panierId
     * @param int $quantite
     * @return bool
     */
    public static function updateQuantity($panierId, $quantite)
    {
        $pdo = Database::getPDO();
        
        // Minimum 1
        if ($quantite < 1) {
            $quantite = 1;
        }
        
        $stmt = $pdo->prepare("UPDATE panier SET quantite = ? WHERE id = ?");
        return $stmt->execute([$quantite, $panierId]);
    }

    /**
     * Supprime un article du panier
     * @param int $panierId
     * @param int $userId
     * @return bool
     */
    public static function remove($panierId, $userId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM panier WHERE id = ? AND user_id = ?");
        return $stmt->execute([$panierId, $userId]);
    }

    /**
     * Vide tout le panier d'un utilisateur
     * @param int $userId
     * @return bool
     */
    public static function clear($userId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM panier WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    /**
     * Calcule le total du panier
     * @param int $userId
     * @return float
     */
    public static function getTotal($userId)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT SUM(produit.prix * panier.quantite) as total
                FROM panier
                INNER JOIN produit ON panier.produit_id = produit.id
                WHERE panier.user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    /**
     * Compte le nombre d'articles dans le panier
     * @param int $userId
     * @return int
     */
    public static function count($userId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM panier WHERE user_id = ?");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}
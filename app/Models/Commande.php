<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Commande
{
    /**
     * Récupère toutes les commandes d'un utilisateur
     * @param int $userId
     * @return array
     */
    public static function getByUser($userId)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT 
                    commande.id,
                    commande.user_id,
                    commande.produit_id,
                    commande.quantite,
                    commande.date_achat,
                    produit.nom as produit_nom,
                    produit.prix as produit_prix,
                    produit.image as produit_image,
                    (produit.prix * commande.quantite) as total_ligne
                FROM commande
                INNER JOIN produit ON commande.produit_id = produit.id
                WHERE commande.user_id = ?
                ORDER BY commande.date_achat DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée une commande à partir d'un article du panier
     * @param int $userId
     * @param int $produitId
     * @param int $quantite
     * @return bool
     */
    public static function create($userId, $produitId, $quantite)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO commande (user_id, produit_id, quantite) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $produitId, $quantite]);
    }

    /**
     * Transfère tous les articles du panier vers les commandes
     * @param int $userId
     * @return bool
     */
    public static function createFromCart($userId)
    {
        $pdo = Database::getPDO();
        
        try {
            // Démarrer une transaction
            $pdo->beginTransaction();
            
            // Récupérer tous les articles du panier
            $panierItems = Panier::getByUser($userId);
            
            if (empty($panierItems)) {
                $pdo->rollBack();
                return false;
            }
            
            // Créer une commande pour chaque article du panier
            foreach ($panierItems as $item) {
                self::create($userId, $item['produit_id'], $item['quantite']);
            }
            
            // Vider le panier
            Panier::clear($userId);
            
            // Valider la transaction
            $pdo->commit();
            return true;
            
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollBack();
            return false;
        }
    }

    /**
     * Compte le nombre total de commandes d'un utilisateur
     * @param int $userId
     * @return int
     */
    public static function count($userId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM commande WHERE user_id = ?");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}
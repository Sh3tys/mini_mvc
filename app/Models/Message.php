<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Message
{
    private $id;
    private $user_id;
    private $message;
    private $date_envoi;

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

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getDateEnvoi()
    {
        return $this->date_envoi;
    }

    public function setDateEnvoi($date_envoi)
    {
        $this->date_envoi = $date_envoi;
    }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère tous les messages
     * @return array
     */
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $sql = "SELECT 
                    message.id,
                    message.user_id,
                    message.message,
                    message.date_envoi,
                    user.prenom,
                    user.nom,
                    user.email
                FROM message
                INNER JOIN user ON message.user_id = user.id
                ORDER BY message.date_envoi DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les messages d'un utilisateur
     * @param int $userId
     * @return array
     */
    public static function getByUser($userId)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT * FROM message WHERE user_id = ? ORDER BY date_envoi DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un message par son ID
     * @param int $id
     * @return array|null
     */
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM message WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau message
     * @param int $userId
     * @param string $message
     * @return bool
     */
    public static function create($userId, $message)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO message (user_id, message) VALUES (?, ?)");
        return $stmt->execute([$userId, $message]);
    }

    /**
     * Supprime un message
     * @param int $id
     * @return bool
     */
    public static function delete($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM message WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Compte le nombre total de messages
     * @return int
     */
    public static function count()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT COUNT(*) FROM message");
        return (int)$stmt->fetchColumn();
    }

    /**
     * Compte les messages d'un utilisateur
     * @param int $userId
     * @return int
     */
    public static function countByUser($userId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM message WHERE user_id = ?");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}
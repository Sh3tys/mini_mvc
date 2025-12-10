<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class User
{
    private $id;
    private $prenom;
    private $nom;
    private $email;
    private $password;

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

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère tous les utilisateurs
     * @return array
     */
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT id, prenom, nom, email FROM user ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son ID
     * @param int $id
     * @return array|null
     */
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT id, prenom, nom, email FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son email (avec mot de passe pour authentification)
     * @param string $email
     * @return array|null
     */
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un email existe déjà
     * @param string $email
     * @return bool
     */
    public static function emailExists($email)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crée un nouvel utilisateur avec mot de passe hashé
     * @param string $prenom
     * @param string $nom
     * @param string $email
     * @param string $password
     * @return bool
     */
    public static function create($prenom, $nom, $email, $password)
    {
        $pdo = Database::getPDO();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO user (prenom, nom, email, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$prenom, $nom, $email, $hashedPassword]);
    }

    /**
     * Vérifie les identifiants de connexion
     * @param string $email
     * @param string $password
     * @return array|false Retourne les données utilisateur si succès, false sinon
     */
    public static function authenticate($email, $password)
    {
        $user = self::findByEmail($email);
        
        if (!$user) {
            return false;
        }
        
        if (password_verify($password, $user['password'])) {
            // Ne pas retourner le mot de passe
            unset($user['password']);
            return $user;
        }
        
        return false;
    }

    /**
     * Met à jour les informations d'un utilisateur
     * @param int $id
     * @param string $prenom
     * @param string $nom
     * @param string $email
     * @return bool
     */
    public static function updateInfo($id, $prenom, $nom, $email)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE user SET prenom = ?, nom = ?, email = ? WHERE id = ?");
        return $stmt->execute([$prenom, $nom, $email, $id]);
    }

    /**
     * Met à jour le mot de passe d'un utilisateur
     * @param int $id
     * @param string $newPassword
     * @return bool
     */
    public static function updatePassword($id, $newPassword)
    {
        $pdo = Database::getPDO();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $id]);
    }

    /**
     * Supprime un utilisateur
     * @param int $id
     * @return bool
     */
    public static function deleteById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
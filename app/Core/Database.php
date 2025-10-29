<?php
// Active le mode strict pour les types
declare(strict_types=1);
// Espace de noms du noyau
namespace Mini\Core;
// Importe les classes PDO et PDOException
use PDO;
use PDOException;
// Déclare une classe finale gérant la connexion PDO
final class Database
{
    // Stocke l'instance PDO unique (singleton)
    private static ?PDO $pdo = null;

    // Retourne une instance PDO prête à l'emploi
    public static function getConnection(): PDO
    {
        // Retourne l'instance existante si déjà initialisée
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        // Charge la configuration depuis le fichier INI
        $config = parse_ini_file(dirname(__DIR__) . '/config.ini');
        // Récupère la chaîne DSN
        $dsn = $config['DSN'] ?? '';
        // Récupère l'utilisateur de la base de données
        $user = $config['USER'] ?? '';
        // Récupère le mot de passe de la base de données
        $pass = $config['PASS'] ?? '';

        try {
            // Crée la connexion PDO avec les options souhaitées
            self::$pdo = new PDO($dsn, $user, $pass, [
                // Lève des exceptions en cas d'erreur SQL
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Retourne les résultats sous forme de tableaux associatifs
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            // En cas d'échec, renvoie une erreur 500 et un message générique
            http_response_code(500);
            echo 'Erreur base de données';
            exit;
        }

        // Retourne et mémorise l'instance PDO créée
        return self::$pdo;
    }
}



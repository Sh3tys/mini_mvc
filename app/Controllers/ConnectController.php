<?php
declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;

class ConnectController extends Controller
{
    /**
     * Démarre une session si elle n'est pas déjà démarrée
     */
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function register(): void
    {
        $this->startSession();
        
        // Si déjà connecté, rediriger vers le profil
        if (isset($_SESSION['user_id'])) {
            header('Location: /logout');
            exit;
        }

        $error = '';

        // Traitement du formulaire d'inscription
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom = trim($_POST['prenom'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($prenom) || empty($nom) || empty($email) || empty($password)) {
                $error = 'Tous les champs sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email invalide.';
            } elseif (strlen($password) < 6) {
                $error = 'Le mot de passe doit contenir au moins 6 caractères.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Les mots de passe ne correspondent pas.';
            } elseif (User::emailExists($email)) {
                $error = 'Cet email est déjà utilisé.';
            } else {
                // Inscription réussie
                if (User::create($prenom, $nom, $email, $password)) {
                    // Connexion automatique après inscription
                    $user = User::findByEmail($email);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_prenom'] = $user['prenom'];
                    $_SESSION['user_nom'] = $user['nom'];
                    $_SESSION['user_email'] = $user['email'];
                    
                    header('Location: /logout');
                    exit;
                } else {
                    $error = 'Erreur lors de l\'inscription. Veuillez réessayer.';
                }
            }
        }

        $this->render('connect/register', [
            'title' => 'Inscription',
            'error' => $error,
        ]);
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function login(): void
    {
        $this->startSession();
        
        // Si déjà connecté, rediriger vers le profil
        if (isset($_SESSION['user_id'])) {
            header('Location: /logout');
            exit;
        }

        $error = '';

        // Traitement du formulaire de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validation
            if (empty($email) || empty($password)) {
                $error = 'Email et mot de passe sont obligatoires.';
            } else {
                // Tentative d'authentification
                $user = User::authenticate($email, $password);
                
                if ($user) {
                    // Connexion réussie
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_prenom'] = $user['prenom'];
                    $_SESSION['user_nom'] = $user['nom'];
                    $_SESSION['user_email'] = $user['email'];
                    
                    header('Location: /logout');
                    exit;
                } else {
                    $error = 'Email ou mot de passe incorrect.';
                }
            }
        }

        $this->render('connect/login', [
            'title' => 'Connexion',
            'error' => $error,
        ]);
    }

    /**
     * Page de profil utilisateur (accessible uniquement si connecté)
     */
    public function logout(): void
    {
        $this->startSession();
        
        // Si pas connecté, rediriger vers la page de connexion
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $success = '';
        $error = '';

        // Traitement de la mise à jour des informations
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Mise à jour du profil
            if (isset($_POST['update_profile'])) {
                $prenom = trim($_POST['prenom'] ?? '');
                $nom = trim($_POST['nom'] ?? '');
                $email = trim($_POST['email'] ?? '');

                if (empty($prenom) || empty($nom) || empty($email)) {
                    $error = 'Tous les champs sont obligatoires.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Email invalide.';
                } else {
                    // Vérifier si l'email existe déjà (sauf pour l'utilisateur actuel)
                    $existingUser = User::findByEmail($email);
                    if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
                        $error = 'Cet email est déjà utilisé par un autre compte.';
                    } else {
                        if (User::updateInfo($_SESSION['user_id'], $prenom, $nom, $email)) {
                            $_SESSION['user_prenom'] = $prenom;
                            $_SESSION['user_nom'] = $nom;
                            $_SESSION['user_email'] = $email;
                            $success = 'Informations mises à jour avec succès.';
                        } else {
                            $error = 'Erreur lors de la mise à jour.';
                        }
                    }
                }
            }

            // Mise à jour du mot de passe
            if (isset($_POST['update_password'])) {
                $newPassword = $_POST['new_password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                if (empty($newPassword) || empty($confirmPassword)) {
                    $error = 'Tous les champs sont obligatoires.';
                } elseif (strlen($newPassword) < 6) {
                    $error = 'Le mot de passe doit contenir au moins 6 caractères.';
                } elseif ($newPassword !== $confirmPassword) {
                    $error = 'Les mots de passe ne correspondent pas.';
                } else {
                    if (User::updatePassword($_SESSION['user_id'], $newPassword)) {
                        $success = 'Mot de passe modifié avec succès.';
                    } else {
                        $error = 'Erreur lors de la modification du mot de passe.';
                    }
                }
            }
        }

        // Récupérer les infos utilisateur à jour
        $user = User::findById($_SESSION['user_id']);

        $this->render('connect/logout', [
            'title' => 'Mon Profil',
            'user' => $user,
            'success' => $success,
            'error' => $error,
        ]);
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function disconnect(): void
    {
        $this->startSession();
        
        // Détruire toutes les données de session
        $_SESSION = [];
        
        // Détruire le cookie de session
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        // Détruire la session
        session_destroy();
        
        // Rediriger vers la page d'accueil
        header('Location: /');
        exit;
    }
}
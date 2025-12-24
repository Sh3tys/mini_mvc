<?php
declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Message;

class ContactController extends Controller
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
     * Vérifie si l'utilisateur est connecté
     */
    private function isConnected(): bool
    {
        $this->startSession();
        return isset($_SESSION['user_id']);
    }

    /**
     * Affiche la page de contact
     */
    public function index(): void
    {
        $this->startSession();

        // Si pas connecté, rediriger vers login
        if (!$this->isConnected()) {
            $_SESSION['login_message'] = 'Connectez-vous pour nous envoyer un message.';
            header('Location: /login');
            exit;
        }

        $error = '';

        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = trim($_POST['message'] ?? '');

            // Validation
            if (empty($message)) {
                $error = 'Le message ne peut pas être vide.';
            } elseif (strlen($message) < 10) {
                $error = 'Le message doit contenir au moins 10 caractères.';
            } elseif (strlen($message) > 1000) {
                $error = 'Le message ne peut pas dépasser 1000 caractères.';
            } else {
                // Enregistrer le message
                $userId = $_SESSION['user_id'];
                
                if (Message::create($userId, $message)) {
                    // Stocker le message de succès en session
                    $_SESSION['contact_success'] = 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.';
                    
                    // Redirection pour éviter le renvoi du formulaire
                    header('Location: /contact');
                    exit;
                } else {
                    $error = 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer.';
                }
            }
        }

        // Récupérer le message de succès depuis la session
        $success = $_SESSION['contact_success'] ?? '';
        unset($_SESSION['contact_success']);

        // Récupérer les messages de l'utilisateur (historique)
        $userMessages = Message::getByUser($_SESSION['user_id']);

        $this->render('contact/contact', [
            'title' => 'Contactez-nous',
            'success' => $success,
            'error' => $error,
            'userMessages' => $userMessages,
        ]);
    }
}
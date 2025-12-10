<?php
declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Panier;
use Mini\Models\Commande;
use Mini\Models\Product;

class CartController extends Controller
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
     * Affiche le panier
     */
    public function index(): void
    {
        $this->startSession();

        // Si pas connecté, rediriger vers login
        if (!$this->isConnected()) {
            $_SESSION['login_message'] = 'Connectez-vous pour accéder à votre panier.';
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $panierItems = Panier::getByUser($userId);
        $total = Panier::getTotal($userId);
        $success = $_SESSION['cart_success'] ?? '';
        
        // Effacer le message après affichage
        unset($_SESSION['cart_success']);

        $this->render('cart/cart', [
            'title' => 'Mon Panier',
            'panierItems' => $panierItems,
            'total' => $total,
            'success' => $success,
        ]);
    }

    /**
     * Ajoute un produit au panier
     */
    public function add(): void
    {
        $this->startSession();

        // Vérifier si connecté
        if (!$this->isConnected()) {
            $_SESSION['login_message'] = 'Connectez-vous pour effectuer des achats.';
            header('Location: /login');
            exit;
        }

        // Récupérer les données POST
        $produitId = isset($_POST['produit_id']) ? (int)$_POST['produit_id'] : 0;
        $quantite = isset($_POST['quantite']) ? (int)$_POST['quantite'] : 1;

        if ($produitId <= 0) {
            header('Location: /products');
            exit;
        }

        // Vérifier si le produit existe
        $produit = Product::findById($produitId);
        if (!$produit) {
            header('Location: /products');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Vérifier si le produit est déjà dans le panier
        $existing = Panier::findItem($userId, $produitId);

        if ($existing) {
            // Produit déjà dans le panier, incrémenter
            Panier::add($userId, $produitId, 1);
            $_SESSION['cart_message'] = 'Produit déjà dans le panier. Quantité augmentée de 1.';
        } else {
            // Nouveau produit
            Panier::add($userId, $produitId, $quantite);
            $_SESSION['cart_message'] = 'Produit ajouté au panier avec succès !';
        }

        // Rediriger vers le panier
        header('Location: /cart');
        exit;
    }

    /**
     * Met à jour la quantité d'un article
     */
    public function updateQuantity(): void
    {
        $this->startSession();

        if (!$this->isConnected()) {
            header('Location: /login');
            exit;
        }

        $panierId = isset($_POST['panier_id']) ? (int)$_POST['panier_id'] : 0;
        $quantite = isset($_POST['quantite']) ? (int)$_POST['quantite'] : 1;

        if ($panierId > 0) {
            Panier::updateQuantity($panierId, $quantite);
        }

        header('Location: /cart');
        exit;
    }

    /**
     * Supprime un article du panier
     */
    public function remove(): void
    {
        $this->startSession();

        if (!$this->isConnected()) {
            header('Location: /login');
            exit;
        }

        $panierId = isset($_POST['panier_id']) ? (int)$_POST['panier_id'] : 0;
        $userId = $_SESSION['user_id'];

        if ($panierId > 0) {
            Panier::remove($panierId, $userId);
        }

        header('Location: /cart');
        exit;
    }

    /**
     * Valide la commande (transfert panier -> commande)
     */
    public function checkout(): void
    {
        $this->startSession();

        if (!$this->isConnected()) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Vérifier que le panier n'est pas vide
        $panierItems = Panier::getByUser($userId);
        if (empty($panierItems)) {
            header('Location: /cart');
            exit;
        }

        // Transférer le panier vers les commandes
        if (Commande::createFromCart($userId)) {
            $_SESSION['order_success'] = 'Commande validée avec succès !';
        }

        // Rediriger vers l'accueil
        header('Location: /');
        exit;
    }
}
<?php
// Active le mode strict pour la vérification des types
declare(strict_types=1);

// Déclare l'espace de noms pour ce contrôleur
namespace Mini\Controllers;

// Importe la classe de base Controller du noyau
use Mini\Core\Controller;
use Mini\Models\Product;
use Mini\Models\Categorie;

// Déclare la classe finale ProductController qui hérite de Controller
final class ProductController extends Controller
{
    /**
     * Affiche la liste de tous les produits
     */
    public function index(): void
    {
        // Récupération des données via les modèles
        $produits = Product::getAll();
        $categories = Categorie::getAll();

        // Appelle le moteur de rendu avec la vue et ses paramètres
        $this->render('Produit/listProduct', params: [
            'title' => 'Nos Produits',
            'produits' => $produits,
            'categories' => $categories,
        ]);
    }

    /**
     * Affiche les détails d'un produit
     */
    public function detail(int $id): void
    {
        // Récupération du produit
        $produit = Product::findById($id);

        // Si le produit n'existe pas, rediriger vers la liste
        if (!$produit) {
            header('Location: /produits');
            exit;
        }

        // Appelle le moteur de rendu pour le détail
        $this->render('Produit/detailProduct', params: [
            'title' => 'Détail du produit', // Tu peux dynamiser ça avec le nom du produit si tu veux
            'produit' => $produit,
        ]);
    }
}
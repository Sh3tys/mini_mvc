<?php
// Active le mode strict pour la vérification des types
declare(strict_types=1);
// Déclare l'espace de noms pour ce contrôleur
namespace Mini\Controllers;
// Importe la classe de base Controller du noyau
use Mini\Core\Controller;
use Mini\Models\User;
// Déclare la classe finale HomeController qui hérite de Controller
final class HomeController extends Controller
{
    // Déclare la méthode d'action par défaut qui ne retourne rien
    public function acceuil(): void
    {
        // Appelle le moteur de rendu avec la vue et ses paramètres
        $this->render('home/acceuil', params: [
            // Définit le titre transmis à la vue
            'title' => 'SparkleLoop',
            'prenom' => 'Toto',
            'prenom2' => 'Tata',
        ]);
    }

    public function users(): void
    {
        // Appelle le moteur de rendu avec la vue et ses paramètres
        $this->render('admin/users', params: [
            // Définit le titre transmis à la vue
            'users' => $users = User::getAll(),
            'title' => 'Liste des utilisateurs',
        ]);
    }
}
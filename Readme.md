# 💎 SparkleLoop - Boutique de Bijouterie en Ligne

SparkleLoop est une plateforme e-commerce moderne spécialisée dans la vente de bijoux de qualité premium. Le site propose une expérience d'achat élégante avec gestion du panier, système de commande sécurisé et interface utilisateur soignée.

## 🚀 Technologies Utilisées

- **Backend** : PHP 8.3+ (Vanilla, Architecture MVC)
- **Base de données** : MySQL 8.0+
- **Frontend** : HTML5, CSS3, JavaScript (Vanilla)
- **Architecture** : MVC personnalisé sans framework

## 📋 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP 8.3 ou supérieur
- MySQL 8.0 ou supérieur
- Git
- Un éditeur de code (VSCode recommandé)

## 🛠️ Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/Sh3tys/mini_mvc
cd NOM_DOSSIER
```

### 2. Configuration de la base de données

#### a) Créer la base de données

Connectez-vous à MySQL et créez la base de données :

```bash
mysql -u root -p
```

```sql
CREATE DATABASE sparkleloop;
EXIT;
```

#### b) Importer la structure et les données

Importez le fichier SQL complet qui contient :

- La structure des tables
- Les données de test (catégories, produits, utilisateurs)

```bash
mysql -u root -p NOM_DOSSIER < DataBase/CreationDB.sql
```

#### c) Configuration de la connexion

Créez un fichier `./app/config.ini` (ou modifiez le fichier existant) avec vos identifiants :

```[ini]
; Description de la configuration (commentaire)
; Exemple de configuration locale
; Chaîne de connexion PDO (hôte, base, encodage)
; Nom d'utilisateur de la base de données

DB_NAME = ""

DB_HOST = "localhost"

DB_USERNAME = "root"
; Mot de passe de la base de données
DB_PASSWORD = ""

```

### 3. Lancer le serveur

À la racine du projet, lancez le serveur PHP intégré :

```bash
php -S 127.0.0.1:3005 -t public
```

### 4. Accéder au site

Ouvrez votre navigateur et accédez à :

```
http://127.0.0.1:3005
```

## 👤 Comptes de Test

Trois utilisateurs de test sont disponibles (mot de passe identique pour tous) :

| Email                   | Mot de passe  | Rôle           |
| ----------------------- | ------------- | -------------- |
| `admin@sparkleloop.com` | `password123` | Administrateur |
| `marie@example.com`     | `password123` | Client         |
| `jean@example.com`      | `password123` | Client         |

## 📁 Structure du Projet

```
sparkleloop/
├── app/
│   ├── Controllers/          # Contrôleurs MVC
│   │   ├── AboutController.php
│   │   ├── CartController.php
│   │   ├── ConnectController.php
│   │   ├── ContactController.php
│   │   ├── HomeController.php
│   │   └── ProductController.php
│   │
│   ├── Models/              # Modèles (interaction BDD)
│   │   ├── Categorie.php
│   │   ├── Commande.php
│   │   ├── Message.php
│   │   ├── Panier.php
│   │   ├── Product.php
│   │   └── User.php
│   │
│   ├── Views/               # Vues (templates HTML)
│   │   ├── about/
│   │   │   └── about.php
│   │   ├── admin/
│   │   │   └── users.php
│   │   ├── cart/
│   │   │   ├── cart.php
│   │   │   └── orders.php
│   │   ├── connect/
│   │   │   ├── login.php
│   │   │   ├── logout.php
│   │   │   └── register.php
│   │   ├── contact/
│   │   │   └── contact.php
│   │   ├── home/
│   │   │   └── accueil.php
│   │   ├── Product/
│   │   │   ├── detailProduct.php
│   │   │   └── listProduct.php
│   │   └── layout.php       # Template principal (HEADER - [CONTENT] - FOOTER)
│   │
│   └── Core/                # Noyau du framework
│       ├── Controller.php
│       ├── Database.php
│       ├── Model.php
│       └── Router.php
│
├── public/                  # Point d'entrée public
│   ├── index.php           # Routeur principal
│   ├── style/              # Fichiers CSS
│   │   ├── about/
│   │   ├── cart/
│   │   ├── connect/
│   │   ├── contact/
│   │   ├── home/
│   │   ├── Product/
│   │   └── layout.css
│   │
│   ├── js/                 # Fichiers JavaScript
│   │   ├── cart/
│   │   ├── home/
│   │   └── Product/
│   │
│   └── images/             # Images du site
│       ├── carousel/
│       ├── categories/
│       ├── logo/
│       └── products/
│
└── DataBase/               # Scripts SQL
    └── CreationDB.sql
```

## 🗄️ Structure de la Base de Données

### Tables principales

#### **user**

Gestion des utilisateurs

```sql
- id (INT, AUTO_INCREMENT)
- prenom (VARCHAR)
- nom (VARCHAR)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, hashé)
```

#### **categorie**

Catégories de bijoux

```sql
- id (INT, AUTO_INCREMENT)
- nom (VARCHAR)
```

#### **produit**

Produits (bijoux) disponibles

```sql
- id (INT, AUTO_INCREMENT)
- nom (VARCHAR)
- description (TEXT)
- prix (DECIMAL)
- image (VARCHAR)
- categorie_id (INT, FK)
```

#### **panier**

Articles en attente d'achat

```sql
- id (INT, AUTO_INCREMENT)
- user_id (INT, FK)
- produit_id (INT, FK)
- quantite (INT)
- date_ajout (TIMESTAMP)
```

#### **commande**

Commandes validées

```sql
- id (INT, AUTO_INCREMENT)
- user_id (INT, FK)
- produit_id (INT, FK)
- quantite (INT)
- date_achat (TIMESTAMP)
```

#### **message**

Messages de contact

```sql
- id (INT, AUTO_INCREMENT)
- user_id (INT, FK)
- message (TEXT)
- date_envoi (TIMESTAMP)
```

## 🎨 Fonctionnalités

### 🏠 Page d'Accueil

- Carrousel d'images avec navigation
- Grille de catégories interactive
- Avis clients
- Section "Pourquoi nous choisir"

### 📦 Gestion des Produits

- **Liste des produits** : Affichage par catégories avec filtres dynamiques
- **Détail produit** : Fiche complète avec image, description, prix
- **Ajout au panier** : Système sécurisé (connexion requise)
- **Stock** : Gestion Stock de produits (non implémentée dans cette version)

### 🛒 Panier & Commandes

- **Panier** : Gestion des quantités, suppression d'articles, calcul du total
- **Validation** : Transfert automatique panier vers commande
- **Historique** : Page dédiée avec statistiques (total dépensé, panier moyen, ...)

### 🔐 Authentification

- **Inscription** : Création de compte avec validation
- **Connexion** : Système sécurisé avec mots de passe hashés
- **Profil** : Modification des informations personnelles
- **Sécurité** : Protection CSRF, validation des données, sessions PHP

### 📬 Contact

- Formulaire de contact (accessible uniquement connecté)
- Historique des messages envoyés
- Validation côté serveur

### ℹ️ À Propos

- Présentation de l'entreprise
- Mise en avant de la qualité française
- Détails sur les matériaux utilisés
- Informations de sécurité

## 🔒 Sécurité

Le site intègre plusieurs mesures de sécurité :

- ✅ **Mots de passe hashés** : Utilisation de `password_hash()` et `password_verify()`
- ✅ **Protection XSS** : `htmlspecialchars()` sur toutes les sorties
- ✅ **Requêtes préparées** : Protection contre les injections SQL
- ✅ **Validation des données** : Contrôles côté serveur
- ✅ **Sessions sécurisées** : Gestion propre des sessions PHP
- ✅ **Vérification de connexion** : Middleware sur les routes protégées

## 🎯 Routes Disponibles

### Pages Publiques

- `GET /` - Page d'accueil
- `GET /products` - Liste des produits
- `GET /detailProduct?id={id}` - Détail d'un produit
- `GET /about` - À propos
- `GET /login` - Connexion
- `GET /register` - Inscription

### Pages Protégées (connexion requise)

- `GET /cart` - Panier
- `POST /cart/add` - Ajouter au panier
- `POST /cart/update` - Modifier quantité
- `POST /cart/remove` - Supprimer article
- `POST /cart/checkout` - Valider la commande
- `GET /orders` - Historique des commandes
- `GET /contact` - Page de contact
- `POST /contact` - Envoyer un message
- `GET /logout` - Profil utilisateur
- `POST /logout` - Modifier le profil
- `GET /disconnect` - Déconnexion

### Pages Admin (à finaliser)

- `GET /users` - Gestion des utilisateurs

## --- Thème Visuel & Responsive Design ---

## 🐛 Dépannage

### Erreur de connexion à la base de données

Vérifiez vos identifiants dans `app/config.ini`

### Page blanche

Activez l'affichage des erreurs dans `public/index.php`:

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Problème de session

Assurez-vous que le dossier sessions est accessible en écriture

### Images non affichées

Vérifiez que les chemins dans la base de données correspondent aux fichiers dans `public/images/`

## 📝 Évolutions Futures

Fonctionnalités potentielles à ajouter :

- [ ] Panel d'administration
- [ ] Gestion des stocks en temps réel
- [ ] Système de paiement
- [ ] Système de notation des produits

## 👨‍💻 Développement

### Ajouter une nouvelle page

1. **Créer le contrôleur** dans `app/Controllers/`
2. **Créer la vue** dans `app/Views/`
3. **Créer le CSS** dans `public/style/`
4. **Ajouter la route** dans `public/index.php`

### Ajouter un nouveau modèle

1. Créer la table dans MySQL
2. Créer le fichier dans `app/Models/`
3. Implémenter les méthodes CRUD nécessaires

## 📄 Licence

Ce projet est un projet éducatif réalisé dans le cadre d'un exercice école supérieur.

## 🙏 Crédits

- **Développement** : Projet étudiant - Sh3tys
- **Design** : SparkleLoop Team (fictif)
- **Framework** : MVC personnalisé

## 📧 Support

Pour toute question ou problème :

- Email : admin@sparkleloop.com (fictif)
- GitHub Issues : [Créer une issue](https://github.com/Sh3tys/mini_mvc/issues)

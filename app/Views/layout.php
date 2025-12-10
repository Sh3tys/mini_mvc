<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
$isConnected = isset($_SESSION['user_id']);
$userPrenom = $_SESSION['user_prenom'] ?? '';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Boutique' ?></title>
    <link rel="stylesheet" href="./style/layout.css">
</head>
<body>
<header class="navbar">
    <div class="logo">SparkleLoop</div>
    <nav>
        <a href="/">Accueil</a>
        <a href="/products">Produits</a>
        <a href="/about">À propos</a>
        <a href="/contact">Contact</a>
        <a href="/cart">Panier</a>
        
        <?php if ($isConnected): ?>
            <a href="/logout" class="nav-connected">
                <span class="status-indicator"></span>
                ✅Connecté
            </a>
        <?php else: ?>
            <a href="/login"> ❌Connexion</a>
        <?php endif; ?>
    </nav>
</header>
<main class="content">
    <?= $content ?>
</main>
<footer class="footer">
    <p>© <?= date('Y') ?> SparkleLoop — Tous droits réservés.</p>
    <p><a href="/legal">Mentions légales</a> | <a href="/privacy">Politique de confidentialité</a></p>
</footer>
</body>
</html>
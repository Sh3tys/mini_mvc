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

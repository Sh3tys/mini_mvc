<link rel="stylesheet" href="/style/Product/listProduct.css">

<section class="products-page">
    <div class="container">
        <h1>Nos Produits</h1>
        
        <!-- Filtres par catégorie -->
        <div class="category-filters">
            <button class="filter-btn active" data-category="all">Tous les produits</button>
            <?php foreach ($categories as $categorie): ?>
                <button class="filter-btn" data-category="<?= $categorie['id'] ?>">
                    <?= htmlspecialchars($categorie['nom']) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Grille de produits -->
        <div class="products-grid">
            <?php foreach ($produits as $produit): ?>
                <div class="product-card" data-category="<?= $produit['categorie_id'] ?>">
                    <a href="/detailProduct?id=<?= $produit['id'] ?>" class="product-link">
                        <div class="product-image">
                            <img src="<?= htmlspecialchars($produit['image']) ?>" 
                                 alt="<?= htmlspecialchars($produit['nom']) ?>">
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><?= htmlspecialchars($produit['nom']) ?></h3>
                            <p class="product-price"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>
                            <span class="product-category"><?= htmlspecialchars($produit['categorie_nom']) ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    </section>

<script src="/js/Product/filtrerProduct.js"></script>
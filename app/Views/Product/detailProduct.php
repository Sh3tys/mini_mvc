<link rel="stylesheet" href="/style/Product/detailProduct.css">

<section class="product-detail">
    <div class="container">
        <!-- Bouton retour -->
        <button class="back-button" onclick="history.back()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Retour
        </button>

        <div class="product-content">
            <!-- Image du produit -->
            <div class="product-image-container">
                <img src="<?= htmlspecialchars($produit['image']) ?>" 
                     alt="<?= htmlspecialchars($produit['nom']) ?>"
                     class="product-main-image">
            </div>

            <!-- Informations du produit -->
            <div class="product-details">
                <h1 class="product-title"><?= htmlspecialchars($produit['nom']) ?></h1>
                
                <p class="product-price"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>
                
                <div class="product-category-badge">
                    <span class="category-label">Catégorie :</span>
                    <span class="category-value"><?= htmlspecialchars($produit['categorie_nom']) ?></span>
                </div>

                <div class="product-description">
                    <h3>Description</h3>
                    <p><?= nl2br(htmlspecialchars($produit['description'])) ?></p>
                </div>
            </div>
        </div>

        <!-- Bouton Acheter (centré en dessous) -->
        <div class="buy-section">
            <button class="buy-button" onclick="alert('Fonctionnalité à venir !')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                Ajouter au panier
            </button>
        </div>
    </div>
</section>
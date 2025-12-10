<link rel="stylesheet" href="/style/cart/cart.css">

<div class="cart-container">
    <h1 class="cart-title">Mon Panier</h1>

    <?php if (isset($_SESSION['cart_message'])): ?>
        <div class="info-message">
            <?= htmlspecialchars($_SESSION['cart_message']) ?>
        </div>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success-message">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($panierItems)): ?>
        <!-- Panier vide -->
        <div class="empty-cart">
            <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <h2>Votre panier est vide</h2>
            <p>Découvrez nos magnifiques bijoux et ajoutez-les à votre panier</p>
            <a href="/products" class="btn-primary">Voir les produits</a>
        </div>
    <?php else: ?>
        <!-- Liste des produits -->
        <div class="cart-items">
            <?php foreach ($panierItems as $item): ?>
                <div class="cart-item">
                    <div class="item-image">
                        <img src="<?= htmlspecialchars($item['produit_image']) ?>" 
                             alt="<?= htmlspecialchars($item['produit_nom']) ?>">
                    </div>

                    <div class="item-name">
                        <h3><?= htmlspecialchars($item['produit_nom']) ?></h3>
                    </div>

                    <div class="item-price">
                        <p><?= number_format($item['produit_prix'], 2, ',', ' ') ?> €</p>
                        <small>Prix unitaire</small>
                    </div>

                    <div class="item-quantity">
                        <form method="POST" action="/cart/update" class="quantity-form">
                            <input type="hidden" name="panier_id" value="<?= $item['id'] ?>">
                            
                            <button type="button" class="qty-btn" onclick="decrementQty(this)">-</button>
                            
                            <input 
                                type="number" 
                                name="quantite" 
                                value="<?= $item['quantite'] ?>" 
                                min="1" 
                                class="qty-input"
                                onchange="this.form.submit()"
                            >
                            
                            <button type="button" class="qty-btn" onclick="incrementQty(this)">+</button>
                        </form>
                    </div>

                    <div class="item-total">
                        <p class="total-price"><?= number_format($item['total_ligne'], 2, ',', ' ') ?> €</p>
                        <small>Total</small>
                    </div>

                    <div class="item-actions">
                        <form method="POST" action="/cart/remove" onsubmit="return confirm('Supprimer cet article ?')">
                            <input type="hidden" name="panier_id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn-remove">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Résumé et validation -->
        <div class="cart-summary">
            <div class="summary-total">
                <span class="total-label">Total du panier :</span>
                <span class="total-amount"><?= number_format($total, 2, ',', ' ') ?> €</span>
            </div>

            <form method="POST" action="/cart/checkout" onsubmit="return confirm('Valider votre commande ?')">
                <button type="submit" class="btn-checkout">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                    Valider la commande
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<script src="/js/cart/quantity.js"></script>
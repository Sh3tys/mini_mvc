<link rel="stylesheet" href="/style/cart/orders.css">

<div class="orders-container">
    <!-- Header -->
    <div class="orders-header">
        <button class="back-button" onclick="history.back()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Retour
        </button>
        <h1>Mes Commandes</h1>
        <p>Consultez l'historique de vos achats</p>
    </div>

    <?php if (empty($ordersGrouped)): ?>
        <!-- Aucune commande -->
        <div class="empty-orders">
            <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1">
                <path d="M9 11l3 3L22 4"/>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
            </svg>
            <h2>Aucune commande pour le moment</h2>
            <p>Découvrez nos bijoux et passez votre première commande</p>
            <a href="/products" class="btn-primary">Voir les produits</a>
        </div>
    <?php else: ?>
        <!-- Statistiques -->
        <div class="order-stats">
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-content">                    
                    <span class="stat-label">Commande<?= $orderCount > 1 ? 's' : '' ?></span>
                    <span class="stat-value"><?= $orderCount ?></span>
                </div>
            </div>

            <div class="stat-card highlight">
                <div class="stat-content">
                    <span class="stat-label">Total dépensé</span>
                    <span class="stat-value"><?= number_format($totalSpent, 2, ',', ' ') ?> €</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Panier moyen</span>
                    <span class="stat-value"><?= number_format($totalSpent / $orderCount, 2, ',', ' ') ?> €</span>
                </div>
            </div>
        </div>

        <!-- Liste des commandes groupées par date -->
        <div class="orders-list">
            <?php foreach ($ordersGrouped as $dateGroup): ?>
                <div class="order-group">
                    <div class="order-group-header">
                        <div class="order-date">
                            <span>Commande du <?= date('d/m/Y à H:i', strtotime($dateGroup['date'])) ?></span>
                        </div>
                        <div class="order-total">
                            Total : <strong><?= number_format($dateGroup['total'], 2, ',', ' ') ?> €</strong>
                        </div>
                    </div>

                    <div class="order-items">
                        <?php foreach ($dateGroup['items'] as $item): ?>
                            <div class="order-item">
                                <div class="item-image">
                                    <img src="<?= htmlspecialchars($item['produit_image']) ?>" 
                                         alt="<?= htmlspecialchars($item['produit_nom']) ?>">
                                </div>

                                <div class="item-details">
                                    <h3><?= htmlspecialchars($item['produit_nom']) ?></h3>
                                    <div class="item-info">
                                        <span class="item-quantity">Quantité : <?= $item['quantite'] ?></span>
                                        <span class="item-separator">•</span>
                                        <span class="item-unit-price">Prix unitaire : <?= number_format($item['produit_prix'], 2, ',', ' ') ?> €</span>
                                    </div>
                                </div>

                                <div class="item-total">
                                    <span class="total-label">Total</span>
                                    <span class="total-price"><?= number_format($item['total_ligne'], 2, ',', ' ') ?> €</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Call to Action -->
        <div class="orders-cta">
            <h2>Envie de commander à nouveau ?</h2>
            <p>Découvrez nos nouvelles collections de bijoux</p>
            <a href="/products" class="btn-cta">Voir les produits</a>
        </div>
    <?php endif; ?>
</div>
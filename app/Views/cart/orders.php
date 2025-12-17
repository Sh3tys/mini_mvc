<link rel="stylesheet" href="/style/Product/detailProduct.css">

<div class="order-container">
    <button class="back-button" onclick="history.back()">
        <p><</p>
        Retour
    </button>

<?php
    foreach ($orders as $order):
?>
    <div class="order-card">
        <h3>Commande #<?= htmlspecialchars($order['id']) ?></h3>
        <p>Date: <?= htmlspecialchars($order['date_achat']) ?></p>
        <h4>Articles:</h4>
        <ul>
            <?php
                foreach ($produits as $item):
            ?>
                <?php if ($item['id'] != $order['produit_id']) continue; ?>
                <li>
                    <?= htmlspecialchars($item['nom']) ?> - 
                    Quantité: <?= htmlspecialchars($order['quantite']) ?> - 
                    Prix Unitaire: <?= htmlspecialchars(number_format($item['prix'], 2)) ?> €
                    <?php $totalPrix = $item['prix'] * $order['quantite']; ?>
                </li>
            <?php
                endforeach;
            ?>
        </ul>
        <p>Total: <strong><?= htmlspecialchars(number_format($totalPrix, 2)) ?> €</strong> </p>
    </div>
<?php
    endforeach;
?>
</div>
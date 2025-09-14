<?php
require_once 'db.php';
session_start();
$user = $_SESSION['user'] ?? null;
$panier = $_SESSION['panier'] ?? [];

function total_panier($panier) {
    $total = 0.0;
    foreach ($panier as $item) {
        $total += $item['prix'] * $item['qte'];
    }
    return $total;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="./css/panier.css">
  <meta charset="utf-8">
  <title>Mon panier</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
  <header>
    <h1>Panier</h1>
    <nav>
      <a href="index.php" style="color:#fff;text-decoration:none;">Boutique</a>
    </nav>
  </header>

  <div class="container">
    <?php if (empty($panier)): ?>
      <p>Votre panier est vide. <a href="index.php">Continuer les achats</a></p>
    <?php else: ?>
      <table>
        <thead><tr><th>Produit</th><th>Prix unitaire</th><th>Quantité</th><th>Sous-total</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($panier as $id => $item): ?>
            <tr>
              <td><?php echo htmlspecialchars($item['nom']); ?></td>
              <td><?php echo number_format($item['prix'], 2, ',', ' '); ?> €</td>
              <td><?php echo (int)$item['qte']; ?></td>
              <td><?php echo number_format($item['prix'] * $item['qte'], 2, ',', ' '); ?> €</td>
              <td class="actions">
                <form method="post" action="modifier_panier.php" style="display:inline-block;">
                  <input type="hidden" name="action" value="plus">
                  <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
                  <button class="btn" type="submit">+</button>
                </form>
                <form method="post" action="modifier_panier.php" style="display:inline-block;">
                  <input type="hidden" name="action" value="moins">
                  <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
                  <button class="btn" type="submit">-</button>
                </form>
                <form method="post" action="modifier_panier.php" style="display:inline-block;">
                  <input type="hidden" name="action" value="supprimer">
                  <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
                  <button class="btn" type="submit">Supprimer</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr><th colspan="3">Total</th><th colspan="2"><?php echo number_format(total_panier($panier), 2, ',', ' '); ?> €</th></tr>
        </tfoot>
      </table>
      <p style="margin-top:.5rem;">
        <form method="post" action="modifier_panier.php" style="display:inline-block;">
          <input type="hidden" name="action" value="vider">
          <button class="btn" type="submit">Vider le panier</button>
        </form>
      </p>
    <?php endif; ?>
  </div>
  
</body>
</html>

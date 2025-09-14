<?php
require_once 'db.php';
session_start();
$user = $_SESSION['user'] ?? null;


$stmt = $pdo->query('SELECT id, nom, description, prix FROM produits ORDER BY id ASC');
$products = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="./css/index.css">
  <meta charset="utf-8">
  <title>Boutique électronique</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>

  </style>
</head>
<body>
  <header>
    <h1>Boutique électronique</h1>
    <nav>
      <a href="panier.php" class="cart-link">Panier (<?php echo array_sum(array_column($_SESSION['panier'] ?? [], 'qte')) ?: 0; ?>)</a>
      <?php if ($user): ?>
        <span>Bonjour, <?php echo htmlspecialchars($user['pseudo']); ?></span>
        <a href="logout.php">Se déconnecter</a>
      <?php else: ?>
        <a href="login.php">Se connecter</a>
        <a href="register.php">S'inscrire</a>
      <?php endif; ?>
    </nav>
  </header>

  <div class="container">
    <h2>Produits disponibles</h2>
    <div class="grid">
      <?php foreach ($products as $p): ?>
        <div class="card">
          <h3><?php echo htmlspecialchars($p['nom']); ?></h3>
          <p><?php echo htmlspecialchars($p['description']); ?></p>
          <p class="price"><?php echo number_format($p['prix'], 2, ',', ' '); ?> €</p>
          <div class="actions">
            <form method="post" action="ajouter_panier.php" style="margin:0;">
              <input type="hidden" name="id" value="<?php echo (int)$p['id']; ?>">
              <label style="display:inline-block">Quantité <input type="number" name="qte" value="1" min="1" style="width:60px;"></label>
              <button type="submit" class="btn">Ajouter au panier</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>

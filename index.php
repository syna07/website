<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop Home</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <h1>Mini E-commerce Showcase</h1>
    <form method="GET" action="">
      <input id="search" name="search" type="text" placeholder="Search products…" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
      <button type="submit">Search</button>
    </form>
    <a href="cart.php">Cart 🛒</a>
  </header>

  <main id="product-list">
    <?php
    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
    $stmt = $dbh->prepare("SELECT * FROM products WHERE name LIKE ?");
    $stmt->execute([$search]);
    foreach($stmt as $product):
    ?>
      <div class="product-card" data-name="<?= htmlspecialchars($product['name']) ?>">
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p>$<?= number_format($product['price'], 2) ?></p>
        <a href="product.php?id=<?= $product['id'] ?>">View</a>
        <form method="POST" action="cart.php">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <button type="submit">Add to Cart</button>
        </form>
      </div>
    <?php endforeach; ?>
  </main>

  <script src="js/script.js"></script>
</body>
</html>

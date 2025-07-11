<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = $_GET['id'];

$stmt = $dbh->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']) ?> - Product</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <a href="index.php">← Back to Home</a>
  </header>
  <main>
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <img src="<?= htmlspecialchars($product['image']) ?>" alt="">
    <p>Price: $<?= number_format($product['price'], 2) ?></p>
    <form method="POST" action="cart.php">
      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
      <button type="submit">Add to Cart 🛒</button>
    </form>
  </main>
</body>
</html>

<?php
session_start();
include 'db.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int) $_POST['product_id'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
    header("Location: cart.php");
    exit;
}

// Prepare cart items
$cartItems = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $stmt = $dbh->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($_SESSION['cart']));
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        $quantity = $_SESSION['cart'][$product['id']];
        $subtotal = $product['price'] * $quantity;
        $cartItems[] = [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
        $total += $subtotal;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <a href="index.php">← Back to Shop</a>
    <h1>Your Shopping Cart</h1>
  </header>
  <main>
    <?php if (empty($cartItems)): ?>
      <p>Your cart is empty.</p>
    <?php else: ?>
      <ul>
        <?php foreach ($cartItems as $item): ?>
          <li>
            <strong><?= htmlspecialchars($item['product']['name']) ?></strong>
            — $<?= number_format($item['product']['price'], 2) ?> × <?= $item['quantity'] ?> = $<?= number_format($item['subtotal'], 2) ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <h3>Total: $<?= number_format($total, 2) ?></h3>
    <?php endif; ?>
  </main>
</body>
</html>

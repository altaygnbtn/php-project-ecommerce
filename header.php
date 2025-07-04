<?php
session_start();

require_once 'admin/db.php';

?>

<!DOCTYPE html>

<head>
  <title>ShopEase</title>
  <link rel="stylesheet" href="style.css">
</head>
<html>
<body>
  <header>
    <h1>🛍️ ShopEase</h1>
    <nav>
      
      <a href="store.php">Home</a>
      <?= "|" ?>
      
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="admin/add_product.php">Add Product</a>
        <?= "|" ?>
        <a href="admin/manage_products.php">Manage Products</a>
        <?= "|" ?>
     <?php endif; ?>
        
     <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
        <a href="cart.php">Cart</a>
          <?= "|" ?>
           <a href="checkout.php">Checkout</a>
          <?= "|" ?>
        <a href="order_history.php">Order History</a>
          <?= "|" ?>
        <a href="wishlist.php">Wishlist</a>
          <?= "|" ?>
    <?php endif; ?>
     
      <a href="admin/logout.php">Logout</a>
      
    </nav>
  </header>
  </body>
</html>

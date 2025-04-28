<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Add item to cart
if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];

  // Check if the product is already in the cart
  if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
  } else {
    $_SESSION['cart'][$product_id] = $quantity;
  }

  echo "Product added to cart!";
}

// Remove item from cart
if (isset($_POST['remove_from_cart'])) {
  $product_id = $_POST['product_id'];

  if (isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
    echo "Product removed from cart!";
  }
}

// Display cart
function displayCart() {
  if (empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
    return;
  }

  echo "<table border='1'>";
  echo "<tr><th>Product ID</th><th>Quantity</th><th>Action</th></tr>";

  foreach ($_SESSION['cart'] as $product_id => $quantity) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($product_id) . "</td>";
    echo "<td>" . htmlspecialchars($quantity) . "</td>";
    echo "<td>
        <form method='POST'>
          <input type='hidden' name='product_id' value='" . htmlspecialchars($product_id) . "'>
          <button type='submit' name='remove_from_cart'>Remove</button>
        </form>
        </td>";
    echo "</tr>";
  }

  echo "</table>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>
</head>
<body>
  <h1>Shopping Cart</h1>

  <h2>Add Product to Cart</h2>
  <form method="POST">
    <label for="product_id">Product ID:</label>
    <input type="text" id="product_id" name="product_id" required>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" required>
    <button type="submit" name="add_to_cart">Add to Cart</button>
  </form>

  <h2>Your Cart</h2>
  <?php displayCart(); ?>
</body>
</html>
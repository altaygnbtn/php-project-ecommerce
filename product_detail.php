<?php
session_start();
require_once 'admin/db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}
if (!isset($_GET['id'])) {
    echo "Product ID is not recognized.";
    exit;
}
?>
<?php

$product_id = $_GET['id'];
$result = $mysqli->query("SELECT * FROM products WHERE id = $product_id");


if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();
    ?>
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <img src="<?php echo 'admin/' . $product['image']; ?>" width="300"><br>
    <p><?php echo htmlspecialchars($product['description']); ?></p>
    <strong>Price: $<?php echo $product['price']; ?></strong><br>
    <strong>Stock: <?php echo $product['stock']; ?></strong><br>
    <br>
    <?php if (!isset($_SESSION['role']) == 'admin') : ?>
    <strong>Select quantity</strong>
    <form method="POST" action="cart.php?action=add&id=<?php echo $product['id']; ?>">
        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
        <input type="submit" value="Add to Cart">
    </form>
    <br>
    <a href="cart.php?action=add&id=<?php echo $product['id']; ?>">Add to Cart</a>
    <?php endif; ?>
    <br><br>
    <a href="store.php">Back to Store</a>

    
    <?php
} else {
    echo "Product not found.";
}
$mysqli->close();
?>
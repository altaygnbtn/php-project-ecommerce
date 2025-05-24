<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}
include 'admin/db.php';
include 'header.php';

if (empty($_SESSION['cart'])) { //check if cart is empty 
    echo "<h2>Your cart is empty.</h2>";
    echo "<a href='store.php'>Go to Store</a>";
    exit;
}

// order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // inserting order into database using prepared statements to prevent sql injection
    $stmt = $mysqli->prepare("INSERT INTO orders (user_id, total, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // inserting order items into database using prepared statements to prevent sql injection
    $stmt_item = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $stmt_item->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
        $stmt_item->execute();
        // Optionally update stock
        $mysqli->query("UPDATE products SET stock = stock - {$item['quantity']} WHERE id = $product_id");
    }

    // Clear cart
    unset($_SESSION['cart']);
    echo "<h2>Thank you for your purchase!</h2>";
    echo "<a href='store.php'>Continue Shopping</a>";
    $mysqli->close();
    exit;
}
?>

<h2>Checkout</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>
    <?php
    $grand_total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $line_total = $item['price'] * $item['quantity'];
        $grand_total += $line_total;
        echo "<tr>
                <td>{$item['name']}</td>
                <td>\${$item['price']}</td>
                <td>{$item['quantity']}</td>
                <td>\$" . number_format($line_total, 2) . "</td>
              </tr>";
    }
    ?>
    <tr>
        <td colspan="3"><strong>Grand Total</strong></td>
        <td><strong>$<?php echo number_format($grand_total, 2); ?></strong></td>
    </tr>
</table>
<br>
<form method="post">
    <button type="submit" name="checkout" style="padding:10px 30px; background:#4CAF50; color:white; border:none; border-radius:5px; font-size:16px;">Place Order</button>
</form>
<br>
<a href="cart.php">Back to Cart</a>
<?php $mysqli->close(); ?> 
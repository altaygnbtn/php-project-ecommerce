<?php
session_start();
require_once 'admin/db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];

    if (!$address || !$city || !$postal_code || !$country) {
        $error = "All fields are required.";
    } else {
        $user_id = $_SESSION['user_id'];
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        
        $order = $mysqli->prepare("INSERT INTO orders (user_id, total, created_at) VALUES (?, ?, NOW())");
        $order->bind_param("id", $user_id, $total);
        $order->execute();
        $order_id = $order->insert_id;

        // Insert order items
        $items = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $items->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
            $items->execute();
            $mysqli->query("UPDATE products SET stock = stock - {$item['quantity']} WHERE id = $product_id");
        }

        // Insert shipment address
        $shipment = $mysqli->prepare("INSERT INTO shipment_addresses (order_id, user_id, address, city, postal_code, country) VALUES (?, ?, ?, ?, ?, ?)");
        $shipment->bind_param("iissss", $order_id, $user_id, $address, $city, $postal_code, $country);
        $shipment->execute();

        // Clear cart
        unset($_SESSION['cart']);
        echo "<h2>Thank you for your purchase!</h2>";
        echo "<a href='store.php'>Continue Shopping</a>";
        $mysqli->close();
        exit;
    }
}
?>

<h2>Checkout</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="post">
    <h3>Shipment Address</h3>
    Address: <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br><br>
    City: <input type="text" name="city" value="<?php echo htmlspecialchars($city); ?>" required><br><br>
    Postal Code: <input type="text" name="postal_code" value="<?php echo htmlspecialchars($postal_code); ?>" required><br><br>
    Country: <input type="text" name="country" value="<?php echo htmlspecialchars($country); ?>" required><br><br>

    <h3>Order Summary</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Image</th>
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
                    <td><img src='{$item['image']}' width='50' height='50'></td>
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
    <button type="submit" name="checkout" style="padding:10px 30px; background:green; color:white; font-size:16px;" onclick="return confirm('Are you sure want to pay <?php echo "$" . $grand_total ?>')" >Make Payment</button>
</form>
<br><br>
<a href='cart.php' style='padding:12px 28px; background:#2196F3; color:#fff; font-size:17px; border:none; border-radius:6px; text-decoration:none; transition:background 0.2s;'>Back to Cart</a>

<?php $mysqli->close(); ?>
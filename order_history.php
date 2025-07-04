<?php
// filepath: /Applications/XAMPP/xamppfiles/htdocs/php-ecommerce-project/order_history.php
session_start();
require_once 'admin/db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

//fetch orders for the current user
$orders = $mysqli->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<h2>Your Order History</h2>

<?php if ($orders->num_rows > 0): ?> <!-- checking if there are any order, if so then creating table -->
    <table border="1" cellpadding="10">
        <tr>
            <th>Order ID</th> <!-- headers -->
            <th>Date</th>
            <th>Total</th>
            <th>Items</th>
        </tr>
        <?php while ($order = $orders->fetch_assoc()): ?> <!-- fetching each order from result to be displayed -->
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['created_at']; ?></td>
                <td>$<?php echo $order['total']; ?></td> 
                <td> <!-- displaying the items in the order -->
                    <ul style="margin:0; padding-left:18px;">
                    <?php
                        $order_id = $order['id'];
                        $items = $mysqli->query("SELECT oi.quantity, oi.price, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id"); //fetching items from order_items table using JOIN
                        while ($item = $items->fetch_assoc()):
                    ?>
                        <li>
                            <?php echo ($item['name']); ?> (x<?php echo $item['quantity']; ?>) - $<?php echo $item['price']; ?>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>You have no orders yet.</p>
<?php endif; ?>

<a href="store.php">Back to Store</a>
<?php $mysqli->close(); ?>
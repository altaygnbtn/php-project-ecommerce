
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'admin/db.php';
include 'header.php';
?>

<?php

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// ADD TO CART
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $product_id = (int) $_GET['id'];
    
    // if product is already in cart, increment quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        // Get product from database
        $result = $mysqli->query("SELECT * FROM products WHERE id=$product_id");
        if ($result && $result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $_SESSION['cart'][$product_id] = array(
                "name" => $product['name'],
                "price" => $product['price'],
                "image" => 'admin/' . $product['image'],
                "quantity" => 1
            );
        }
    }
    header("Location: cart.php");
    exit;
}

// REMOVE FROM CART
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $product_id = (int) $_GET['id'];
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php");
    exit;
}

// EMPTY CART
if (isset($_GET['action']) && $_GET['action'] == 'empty') {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']) && isset($_POST['update_id'], $_POST['quantity'])) {
    $update_id = (int) $_POST['update_id'];
    $new_quantity = max(1, (int) $_POST['quantity']); // ensure at least 1
    if (isset($_SESSION['cart'][$update_id])) {
        $_SESSION['cart'][$update_id]['quantity'] = $new_quantity;
    }
}

// VIEW CART
echo "<h2>Your Shopping Cart</h2>";
if (!empty($_SESSION['cart'])) {
    $total = 0;
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Image</th><th>Name</th><th>Price</th><th>Qty</th><th>Total</th><th>Action</th></tr>";

    foreach ($_SESSION['cart'] as $id => $item) {
        $line_total = $item['price'] * $item['quantity'];
        $total += $line_total;
        echo "<tr>
                <td><img src='{$item['image']}' width='50' height='50'></td>
                <td>{$item['name']}</td>
                <td>\${$item['price']}</td>
                <td>
                     <form method='post' action='cart.php'>
                        <input type='hidden' name='update_id' value='$id'>
                        <input type='number' name='quantity' value='{$item['quantity']}' min='1' style='width: 50px;'>
                        <input type='submit' name='update' value='Update'>
                     </form>
                </td>
                <td>\$" . number_format($line_total, 2) . "</td>
                <td><a href='cart.php?action=remove&id=$id'>Remove</a></td>
              </tr>";
    }
    echo "<tr><td colspan='3'>Grand Total</td><td colspan='2'>\$" . number_format($total, 2) . "</td></tr>";
    echo "</table>";
    echo "<br><a href='cart.php?action=empty'>Empty Cart</a>";
} else {
    echo "Your cart is empty.";
}

$mysqli->close();
?>

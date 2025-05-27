<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}
require_once 'admin/db.php';
require 'header.php';
?>

<?php

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); //initializing the cart for storing the products as an array
}

// adding the products to the cart from the button click "add"
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $product_id =  $_GET['id'];
    if (isset($_POST['quantity'])){
        $quantity = max(1, (int)$_POST['quantity']); // fetching quanity amount from the form, setting mininum to 1
    } else {
        $quantity = 1; // default
    }
    

    
    // if product is already in cart, increment quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        
        $result = $mysqli->query("SELECT * FROM products WHERE id=$product_id");
        if ($result && $result->num_rows > 0) {
            $product = $result->fetch_assoc(); // fetching the product details from the database
            $_SESSION['cart'][$product_id] = array( 
                "name" => $product['name'],
                "price" => $product['price'],
                "image" => 'admin/' . $product['image'],
                "quantity" => $quantity
            );
        }
    }
    header("Location: cart.php");
    exit;
}

//removing the products from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $product_id =  $_GET['id'];
    unset($_SESSION['cart'][$product_id]); //removing the product
    header("Location: cart.php");
    exit;
}

//removing all products
if (isset($_GET['action']) && $_GET['action'] == 'empty') {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']) && isset($_POST['update_id'], $_POST['quantity'])) {
    $update_id = (int) $_POST['update_id'];
    $new_quantity = max(1, (int) $_POST['quantity']); // ensure at least 1

    // Fetch current stock from database
    $result = $mysqli->query("SELECT stock FROM products WHERE id = $update_id");
    if ($result && $row = $result->fetch_assoc()) {
        $stock = (int)$row['stock'];
        if ($new_quantity > $stock) {
            $error = "Cannot update. Only $stock item(s) in stock.";
        } else {
            if (isset($_SESSION['cart'][$update_id])) {
                $_SESSION['cart'][$update_id]['quantity'] = $new_quantity;
            }
        }
    }
}

// VIEW CART
echo "<h2>Shopping Cart</h2>";
if (!empty($_SESSION['cart'])) {
    $total = 0;
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Image</th><th>Name</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr>";

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

// Improved button styles
echo "<div style='margin-top:30px; display:flex; gap:18px; flex-wrap:wrap;'>";

echo "<a href='cart.php?action=empty' style='padding:12px 28px; background:#e53935; color:#fff; font-size:17px; border:none; border-radius:6px; text-decoration:none; transition:background 0.2s;'> Empty Cart</a>";

echo "<a href='store.php' style='padding:12px 28px; background:#2196F3; color:#fff; font-size:17px; border:none; border-radius:6px; text-decoration:none; transition:background 0.2s;'> Continue Shopping</a>";

echo "<a href='checkout.php' style='padding:12px 28px; background:#43a047; color:#fff; font-size:17px; border:none; border-radius:6px; text-decoration:none; transition:background 0.2s;'>  Checkout</a>";

echo "</div>";
} else {
    echo "Your cart is empty.";
    echo '<br><br>';
    echo "<a href='store.php' style='padding:12px 28px; background:#2196F3; color:#fff; font-size:17px; border:none; border-radius:6px; text-decoration:none;'>Go back to store</a>";

}

$mysqli->close();
?>

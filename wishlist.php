
<?php
require_once 'admin/db.php';
require 'header.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $mysqli->query("SELECT p.* FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = $user_id"); //fetching products from wishlist for the user

echo '<div style="max-width:700px;margin:40px auto;">';
echo '<h2>Your Wishlist</h2>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div style="border:1px solid #ddd; margin-bottom:18px; padding:18px; border-radius:8px;">';
        echo '<h3><a href="product_detail.php?id='.$row['id'].'">'.($row['name']).'</a></h3>';
        echo '<img src="admin/'.$row['image'].'" width="120" style="border-radius:6px;"> ';
        echo '<p>'.($row['description']).'</p>';
        echo '<strong>Price: $'.$row['price'].'</strong>';
        echo '</div>';
    }
} else {
    echo '<p>Your wishlist is empty.</p>';
}
echo '<a href="store.php">Back to Store</a>';
echo '</div>';

$mysqli->close();
?>
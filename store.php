<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}
echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "!";


require_once 'admin/db.php';
require 'header.php';
?>

<?php
$record = $mysqli->query("SELECT * FROM products");

echo '<h2>Products</h2>';




?>

<?php
if (isset($_GET['success'])) {
    echo '<p style="color: green;">Product added successfully!</p>';
}
if (isset($_GET['error'])) {
    echo '<p style="color: red;">Error adding product!</p>';
}
?>

<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 20px;
    }
    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    .product-card:hover {
        transform: scale(1.05);
    }
    .product-card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
    .product-card strong {
        display: block;
        margin: 10px 0;
        font-size: 18px;
        color: #333;
    }
    .product-card a {
        text-decoration: none;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        display: inline-block;
        margin-top: 10px;
    }
    .product-card a:hover {
        background-color: #45a049;
    }
</style>

<div class="product-grid">
<?php while ($row = $record->fetch_assoc()): ?>
    <div class="product-card">
        <img src="<?php echo 'admin/' . $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <strong><?php echo htmlspecialchars($row['name']); ?></strong>
        <p>Stock:<?php echo htmlspecialchars($row['stock']); ?></p>
        <strong>$<?php echo $row['price']; ?></strong>
        <a href="product_detail.php?id=<?php echo $row['id']; ?>" style="background:#2196F3; color:white; padding:10px 20px; border-radius:5px; text-decoration:none; margin-right:10px;">View</a>
        <a href="cart.php?action=add&id=<?php echo $row['id']; ?>">Add to Cart</a>
    </div>
<?php endwhile; ?>
</div>

<?php $mysqli->close(); ?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: admin/login.php");
    exit;
}
echo "Welcome, " . ($_SESSION['username']) . "!";


require_once 'admin/db.php';
require 'header.php';
?>

<?php
$record = $mysqli->query("SELECT * FROM products");

echo '<h2>Products</h2>';


?>

<form method="get" action="store.php" class="search-bar">
    <input type="text" name="search" placeholder="Search for products..." value="<?php echo isset($_GET['search']) ? ($_GET['search']) : ''; ?>" class="search-input"> <!-- getting the search value from url -->
    <button type="submit" class="search-btn">Search</button>
</form>

<?php
$search = '';  
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $search = $_GET['search']; //
    $record = $mysqli->query("SELECT * FROM products WHERE name LIKE '%$search%'"); //searching the products by name

} else {
    $record = $mysqli->query("SELECT * FROM products");
}
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

    .search-bar{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 30px 0 20px 0;
        gap: 10px;
    }

    .search-input {
        padding: 12px 18px;
        font-size: 12px;
        border: 1px solid #bbb;
        border-radius: 6px;
        width: 200px;
        transition: border-color 0.2s;

    }
    .search-input:focus {
    border-color: #2196F3;
    outline: none;
    }
    .search-btn {
        padding: 12px 18px;
        font-size: 12px;
        background-color: #2196F3;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
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
    
</style>

<div class="product-grid">
<?php while ($row = $record->fetch_assoc()): ?>
    <div class="product-card">
        <img src="<?php echo 'admin/' . $row['image']; ?>" alt="<?php echo ($row['name']); ?>">
        <strong><?php echo ($row['name']); ?></strong>
        <p>Stock:<?php echo ($row['stock']); ?></p>
        <strong>$<?php echo $row['price']; ?></strong>
        <a href="product_detail.php?id=<?php echo $row['id']; ?>" style="background:#2196F3; color:white; padding:10px 20px; border-radius:5px; text-decoration:none; margin-right:10px;">View</a>
        <?php if (($_SESSION['role']) !== 'admin'): ?><a href="cart.php?action=add&id=<?php echo $row['id']; ?>">Add to Cart</a> <?php endif; ?>
    </div>
<?php endwhile; ?>
</div>

<?php $mysqli->close(); ?>
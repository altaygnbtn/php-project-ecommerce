<?php
require_once 'admin/db.php';
require 'header.php';
?>

<?php
$product_id = $_GET['id'];
$result = $mysqli->query("SELECT * FROM products WHERE id = $product_id");

if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();
    ?>
    <div style="max-width: 500px; margin: 40px auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 2px 8px #eee; padding: 30px; background: #fafbfc;">
        <h2 style="text-align:center; color:#2196F3;"><?php echo htmlspecialchars($product['name']); ?></h2>
        <div style="text-align:center;">
            <img src="<?php echo 'admin/' . $product['image']; ?>" width="300" style="border-radius:8px; box-shadow:0 1px 4px #ccc;">
        </div>
        <p style="margin-top:20px;"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <div style="margin: 18px 0;">
            <strong style="font-size:18px;">Price: <span style="color:#388e3c;">$<?php echo $product['price']; ?></span></strong><br>
            <strong>Stock: <?php echo $product['stock']; ?></strong>
        </div>
        <br>
        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') : ?>
            <strong>Select quantity</strong>
            <form method="POST" action="cart.php?action=add&id=<?php echo $product['id']; ?>" style="margin:10px 0;">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" style="width:60px; padding:5px;">
                <input type="submit" value="Add to Cart" style="padding:8px 18px; background:#2196F3; color:white; border:none; border-radius:5px; cursor:pointer;">
            </form>
            <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" style="color:#2196F3; text-decoration:underline;">Quick Add to Cart</a>
            <br>
        <?php endif; ?>
        <br>
        <a href="store.php" style="display:inline-block; margin-top:10px; color:#555; text-decoration:none;">&larr; Back to Store</a>
    </div>
    <?php
} else {
    echo "<div style='text-align:center; margin-top:40px; color:#c00;'>Product not found.</div>";
}
$mysqli->close();
?>
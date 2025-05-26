<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /store.php");
    exit;
}
require_once 'db.php';

//deleting a product
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $mysqli->query("DELETE FROM products WHERE id = $id");
    header("Location: manage_products.php"); //render itself
    exit;
}


$result = $mysqli->query("SELECT * FROM products");

?>

<h2>Manage Products</h2>
<a href="add_product.php">Add New Product</a>
<table border="1" cellpadding="10"> 
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?> <!-- repeating the rows based on the data fetched !-->
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td>$<?= $row['price'] ?></td>
        <td><?= $row['stock'] ?></td>
        <td>
            <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="manage_products.php?action=delete&id=<?= $row['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<br>
<br>
<a href="/store.php">Back to Store</a>
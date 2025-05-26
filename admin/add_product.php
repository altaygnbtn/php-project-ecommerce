<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


?>

<h2>Add New Product</h2>
<form action="save_product.php" method="post" enctype="multipart/form-data">
    Product Name: <input type="text" name="name"><br><br>
    Description: <textarea name="description"></textarea><br><br>
    Price: <input type="text" name="price"><br><br>
    Stock: <input type="number" name="stock"><br><br>
    Image: <input type="file" name="image" accept="image/*"><br><br> <!-- accept attribute prevents other file types being uploaded -->
    <input type="submit" value="Add Product">
</form>

<a href="/store.php">Back to Store</a>
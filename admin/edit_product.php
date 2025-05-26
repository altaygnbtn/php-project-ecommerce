<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /store.php");
    exit;
}
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo "product not found.";
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if (isset($_FILES['image'])){
      $imageName = basename($_FILES["image"]["name"]); // image.jpg
      $dir = "uploads/"; // images uploaded to uploads/ directory 
      $file = $dir . $imageName; // uploads/image.jpg
      move_uploaded_file($_FILES["image"]["tmp_name"], $file);

      $mysqli->query("UPDATE products SET name='$name', description='$description', price='$price', stock='$stock', image='$file' WHERE id=$id");
      header("Location: manage_products.php");
    } else {
        $mysqli->query("UPDATE products SET name='$name', description='$description', price='$price', stock='$stock' WHERE id=$id"); //upload without changing the image
        header("Location: manage_products.php");
      }
 
}

$result = $mysqli->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();
?>


<h2>Edit Product</h2>
<form method="post" enctype="multipart/form-data">
    Name: <input type="text" name="name" value="<?php echo ($product['name']) ?>"><br><br>
    Description: <textarea name="description"><?php echo ($product['description']) ?></textarea><br><br>
    Price: <input type="text" name="price" value="<?php echo $product['price'] ?>"><br><br>
    Stock: <input type="number" name="stock" value="<?php echo $product['stock'] ?>"><br><br>
    Current Image: <br> <img src="<?php echo $product['image']; ?>" width="100"><br>
    Upload a New Image <input type="file" name="image" accept="image/*"><br><br> 
    <input type="submit" value="Update Product">
</form>

<a href="manage_products.php">Back to Manage Products</a>
<br>
<a href="/store.php">Back to Store</a>
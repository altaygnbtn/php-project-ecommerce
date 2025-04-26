<h2>Add New Product</h2>
<form action="save_product.php" method="post" enctype="multipart/form-data">
    Product Name: <input type="text" name="name"><br><br>
    Description: <textarea name="description"></textarea><br><br>
    Price: <input type="text" name="price"><br><br>
    Image: <input type="file" name="image" accept="image/*"><br><br>
    <input type="submit" value="Add Product">
</form>
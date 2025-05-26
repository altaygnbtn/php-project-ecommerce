<?php
require_once 'db.php'; 
?>
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price']; 
    $stock = $_POST['stock'];

    
    $target_dir = "uploads/"; //specifying the directory for the images uploaded via the form
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); //creating the director with permissions
    }
    $image_name = basename($_FILES["image"]["name"]); //stores the original filename from the client
    $target_file = $target_dir . $image_name; //uploads/filename.jpg

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { //move the temporary stored file to the specified location

        $stmt = $mysqli->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)"); //prepared statements
        $stmt->bind_param("ssdis", $name, $desc, $price, $stock, $target_file); //string, string, double, integer, string
        $stmt->execute();

        header("Location: /store.php" ."?success=1"); //redirecting the user with the success message 

        exit();

        

    } else {
        echo "Failed to upload image.";
    }
}
?>

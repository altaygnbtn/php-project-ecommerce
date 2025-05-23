<?php
include 'db.php'; 
?>
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price']; 

    
    $target_dir = "uploads/"; 
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $image_name = basename($_FILES["image"]["name"]); //stores the original filename from the client
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { //move the temporary stored file to the specified location

        $stmt = $mysqli->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $desc, $price, $target_file);
        $stmt->execute();

        header("Location: /store.php" ."?success=1");

        exit();

        

    } else {
        echo "Failed to upload image.";
    }
}
?>

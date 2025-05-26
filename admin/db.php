<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$mysqli = new mysqli('localhost', 'root', '', 'ecommerce', 3306);

 if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// $alter = $mysqli->query("ALTER TABLE products MODIFY stock INT UNSIGNED NOT NULL DEFAULT 0");
// if (!$alter) {
//     die("Error altering table: " . $mysqli->error);
// }

// $alter = $mysqli->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('admin', 'user') DEFAULT 'user'");

// $order = $mysqli->query("CREATE TABLE IF NOT EXISTS orders (
//   id INT AUTO_INCREMENT PRIMARY KEY,
//   user_id INT NOT NULL,
//   total DECIMAL(10,2) NOT NULL,
//   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//   FOREIGN KEY (user_id) REFERENCES users(id)
// )");

// $order_items = $mysqli->query("CREATE TABLE IF NOT EXISTS order_items (
//   id INT AUTO_INCREMENT PRIMARY KEY,
//   order_id INT NOT NULL,
//   product_id INT NOT NULL,
//   quantity INT NOT NULL,
//   price DECIMAL(10,2) NOT NULL,
//   FOREIGN KEY (order_id) REFERENCES orders(id),
//   FOREIGN KEY (product_id) REFERENCES products(id)
// )");




// $query = $mysqli->query("CREATE TABLE IF NOT EXISTS cart(
//   id INT AUTO_INCREMENT PRIMARY KEY,
//   user_id INT NOT NULL,
//   product_id INT NOT NULL,
//   quantity INT DEFAULT 1,
//   added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//   FOREIGN KEY (user_id) REFERENCES users(id),
//   FOREIGN KEY (product_id) REFERENCES products(id)
//   )");

// if ($query) {
//     echo 'Created table cart successfully!';
// } else {
//     echo 'Error occurred on creating table cart';
// }


  // $mysqli->query("USE ecommerce");

  // $table = $mysqli->query("CREATE TABLE IF NOT EXISTS products (
  //                           id INT AUTO_INCREMENT PRIMARY KEY,
  //                           name VARCHAR(200) NOT NULL,
  //                           description TEXT,
  //                           price DECIMAL(10,2),
  //                           image VARCHAR(255)
  //                           )");
                            
//   $users = $mysqli->query("CREATE TABLE IF NOT EXISTS users (
//                             id INT AUTO_INCREMENT PRIMARY KEY,
//                             username VARCHAR(50) NOT NULL,
//                             password VARCHAR(255) NOT NULL,
//                             email VARCHAR(100) NOT NULL
//                             )");
//   if ($table)
//     echo 'Created table products successfully!';
//   else 
//     echo 'Error occured on creating table';

    
// $query = $mysqli->query("ALTER TABLE products ADD COLUMN IF NOT EXISTS stock INT DEFAULT 0");

$shipment = $mysqli->query("CREATE TABLE IF NOT EXISTS shipment_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    user_id INT NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(100) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)");

// if ($shipment) {
//     echo 'Created table shipment_addresses successfully!';
// } else {
//     echo 'Error occurred on creating table shipment_addresses';
// }


<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  $mysqli = new mysqli('localhost', 'root', '', 'ecommerce', 3306);

 if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}



$query = $mysqli->query("CREATE TABLE IF cart(
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT DEFAULT 1,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
  )");

if ($query) {
    echo 'Created table cart successfully!';
} else {
    echo 'Error occurred on creating table cart';
}

  $mysqli->query("CREATE DATABASE IF NOT EXISTS ecommerce");
  $mysqli->query("USE ecommerce");

  $table = $mysqli->query("CREATE TABLE IF NOT EXISTS products (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(200) NOT NULL,
                            description TEXT,
                            price DECIMAL(10,2),
                            image VARCHAR(255)
                            )");
                            
  $users = $mysqli->query("CREATE TABLE IF NOT EXISTS users (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            username VARCHAR(50) NOT NULL,
                            password VARCHAR(255) NOT NULL,
                            email VARCHAR(100) NOT NULL
                            )");
  if ($table)
    echo 'Created table products successfully!';
  else 
    echo 'Error occured on creating table';

    

  

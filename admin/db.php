<?php


  $mysqli = new mysqli('localhost', 'root', '', 'ecommerce', 3306);

 if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

  // $mysqli->query("CREATE DATABASE IF NOT EXISTS ecommerce");
  // $mysqli->query("USE ecommerce");

  // $table = $mysqli->query("CREATE TABLE IF NOT EXISTS products (
  //                           id INT AUTO_INCREMENT PRIMARY KEY,
  //                           name VARCHAR(200) NOT NULL,
  //                           description TEXT,
  //                           price DECIMAL(10,2),
  //                           image VARCHAR(255)
  //                           )");
                            
  // $users = $mysqli->query("CREATE TABLE IF NOT EXISTS users (
  //                           id INT AUTO_INCREMENT PRIMARY KEY,
  //                           username VARCHAR(50) NOT NULL,
  //                           password VARCHAR(255) NOT NULL,
  //                           email VARCHAR(100) NOT NULL
  //                           )");
  // if ($table)
  //   echo 'Created table products successfully!';
  // else 
  //   echo 'Error occured on creating table';

    

  

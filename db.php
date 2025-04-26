<?php


  $mysqli = new mysqli('localhost', 'root', '',);

  if($mysqli)
    echo 'Connected to mysql successfully <br />';
  else
    die('Connection failed: ' . $mysqli->connect_error);

  $mysqli->query("CREATE DATABASE IF NOT EXISTS ecommerce");
  $mysqli->query("USE ecommerce");

  $table = $mysqli->query("CREATE TABLE IF NOT EXISTS products (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(200) NOT NULL,
                            description TEXT,
                            price DECIMAL(10,2),
                            image VARCHAR(255)
                            )");

  if ($table)
    echo 'Created table products successfully!';
  else 
    echo 'Error occured on creating table';

    

  

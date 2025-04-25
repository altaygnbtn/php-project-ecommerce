<?php


  $mysqli = new mysqli('localhost', 'root', '');

  if($mysqli)
    echo 'Connected to mysql successfully <br />';
  else
    die('Connection failed: ' . $mysqli->connect_error);

  $mysqli->query("DROP DATABASE IF EXISTS ecommerce");
  $db = $mysqli->query("CREATE DATABASE ecommerce");

  if ($db)
    echo 'Created ecommerce database <br />';

  $use = $mysqli->query("USE ecommerce");
  if ($use)
    echo "using ecommerce database <br />";
  
  $table = $mysqli->query("CREATE TABLE products (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(100),
                          description TEXT,
                          price DECIMAL(10,2),
                          image VARCHAR(255))
                          ");
  if ($table)
    echo "products table is created <br />";

  $insert = $mysqli->query("INSERT INTO 
                            products (name, description, price, image)
                            VALUES ('Keyboard', 'A red switch keyboard', 10.99, 'images/product1.jpg')
                             ");

if ($insert)
    echo "data is inserted into products table <br />";

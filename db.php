<?php


  $mysqli = new mysqli('localhost', 'root', '', 'ecommerce');

  if($mysqli)
    echo 'Connected to mysql successfully <br />';
  else
    die('Connection failed: ' . $mysqli->connect_error);

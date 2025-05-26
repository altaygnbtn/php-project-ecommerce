<?php
session_start(); 
session_unset(); // unset the session variables
session_destroy(); //destroying the session
header("Location: login.php"); //redirecting the user to login page
exit;
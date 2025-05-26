<?php


// ini_set('display_errors', 1); 
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start(); //creating a session to handle user login
require_once 'db.php'; // include database for storing user data

$success = '';
$error = '';
$role = 'user'; //default role 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $username = '';
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = '';
    }
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }

    if ($username !== '' && $email !== '' && $password !== '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //validate email format
            $error = 'Please enter a valid email address!';
        } else {
            //checking if the username or email exists in the database
            $record = $mysqli->prepare("SELECT id FROM users WHERE username = ? OR email = ?"); //prepared statements
            $record->bind_param('ss', $username, $email); //string parameters (username and email)
            $record->execute();
            $record->store_result();

            if ($record->num_rows > 0) {
                $error = 'Username or email already exists. Please choose another.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT); //hashing the password using bcrpyt algorithm for security
                $record = $mysqli->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)"); //prepared statements to prevent sql injection
                $record->bind_param('ssss', $username, $hashedPassword, $email, $role);
                if ($record->execute()) {
                    $success = 'Registration successful. You can now log in.';
                    header("Location: login.php?success=1"); //redirecting the user to the login page with success message
                } else {
                    $error = 'Error occured on registering user';
                }
            }
        }
    } else {
        $error = 'All fields are required';
    }
}
?>


<!DOCTYPE html>
<html>
<head><title>Sign Up</title></head>
<body>
<h2>Sign Up</h2>
<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?> <!-- outputs error with red color -->
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?> <!-- outputs success message with green color -->
<form method="post" >
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>

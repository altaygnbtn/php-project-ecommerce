<?php
session_start();
require_once 'db.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])){
        $username = $_POST['username'];
    } else {
        $username = "";
    }
    if (isset($_POST['password'])){
        $password = $_POST['password'];
    } else {
        $password = "";
    }

    if ($username !== '' && $password !== '') {
        $record = $mysqli->prepare("SELECT id, username, email, password, role FROM users WHERE username = ? LIMIT 1"); //using prepare statement to prevent sql injection
        $record->bind_param('s', $username); //string parameter
        $record->execute(); 
        $result = $record->get_result(); 

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) { //verify the password with the hashed password
                $_SESSION['user_id'] = $row['id']; //using session for throughout the site 
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                header("Location: /store.php"); //redirect the user to the store.php if the password is correct
                exit; 
            } else {
                $error = 'Incorrect password';
            }
        } else {
            $error = 'User not found'; //username not found
        }
    } else {
        $error = 'Both fields are required';
    }
}
?>

<?php

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success = "Registration successful. You can now log in.";
}

?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?> <!-- outputs errror with red color -->
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
    <br>
    <br>
    Don't have an account? <a href="signup.php">Sign up here</a>
</form>
</body>
</html>

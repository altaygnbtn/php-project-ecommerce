<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php'; // this must initialize $mysqli

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $email !== '' && $password !== '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email format';
        } else {
            // Check if username or email exists
            $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->bind_param('ss', $username, $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = 'Username or email already taken';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $mysqli->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $username, $hashedPassword, $email);
                if ($stmt->execute()) {
                    $success = 'Registration successful. You can now log in.';
                } else {
                    $error = 'Error registering user';
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
<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
<form method="post" >
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>
</body>
</html>

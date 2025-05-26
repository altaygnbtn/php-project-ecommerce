<?php
session_start();
require_once 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; 
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {
        $record = $mysqli->prepare("SELECT id, username, email, password FROM users WHERE username = ? LIMIT 1"); //using prepare statement to prevent sql injection
        $record->bind_param('s', $username); //string parameter
        $record->execute();
        $result = $record->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                header("Location: /store.php");
                exit;
            } else {
                $error = 'Incorrect password';
            }
        } else {
            $error = 'User not found';
        }
    } else {
        $error = 'Both fields are required';
    }
}
?>

<!-- HTML PART -->
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
    <br>
    Dont have an account? <a href="signup.php">Sign up here</a>
</form>
</body>
</html>

<?php
session_start();
include 'admin/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? ''); 
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username !== '' && $email !== '' && $password !== '') {
        $stmt = $mysqli->prepare('SELECT id, username, email, password FROM users WHERE username=? OR email=? LIMIT 1');
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                header('Location: store.php');
                exit;
            }
        }
        $error = 'Invalid credentials';
    } else {
        $error = 'All fields required';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body{font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}
form{background:#fff;padding:40px;border-radius:8px;box-shadow:0 4px 10px rgba(0,0,0,.1);width:320px}
h2{text-align:center;margin-bottom:24px}
input{width:100%;padding:10px;margin:8px 0;border:1px solid #ccc;border-radius:4px}
button{width:100%;padding:10px;border:none;background:#28a745;color:#fff;border-radius:4px;font-size:16px;cursor:pointer}
button:hover{background:#218838}
.error{color:#e74c3c;text-align:center;margin-bottom:12px}
</style>
</head>
<body>
<form method="post" action="login.php">
<h2>Login</h2>
<?php if($error!==''){echo'<div class="error">'.$error.'</div>';}?>
<input type="text" name="username" placeholder="Username" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Login</button>
</form>
</body>
</html>

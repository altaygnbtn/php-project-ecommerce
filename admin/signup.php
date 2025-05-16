<?php
session_start();
$success='';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??'');
    $surname=trim($_POST['surname']??'');
    $email=trim($_POST['email']??'');
    $password=$_POST['password']??'';
    if($name!==''&&$surname!==''&&$email!==''&&$password!==''){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $_SESSION['registered_user']=[$name,$surname,$email,password_hash($password,PASSWORD_BCRYPT)];
            $success='Registration successful. You can now log in.';
        }else{
            $error='Invalid email';
        }
    }else{
        $error='All fields required';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<style>
body{font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}
form{background:#fff;padding:40px;border-radius:8px;box-shadow:0 4px 10px rgba(0,0,0,.1);width:320px}
h2{text-align:center;margin-bottom:24px}
input{width:100%;padding:10px;margin:8px 0;border:1px solid #ccc;border-radius:4px}
button{width:100%;padding:10px;border:none;background:#007bff;color:#fff;border-radius:4px;font-size:16px;cursor:pointer}
button:hover{background:#0069d9}
.error{color:#e74c3c;text-align:center;margin-bottom:12px}
.success{color:#28a745;text-align:center;margin-bottom:12px}
</style>
</head>
<body>
<form method="post">
<h2>Sign Up</h2>
<?php
if($error!==''){echo'<div class="error">'.$error.'</div>';}
if($success!==''){echo'<div class="success">'.$success.'</div>';}
?>
<input type="text" name="name" placeholder="Name" required>
<input type="text" name="surname" placeholder="Surname" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Register</button>
</form>
</body>
</html>

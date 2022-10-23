<?php
session_start();
require('connect.php');    
if (isset($_POST['submit'])) {
    $username = stripslashes($_REQUEST['username']);
    $password = stripslashes($_REQUEST['password']);
    $result = $conn->query("SELECT password, isAdmin FROM \"user\" WHERE username='$username'");
    $fetch_array = $result->fetch(PDO::FETCH_ASSOC) ?? '';
    $hash = $fetch_array['password'];
    $role = $fetch_array['isadmin'];
    if (password_verify($password, $hash)) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        if($role === true) {
            header("Location: admin.php");
        } else {
            header("Location: /");
        }
    } else {
        echo "<div class='form'>
                <h3>Incorrect Username/password.</h3><br/>
                <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<form class="form" method="post" name="login">
    <h1 class="login-title">Log in</h1>
    <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true" required/>
    <input type="password" class="login-input" name="password" placeholder="Password" required/>
    <input type="submit" value="Log in" name="submit" class="login-button"/>
    <p class="link">Don't have an account? <a href="signup.php">Sign Up Now</a></p>
</form>
</body>
</html>

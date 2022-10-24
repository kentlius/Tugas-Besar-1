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
    <title>Login - Binotify</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="assets/Spotify_Logo_RGB_White.png" alt="logo" width="128">
        </div>
        <div class="auth-container">
            <div class="auth-form">
                <h1 class="title">Log in to continue.</h1>
                <form method="post" name="login">
                    <div class="input-form">
                        <input type="text" id="login-username" name="username" placeholder="Username" autofocus required>
                    </div>
                    <div class="input-form">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <input type="submit" value="LOG IN" name="submit"">
                    <p class="link">Don't have an account? <a href="signup.php">Sign Up</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

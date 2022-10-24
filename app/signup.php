<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - Binotify</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('connect.php');
    if (isset($_REQUEST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $email = stripslashes($_REQUEST['email']);
        $password = stripslashes($_REQUEST['password']);
        $result = $conn->query("INSERT into \"user\" (email, password, username, isAdmin) VALUES ('$email', '" . password_hash($password, PASSWORD_DEFAULT) . "', '$username', false)");
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='signup.php'>sign up</a> again.</p>
                  </div>";
        }
    } else {
?>
    <div class="container">
        <div class="logo">
            <img src="assets/Spotify_Logo_RGB_White.png" alt="logo" width="128">
        </div>
        <div class="auth-container">
            <div class="auth-form">
                <h1 class="title">Sign up for free to start listening.</h1>
                <form method="post" name="signup">
                    <div class="input-form">
                        <input type="text" name="username" placeholder="Username" autofocus required>
                    </div>
                    <div class="input-form">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-form">
                        <input type="password" name="password" placeholder="Create a Password" required>
                    </div>
                    <div class="input-form">
                        <input type="password" name="confirm-password" placeholder="Confirm Password" required>
                    </div>
                    <input type="submit" name="submit" value="Continue" class="signup-button">
                    <p class="link">Have an account? <a href="login.php">Log in</a>.</p>
                </form>
            </div>
        </div>
    </div>
<?php
    }
?>
</body>
</html>

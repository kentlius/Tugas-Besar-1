<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
    <form class="form" action="" method="post">
        <h1 class="login-title">Sign Up</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="email" class="login-input" name="email" placeholder="Email" required>
        <input type="password" class="login-input" name="password" placeholder="Password" required>
        <input type="submit" name="submit" value="Sign Up" class="login-button">
        <p class="link">Already have an account? <a href="login.php">Log in here</a></p>
    </form>
<?php
    }
?>
</body>
</html>

<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: /");
    exit();
}

require('connect.php');
$username = $email = $passErr = $usernameErr = $emailErr = "";
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST['username']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $confirm_password = test_input($_POST['confirm_password']);

    if(!preg_match("/^(?=[a-zA-Z0-9._]{1,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/", $username)) {
        $usernameErr = "<div class='error'>Please enter a valid username.</div>";
        $error = true;
    }

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $usernameErr = "<div class='error'>Username already exists.</div>";
        $error = true;
    }  

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $emailErr = "<div class='error'>Email already exists.</div>";
        $error = true;
    }

    if($password !== $confirm_password) {
        $passErr = "<div class='error'>Passwords do not match.</div>";
        $error = true;
    }

    if ($error === false) {
        $password = 
        $query = "INSERT INTO users (email, password, username, isadmin) VALUES ('$email', '" . password_hash($password, PASSWORD_DEFAULT) . "', '$username', false)";
        $conn->exec($query);
        header("Location: /login.php");
        exit(); 
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - Binotify</title>
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <a href="/">
                <img src="img/Spotify_Logo_RGB_White.png" alt="logo" width="128">
            </a>
        </div>
        <div class="auth-container">
            <div class="auth-form">
                <h1 class="title">Sign up for free to start listening.</h1>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="input-form">
                        <input type="text" name="username" placeholder="Username" value="<?php echo $username;?>" autofocus required>
                        <?php echo $usernameErr; ?>
                    </div>
                    <div class="input-form">
                        <input type="email" name="email" placeholder="Email" value="<?php echo $email;?>" required>
                        <?php echo $emailErr; ?>
                    </div>
                    <div class="input-form">
                        <input type="password" name="password" placeholder="Create a Password" required>
                    </div>
                    <div class="input-form">
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                        <?php echo $passErr; ?>
                    </div>
                    <input type="submit" name="submit" value="Continue" class="signup-button">
                    <p class="link">Have an account? <a href="login.php">Log in</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

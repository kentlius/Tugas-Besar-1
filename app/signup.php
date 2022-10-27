<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: /");
    exit();
}

require('connect.php');
$passErr = "";
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST['username']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $confirm_password = test_input($_POST['confirm_password']);

    if(!preg_match("/^(?=[a-zA-Z0-9._]{1,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/", $username)) {
        $error = true;
    }

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $error = true;
    }  

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $error = true;
    }

    if($password !== $confirm_password) {
        $passErr = "<div class='error'>Passwords do not match.</div>";
        $error = true;
    }

    if ($error === false) {
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
    <script src="js/auth.js" defer></script>
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
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
                    <div class="input-form">
                        <input id="username" type="text" name="username" placeholder="Username" onkeyup="checkUsername(this.value)" autofocus required autocomplete="off">
                        <div class="error" id="usernameErr"></div>
                    </div>
                    <div class="input-form">
                        <input id="email" type="email" name="email" placeholder="Email" onkeyup="checkEmail(this.value)" required autocomplete="off">
                        <div class="error" id="emailErr"></div>
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

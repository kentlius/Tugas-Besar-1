<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: /");
    exit();
}

require('connect.php');
$username = $password = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $result = $conn->query("SELECT password, isadmin FROM users WHERE username='$username'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        if (password_verify($password, $row['password'])) {
            session_unset();
            $_SESSION['username'] = $username;
            if ($row['isadmin']) {
                $_SESSION['admin'] = true;
            }
            header("Location: /");
        } else {
            $error = "<div class='error-box'>The username or password is incorrect.</div>";
        }
    }
    else {
        $error = "<div class='error-box'>The username or password is incorrect.</div>";
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
    <title>Login - Binotify</title>
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
                <h1 class="title">Log in to continue.</h1>
                <?php echo $error; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="input-form">
                        <input type="text" name="username" placeholder="Username" value="<?php echo $username;?>" autofocus required>
                    </div>
                    <div class="input-form">
                        <input type="password" name="password" placeholder="Password" value="<?php echo $password;?>" required>
                    </div>
                    <input type="submit" name="submit" value="LOG IN">
                    <p class=" link">Don't have an account? <a href="signup.php">Sign Up</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
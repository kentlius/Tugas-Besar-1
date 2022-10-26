<?php
require("session/admin_auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List - Binotify</title>
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/users.css">
</head>
<body>
    <?php
    require('connect.php');
    $result = $conn->query("SELECT user_id, username, email, isadmin FROM users");
    $users = $result->fetchAll(PDO::FETCH_ASSOC);

    require("template/navbar.php");
    navbar();
    ?>
    <div class="wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>isAdmin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo $user["user_id"]; ?></td>
                        <td><?php echo $user["username"]; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <?php
                            if ($user['isadmin']) {
                                echo "Yes";
                            } else {
                                echo "No";
                            } ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

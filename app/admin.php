<?php
require("session/admin_auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <?php
    require('connect.php');

    $result = $conn->query("SELECT * FROM users");
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="container">
        <p>Hey, <?php echo $_SESSION['username']; ?>!</p>
        <p>You are in admin dashboard page.</p>
        <p><a href="logout.php">Logout</a></p>

        <table>
            <caption>Users List</caption>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>isAdmin</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user["user_id"]; ?></td>
                    <td><?php echo $user["username"]; ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td>
                        <?php
                        if ($user['isadmin']) {
                            echo "Yes";
                        } else {
                            echo "No";
                        } ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
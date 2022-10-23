<?php
require("admin_auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
require('connect.php');

$result = $conn->query("SELECT * FROM \"user\"");
$users = $result->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="container">
        <p>Hey, <?php echo $_SESSION['username']; ?>!</p>
        <p>You are in admin dashboard page.</p>
        <p><a href="logout.php">Logout</a></p>
        <div>
            <table>
                <caption>Users List</caption>
                <tr><th>Username</th> <th>Email</th></tr>
                <?php foreach ($users as $user): ?>
                    <tr><td><?php echo $user["username"]; ?></td> <td><?php echo $user['email'] ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>

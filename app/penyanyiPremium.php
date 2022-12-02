<?php
session_start();
require('connect.php');
require('template/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/penyanyiPremium.css"/>
    <link rel="stylesheet" href="css/globals.css"/>
    <script src="js/getPenyanyiPremium.js" defer></script>
    <title>List Penyanyi Premium</title>
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
        <div class="main" id="main">
        </div>
    </div>

</body>
</html>
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
    <link rel="stylesheet" href="css/premiumSong.css"/>
    <link rel="stylesheet" href="css/globals.css">
    <script src="js/getPremiumSongs.js" defer></script>
    <title>Lagu Premium</title>
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
        <div class="main">
            <div class="back">
                <a href="penyanyiPremium.php">
                    <div class="gambar_back">
                        <img src="img/back.png" alt="back">
                    </div>
                </a>
            </div>
            
            <div class="penyanyi" id="penyanyi">
                <p>(nama penyanyi)</p>
            </div>
            <table id="songs">
            </table>
        </div>
    </div>

</body>
</html>
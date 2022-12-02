<?php
require('connect.php');
require('template/navbar.php');
require('session/session_auth.php');
if(isset($_GET["penyanyi_id"])){
    $penyanyi_id = $_GET["penyanyi_id"];
}
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
    <div id="dom-target" style="display: none;">
        <?php
            echo htmlspecialchars($penyanyi_id);
        ?>
    </div>
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
   <div id="popup1" class="overlay">
	<div class="popup">
		<h2 id='judul-lagu-popup'>Here i am</h2>
		<a class="close" href="#">&times;</a>
		<div class="audio-player">
            <audio controls autoplay id="audioplay">
                    <source src='./uploads/audio/HelloFuture.mp3' type='audio/mpeg' id='src-song'>
            </audio>";
        </div>
	</div>
</div>
</body>
</html>
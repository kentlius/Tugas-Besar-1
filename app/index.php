<?php
session_start();
require('template/navbar.php');
require('connect.php');

$query = $conn->query("SELECT * FROM song ORDER BY tanggal_terbit DESC LIMIT 10");
$songs = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binotify</title>
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
        <div class="main">
            <h1>Binotify</h1>
            <div id='song-container' class='song-container'>
                <?php foreach ($songs as $song) : ?>
                    <?php 
                        if($song['album_id'] != NULL){
                            $album = $conn->query("SELECT * FROM album WHERE album_id = '$song[album_id]'")->fetch(PDO::FETCH_ASSOC);
                            $album_name = $album['judul'];
                        }else{
                            $album_name = 'Tidak ada album';
                        }
                        if($song["image_path"] == "uploads/img/"){
                            $image = 'uploads/img/NoImage.png';
                        }else{
                            $image = $song["image_path"];
                        }
                    ?>
                    <div class='song'>
                        <a href="detailLagu.php?song_id=<?php echo $song['song_id']; ?>">
                            <div class='song-img'>
                                <img src='<?php echo $image; ?>' alt="song image">
                            </div>
                            <div class='song-info'>
                                <h2><?php echo $song['judul']; ?></h2>
                                <p><?php echo substr($song['tanggal_terbit'], 0, 4), " &#8226 ", $song['penyanyi']; ?></p>
                                <p><?php echo $album_name ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>

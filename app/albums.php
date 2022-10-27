<?php
session_start();
require('connect.php');
require('template/navbar.php');

$result = $conn->query("SELECT * FROM album");
$albums = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albums - Binotify</title>
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/albums.css">
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
        <div class="main">
            <h1>Daftar Album</h1>
            <div class="container"> 
                <?php foreach ($albums as $album): ?>
                    <?php
                        $tahun = substr($album['tanggal_terbit'], 0, 4);
                    ?>
                    <div class="album">
                        <a href="detailAlbum.php?album_id=<?= $album['album_id'] ?>">
                            <div class="gambar"><img src='<?php echo $album['image_path']; ?>'/></div>
                            <div class="judul"><?php echo $album['judul']; ?></div>
                            <div class="tahun"><?php echo $tahun," &#8226; ", $album['penyanyi'] ; ?></div>
                            <div class="genre"><?php echo $album['genre']; ?></div>
                        </a>
                    </div> 
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    require('connect.php');
    require('template/navbar.php');
    $song_id = $_GET['song_id'];
    $res = $conn->query("SELECT * FROM song WHERE song_id = '$song_id'");
    $song= $res->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/detailLagu.css"/>
    <link rel="stylesheet" href="css/globals.css">
    <title>Detail lagu</title>
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
    </div>
    <div class="container">
        <div class="back">
            <a href="detailAlbum.php?album_id=<?= $song['album_id'] ?>">
                <div class="gambar_back">
                    <img src="img/back.png" alt="back">
                </div>
            </a>
        </div>
        <div class="cover">
            <div class="image">
                <img src='<?php echo $song['image_path']; ?>'/>
            </div>
            <div class="lagu_detail">
                <?php
                    $tahun = substr($song['tanggal_terbit'], 0, 4);
                    $bulan = substr($song['tanggal_terbit'], 5, 2);
                    $tanggal = substr($song['tanggal_terbit'], 8, 2);
                    $minute = floor($song['duration'] / 60);
                    $second = $song['duration'] % 60;
                ?>
                <div class="judul"><?php echo $song['judul']; ?></div>
                <div class="penyanyi"><?php echo $song['penyanyi']; ?></div>
                <div class="tanggal_terbit"><?php echo $song['tanggal_terbit']; ?></div>
                <div class="genre"><?php echo $song['genre']; ?></div>
                <div class="durasi"><?php echo $minute," minutes ",$second," seconds"; ?></div>
            </div>
        </div>
        <div class="audio-player">
            <audio controls>
                <source src='<?php echo $song['audio_path']; ?>' type="audio/mpeg">
            </audio>
        </div>
    </div>
</body>
</html>
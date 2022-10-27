<?php
    session_start();
    require('connect.php');
    require('template/navbar.php');
    $album_id = $_GET['album_id'];
    $result = $conn->query("SELECT * FROM album WHERE album_id = '$album_id'");
    $albums= $result->fetch(PDO::FETCH_ASSOC);

    $res = $conn->query("SELECT * FROM song WHERE album_id = '$album_id'");
    $songs= $res->fetchAll(PDO::FETCH_ASSOC);
    $jumlah_lagu = $conn->query("SELECT * FROM song WHERE album_id = '$album_id'")->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/detailalbum.css"/>
    <link rel="stylesheet" href="css/globals.css">
    <title>Detail Album</title>
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
    </div>
    <div class="container">
        <?php
            $tahun = substr($albums['tanggal_terbit'], 0, 4);
        ?>
        <div class="top-bar">

        </div>
        <div class="cover">
            <div class="image">
                <img src='img/Spotify_Icon_RGB_Green.png'/>
            </div>
            <div class="album_detail">
                <?php
                    $tahun = substr($albums['tanggal_terbit'], 0, 4);
                    $minute = floor($albums['total_duration'] / 60);
                    $second = $albums['total_duration'] % 60;
                ?>
                <div class="album_title">ALBUM</div>
                <div class="nama_album"><?php echo $albums['judul']; ?></div>
                <div class="tahun"><?php echo $albums['penyanyi'] ," &#8226; ",$tahun," &#8226; ",$jumlah_lagu," songs, ", $minute," minutes ",$second," seconds"; ?></div>
            </div>
        </div>
        <div class="daftar_lagu">
            <?php $count=1; ?>
            <?php foreach ($songs as $song): ?>
                <?php  $minute = floor($song['duration'] / 60);
                    $second = $song['duration'] % 60;?>
                <div class="lagu">
                    <div class="num"><?php echo $count; ?></div>
                    <div class="judul_penyayi">
                        <div class="judul"><?php echo $song['judul']; ?></div>
                        <div class="penyanyi"><?php echo $song['penyanyi']; ?></div>
                    </div>
                    <div class="durasi"><?php echo $minute,":",$second; ?></div>
                    <?php $count++; ?>
                </div>
            <?php endforeach; ?>
        </div>
                  
        </div> 
    </div>
</body>
</html>
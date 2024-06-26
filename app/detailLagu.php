<?php
    session_start();
    require('connect.php');
    require('template/navbar.php');

    if(!isset($_GET['song_id'])){
        header('Location: index.php');
    }
    $song_id = $_GET['song_id'];
    $res = $conn->query("SELECT * FROM song WHERE song_id = '$song_id'");
    $song= $res->fetch(PDO::FETCH_ASSOC);
    $album = "";
    if($song['album_id'] != null){
        $result = $conn->query("SELECT * FROM album WHERE album_id = '$song[album_id]'");
        $album = $result->fetch(PDO::FETCH_ASSOC);
    }
    $isAdmin = isset($_SESSION["admin"]);

    $val = 0;
    if(!isset($_SESSION['username'])) {
        if (isset($_COOKIE['count'])) {
            $val = ++$_COOKIE['count'];
        } else {
            $val = 1;
        }
        setcookie('count', $val, strtotime('today 23:59'), '/');
    }
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
            <?php if ($isAdmin): ?>
                <a href="edit-lagu.php?song_id=<?= $song['song_id'] ?>">
                    <div class="gambar_edit">
                        <img src="img/edit.png" alt="edit">
                    </div>
                </a>
            <?php endif; ?>
        </div>
        <div class="isi">
            <div class="cover">
                <?php
                    if($song["image_path"] == "uploads/img/"){
                        $image = 'uploads/img/NoImage.png';
                    }else{
                        $image = $song["image_path"];
                    }
                ?>
                <div class="image">
                    <img src='<?php echo $image; ?>'/>
                </div>
                <div class="lagu_detail">
                    <?php
                        $tahun = substr($song['tanggal_terbit'], 0, 4);
                        $bulan = (int) substr($song['tanggal_terbit'], 5, 2);
                        $nama_bulan = date("F", mktime(0, 0, 0, $bulan, 10));
                        $tanggal = substr($song['tanggal_terbit'], 8, 2);
                        $minute = floor($song['duration'] / 60);
                        $second = $song['duration'] % 60;
                    ?>
                    <div class="album">
                        <?php 
                            if($album != ""){
                                echo $album["judul"];
                            }else{
                                echo "Single";
                            }
                    ?></div>
                    <div class="judul"><?php echo $song['judul']; ?></div>
                    <div class="penyanyi"><?php echo $song['penyanyi']," &#8226; ",$tanggal," ",$nama_bulan," ", $tahun; ?></div>
                    <div class="durasi"><?php echo $minute," minutes ",$second," seconds"; ?></div>
                    <div class="genre"><?php 
                                if($song["genre"] != NULL){
                                    echo $song["genre"];
                                }
                            ?>
                            </div>
                </div>
            </div>
            <div class="audio-player">
                <?php if($val <= 3) {
                    echo "
                    <audio controls autoplay>
                        <source src='$song[audio_path]' type='audio/mpeg'>
                    </audio>";
                } else {
                    echo "You have played music 3 times today.";
                } ?>
            </div>
        </div>
    </div>
</body>
</html>
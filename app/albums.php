<?php
session_start();
require('connect.php');
require('template/navbar.php');

$jumlahDataPerHalaman = 10;
$jumlahData = $conn->query("SELECT * FROM album")->rowCount();
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awalData = ($jumlahDataPerHalaman * ($halamanAktif-1));

$result = $conn->query("SELECT * FROM album LIMIT $jumlahDataPerHalaman OFFSET $awalData");
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
            <div class='page'>
                <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="page">Page:</label>
                    <select name="page" id="page" onchange="this.form.submit();">
                        <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
                            <?php if($i == $halamanAktif): ?>
                                <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </form>
            </div>
            <div class="container"> 
                <?php foreach ($albums as $album): ?>
                    <?php
                        if($album["image_path"] == "uploads/img/"){
                            $image = 'uploads/img/NoImage.png';
                        }else{
                            $image = $album["image_path"];
                        }
                        $tahun = substr($album['tanggal_terbit'], 0, 4);
                    ?>
                    <div class="album">
                        <a href="detailAlbum.php?album_id=<?= $album['album_id'] ?>">
                            <div class="gambar"><img src="<?php echo  $image; ?>"/></div>
                            <div class="judul"><?php echo $album['judul']; ?></div>
                            <div class="tahun"><?php echo $tahun," &#8226; ", $album['penyanyi'] ; ?></div>
                            <div class="genre"><?php 
                                if($album["genre"] != NULL){
                                    echo $album["genre"];
                                }
                            ?>
                            </div>
                        </a>
                    </div> 
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>

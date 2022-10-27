<?php
    require('connect.php');
    require('template/navbar.php');
    $album_id = $_GET['album_id'];
    $result = $conn->query("SELECT * FROM album WHERE album_id = '$album_id'");
    $albums= $result->fetch(PDO::FETCH_ASSOC);

    $res = $conn->query("SELECT * FROM song WHERE album_id = '$album_id'");
    $songs = $res->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit-album.css"/>
    <link rel="stylesheet" href="css/globals.css">
    <title>Edit Album</title>
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
    </div>
    <div class="container">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" value="<?php echo $albums['judul']; ?>">
        <label for="tanggal_terbit">Tanggal Terbit</label>
        <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="<?php echo $albums['tanggal_terbit']; ?>">
        <label for="genre">Genre</label>
        <input type="text" name="genre" id="genre" value="<?php echo $albums['genre']; ?>">
        <label for="image_path">Image Path</label>
        <input type="file" name="image_path" id="image_path" value="<?php echo $albums['image_path']; ?>">
        <label for="daftar_lagu">Daftar Lagu</label>
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
                    <div class="delete">
                        <a href="edit-album.php/?delete"></a>
                        <img src="img/trash.png"/>
                    </div>
                    
                        <?php $count++; ?>
                </div>
                
            <?php endforeach; ?>
        </div>
        <div class="but">
            <button class="delete_but" type="submit" name="submit" id="submit">Delete Album</button>
            <button class="save_but" type="submit" name="submit" id="submit">Save</button>
        </div>
    </div>
</body>
</html>
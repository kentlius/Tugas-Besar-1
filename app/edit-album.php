<?php
    require('session/admin_auth.php');
    require('connect.php');
    require('template/navbar.php');

    $album_id = $_GET['album_id'];
    $result = $conn->query("SELECT * FROM album WHERE album_id = '$album_id'");
    $albums= $result->fetch(PDO::FETCH_ASSOC);
    $res = $conn->query("SELECT * FROM song WHERE album_id = '$album_id'");
    $songs = $res->fetchAll(PDO::FETCH_ASSOC);


    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!empty($_POST) && !isset($_POST['delete-album'])) {
            foreach($_POST as $key => $value){
                if($key == 'judul'){
                    $conn->exec("UPDATE album SET judul = '$value' WHERE album_id = $album_id");
                } elseif($key == 'tanggal_terbit'){
                    $conn->exec("UPDATE album SET tanggal_terbit = '$value' WHERE album_id = '$album_id'");
                } elseif($key == 'penyanyi'){
                    $conn->exec("UPDATE album SET penyanyi = '$value' WHERE album_id = '$album_id'");
                } elseif($key == 'image_path'){
                    $conn->exec("UPDATE album SET image_path = '$value' WHERE album_id = '$album_id'");
                }
            }

            if(isset($_POST['delete'])){
                foreach($_POST['delete'] as $key => $value){
                    $conn->exec("UPDATE song SET album_id = NULL WHERE song_id = '$value'");
                }
            }
            $albums = $conn->query("SELECT * FROM album WHERE album_id = '$album_id'")->fetch(PDO::FETCH_ASSOC);
            $songs = $conn->query("SELECT * FROM song WHERE album_id = '$album_id'")->fetchAll(PDO::FETCH_ASSOC);
        }elseif(isset($_POST['delete-album'])){
            $conn->query("UPDATE song SET album_id = NULL WHERE album_id = '$album_id'");
            $conn->query("DELETE FROM album WHERE album_id = '$album_id'");
            header("Location: albums.php");
        }
    }
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
        <form action='edit-album.php?album_id=<?php echo $album_id ?>' method='post'>
            <div class="form-container">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" value="<?php echo $albums['judul']; ?>">
                <label for="tanggal_terbit">Tanggal Terbit</label>
                <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="<?php echo $albums['tanggal_terbit']; ?>">
                <label for="genre">Genre</label>
                <input type="text" name="genre" id="genre" value="<?php echo $albums['genre']; ?>">
                <label for="image_path">Image Path</label>
                <input type="file" name="image_path" id="image_path" value="<?php echo $albums['image_path']; ?>">
            </div>
            <div class="daftar_lagu">
                <h2>Daftar Lagu</h2>
                <?php $count=1; ?>
                <?php foreach ($songs as $song): ?>
                    <div class="lagu">
                        <div class="num"><?php echo $count; ?></div>
                        <div class="judul_penyayi">
                            <div class="judul"><?php echo $song['judul']; ?></div>
                            <div class="penyanyi"><?php echo $song['penyanyi']; ?></div>
                        </div>
                        <div class="delete">
                                <img src="img/trash.png" alt="delete" width="35px" height="35px">
                                <input type="checkbox" name='delete[]' value="<?php echo $song['song_id'] ?>">
                        </div>
                        
                    </div>
                    
                    <?php $count++; ?>
                <?php endforeach; ?>
            </div>
            <div class="but">
                <button class="delete_but" type="submit" name="delete-album" id="submit">Delete Album</button>
                <button class="save_but" type="submit" name="submit" id="submit">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
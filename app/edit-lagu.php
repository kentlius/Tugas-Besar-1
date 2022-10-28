<?php
    require('session/admin_auth.php');
    require('connect.php');
    require('template/navbar.php');

    if(!isset($_GET['song_id'])){
        header('Location: index.php');
    }
    $song_id = $_GET['song_id'];
    
    $res = $conn->query("SELECT * FROM song WHERE song_id = '$song_id'");
    $song = $res->fetch(PDO::FETCH_ASSOC);
    $hasil = $conn->query("SELECT * FROM album");
    $albums = $hasil->fetchAll(PDO::FETCH_ASSOC);
    $uploadErr = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['submit'])){
            $target_dir_img = "uploads/img/";
            $target_dir_audio = "uploads/audio/";
            $target_file_img = $target_dir_img . basename($_FILES["image_path"]["name"]);
            $target_file_audio = $target_dir_audio . basename($_FILES["audio_path"]["name"]);
            $new_judul = stripslashes($_POST['judul']);
            $new_tanggal = stripslashes($_POST['tanggal_terbit']);
            $new_genre = stripslashes($_POST['genre']);
            $new_album_id = stripslashes($_POST['album']);
            if($target_file_img != $song['image_path'] && $target_file_img != $target_dir_img){
                $new_image_path = $target_file_img;
                if (file_exists($target_file_img)) {
                    $uploadImgErr = "img already exists.";
                } else {
                    if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file_img)) {
                        $uploadErr = "The file ". htmlspecialchars(basename($_FILES["image_path"]["name"])). " has been uploaded.";
                    } else {
                        $uploadErr = "Sorry, there was an error uploading your file.";
                    }
                }
            }
            else{
                $new_image_path = $song['image_path'];
            }
            if($target_file_audio != $song['audio_path'] && $target_file_audio != $target_dir_audio){
                $new_audio_path = $target_file_audio;
                if (file_exists($target_file_audio)) {
                    $uploadSongErr = "song already exists.";
                    $time = exec("ffmpeg -i " . escapeshellarg($target_file_audio) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
                    list($hms, $milli) = explode('.', $time);
                    list($hours, $minutes, $seconds) = explode(':', $hms);
                    $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
                } else {
                    if (move_uploaded_file($_FILES["audio_path"]["tmp_name"], $target_file_audio)) {
                        $uploadErr = "The file ". htmlspecialchars(basename($_FILES["audio_path"]["name"])). " has been uploaded.";
                        $time = exec("ffmpeg -i " . escapeshellarg($target_file_audio) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
                        list($hms, $milli) = explode('.', $time);
                        list($hours, $minutes, $seconds) = explode(':', $hms);
                        $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
                    } else {
                        $uploadErr = "Sorry, there was an error uploading your file.";
                    }
                }
            }
            else{
                $new_audio_path = $song['audio_path'];
                $total_seconds = $song['duration'];
            }
            

            $conn->exec("UPDATE song SET judul = '$new_judul', tanggal_terbit = '$new_tanggal', genre = '$new_genre', duration = '$total_seconds', image_path = '$new_image_path', audio_path= '$new_audio_path', album_id = $new_album_id WHERE song_id = '$song_id'");
            $song= $conn->query("SELECT * FROM song WHERE song_id = '$song_id'")->fetch(PDO::FETCH_ASSOC);
            $albums = $conn->query("SELECT * FROM album")->fetchAll(PDO::FETCH_ASSOC);
            header("Location: edit-lagu.php?song_id=$song_id");
        }
        if(isset($_POST['delete'])){
            $conn->exec("DELETE FROM song WHERE song_id = '$song_id'");
            header("Location: index.php");
        }
    }




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit-lagu.css"/>
    <link rel="stylesheet" href="css/globals.css">
    <title>Edit Lagu</title>
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
    </div>
    <div class="container">  
        <form method="post" enctype="multipart/form-data">
            <label for="image_path">Image Path</label>
            <div class="image">
                <img src="<?php echo $song['image_path']; ?>" alt="album image">
            </div>
            <div class="item">
                <input type="file" name="image_path" id="image_path" accept="image/*">
                <label for="audio_path">Audio Path</label>
                <input type="file" name="audio_path" id="audio_path" accept="audio/*">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" value="<?php echo $song['judul']; ?>">
                <label for="tanggal_terbit">Tanggal Terbit</label>
                <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="<?php echo $song['tanggal_terbit']; ?>">
                <label for="genre">Genre</label>
                <input type="text" name="genre" id="genre" value="<?php echo $song['genre']; ?>">
                <label for="album">Album</label>
                <select name="album" id="album">
                    <?php foreach ($albums as $item): ?>
                        <option value="<?php echo $item["album_id"]; ?>"><?php echo $item["judul"]; ?></option>
                        <option value="NULL">None</option>
                    <?php endforeach; ?>
                </select>
                <div class="but">
                    <button class="delete_but" type="submit" name="delete" id="delete">Delete Lagu</button>
                    <button class="save_but" type="submit" name="submit" id="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
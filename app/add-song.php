<?php
require("session/admin_auth.php");
require("connect.php");

$uploadSongErr = $uploadImgErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $song_title = $_POST["song_title"];
    $artist_name = $_POST["artist_name"];
    $release_date = $_POST["release_date"];
    $genre = $_POST["genre"];
    $album_id = $_POST["album"];

    $target_dir_audio = "uploads/audio/";
    $target_dir_img = "uploads/img/";
    $target_file_audio = $target_dir_audio . basename($_FILES["song_audio"]["name"]);
    $target_file_img = $target_dir_img . basename($_FILES["song_image"]["name"]);

    if (file_exists($target_file_img)) {
        $uploadImgErr = "img already exists.";
    } else {
        if (move_uploaded_file($_FILES["song_image"]["tmp_name"], $target_file_img)) {
            $uploadErr = "The file ". htmlspecialchars(basename($_FILES["song_image"]["name"])). " has been uploaded.";
        } else {
            $uploadErr = "Sorry, there was an error uploading your file.";
        }
    }

    $time = exec("ffmpeg -i " . escapeshellarg($_FILES["song_audio"]["tmp_name"]) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
    list($hms, $milli) = explode('.', $time);
    list($hours, $minutes, $seconds) = explode(':', $hms);
    $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;

    if (file_exists($target_file_audio)) {
        $uploadSongErr = "song already exists.";
    } else {
        if (move_uploaded_file($_FILES["song_audio"]["tmp_name"], $target_file_audio)) {
            $uploadErr = "The file ". htmlspecialchars(basename($_FILES["song_audio"]["name"])). " has been uploaded.";
        } else {
            $uploadErr = "Sorry, there was an error uploading your file.";
        }
    }

    $query = "INSERT INTO song (judul, penyanyi, tanggal_terbit, genre, duration, audio_path, image_path, album_id) VALUES ('$song_title', '$artist_name', '$release_date', '$genre', '$total_seconds', '$target_file_audio', '$target_file_img', '$album_id')";
    $conn->exec($query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Song - Binotify</title>
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/add-song.css">
</head>
<body>
    <?php 
    require("template/navbar.php");
    navbar();
    ?>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <div>
                <label for="album_title">Song Title</label>
                <input type="text" name="song_title" id="song_title" required>
            </div>
            <div>
                <label for="artist_name">Artist Name</label>
                <input type="text" name="artist_name" id="artist_name" required>
            </div>
            <div>
                <label for="release_date">Release Date</label>
                <input type="date" name="release_date" id="release_date" required>
            </div>
            <div>
                <label for="genre">Genre</label>
                <input type="text" name="genre" id="genre">
            </div>
            <div>
                <label for="song_audio">Song</label>
                <input type="file" name="song_audio" id="song_audio" accept="audio/*" required>
                <?php echo $uploadSongErr; ?>
            </div>
            <div>
                <label for="song_image">Song Image</label>
                <input type="file" name="song_image" id="song_image" accept="image/*" required>
                <?php echo $uploadImgErr; ?>
            </div>
            <div>
                <?php
                    $query = $conn->query("SELECT * FROM album");
                    $albums = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <label for="album">Album</label>
                <select name="album" id="album">
                    <?php foreach ($albums as $album): ?>
                        <option value="<?php echo $album["album_id"]; ?>"><?php echo $album["judul"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="submit" value="Add Song" name="submit">
        </form>
    </div>
</body>
</html>

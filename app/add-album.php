<?php
require("session/admin_auth.php");
require("connect.php");

$uploadErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $album_title = $_POST['album_title'];
    $artist_name = $_POST['artist_name'];
    $release_date = $_POST['release_date'];
    $album_genre = $_POST['genre'];
    
    $target_dir = "uploads/img/";
    $target_file = $target_dir . basename($_FILES["album_image"]["name"]);

    if (file_exists($target_file)) {
        $uploadErr = "File already exists.";
        $query = "INSERT INTO album (judul, penyanyi, total_duration, image_path, tanggal_terbit, genre) VALUES ('$album_title', '$artist_name', 0, '$target_file', '$release_date', '$album_genre')";
        $conn->exec($query);
    } else {
        if (move_uploaded_file($_FILES["album_image"]["tmp_name"], $target_file)) {
            $uploadErr = "The file ". htmlspecialchars(basename($_FILES["album_image"]["name"])). " has been uploaded.";
            $query = "INSERT INTO album (judul, penyanyi, total_duration, image_path, tanggal_terbit, genre) VALUES ('$album_title', '$artist_name', 0, '$target_file', '$release_date', '$album_genre')";
            $conn->exec($query);
        } else {
            $uploadErr = "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Album - Binotify</title>
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/add-album.css">
</head>
<body>
    <?php 
    require("template/navbar.php");
    navbar();
    ?>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <div>
                <label for="album_title">Album Title</label>
                <input type="text" name="album_title" id="album_title" required>
            </div>
            <div>
                <label for="artist_name">Artist Name</label>
                <input type="text" name="artist_name" id="artist_name" required>
            </div>
            <div>
                <label for="album_image">Album Image</label>
                <input type="file" name="album_image" id="album_image" accept="image/*" required>
                <?php echo $uploadErr; ?>
            </div>
            <div>
                <label for="release_date">Release Date</label>
                <input type="date" name="release_date" id="release_date" required>
            </div>
            <div>
                <label for="genre">Genre</label>
                <input type="text" name="genre" id="genre">
            </div>
            <input type="submit" value="Add Album" name="submit">
        </form>
    </div>
</body>
</html>

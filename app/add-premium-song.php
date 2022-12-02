<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");

$uploadErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir_audio = "uploads/audio/";
    $target_file_audio = $target_dir_audio . basename($_FILES["audio_path"]["name"]);

    if (file_exists($target_file_audio)) {
        $uploadErr = "song already exists.";
    } else {
        if (move_uploaded_file($_FILES["audio_path"]["tmp_name"], $target_file_audio)) {
            $uploadErr = "The file ". htmlspecialchars(basename($_FILES["audio_path"]["name"])). " has been uploaded.";
        } else {
            $uploadErr = "Sorry, there was an error uploading your file.";
        }
    }
    echo $uploadErr;
}

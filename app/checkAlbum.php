<?php
require('connect.php');
$album_id = $_REQUEST["q"];
$hint = "";

if ($album_id !== "NULL") {
    $query = "SELECT penyanyi FROM album WHERE album_id = '$album_id'";
    $result = $conn->query($query);
    $row = $result->fetch();
    $hint = $row['penyanyi'];
}

echo $hint === "" ? "" : $hint;

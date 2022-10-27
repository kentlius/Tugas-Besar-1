<?php
require('connect.php');
$username = $_REQUEST["q"];
$hint = "";

if(!preg_match("/^(?=[a-zA-Z0-9._]{1,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/", $username)) {
    $hint = "Please enter a valid username.";
}

$result = $conn->query("SELECT * FROM users WHERE username='$username'");
$row = $result->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $hint = "Username already exists.";
}

echo $hint === "" ? "green" : $hint;
<?php
require('connect.php');
$email = $_REQUEST["q"];
$hint = "";

$result = $conn->query("SELECT * FROM users WHERE email='$email'");
$row = $result->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $hint = "Email already exists.";
    
}

echo $hint === "" ? "green" : $hint;
<?php
require('connect.php');
$email = $_REQUEST["q"];
$hint = "";

# Check if email is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $hint = "Email is not valid.";
} else {
    # Check if email is already registered
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    $row = $result->fetch();
    if ($row) {
        $hint = "Email is already registered.";
    }
}

echo $hint === "" ? "green" : $hint;
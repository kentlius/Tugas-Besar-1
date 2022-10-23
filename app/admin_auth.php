<?php
session_start();
if(!isset($_SESSION['role'])) {
    header("Location: /");
    exit();
} else {
    if(!$_SESSION['role']) {
        header("Location: /");
        exit();
    }
}

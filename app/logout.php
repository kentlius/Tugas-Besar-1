<?php
session_start();
session_unset();
if (session_destroy()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

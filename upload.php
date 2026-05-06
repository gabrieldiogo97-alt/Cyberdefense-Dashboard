<?php
session_start();

if (!isset($_SESSION['user'])) {
    die("Access denied");
}

$target = "/var/www/meusite/files/";

if (isset($_FILES["file"])) {
    $file = $target . basename($_FILES["file"]["name"]);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $file)) {
        echo "upload success";
    } else {
        echo "upload failed";
    }
}
?>

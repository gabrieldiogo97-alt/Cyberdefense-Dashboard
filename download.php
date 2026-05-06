<?php
session_start();

if (!isset($_SESSION['user'])) {
    die("Access denied");
}

$file = $_GET['file'] ?? '';
$path = "/var/www/meusite/files/" . $file;

if (file_exists($path)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($path).'"');
    readfile($path);
} else {
    echo "file not found";
}
?>

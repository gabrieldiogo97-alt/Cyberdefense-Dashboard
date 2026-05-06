<?php
require 'vendor/autoload.php';

use OTPHP\TOTP;

session_start();

$code = $_POST['code'] ?? '';

if (!isset($_SESSION['2fa_secret'])) {
    echo "NO_SECRET";
    exit();
}

$totp = TOTP::create($_SESSION['2fa_secret']);

if ($totp->verify($code)) {

    $_SESSION['user'] = $_SESSION['2fa_user'];

    echo "OK";

} else {
    echo "INVALID";
}
?>

<?php

require 'vendor/autoload.php';
use OTPHP\TOTP;

$db = new SQLite3('users.db');

$username = "Gabriel";
$password = password_hash("1q2w3e4r5t", PASSWORD_DEFAULT);

// 🔥 gerar secret automaticamente
$totp = TOTP::create();
$secret = $totp->getSecret();

$stmt = $db->prepare("INSERT INTO users (username, password, secret) VALUES (?, ?, ?)");
$stmt->bindValue(1, $username);
$stmt->bindValue(2, $password);
$stmt->bindValue(3, $secret);

$stmt->execute();

echo "User created<br>";
echo "Secret: " . $secret;
?>

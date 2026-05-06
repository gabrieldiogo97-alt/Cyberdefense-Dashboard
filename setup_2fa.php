<?php
require 'vendor/autoload.php';

use OTPHP\TOTP;

$db = new SQLite3('users.db');

// buscar user da base de dados
$user = $db->querySingle("SELECT * FROM users WHERE username='Gabriel'", true);

if (!$user) {
    die("User not found");
}

// 🔥 usar o secret existente
$totp = TOTP::create($user['secret']);
$totp->setLabel('GabrielServer');

$qr = urlencode($totp->getProvisioningUri());
?>

<!DOCTYPE html>
<html>
<body style="background:black;color:#00ff00;text-align:center;font-family:monospace;">

<h2>Scan QR Code</h2>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo $qr; ?>">

<p>Secret: <?php echo $user['secret']; ?></p>

</body>
</html>

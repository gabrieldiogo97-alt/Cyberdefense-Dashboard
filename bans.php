<?php

session_start();

if (!isset($_SESSION['user'])) {

    die("Access denied");
}

$file = "blacklist.json";

$blacklist =
    json_decode(
        @file_get_contents($file),
        true
    ) ?? [];

$currentTime = time();

/* remover expirados */

foreach($blacklist as $ip => $expire) {

    if ($expire < $currentTime) {

        unset($blacklist[$ip]);
    }
}

/* MANUAL BAN */

if (isset($_POST['ban_ip'])) {

    $ip = trim($_POST['ban_ip']);

    if ($ip) {

        $blacklist[$ip] = time() + 600;

        file_put_contents(
            $file,
            json_encode(
                $blacklist,
                JSON_PRETTY_PRINT
            )
        );
    }

    header("Location: bans.php");

    exit();
}

/* UNBAN */

if (isset($_GET['unban'])) {

    $ip = $_GET['unban'];

    unset($blacklist[$ip]);

    file_put_contents(
        $file,
        json_encode(
            $blacklist,
            JSON_PRETTY_PRINT
        )
    );

    header("Location: bans.php");

    exit();
}

file_put_contents(
    $file,
    json_encode(
        $blacklist,
        JSON_PRETTY_PRINT
    )
);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Ban Manager</title>

<style>

body{

    background:black;

    color:#00ff00;

    font-family:monospace;

    padding:20px;
}

h1{

    margin-bottom:20px;
}

.card{

    border:1px solid red;

    padding:20px;

    margin-bottom:15px;

    background:rgba(255,0,0,0.08);

    box-shadow:0 0 15px red;
}

button{

    background:black;

    border:1px solid red;

    color:red;

    padding:10px 15px;

    cursor:pointer;
}

input{

    background:black;

    color:#00ff00;

    border:1px solid #00ff00;

    padding:10px;

    width:250px;
}

form{

    margin-bottom:30px;
}

.timer{

    font-size:20px;

    color:red;
}

</style>

</head>

<body>

<h1>🚫 BAN MANAGER</h1>

<form method="POST">

<input
    type="text"
    name="ban_ip"
    placeholder="IP to ban"
>

<button type="submit">
BAN IP
</button>

</form>

<?php if(empty($blacklist)): ?>

<p>No banned IPs</p>

<?php endif; ?>

<?php foreach($blacklist as $ip => $expire): ?>

<?php

$remaining = $expire - time();

if ($remaining < 0) {

    continue;
}

?>

<div class="card">

<h2><?= htmlspecialchars($ip) ?></h2>

<div class="timer">

Remaining:
<?= gmdate("i:s", $remaining) ?>

</div>

<br>

<a href="?unban=<?= urlencode($ip) ?>">

<button>
UNBAN
</button>

</a>

</div>

<?php endforeach; ?>

</body>
</html>

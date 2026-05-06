<?php

$logs = @file("logs.txt");

$totalFailed = 0;

$totalBrute = 0;

$blockedIPs = 0;

$blacklist =
    json_decode(
        @file_get_contents("blacklist.json"),
        true
    ) ?? [];

$blockedIPs = count($blacklist);

if ($logs) {

    foreach($logs as $line) {

        if (
            strpos(
                $line,
                "FAILED LOGIN"
            ) !== false
        ) {

            $totalFailed++;
        }

        if (
            strpos(
                $line,
                "BRUTE FORCE ALERT"
            ) !== false
        ) {

            $totalBrute++;
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Threat Analytics</title>

<style>

body{

    background:black;
    color:#00ff00;
    font-family:monospace;
    padding:20px;
}

.cards{

    display:grid;

    grid-template-columns:
        repeat(auto-fit,minmax(250px,1fr));

    gap:20px;
}

.card{

    border:1px solid #00ff00;

    padding:20px;

    background:
        rgba(0,255,0,0.08);

    box-shadow:
        0 0 15px #00ff00;
}

.big{

    font-size:40px;

    margin-top:10px;
}

</style>

</head>

<body>

<h1>🧠 THREAT ANALYTICS</h1>

<div class="cards">

<div class="card">

<h2>FAILED LOGINS</h2>

<div class="big">

<?= $totalFailed ?>

</div>

</div>

<div class="card">

<h2>BRUTE FORCE ALERTS</h2>

<div class="big">

<?= $totalBrute ?>

</div>

</div>

<div class="card">

<h2>BLOCKED IPS</h2>

<div class="big">

<?= $blockedIPs ?>

</div>

</div>

</div>

</body>
</html>

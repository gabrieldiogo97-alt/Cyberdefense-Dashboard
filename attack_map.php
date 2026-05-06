<?php

$logs = @file("logs.txt");

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Attack Monitor</title>

<style>

body{

    background:black;
    color:#00ff00;
    font-family:monospace;
    padding:20px;
}

.attack{

    border:1px solid red;

    padding:15px;

    margin-bottom:10px;

    background:rgba(255,0,0,0.1);

    box-shadow:0 0 10px red;
}

</style>

</head>

<body>

<h1>🌍 LIVE ATTACK MONITOR</h1>

<?php

if ($logs) {

    foreach(array_reverse($logs) as $line) {

        if (
            strpos($line, "BRUTE FORCE ALERT") !== false
            ||
            strpos($line, "FAILED LOGIN") !== false
        ) {

            echo "<div class='attack'>";

            preg_match(
    '/IP: ([0-9\.]+)/',
    $line,
    $matches
);

$ip =
    $matches[1] ?? 'Unknown';

echo "<strong>IP:</strong> " .
     htmlspecialchars($ip);

echo "<br>";

echo htmlspecialchars($line);

echo "<div id='geo-$ip'>
Loading GEO...
</div>";

echo "

<script>

fetch(
'geo_lookup.php?ip=$ip'
)

.then(res => res.json())

.then(data => {

document.getElementById(
'geo-$ip'
).innerHTML =

'🌍 ' +

(data.country || 'Unknown') +

' - ' +

(data.city || '');

});

</script>

";

            echo "</div>";
        }
    }
}

?>

</body>
</html>

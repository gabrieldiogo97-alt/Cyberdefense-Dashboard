<?php

$logs = @file("logs.txt");

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>World Attack Map</title>

<link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"
/>

<script
src="https://unpkg.com/leaflet/dist/leaflet.js">
</script>

<style>

body{

    margin:0;

    background:black;

    color:#00ff00;

    font-family:monospace;
}

h1{

    padding:20px;
}

#map{

    width:100%;

    height:90vh;
}

</style>

</head>

<body>

<h1>🌍 LIVE WORLD ATTACK MAP</h1>

<div id="map"></div>

<script>

const map = L.map('map').setView([20,0], 2);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    attribution:'OSM'
}
).addTo(map);

</script>

<?php

if ($logs) {

    foreach(array_reverse($logs) as $line) {

        if (
            strpos(
                $line,
                "FAILED LOGIN"
            ) !== false
            ||
            strpos(
                $line,
                "BRUTE FORCE ALERT"
            ) !== false
        ) {

            preg_match(
                '/IP: ([0-9\.]+)/',
                $line,
                $matches
            );

            $ip =
                $matches[1] ?? '';

            if (
                !$ip ||
                strpos($ip, "10.") === 0 ||
                strpos($ip, "192.168") === 0
            ) {

                continue;
            }

            $geo =
                @file_get_contents(
                    "http://ip-api.com/json/" .
                    $ip
                );

            if ($geo) {

                $geoData =
                    json_decode(
                        $geo,
                        true
                    );

                $lat =
                    $geoData['lat'] ?? null;

                $lon =
                    $geoData['lon'] ?? null;

                $country =
                    $geoData['country']
                    ?? 'Unknown';

                if ($lat && $lon) {

                    echo "

<script>

L.circleMarker(
[$lat,$lon],
{
    radius:10,
    color:'red'
})

.addTo(map)

.bindPopup(
'🚨 Attack from:
$country<br>IP: $ip'
);

</script>

";
                }
            }
        }
    }
}

?>

</body>
</html>

<?php

$ip = $_GET['ip'] ?? '';

if (!$ip) {

    exit("No IP");
}

$url =
    "http://ip-api.com/json/" .
    urlencode($ip);

$response =
    @file_get_contents($url);

if (!$response) {

    exit("Lookup failed");
}

header("Content-Type: application/json");

echo $response;

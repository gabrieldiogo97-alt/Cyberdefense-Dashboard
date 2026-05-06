<?php

$ip =
    $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR'];

$file = "scan_activity.json";

$data = [];

if (file_exists($file)) {

    $data =
        json_decode(
            file_get_contents($file),
            true
        ) ?? [];
}

$time = time();

if (!isset($data[$ip])) {

    $data[$ip] = [];
}

/* guardar timestamp */

$data[$ip][] = $time;

/* manter últimos 30 segundos */

$data[$ip] = array_filter(

    $data[$ip],

    function($t) use ($time) {

        return ($time - $t) < 30;
    }
);

/* DETEÇÃO */

if (count($data[$ip]) > 20) {

    file_put_contents(

        "logs.txt",

        date("Y-m-d H:i:s") .
        " 🚨 POSSIBLE PORT SCAN | IP: " .
        $ip . PHP_EOL,

        FILE_APPEND
    );
}

file_put_contents(
    $file,
    json_encode(
        $data,
        JSON_PRETTY_PRINT
    )
);

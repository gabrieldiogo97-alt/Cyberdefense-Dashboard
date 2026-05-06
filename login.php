<?php
session_start();
function addThreatScore($ip, $points) {

    $file = "threat_scores.json";

    $scores = [];

    if (file_exists($file)) {

        $scores =
            json_decode(
                file_get_contents($file),
                true
            ) ?? [];
    }

    if (!isset($scores[$ip])) {

        $scores[$ip] = 0;
    }

    $scores[$ip] += $points;

    file_put_contents(
        $file,
        json_encode(
            $scores,
            JSON_PRETTY_PRINT
        )
    );
}
$ip =
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR'];

$blacklist =
    json_decode(
        @file_get_contents(
            "blacklist.json"
        ),
        true
    ) ?? [];

$currentTime = time();

/* limpar expirados */

foreach($blacklist as $blockedIp => $expire) {

    if ($expire < $currentTime) {

        unset($blacklist[$blockedIp]);

        shell_exec(
            "sudo /usr/sbin/ufw delete deny from " .
            escapeshellarg($blockedIp)
        );
    }
}

file_put_contents(
    "blacklist.json",
    json_encode(
        $blacklist,
        JSON_PRETTY_PRINT
    )
);

/* verificar ban */

if (
    isset($blacklist[$ip])
) {

    $remaining =
        $blacklist[$ip]
        - $currentTime;

    die(
        "🚫 IP TEMPORARILY BLOCKED<br><br>" .
        "Remaining: " .
        gmdate(
            "i:s",
            $remaining
        )
    );
}
$db = new SQLite3('users.db');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bindValue(1, $username);
$result = $stmt->execute();

$user = $result->fetchArray();

if ($user && password_verify($password, $user['password'])) {


    $_SESSION['2fa_user'] = $user['username'];
    $_SESSION['2fa_secret'] = $user['secret'];
$ip = $_SERVER['REMOTE_ADDR'];

$browser = $_SERVER['HTTP_USER_AGENT'];

file_put_contents(

    "logs.txt",

    date("Y-m-d H:i:s") .
    " LOGIN SUCCESS | IP: " .
    $ip .
    " | BROWSER: " .
    $browser . PHP_EOL,

    FILE_APPEND
);
    echo "2FA_REQUIRED";

} else {
file_put_contents(

    "logs.txt",

    date("Y-m-d H:i:s") .
    " FAILED LOGIN | IP: " .
    $ip . PHP_EOL,

    FILE_APPEND


);
$ip = $_SERVER['REMOTE_ADDR'];

$file = "failed_attempts.json";

$data = [];

if (file_exists($file)) {

    $data =
        json_decode(
            file_get_contents($file),
            true
        ) ?? [];
}

if (!isset($data[$ip])) {

    $data[$ip] = 0;
}

$data[$ip]++;

file_put_contents(
    $file,
    json_encode($data, JSON_PRETTY_PRINT)
);

/* ALERT */

if ($data[$ip] >= 5) {

    file_put_contents(

        "logs.txt",

        date("Y-m-d H:i:s") .
        " 🚨 BRUTE FORCE ALERT | IP: " .
        $ip . PHP_EOL,

        FILE_APPEND
    );
$blacklist =
    json_decode(
        @file_get_contents("blacklist.json"),
        true
    ) ?? [];

if (!in_array($ip, $blacklist)) {

    $blacklist[$ip] = time() + 600;
shell_exec(
    "sudo /usr/sbin/ufw deny from " .
    escapeshellarg($ip)
);

    file_put_contents(
        "blacklist.json",
        json_encode(
            $blacklist,
            JSON_PRETTY_PRINT
        )
    );
}
}
    echo "ERROR";
}
?>

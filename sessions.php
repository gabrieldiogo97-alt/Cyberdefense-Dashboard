<?php

$sessions =
    json_decode(
        @file_get_contents("sessions.json"),
        true
    ) ?? [];

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Active Sessions</title>

<style>

body{

    background:black;

    color:#00ff00;

    font-family:monospace;

    padding:20px;
}

table{

    width:100%;

    border-collapse:collapse;
}

td, th{

    border:1px solid #00ff00;

    padding:10px;
}

</style>

</head>

<body>

<h1>👥 ACTIVE SESSIONS</h1>

<table>

<tr>

<th>User</th>
<th>IP</th>
<th>Browser</th>
<th>Last Seen</th>

</tr>

<?php foreach($sessions as $user => $data): ?>

<tr>

<td><?= htmlspecialchars($user) ?></td>

<td><?= htmlspecialchars($data['ip']) ?></td>

<td><?= htmlspecialchars($data['browser']) ?></td>

<td><?= htmlspecialchars($data['last_seen']) ?></td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>

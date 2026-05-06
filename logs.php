<?php

$logs = file_get_contents("logs.txt");

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>System Logs</title>

<style>

body{
    background:black;
    color:#00ff00;
    font-family:monospace;
    padding:20px;
}

pre{
    white-space:pre-wrap;
}

</style>

</head>

<body>

<h1>📜 SYSTEM LOGS</h1>

<pre><?php echo htmlspecialchars($logs); ?></pre>

</body>
</html>

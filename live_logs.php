<?php

$logs = @file_get_contents("logs.txt");

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Live Logs</title>

<style>

body{

    background:black;
    color:#00ff00;
    font-family:monospace;
    padding:20px;
}

#logs{

    white-space:pre-wrap;

    border:1px solid #00ff00;

    padding:20px;

    height:80vh;

    overflow-y:auto;

    background:rgba(0,0,0,0.7);
}

</style>

</head>

<body>

<h1>📜 LIVE LOGS</h1>

<div id="logs"></div>

<script>

function updateLogs() {

    fetch("logs.txt")

    .then(res => res.text())

    .then(data => {

        const logs =
            document.getElementById("logs");

        logs.innerText = data;

        logs.scrollTop =
            logs.scrollHeight;

    });

}

setInterval(updateLogs, 2000);

updateLogs();

</script>

</body>
</html>

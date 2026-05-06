<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}
if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}

/* SESSION TRACKING */

$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR'];

$browser = $_SERVER['HTTP_USER_AGENT'];

$user = $_SESSION['user'];

$sessions = [];

if (file_exists("sessions.json")) {

    $sessions =
        json_decode(
            file_get_contents("sessions.json"),
            true
        ) ?? [];
}

$sessions[$user] = [

    "ip" => $ip,

    "browser" => $browser,

    "last_seen" => date("Y-m-d H:i:s")
];

file_put_contents(
    "sessions.json",
    json_encode($sessions, JSON_PRETTY_PRINT)
);

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Gabriel Server</title>

<link rel="stylesheet" href="/style.css">

</head>

<body>
<div id="alertBox"></div>
<canvas id="matrix"></canvas>

<!-- SIDEBAR -->

<div class="sidebar">

<a href="graphs.php">📈 Graphs</a>
<a href="bans.php">🚫 Ban Manager</a>
<a href="world_map.php">🌍 World Map</a>
<a href="attack_map.php">🌍 Attack Monitor</a>
<a href="dashboard.php">🏠 Dashboard</a>
<a href="analytics.php">🧠 Analytics</a>
<a href="live_logs.php">📜 Live Logs</a>
 <a href="dashboard.php">💻 Terminal</a>
    <a href="files.php">📁 Files</a>
    <a href="monitor.php">📊 Monitor</a>
   


<a href="sessions.php">👥 Sessions</a>

</div>

    <h1>⚡ Maduro Cybersecurity</h1>


<!-- MAIN -->
<div class="main">

    <!-- TOP STATS -->
    <div class="topbar">

        <div class="card">
            CPU<br>
            <span id="cpu">...</span>
        </div>

        <div class="card">
            RAM<br>
            <span id="ram">...</span>
        </div>

        <div class="card">
            STATUS<br>
            ONLINE
        </div>

    </div>
<div class="charts">

    <div class="chartBox">
        <canvas id="cpuChart"></canvas>
    </div>

    <div class="chartBox">
        <canvas id="ramChart"></canvas>
    </div>

</div>

    <!-- TERMINAL -->
    <div class="terminal" id="terminal"></div>

    <input id="input" placeholder="type command..." autofocus>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="/script.js"></script>

<script>
function updateStats() {

    fetch("system.php")
    .then(res => res.json())
    .then(data => {

        document.getElementById("cpu").innerText = data.cpu;

        document.getElementById("ram").innerText =
            data.ram_used + "MB / " + data.ram_total + "MB";

    });

}

setInterval(updateStats, 2000);
updateStats();
<script>


const cpuData = {
    labels: [],
    datasets: [{
        label: 'CPU',
        data: [],
        borderColor: '#00ff00',
        tension: 0.3
    }]
};

const ramData = {
    labels: [],
    datasets: [{
        label: 'RAM',
        data: [],
        borderColor: '#00ff00',
        tension: 0.3
    }]
};

const cpuChart = new Chart(cpuCtx, {
    type: 'line',
    data: cpuData
});

const ramChart = new Chart(ramCtx, {
    type: 'line',
    data: ramData
});

function updateCharts() {

    fetch("system.php")
    .then(res => res.json())
    .then(data => {

        const time = new Date().toLocaleTimeString();

        // CPU
        cpuData.labels.push(time);
        cpuData.datasets[0].data.push(data.cpu);

        // RAM %
        const ramPercent =
            (data.ram_used / data.ram_total) * 100;

        ramData.labels.push(time);
        ramData.datasets[0].data.push(ramPercent);

        // limitar tamanho
        if (cpuData.labels.length > 10) {
            cpuData.labels.shift();
            cpuData.datasets[0].data.shift();

            ramData.labels.shift();
            ramData.datasets[0].data.shift();
        }

        cpuChart.update();
        ramChart.update();

    });

}

setInterval(updateCharts, 2000);

</script>
<script>

const cpuCtx = document.getElementById('cpuChart');
const ramCtx = document.getElementById('ramChart');

const cpuData = {
    labels: [],
    datasets: [{
        label: 'CPU',
        data: [],
        borderColor: '#00ff00',
        tension: 0.3
    }]
};

const ramData = {
    labels: [],
    datasets: [{
        label: 'RAM',
        data: [],
        borderColor: '#00ff00',
        tension: 0.3
    }]
};

const cpuChart = new Chart(cpuCtx, {
    type: 'line',
    data: cpuData
});

const ramChart = new Chart(ramCtx, {
    type: 'line',
    data: ramData
});

function updateCharts() {

    fetch("system.php")
    .then(res => res.json())
    .then(data => {

        const time = new Date().toLocaleTimeString();

        cpuData.labels.push(time);
        cpuData.datasets[0].data.push(data.cpu);

        const ramPercent =
            (data.ram_used / data.ram_total) * 100;

        ramData.labels.push(time);
        ramData.datasets[0].data.push(ramPercent);

        if (cpuData.labels.length > 10) {

            cpuData.labels.shift();
            cpuData.datasets[0].data.shift();

            ramData.labels.shift();
            ramData.datasets[0].data.shift();

        }

        cpuChart.update();
        ramChart.update();

    });

}

setInterval(updateCharts, 2000);

</script>
<script>

const canvas = document.getElementById("matrix");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const letters =
"01ABCDEFGHIJKLMNOPQRSTUVWXYZ#$%&";

const fontSize = 14;

const columns = canvas.width / fontSize;

const drops = [];

for(let x = 0; x < columns; x++) {
    drops[x] = 1;
}

function drawMatrix() {

    ctx.fillStyle = "rgba(0,0,0,0.05)";
    ctx.fillRect(0,0,canvas.width,canvas.height);

    ctx.fillStyle = "#00ff00";
    ctx.font = fontSize + "px monospace";

    for(let i = 0; i < drops.length; i++) {

        const text =
            letters.charAt(
                Math.floor(Math.random() * letters.length)
            );

        ctx.fillText(
            text,
            i * fontSize,
            drops[i] * fontSize
        );

        if(
            drops[i] * fontSize > canvas.height &&
            Math.random() > 0.975
        ) {
            drops[i] = 0;
        }

        drops[i]++;

    }

}

setInterval(drawMatrix, 35);

</script>
<script>

function showAlert(text) {

    const box =
        document.getElementById("alertBox");

    box.innerText = text;

    box.style.display = "block";

    setTimeout(() => {

        box.style.display = "none";

    }, 3000);

}
<script>

function checkBruteForce() {

    fetch("logs.txt")

    .then(res => res.text())

    .then(data => {

        if (
            data.includes(
                "BRUTE FORCE ALERT"
            )
        ) {

            showAlert(
                "🚨 BRUTE FORCE DETECTED"
            );
        }

    });

}

setInterval(checkBruteForce, 5000);

</script>
</script>
<script>

setInterval(() => {

    fetch("scan_detector.php");

}, 1000);

</script>
</body>
</html>

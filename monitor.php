<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>System Monitor</title>

<style>
body {
    background:black;
    color:#00ff00;
    font-family:monospace;
    text-align:center;
}

.box {
    border:1px solid #00ff00;
    padding:20px;
    margin:20px;
}
</style>
</head>

<body>

<h1>📊 SYSTEM MONITOR</h1>

<div class="box">
    CPU: <span id="cpu">...</span>
</div>

<div class="box">
    RAM: <span id="ram">...</span>
</div>

<script>
function update() {
    fetch("system.php")
    .then(res => res.json())
    .then(data => {
        document.getElementById("cpu").innerText = data.cpu;
        document.getElementById("ram").innerText =
            data.ram_used + "MB / " + data.ram_total + "MB";
    });
}

setInterval(update, 1000);
update();
</script>

</body>
</html>

<?php

$logs = @file("logs.txt");

$failed = 0;
$brute = 0;
$scans = 0;

if ($logs) {

    foreach($logs as $line) {

        if (
            strpos(
                $line,
                "FAILED LOGIN"
            ) !== false
        ) {

            $failed++;
        }

        if (
            strpos(
                $line,
                "BRUTE FORCE ALERT"
            ) !== false
        ) {

            $brute++;
        }

        if (
            strpos(
                $line,
                "POSSIBLE PORT SCAN"
            ) !== false
        ) {

            $scans++;
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Attack Graphs</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{

    background:black;

    color:#00ff00;

    font-family:monospace;

    padding:20px;
}


  
.chart-container{

    width:90%;

    max-width:1100px;

    height:500px;

    margin:auto;

    margin-top:40px;

    border:1px solid #00ff00;

    padding:20px;

    background:
        rgba(0,255,0,0.05);

    border-radius:10px;

    box-shadow:
        0 0 20px #00ff00;
}

canvas{

    width:100% !important;

    height:100% !important;
}

</style>

</head>

<body>

<h1>📈 REALTIME ATTACK GRAPHS</h1>

<div class="chart-container">

<canvas id="attackChart"></canvas>

</div>

<script>

const ctx =
    document.getElementById(
        'attackChart'
    );

new Chart(ctx, {

    type:'bar',

    options:{

        responsive:true,

        maintainAspectRatio:false
    },

    data:{

        labels:[
            'Failed Logins',
            'Brute Force',
            'Port Scans'
        ],

        datasets:[{

            label:'Threat Events',

            data:[
                <?= $failed ?>,
                <?= $brute ?>,
                <?= $scans ?>
            ],

            borderWidth:1
        }]
    }
});

</script>

</body>
</html>

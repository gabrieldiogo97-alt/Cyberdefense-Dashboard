<?php

header("Content-Type: application/json");

// CPU (load average)
$load = sys_getloadavg();

// RAM
$free = shell_exec("free -m");
$free = explode("\n", $free);
$mem = preg_split('/\s+/', $free[1]);

$total_ram = $mem[1];
$used_ram = $mem[2];

echo json_encode([
    "cpu" => $load[0],
    "ram_total" => $total_ram,
    "ram_used" => $used_ram
]);

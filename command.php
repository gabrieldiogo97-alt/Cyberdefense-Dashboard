<?php

session_start();

function logAction($text) {

    $file = "logs.txt";

    $date = date("Y-m-d H:i:s");

    file_put_contents(
        $file,
        "[$date] $text\n",
        FILE_APPEND
    );
}

/* AUTH */

if (!isset($_SESSION['user'])) {

    echo "Access denied";

    exit();
}

/* BASE DIR */

$baseDir = "/var/www/meusite/files";

if (!isset($_SESSION['dir'])) {

    $_SESSION['dir'] = $baseDir;
}

/* COMMAND */

$cmd = $_POST['cmd'] ?? '';

$parts = explode(" ", $cmd);

$command = $parts[0] ?? '';

$arg = $parts[1] ?? '';

/* BLOCKED */

$blocked = [

    "rm",
    "shutdown",
    "reboot",
    "mkfs",
    "dd"

];

if (in_array($command, $blocked)) {

    logAction("ALERT: Blocked command -> " . $cmd);

    echo "command not allowed";

    exit();
}

/* LOG */

logAction("COMMAND: " . $cmd);

/* COMMANDS */

switch($command) {

    case "help":

        echo "Commands: cpu, memory, disk, uptime, pwd, ls, cd, cat, whoami, mkdir, touch";

        break;

    case "cpu":

        echo shell_exec("top -bn1 | head -5");

        break;

    case "memory":

        echo shell_exec("free -h");

        break;

    case "disk":

        echo shell_exec("df -h");

        break;

    case "uptime":

        echo shell_exec("uptime");

        break;

    case "pwd":

        echo $_SESSION['dir'];

        break;

    case "ls":

        echo shell_exec("ls " . escapeshellarg($_SESSION['dir']));

        break;

    case "cd":

        $newDir = realpath($_SESSION['dir'] . "/" . $arg);

        if ($newDir && strpos($newDir, $baseDir) === 0) {

            $_SESSION['dir'] = $newDir;

            echo "changed to " . $newDir;

        } else {

            echo "invalid directory";
        }

        break;

    case "cat":

        $file = $_SESSION['dir'] . "/" . $arg;

        if (file_exists($file)) {

            echo htmlspecialchars(file_get_contents($file));

        } else {

            echo "file not found";
        }

        break;

    case "whoami":

        echo shell_exec("whoami");

        break;
case "ports":

    echo shell_exec("ss -tulnp");

    break;

case "connections":

    echo shell_exec("netstat -ant");

    break;

case "processes":

case "ips":

    echo shell_exec("last -i | head");

    break;

case "network":

    echo shell_exec("ss -tunap");

    break;

case "traffic":

    echo shell_exec("ip -s link");

    break;
    echo shell_exec("ps aux");

    break;
    case "mkdir":

        $path = $_SESSION['dir'] . "/" . $arg;

        if (!file_exists($path)) {

            mkdir($path);

            echo "folder created";

        } else {

            echo "folder already exists";
        }

        break;

    case "touch":

        $path = $_SESSION['dir'] . "/" . $arg;

        file_put_contents($path, "");

        echo "file created";

        break;

    case "download":

        echo "<a href='download.php?file=".$arg."' target='_blank'>DOWNLOAD FILE</a>";

        break;

    case "edit":

        echo "<a href='edit.php?file=".$arg."' target='_blank'>OPEN EDITOR</a>";

        break;

    default:

        echo "command not found";
}
?>

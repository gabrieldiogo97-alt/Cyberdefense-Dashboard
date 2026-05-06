<?php
session_start();

if (!isset($_SESSION['user'])) {
    die("Access denied");
}

$file = $_GET['file'] ?? '';
$baseDir = "/var/www/meusite/files/";
$path = realpath($baseDir . $file);

// segurança
if (!$path || strpos($path, $baseDir) !== 0) {
    die("invalid file");
}

$content = file_exists($path) ? file_get_contents($path) : "";

?>

<!DOCTYPE html>
<html>
<head>
<title>Editor</title>
<style>
body {
    background: black;
    color: #00ff00;
    font-family: monospace;
    margin: 0;
    padding: 10px;
}

textarea {
    width: 100%;
    height: 80vh;
    background: black;
    color: #00ff00;
    border: 1px solid #00ff00;
    outline: none;
    padding: 10px;
    font-family: monospace;
    font-size: 14px;
}

button {
    background: black;
    color: #00ff00;
    border: 1px solid #00ff00;
    padding: 10px;
    margin-top: 10px;
    cursor: pointer;
}
</style>
</head>

<body>

<h2>Editing: <?php echo htmlspecialchars($file); ?></h2>

<form method="POST">
<textarea name="content"><?php echo htmlspecialchars($content); ?></textarea>
<br>
<button type="submit">SAVE</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    file_put_contents($path, $_POST['content']);
    echo "<p>Saved!</p>";
}
?>

</body>
</html>

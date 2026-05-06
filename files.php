<?php
$dir = isset($_GET['dir']) ? $_GET['dir'] : '.';

$files = scandir($dir);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>File Manager</title>

<style>
body {
    background: black;
    color: #00ff00;
    font-family: monospace;
}

.file {
    padding: 10px;
    border-bottom: 1px solid #00ff00;
}

a {
    color: #00ff00;
    text-decoration: none;
}

button {
    background: black;
    color: #00ff00;
    border: 1px solid #00ff00;
    cursor: pointer;
}
</style>
</head>

<body>

<h1>📁 FILE MANAGER</h1>

<?php foreach ($files as $file): ?>
    <div class="file">
        <?php if (is_dir($dir . "/" . $file)): ?>
            📂 <a href="?dir=<?php echo $dir . '/' . $file; ?>"><?php echo $file; ?></a>
        <?php else: ?>
            📄 <?php echo $file; ?>
            <a href="download.php?file=<?php echo $dir . '/' . $file; ?>">[Download]</a>
            <a href="edit.php?file=<?php echo $dir . '/' . $file; ?>">[Edit]</a>
            <a href="delete.php?file=<?php echo $dir . '/' . $file; ?>">[Delete]</a>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</body>
</html>

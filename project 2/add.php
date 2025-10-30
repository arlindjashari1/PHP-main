<?php

require_once __DIR__ . '/auth.php';
require_admin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$st = $pdo->prepare("DELETE FROM articles WHERE id=?");
$st->execute([$id]);
header("Location: index.php"); exit;
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    $stmt = $pdo->prepare("INSERT INTO articles (title, content, author) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $author]);

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="UTF-8">
<title>Shto Lajm</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Shto Lajm të Ri</h2>
<form method="post">
<label>Titulli:</label>
<input type="text" name="title" required>

<label>Përmbajtja:</label>
<textarea name="content" rows="5" required></textarea>

<label>Autori:</label>
<input type="text" name="author" required>

<input type="submit" value="Ruaj">
</form>
<a href="index.php">⬅️ Kthehu</a>
</div>
</body>
</html>
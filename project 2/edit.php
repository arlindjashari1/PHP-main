<?php


require_once __DIR__ . '/auth.php';
require_login();

require_once 'config.php';
$id = $_GET['id'];
$article = $pdo->prepare("SELECT * FROM articles WHERE id=?");
$article->execute([$id]);
$r = $article->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    $stmt = $pdo->prepare("UPDATE articles SET title=?, content=?, author=? WHERE id=?");
    $stmt->execute([$title, $content, $author, $id]);

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="UTF-8">
<title>Ndrysho Lajm</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Ndrysho Lajmin</h2>
<form method="post">
<label>Titulli:</label>
<input type="text" name="title" value="<?= htmlspecialchars($r['title']) ?>" required>

<label>Përmbajtja:</label>
<textarea name="content" rows="5" required><?= htmlspecialchars($r['content']) ?></textarea>

<label>Autori:</label>
<input type="text" name="author" value="<?= htmlspecialchars($r['author']) ?>" required>

<input type="submit" value="Përditëso">
</form>
<a href="index.php">⬅️ Kthehu</a>
</div>
</body>
</html>
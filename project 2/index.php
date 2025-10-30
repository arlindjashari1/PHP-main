<?php
<div style="margin:10px 0;">
  <?php if (is_logged_in()): ?>
    Përshëndetje, <?= htmlspecialchars($_SESSION['user']['username']) ?> —
    <a href="logout.php">Dil</a>
 

 require_once 'config.php';
require_once __DIR__ . '/auth.php';
$rows = $pdo->query("SELECT * FROM articles ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="UTF-8">
<title>Mini CMS - Lajmet</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div style="margin:10px 0;">
  <?php if (is_logged_in()): ?>
    Përshëndetje, <?= htmlspecialchars($_SESSION['user']['username']) ?> —
    <a href="logout.php">Dil</a>
  <?php else: ?>
    <a href="login.php">Hyr si admin</a>
  <?php endif; ?>
</div> 
<div class="container">
<h1>📋 Mini CMS - Lajmet</h1>
<a href="add.php"><button>Shto Lajm</button></a>

<table>
<tr>
  <th>ID</th>
  <th>Titulli</th>
  <th>Autori</th>
  <th>Status</th>
  <th>Veprime</th>
</tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?= $r['id'] ?></td>
  <td><?= htmlspecialchars($r['title']) ?></td>
  <td><?= htmlspecialchars($r['author']) ?></td>
  <td><?= $r['approved'] ? "✅ Aprovuar" : "❌ Në pritje" ?></td>
  <td>
     <?php if (is_admin()): ?>
    <a href="edit.php?id=<?= $r['id'] ?>">✏️ Edit</a> |
    <a href="approve.php?id=<?= $r['id'] ?>">✔️ Approve</a> |
    <a href="delete.php?id=<?= $r['id'] ?>" onclick="return confirm('Fshi lajmin?')">🗑️ Delete</a>
     <?php endif; ?>
  <?php else: ?>
    <a href="login.php">Hyr për veprime</a>
  <?php endif; ?>
  </td>
</tr>
<?php endforeach; ?>
</table>
</div>
</body>
</html>
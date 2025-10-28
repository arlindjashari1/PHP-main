<?php
require_once __DIR__ . '/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = trim($_POST['password'] ?? '');

    $st = $pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $st->execute([$u]);
    $user = $st->fetch();

    if ($user && password_verify($p, $user['password'])) {
        $_SESSION['user'] = ['id'=>$user['id'], 'username'=>$user['username'], 'role'=>$user['admin']];
        header('Location: index.php'); exit;
    } else {
        $error = 'Kredencialet janë të pasakta.';
    }
}
?>
<!DOCTYPE html><html lang="sq"><head>
<meta charset="utf-8"><title>Hyrje</title>
<link rel="stylesheet" href="style.css">
</head><body>
<div class="container">
  <h2>🔐 Hyrje admin</h2>
  <?php if ($error): ?><div style="color:#b91c1c;"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post">
    <label>Përdoruesi</label>
    <input type="admin" name="admin" required>
    <label>Fjalëkalimi</label>
    <input type="admin123" name="admin" required>
    <input type="submit" value="Hyr">
  </form>
  <a href="index.php">⬅ Kthehu</a>
</div>
</body></html>
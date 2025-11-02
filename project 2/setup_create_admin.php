<?php
// setup_create_admin.php (ekzekutoje 1 herë: http://localhost/php_mysql_media_starter/setup_create_admin.php)
require __DIR__ . '/config/db.php';
require __DIR__ . '/functions/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? 'Admin');
  $email = trim($_POST['email'] ?? 'admin@example.com');
  $pass  = $_POST['password'] ?? 'admin123';
  $role  = $_POST['role'] ?? 'admin';

  $hash = password_hash($pass, PASSWORD_DEFAULT);
  execStmt($pdo, "INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)", [$name,$email,$hash,$role]);
  echo "<p>U krijua përdoruesi: ".esc($email)."</p><p><a href='login.php'>Shko te login</a></p>";
  exit;
}
?>
<!doctype html>
<html lang="sq"><head><meta charset="utf-8"><title>Krijo Admin</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></head>
<body class="p-4">
  <div class="container" style="max-width:520px">
    <h3>Krijo admin</h3>
    <form method="post">
      <div class="mb-3"><label class="form-label">Emri</label><input class="form-control" name="name" value="Admin" required></div>
      <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="admin@example.com" required></div>
      <div class="mb-3"><label class="form-label">Fjalëkalimi</label><input class="form-control" type="password" name="password" value="admin123" required></div>
      <div class="mb-3">
        <label class="form-label">Roli</label>
        <select class="form-select" name="role">
          <option value="admin">admin</option>
          <option value="editor">editor</option>
          <option value="author">author</option>
        </select>
      </div>
      <button class="btn btn-primary">Krijo</button>
    </form>
  </div>
</body></html>
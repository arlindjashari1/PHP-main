<?php
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../functions/helpers.php';
require __DIR__ . '/../functions/auth.php';
require_login();
include __DIR__ . '/../partials/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $desc = $_POST['description'] ?? '';
  if($name) { execStmt($pdo, "INSERT INTO categories(name, description) VALUES(?,?)", [$name, $desc]); }
  redirect('categories.php');
}
if(isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  execStmt($pdo, "DELETE FROM categories WHERE id=?", [$id]);
  redirect('categories.php');
}

$rows = fetchAll($pdo, "SELECT * FROM categories ORDER BY id DESC");
?>
<h3>Kategoritë</h3>
<form method="post" class="row g-2 mb-3">
  <div class="col-md-4"><input class="form-control" name="name" placeholder="Emri" required></div>
  <div class="col-md-6"><input class="form-control" name="description" placeholder="Përshkrimi"></div>
  <div class="col-md-2"><button class="btn btn-success w-100">Shto</button></div>
</form>

<table class="table table-striped">
  <thead><tr><th>ID</th><th>Emri</th><th>Përshkrimi</th><th></th></tr></thead>
  <tbody>
    <?php foreach($rows as $r): ?>
      <tr>
        <td><?= (int)$r['id'] ?></td>
        <td><?= esc($r['name']) ?></td>
        <td><?= esc($r['description']) ?></td>
        <td><a class="btn btn-sm btn-danger" href="?delete=<?= (int)$r['id'] ?>" onclick="return confirm('Fshije?')">Fshi</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include __DIR__ . '/../partials/footer.php'; ?>
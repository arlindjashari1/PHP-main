<?php
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../functions/helpers.php';
require __DIR__ . '/../functions/auth.php';
require_login();
include __DIR__ . '/../partials/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $image_url = trim($_POST['image_url'] ?? '');
  $caption = $_POST['caption'] ?? '';
  if($image_url) { execStmt($pdo, "INSERT INTO slides(image_url, caption) VALUES(?,?)", [$image_url, $caption]); }
  redirect('slider.php');
}
if(isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  execStmt($pdo, "DELETE FROM slides WHERE id=?", [$id]);
  redirect('slider.php');
}

$rows = fetchAll($pdo, "SELECT * FROM slides ORDER BY id DESC");
?>
<h3>Slider</h3>
<form method="post" class="row g-2 mb-3">
  <div class="col-md-6"><input class="form-control" name="image_url" placeholder="URL i imazhit (https://...)" required></div>
  <div class="col-md-4"><input class="form-control" name="caption" placeholder="Titulli"></div>
  <div class="col-md-2"><button class="btn btn-success w-100">Shto</button></div>
</form>

<table class="table table-striped">
  <thead><tr><th>ID</th><th>Imazhi</th><th>Titulli</th><th></th></tr></thead>
  <tbody>
    <?php foreach($rows as $r): ?>
      <tr>
        <td><?= (int)$r['id'] ?></td>
        <td><?= esc($r['image_url']) ?></td>
        <td><?= esc($r['caption']) ?></td>
        <td><a class="btn btn-sm btn-danger" href="?delete=<?= (int)$r['id'] ?>" onclick="return confirm('Fshije?')">Fshi</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include __DIR__ . '/../partials/footer.php'; ?>
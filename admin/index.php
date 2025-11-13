<?php
require '../../helpers.php';
require '../../auth.php';
require_login();

<a href="/php_mysql_media_starter/index.php">Kreu</a>

$posts = fetchAll($pdo, "SELECT p.*, c.name AS category_name FROM posts p
  LEFT JOIN categories c ON c.id = p.category_id
  ORDER BY p.id DESC");
?>
<?php include '../../header.php'; ?>

<h3>Lista e postimeve</h3>
<a href="create.php" class="btn btn-success mb-3">➕ Shto postim</a>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Titulli</th>
      <th>Kategoria</th>
      <th>Statusi</th>
      <th>Veprime</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($posts as $p): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= esc($p['title']) ?></td>
        <td><?= esc($p['category_name']) ?></td>
        <td><?= esc($p['status']) ?></td>
        <td>
          <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">Ndrysho</a>
          <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('A je i sigurt që dëshiron ta fshish këtë postim?')">Fshi</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include '../../partials/footer.php'; ?>
<?php
require __DIR__ . '/../../helpers.php';
require __DIR__ . '/../../auth.php';
require_login();
require_role(['admin','editor']);

$categories = fetchAll($pdo, "SELECT * FROM categories ORDER BY name ASC");
include __DIR__ . '/../../header.php';
?>
<h3>Krijo postim</h3>
<form method="post" action="store.php" enctype="mutlipart/form-data">
    
  <div class="mb-3">
    <label class="form-label">Imazhi ()</label>
    <input type="file" name="image_file" class="form-control" accept="image/*">
  </div>
  ...
</form>

  <div class="mb-3"><label class="form-label">Titulli</label><input name="title" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Slug</label><input name="slug" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Përmbajtja</label><textarea name="content" rows="6" class="form-control"></textarea></div>
  <div class="mb-3"><label class="form-label">Imazhi (URL)</label><input name="image" class="form-control"></div>
  <div class="mb-3">
    <label class="form-label">Kategoria</label>
    <select name="category_id" class="form-select">
      <option value="">—</option>
      <?php foreach($categories as $c): ?>
        <option value="<?= (int)$c['id'] ?>"><?= esc($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Statusi</label>
    <select name="status" class="form-select">
      <option value="draft">Draft</option>
      <option value="published">Published</option>
    </select>
  </div>
  <button class="btn btn-primary">Ruaj</button>
  <a class="btn btn-secondary" href="index.php">Anulo</a>
</form>
<?php include __DIR__ . '/../../footer.php'; ?>

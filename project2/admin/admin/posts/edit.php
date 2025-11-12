<?php
require __DIR__ . '/../../helpers.php';
require __DIR__ . '/../../auth.php';
require_login();
require_role(['admin','editor']);

$id = (int)($_GET['id'] ?? 0);
$post = fetchOne($pdo, "SELECT * FROM posts WHERE id = :id", [':id'=>$id]);
if(!$post){ redirect('index.php'); }

$categories = fetchAll($pdo, "SELECT * FROM categories ORDER BY name ASC");
include __DIR__ . '/../../header.php';
?>
<h3>Ndrysho postim</h3>
<form method="post" action="update.php">
  <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
  <div class="mb-3"><label class="form-label">Titulli</label><input name="title" class="form-control" value="<?= esc($post['title']) ?>" required></div>
  <div class="mb-3"><label class="form-label">Slug</label><input name="slug" class="form-control" value="<?= esc($post['slug']) ?>"></div>
  <div class="mb-3"><label class="form-label">Përmbajtja</label><textarea name="content" rows="6" class="form-control"><?= esc($post['content']) ?></textarea></div>
  <div class="mb-3"><label class="form-label">Imazhi (URL)</label><input name="image" class="form-control" value="<?= esc($post['image']) ?>"></div>
  <div class="mb-3">
    <label class="form-label">Kategoria</label>
    <select name="category_id" class="form-select">
      <option value="">—</option>
      <?php foreach($categories as $c): ?>
        <option value="<?= (int)$c['id'] ?>" <?= ($post['category_id']==$c['id']?'selected':'') ?>><?= esc($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Statusi</label>
    <select name="status" class="form-select">
      <option value="draft"     <?= $post['status']==='draft'?'selected':'' ?>>Draft</option>
      <option value="published" <?= $post['status']==='published'?'selected':'' ?>>Published</option>
    </select>
  </div>
  <button class="btn btn-primary">Ruaj</button>
  <a class="btn btn-secondary" href="index.php">Kthehu</a>
<form method="post" action="update.php" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
  ...
  <?php if(!empty($post['image'])): ?>
    <div class="mb-2"><img src="<?= esc($post['image']) ?>" style="max-height:120px"></div>
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Ndërro imazhin (opsionale)</label>
    <input type="file" name="image_file" class="form-control" accept="image/*">
  </div>
  ...
</form>

</form>

<?php include __DIR__ . '/../../footer.php'; ?>

<?php
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../functions/helpers.php';
require __DIR__ . '/../functions/auth.php';
require_login();
include __DIR__ . '/../partials/header.php';

// siguro që ekziston folderi i upload-eve
$uploadDir = __DIR__ . '/../public/uploads';
if(!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }

$action = $_GET['action'] ?? 'list';

function upload_and_get_path(string $field='image_file'): ?string {
  if(!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
  $tmp = $_FILES[$field]['tmp_name'];
  $name = basename($_FILES[$field]['name']);
  $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  $allowed = ['jpg','jpeg','png','webp'];
  if(!in_array($ext, $allowed, true)) return null;
  if(filesize($tmp) > 5*1024*1024) return null; // max 5MB
  $safe = preg_replace('/[^a-z0-9\.\-_]+/i','_', pathinfo($name, PATHINFO_FILENAME));
  $new = uniqid('img_', true) . '_' . $safe . '.' . $ext;
  $dest = __DIR__ . '/../public/uploads/' . $new;
  if(move_uploaded_file($tmp, $dest)) { return 'public/uploads/' . $new; }
  return null;
}

if($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
  $content = $_POST['content'] ?? '';
  $category_id = (int)($_POST['category_id'] ?? 0);
  $status = $_POST['status'] ?? 'draft';
  $imagePath = upload_and_get_path('image_file');

  execStmt($pdo, "INSERT INTO posts(title, slug, content, category_id, user_id, status, image) VALUES(?,?,?,?,?,?,?)",
    [$title, $slug, $content, $category_id, (current_user()['id'] ?? 1), $status, $imagePath]);
  redirect('posts.php');
}

if($action === 'approve') {
  $id = (int)($_GET['id'] ?? 0);
  if($id > 0) { execStmt($pdo, "UPDATE posts SET status='published' WHERE id=?", [$id]); }
  redirect('posts.php');
}

if($action === 'delete') {
  $id = (int)($_GET['id'] ?? 0);
  if($id > 0) { execStmt($pdo, "DELETE FROM posts WHERE id=?", [$id]); }
  redirect('posts.php');
}

if($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_GET['id'] ?? 0);
  $title = trim($_POST['title'] ?? '');
  $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
  $content = $_POST['content'] ?? '';
  $category_id = (int)($_POST['category_id'] ?? 0);
  $status = $_POST['status'] ?? 'draft';
  $imagePath = upload_and_get_path('image_file');

  if($imagePath) {
    execStmt($pdo, "UPDATE posts SET title=?, slug=?, content=?, category_id=?, status=?, image=? WHERE id=?",
      [$title, $slug, $content, $category_id, $status, $imagePath, $id]);
  } else {
    execStmt($pdo, "UPDATE posts SET title=?, slug=?, content=?, category_id=?, status=? WHERE id=?",
      [$title, $slug, $content, $category_id, $status, $id]);
  }
  redirect('posts.php');
}

$categories = fetchAll($pdo, "SELECT * FROM categories ORDER BY name ASC");
$rows = fetchAll($pdo, "SELECT p.*, c.name AS category_name FROM posts p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC");
?>
<h3>Postimet</h3>
<a class="btn btn-sm btn-primary mb-3" href="posts.php?action=new">Shto postim</a>

<?php if($action === 'new'): ?>
  <form method="post" action="posts.php?action=create" enctype="multipart/form-data">
    <div class="mb-3"><label class="form-label">Titulli</label><input name="title" class="form-control" required></div>
    <div class="mb-3">
      <label class="form-label">Kategoria</label>
      <select name="category_id" class="form-select">
        <?php foreach($categories as $c): ?>
          <option value="<?= (int)$c['id'] ?>"><?= esc($c['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3"><label class="form-label">Përmbajtja</label><textarea name="content" class="form-control" rows="6"></textarea></div>
    <div class="mb-3"><label class="form-label">Foto (jpg, png, webp)</label><input type="file" name="image_file" class="form-control" accept=".jpg,.jpeg,.png,.webp"></div>
    <div class="mb-3">
      <label class="form-label">Statusi</label>
      <select name="status" class="form-select">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
      </select>
    </div>
    <button class="btn btn-success">Ruaj</button> <a class="btn btn-link" href="posts.php">Anulo</a>
  </form>

<?php elseif($action === 'edit'):
  $id = (int)($_GET['id'] ?? 0);
  $post = fetchOne($pdo, "SELECT * FROM posts WHERE id=?", [$id]);
  if(!$post): ?>
    <div class="alert alert-danger">Postimi nuk u gjet.</div>
  <?php else: ?>
    <form method="post" action="posts.php?action=update&id=<?= (int)$post['id'] ?>" enctype="multipart/form-data">
      <div class="mb-3"><label class="form-label">Titulli</label><input name="title" class="form-control" value="<?= esc($post['title']) ?>" required></div>
      <div class="mb-3">
        <label class="form-label">Kategoria</label>
        <select name="category_id" class="form-select">
          <?php foreach($categories as $c): ?>
            <option value="<?= (int)$c['id'] ?>" <?= $post['category_id']==$c['id']?'selected':'' ?>><?= esc($c['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3"><label class="form-label">Përmbajtja</label><textarea name="content" class="form-control" rows="6"><?= esc($post['content']) ?></textarea></div>
      <div class="mb-3">
        <label class="form-label">Ndrysho Foto (opsionale)</label>
        <input type="file" name="image_file" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <?php if($post['image']): ?><div class="mt-2"><small>Aktuale:</small> <?= esc($post['image']) ?></div><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Statusi</label>
        <select name="status" class="form-select">
          <option value="draft" <?= $post['status']==='draft'?'selected':'' ?>>Draft</option>
          <option value="published" <?= $post['status']==='published'?'selected':'' ?>>Published</option>
        </select>
      </div>
      <button class="btn btn-success">Ruaj</button> <a class="btn btn-link" href="posts.php">Anulo</a>
    </form>
  <?php endif; endif; ?>

<table class="table table-striped mt-3">
  <thead><tr><th>ID</th><th>Titulli</th><th>Foto</th><th>Kategoria</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?= (int)$r['id'] ?></td>
      <td><?= esc($r['title']) ?></td>
      <td><?= esc($r['image']) ?></td>
      <td><?= esc($r['category_name']) ?></td>
      <td><?= esc($r['status']) ?></td>
      <td class="text-nowrap">
        <a class="btn btn-sm btn-outline-secondary" href="posts.php?action=edit&id=<?= (int)$r['id'] ?>">Edit</a>
        <?php if($r['status']!=='published'): ?>
          <a class="btn btn-sm btn-success" href="posts.php?action=approve&id=<?= (int)$r['id'] ?>">Approve</a>
        <?php endif; ?>
        <a class="btn btn-sm btn-danger" href="posts.php?action=delete&id=<?= (int)$r['id'] ?>" onclick="return confirm('Fshije?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include __DIR__ . '/../partials/footer.php'; ?>